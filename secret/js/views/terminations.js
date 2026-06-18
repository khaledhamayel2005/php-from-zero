(function () {
  "use strict";

  S.views.terminations = function () {
    var list = S.db.terminations.length
      ? S.db.terminations.slice().sort(S.u.newest).map(terminationCard).join("")
      : S.u.empty("سجل التصفية فارغ", "أي هدف تنتقل حالته إلى تم التصفية يظهر هنا.");

    return [
      S.ui.pageHead("☠️ سجل التصفية", "مدخلات مغلقة بتواريخ وأساليب وروابط عملياتية.", ""),
      '<div class="grid">' + list + "</div>"
    ].join("");
  };

  function terminationCard(entry) {
    var target = S.u.getById(S.db.targets, entry.targetId);
    var op = S.u.getById(S.db.operations, entry.operationId);

    return `
      <article class="log-card">
        <h3>☠️ ${S.u.html(target ? target.codename : entry.targetCodename || "ملف غير معروف")}</h3>
        <div class="tags">
          <span class="tag red">🩸 ${S.u.html(entry.date || S.u.today())}</span>
          <span class="tag">🔥 ${S.u.html(op ? op.name : "غير محددة")}</span>
        </div>
        <p class="text">${S.u.html(entry.method || "غير مصرح بالإفصاح")}</p>
        <form class="grid form-grid" onsubmit="Agency.saveTermination(event, '${entry.id}')">
          <label>التاريخ
            <input id="date-${entry.id}" type="date" value="${S.u.attr(entry.date || S.u.today())}">
          </label>
          <label>العملية
            <select id="termOp-${entry.id}">
              <option value="">غير محددة</option>
              ${S.db.operations.map(function (operation) {
                return `<option value="${operation.id}" ${entry.operationId === operation.id ? "selected" : ""}>${S.u.html(operation.name)}</option>`;
              }).join("")}
            </select>
          </label>
          <label class="wide">طريقة التصفية
            <input id="method-${entry.id}" value="${S.u.attr(entry.method || "")}">
          </label>
          <div class="actions wide">
            <button class="btn small" type="submit">🛡️ حفظ</button>
            <button class="btn danger small" type="button" onclick="Agency.deleteTermination('${entry.id}')">🧨 حذف</button>
          </div>
        </form>
      </article>
    `;
  }

  S.actions.saveTermination = function (event, id) {
    event.preventDefault();
    var entry = S.u.getById(S.db.terminations, id);
    if (!entry) return;

    entry.date = S.u.$("#date-" + id).value || S.u.today();
    entry.method = S.u.clean(S.u.$("#method-" + id).value) || "غير مصرح بالإفصاح";
    entry.operationId = S.u.$("#termOp-" + id).value;
    entry.updatedAt = S.u.now();
    S.store.save();
    S.ui.render();
    S.ui.toast("☠️ تم تحديث السجل.");
  };

  S.actions.deleteTermination = function (id) {
    if (!confirm("حذف مدخلة سجل التصفية؟")) return;
    S.db.terminations = S.db.terminations.filter(function (entry) { return entry.id !== id; });
    S.store.save();
    S.ui.render();
    S.ui.toast("🧨 تم حذف المدخلة.");
  };
})();
