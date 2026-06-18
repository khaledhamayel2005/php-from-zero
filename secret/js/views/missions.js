(function () {
  "use strict";

  S.views.missions = function () {
    var list = S.db.missions.length
      ? S.db.missions.slice().sort(S.u.newest).map(missionCard).join("")
      : S.u.empty("سجل المهام فارغ", "أضف مدخلة عملياتية أو تقرير عملية.");

    return `
      ${S.ui.pageHead("📓 سجل المهام", "دفتر يوميات عملياتي مع طابع زمني وروابط اختيارية.", "")}
      <section class="panel">
        <form onsubmit="Agency.saveMission(event)">
          <div class="grid form-grid">
            <label class="wide">مدخلة جديدة *
              <textarea id="missionText" required></textarea>
            </label>
            <label>ربط بهدف
              <select id="missionTarget">
                <option value="">بدون ربط</option>
                ${S.db.targets.map(function (target) { return `<option value="${target.id}">${S.u.html(target.codename)}</option>`; }).join("")}
              </select>
            </label>
            <label>ربط بعملية
              <select id="missionOperation">
                <option value="">بدون ربط</option>
                ${S.db.operations.map(function (op) { return `<option value="${op.id}">${S.u.html(op.name)}</option>`; }).join("")}
              </select>
            </label>
          </div>
          <div class="actions">
            <button class="btn primary" type="submit">📓 إضافة للسجل</button>
          </div>
        </form>
      </section>
      <div class="grid">${list}</div>
    `;
  };

  function missionCard(item) {
    var target = S.u.getById(S.db.targets, item.targetId);
    var op = S.u.getById(S.db.operations, item.operationId);

    return `
      <article class="card">
        <h3>📓 ${S.u.dateTime(item.createdAt)}</h3>
        <div class="tags">
          ${target ? `<span class="tag red">🎯 ${S.u.html(target.codename)}</span>` : ""}
          ${op ? `<span class="tag amber">🔥 ${S.u.html(op.name)}</span>` : ""}
        </div>
        <p class="text">${S.u.html(item.text)}</p>
        <div class="actions">
          <button class="btn danger small" onclick="Agency.deleteMission('${item.id}')">🧨 حذف</button>
        </div>
      </article>
    `;
  }

  S.actions.saveMission = function (event) {
    event.preventDefault();
    var text = S.u.clean(S.u.$("#missionText").value);
    if (!text) {
      S.ui.toast("نص المدخلة مطلوب.");
      return;
    }

    S.db.missions.push({
      id: S.u.makeId("m"),
      text: text,
      targetId: S.u.$("#missionTarget").value,
      operationId: S.u.$("#missionOperation").value,
      createdAt: S.u.now()
    });

    S.store.save();
    S.ui.render();
    S.ui.toast("📓 تم إضافة المدخلة.");
  };

  S.actions.deleteMission = function (id) {
    if (!confirm("حذف مدخلة سجل المهام؟")) return;
    S.db.missions = S.db.missions.filter(function (item) { return item.id !== id; });
    S.store.save();
    S.ui.render();
    S.ui.toast("🧨 تم حذف المدخلة.");
  };
})();
