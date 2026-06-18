(function () {
  "use strict";

  S.views.operations = function () {
    var action = '<button class="btn primary" onclick="Agency.showOperationForm()">🔥 عملية جديدة</button>';
    var table = S.db.operations.length ? operationsTable() : S.u.empty("لا توجد عمليات", "أضف عملية خاصة ثم اربطها بالأهداف.");

    return [
      S.ui.pageHead("🔥 العمليات الخاصة", "إدارة الأولويات والحالة والملفات المرتبطة، مع تقارير مباشرة لسجل المهام.", action),
      S.state.editingOperation !== null ? operationForm() : "",
      table
    ].join("");
  };

  function operationForm() {
    var op = getOperation(S.state.editingOperation);
    return `
      <section class="panel">
        <h3>${op ? "🔥 تعديل عملية" : "🔥 عملية جديدة"}</h3>
        <form onsubmit="Agency.saveOperation(event)">
          <div class="grid form-grid">
            <label>اسم العملية *
              <input id="opName" required value="${S.u.attr(op ? op.name : "")}">
            </label>
            <label>الأولوية
              <select id="opPriority">${S.u.options(S.config.priorities, op ? op.priority : "متوسطة")}</select>
            </label>
            <label>الحالة
              <select id="opStatus">${S.u.options(S.config.operationStatuses, op ? op.status : "تخطيط")}</select>
            </label>
            <label class="wide">وصف العملية
              <textarea id="opDescription">${S.u.html(op ? op.description : "")}</textarea>
            </label>
          </div>
          <div class="actions">
            <button class="btn primary" type="submit">🛡️ حفظ العملية</button>
            <button class="btn ghost" type="button" onclick="Agency.cancelForms()">إلغاء</button>
          </div>
        </form>
      </section>
    `;
  }

  function operationsTable() {
    return `
      <div class="table-wrap">
        <table>
          <thead>
            <tr>
              <th>العملية</th>
              <th>الأولوية</th>
              <th>الحالة</th>
              <th>الأهداف المرتبطة</th>
              <th>إجراءات</th>
            </tr>
          </thead>
          <tbody>${S.db.operations.map(operationRow).join("")}</tbody>
        </table>
      </div>
    `;
  }

  function operationRow(op) {
    var linked = S.db.targets.filter(function (target) {
      return (target.operationIds || []).includes(op.id);
    });

    return `
      <tr>
        <td><b>🔥 ${S.u.html(op.name)}</b><br><small class="muted">${S.u.html(S.u.short(op.description || "لا يوجد وصف.", 95))}</small></td>
        <td><span class="tag ${op.priority === "حرجة" ? "red" : "amber"}">${S.u.html(op.priority)}</span></td>
        <td><span class="tag ${op.status === "نشطة" ? "green" : ""}">${S.u.html(op.status)}</span></td>
        <td>${S.ui.linkedTargets(linked)}</td>
        <td>
          <div class="actions">
            <button class="btn small" onclick="Agency.editOperation('${op.id}')">✒️ تعديل</button>
            <button class="btn small" onclick="Agency.operationReport('${op.id}')">📓 تقرير</button>
            <button class="btn danger small" onclick="Agency.deleteOperation('${op.id}')">🧨 حذف</button>
          </div>
        </td>
      </tr>
    `;
  }

  function getOperation(id) {
    return S.u.getById(S.db.operations, id);
  }

  S.actions.showOperationForm = function (id) {
    S.state.editingOperation = id || "";
    S.state.editingTarget = null;
    S.state.editingAnalysis = null;
    S.state.page = "operations";
    S.ui.render();
  };

  S.actions.editOperation = S.actions.showOperationForm;

  S.actions.saveOperation = function (event) {
    event.preventDefault();
    var old = getOperation(S.state.editingOperation);
    var op = {
      id: old ? old.id : S.u.makeId("op"),
      name: S.u.clean(S.u.$("#opName").value),
      priority: S.u.$("#opPriority").value,
      status: S.u.$("#opStatus").value,
      description: S.u.clean(S.u.$("#opDescription").value),
      createdAt: old ? old.createdAt : S.u.now(),
      updatedAt: S.u.now()
    };

    if (!op.name) {
      S.ui.toast("اسم العملية مطلوب.");
      return;
    }

    if (old) S.u.replaceById(S.db.operations, op);
    else S.db.operations.push(op);
    S.store.save();
    S.state.editingOperation = null;
    S.ui.render();
    S.ui.toast("🔥 تم حفظ العملية.");
  };

  S.actions.deleteOperation = function (id) {
    var op = getOperation(id);
    if (!op || !confirm("حذف العملية " + op.name + "؟")) return;

    S.db.operations = S.db.operations.filter(function (item) { return item.id !== id; });
    S.db.targets.forEach(function (target) {
      target.operationIds = (target.operationIds || []).filter(function (opId) { return opId !== id; });
    });
    S.db.terminations.forEach(function (entry) { if (entry.operationId === id) entry.operationId = ""; });
    S.db.missions.forEach(function (entry) { if (entry.operationId === id) entry.operationId = ""; });
    S.store.save();
    S.ui.render();
    S.ui.toast("🧨 تم حذف العملية وفصل روابطها.");
  };

  S.actions.operationReport = function (id) {
    var op = getOperation(id);
    if (!op) return;

    var targets = S.db.targets.filter(function (target) {
      return (target.operationIds || []).includes(id);
    });

    S.db.missions.push({
      id: S.u.makeId("m"),
      text: [
        "تقرير العملية: " + op.name,
        "الأولوية: " + op.priority,
        "الحالة: " + op.status,
        "الأهداف المرتبطة: " + (targets.length ? targets.map(function (target) { return target.codename; }).join("، ") : "لا يوجد"),
        op.description ? "الوصف: " + op.description : ""
      ].filter(Boolean).join("\n"),
      operationId: id,
      targetId: "",
      createdAt: S.u.now()
    });

    S.store.save();
    S.ui.toast("📓 تم إرسال التقرير إلى سجل المهام.");
  };
})();
