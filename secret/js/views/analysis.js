(function () {
  "use strict";

  S.views.analysis = function () {
    var action = '<button class="btn primary" onclick="Agency.showAnalysisForm()">🧠 تحليل جديد</button>';
    var list = S.db.analyses.length
      ? S.db.analyses.slice().sort(S.u.newest).map(analysisCard).join("")
      : S.u.empty("لا توجد تحليلات", "أضف عنوانًا ونصًا واربطه بهدف عند الحاجة.");

    return [
      S.ui.pageHead("🧠 التحليل النفسي", "أرشيف تقييمات وسلوكيات مرتبطة بالملفات.", action),
      S.state.editingAnalysis !== null ? analysisForm() : "",
      '<div class="grid">' + list + "</div>"
    ].join("");
  };

  function analysisForm() {
    var item = S.u.getById(S.db.analyses, S.state.editingAnalysis);
    return `
      <section class="panel">
        <h3>${item ? "🧠 تعديل تحليل" : "🧠 تحليل جديد"}</h3>
        <form onsubmit="Agency.saveAnalysis(event)">
          <div class="grid form-grid">
            <label>العنوان *
              <input id="analysisTitle" required value="${S.u.attr(item ? item.title : "")}">
            </label>
            <label>ربط بهدف
              <select id="analysisTarget">
                <option value="">بدون ربط</option>
                ${S.db.targets.map(function (target) {
                  return `<option value="${target.id}" ${item && item.targetId === target.id ? "selected" : ""}>${S.u.html(target.codename)}</option>`;
                }).join("")}
              </select>
            </label>
            <label class="wide">نص التحليل
              <textarea id="analysisBody">${S.u.html(item ? item.body : "")}</textarea>
            </label>
          </div>
          <div class="actions">
            <button class="btn primary" type="submit">🛡️ حفظ التحليل</button>
            <button class="btn ghost" type="button" onclick="Agency.cancelForms()">إلغاء</button>
          </div>
        </form>
      </section>
    `;
  }

  function analysisCard(item) {
    var target = S.u.getById(S.db.targets, item.targetId);
    return `
      <article class="card">
        <h3>🧠 ${S.u.html(item.title)}</h3>
        <div class="tags">
          <span class="tag">🕯️ ${S.u.dateTime(item.createdAt)}</span>
          ${target ? `<span class="tag red">🎯 ${S.u.html(target.codename)}</span>` : '<span class="tag">⛓️ غير مرتبط</span>'}
        </div>
        <p class="text">${S.u.html(item.body || "لا يوجد نص مرفق.")}</p>
        <div class="actions">
          <button class="btn small" onclick="Agency.editAnalysis('${item.id}')">✒️ تعديل</button>
          <button class="btn danger small" onclick="Agency.deleteAnalysis('${item.id}')">🧨 حذف</button>
        </div>
      </article>
    `;
  }

  S.actions.showAnalysisForm = function (id) {
    S.state.editingAnalysis = id || "";
    S.state.editingTarget = null;
    S.state.editingOperation = null;
    S.state.page = "analysis";
    S.ui.render();
  };

  S.actions.editAnalysis = S.actions.showAnalysisForm;

  S.actions.saveAnalysis = function (event) {
    event.preventDefault();
    var old = S.u.getById(S.db.analyses, S.state.editingAnalysis);
    var item = {
      id: old ? old.id : S.u.makeId("a"),
      title: S.u.clean(S.u.$("#analysisTitle").value),
      targetId: S.u.$("#analysisTarget").value,
      body: S.u.clean(S.u.$("#analysisBody").value),
      createdAt: old ? old.createdAt : S.u.now(),
      updatedAt: S.u.now()
    };

    if (!item.title) {
      S.ui.toast("عنوان التحليل مطلوب.");
      return;
    }

    if (old) S.u.replaceById(S.db.analyses, item);
    else S.db.analyses.push(item);
    S.store.save();
    S.state.editingAnalysis = null;
    S.ui.render();
    S.ui.toast("🧠 تم حفظ التحليل.");
  };

  S.actions.deleteAnalysis = function (id) {
    if (!confirm("حذف التحليل؟")) return;
    S.db.analyses = S.db.analyses.filter(function (item) { return item.id !== id; });
    S.store.save();
    S.ui.render();
    S.ui.toast("🧨 تم حذف التحليل.");
  };
})();
