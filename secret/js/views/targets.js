(function () {
  "use strict";

  S.views.targets = function () {
    var action = '<button class="btn primary" onclick="Agency.showTargetForm()">🩸 هدف جديد</button>';
    var cards = S.db.targets.length
      ? '<div class="grid two-grid">' + S.db.targets.map(targetCard).join("") + "</div>"
      : S.u.empty("لا توجد أهداف مسجلة", "كل ملف جديد يظهر هنا مع صورته ونقطة الدم وروابطه.");

    return [
      S.ui.pageHead("🎯 قسم الأهداف", "ملفات تصنيف وربط عملياتي مع صورة ونقطة دم على خريطة فلسطين.", action),
      S.state.editingTarget !== null ? targetForm() : "",
      cards
    ].join("");
  };

  function targetForm() {
    var target = getTarget(S.state.editingTarget);
    var selectedOps = new Set(target ? target.operationIds || [] : []);
    var location = S.state.formLocation || (target ? target.coords : null);
    var img = S.state.imageCache || (target ? target.image : "");
    var status = target ? target.status : "نشط";
    var term = target ? getTerminationByTarget(target.id) : null;

    return `
      <section class="panel">
        <h3>${target ? "🩸 تعديل ملف هدف" : "🩸 ملف هدف جديد"}</h3>
        <form id="targetForm" onsubmit="Agency.saveTarget(event)">
          <div class="grid form-grid">
            <label>الاسم الحركي *
              <input id="targetCodename" required value="${S.u.attr(target ? target.codename : "")}">
            </label>
            <label>الاسم الحقيقي
              <input id="targetRealName" value="${S.u.attr(target ? target.realName : "")}">
            </label>
            <label>حالة الهدف
              <select id="targetStatus">${S.u.options(S.config.statuses, status)}</select>
            </label>
            <label>مستوى التهديد
              <input id="targetThreat" type="range" min="1" max="5" value="${target ? target.threat : 3}">
              <span id="threatText">${S.u.skulls(target ? target.threat : 3)}</span>
            </label>
            <label>صورة الهدف
              <div id="imagePreview" class="preview">${img ? `<img src="${img}" alt="">` : "🕶️"}</div>
              <input id="targetImage" type="file" accept="image/*">
            </label>
            <label>ربط العمليات
              <select id="targetOperations" multiple>
                ${operationOptions(selectedOps)}
              </select>
            </label>
            <label class="wide">الوصف التفصيلي
              <textarea id="targetDescription">${S.u.html(target ? target.description : "")}</textarea>
            </label>
            <div class="wide location-row">
              <span id="locationText">🩸 ${S.u.locationText(location)}</span>
              <button class="btn small" type="button" onclick="Agency.openMapPicker()">⌖ تحديد نقطة دم</button>
            </div>
            <div id="terminationFields" class="wide ${status === "تم التصفية" ? "" : "hidden"}">
              <div class="panel">
                <h3>☠️ بيانات سجل التصفية</h3>
                <div class="grid form-grid">
                  <label>التاريخ
                    <input id="terminationDate" type="date" value="${S.u.attr(term ? term.date : S.u.today())}">
                  </label>
                  <label>العملية المرتبطة
                    <select id="terminationOperation">
                      <option value="">غير محددة</option>
                      ${S.db.operations.map(function (op) {
                        return `<option value="${op.id}" ${term && term.operationId === op.id ? "selected" : ""}>${S.u.html(op.name)}</option>`;
                      }).join("")}
                    </select>
                  </label>
                  <label class="wide">طريقة التصفية
                    <textarea id="terminationMethod">${S.u.html(term ? term.method : "")}</textarea>
                  </label>
                </div>
              </div>
            </div>
          </div>
          <div class="actions">
            <button class="btn primary" type="submit">🗡️ حفظ الملف</button>
            <button class="btn ghost" type="button" onclick="Agency.cancelForms()">إلغاء</button>
          </div>
        </form>
      </section>
    `;
  }

  function operationOptions(selectedOps) {
    if (!S.db.operations.length) return "<option disabled>لا توجد عمليات</option>";
    return S.db.operations.map(function (op) {
      return '<option value="' + op.id + '" ' + (selectedOps.has(op.id) ? "selected" : "") + ">" + S.u.html(op.name) + " - " + S.u.html(op.status) + "</option>";
    }).join("");
  }

  function targetCard(target) {
    var ops = (target.operationIds || []).map(getOperation).filter(Boolean);
    return `
      <article id="item-${target.id}" class="card target-card">
        <div class="card-head">
          <div class="thumb">${target.image ? `<img src="${target.image}" alt="">` : "🕶️"}</div>
          <div>
            <h3>🎯 ${S.u.html(target.codename)}</h3>
            <small class="muted">${S.u.html(target.realName || "هوية غير مدرجة")}</small>
          </div>
        </div>
        <div class="tags">
          <span class="tag ${target.status === "تم التصفية" ? "red" : "green"}">${S.u.statusIcon(target.status)} ${S.u.html(target.status)}</span>
          <span class="tag amber">${S.u.skulls(target.threat)}</span>
          <span class="tag">🩸 ${S.u.locationText(target.coords)}</span>
        </div>
        <p class="text">${S.u.html(S.u.short(target.description || "لا توجد ملاحظات مرفقة.", 150))}</p>
        <div class="mini-list">${ops.length ? ops.map(function (op) { return `<span class="tag">🔥 ${S.u.html(op.name)}</span>`; }).join("") : '<span class="tag">⛓️ بلا عملية</span>'}</div>
        <div class="actions">
          <button class="btn small" onclick="Agency.editTarget('${target.id}')">✒️ تعديل</button>
          <button class="btn small" onclick="Agency.focusMap('${target.id}')">🩸 نقطة الدم</button>
          ${target.status !== "تم التصفية" ? `<button class="btn danger small" onclick="Agency.terminateTarget('${target.id}')">☠️ تصفية</button>` : ""}
          <button class="btn danger small" onclick="Agency.deleteTarget('${target.id}')">🧨 حذف</button>
        </div>
      </article>
    `;
  }

  function getTarget(id) {
    return S.u.getById(S.db.targets, id);
  }

  function getOperation(id) {
    return S.u.getById(S.db.operations, id);
  }

  function getTerminationByTarget(id) {
    return S.db.terminations.find(function (entry) { return entry.targetId === id; }) || null;
  }

  S.actions.showTargetForm = function (id) {
    S.state.editingTarget = id || "";
    S.state.editingOperation = null;
    S.state.editingAnalysis = null;
    var target = getTarget(id);
    S.state.imageCache = target ? target.image : "";
    S.state.formLocation = target && target.coords ? S.u.copy(target.coords) : null;
    S.state.page = "targets";
    S.ui.render();
  };

  S.actions.editTarget = S.actions.showTargetForm;

  S.actions.saveTarget = function (event) {
    event.preventDefault();
    var old = getTarget(S.state.editingTarget);
    var id = old ? old.id : S.u.makeId("t");
    var selected = Array.from(S.u.$("#targetOperations").selectedOptions)
      .filter(function (option) { return !option.disabled; })
      .map(function (option) { return option.value; });

    var target = {
      id: id,
      codename: S.u.clean(S.u.$("#targetCodename").value),
      realName: S.u.clean(S.u.$("#targetRealName").value),
      image: S.state.imageCache || (old ? old.image : ""),
      status: S.u.$("#targetStatus").value,
      threat: Number(S.u.$("#targetThreat").value),
      description: S.u.clean(S.u.$("#targetDescription").value),
      operationIds: selected,
      coords: S.state.formLocation ? S.u.copy(S.state.formLocation) : null,
      createdAt: old ? old.createdAt : S.u.now(),
      updatedAt: S.u.now()
    };

    if (!target.codename) {
      S.ui.toast("الاسم الحركي مطلوب.");
      return;
    }

    if (old) S.u.replaceById(S.db.targets, target);
    else S.db.targets.push(target);

    if (target.status === "تم التصفية") saveTerminationFor(target);
    else S.db.terminations = S.db.terminations.filter(function (entry) { return entry.targetId !== target.id; });

    S.store.save();
    S.ui.resetForms();
    S.ui.render();
    S.ui.toast("🩸 تم حفظ ملف الهدف.");
  };

  function saveTerminationFor(target) {
    var old = getTerminationByTarget(target.id);
    var entry = {
      id: old ? old.id : S.u.makeId("term"),
      targetId: target.id,
      targetCodename: target.codename,
      date: S.u.$("#terminationDate") ? S.u.$("#terminationDate").value : S.u.today(),
      method: S.u.clean(S.u.$("#terminationMethod") ? S.u.$("#terminationMethod").value : "") || "غير مصرح بالإفصاح",
      operationId: S.u.$("#terminationOperation") ? S.u.$("#terminationOperation").value : (target.operationIds[0] || ""),
      createdAt: old ? old.createdAt : S.u.now(),
      updatedAt: S.u.now()
    };

    if (old) S.u.replaceById(S.db.terminations, entry);
    else S.db.terminations.push(entry);
  }

  S.actions.deleteTarget = function (id) {
    var target = getTarget(id);
    if (!target || !confirm("حذف ملف " + target.codename + " وروابطه؟")) return;
    S.db.targets = S.db.targets.filter(function (item) { return item.id !== id; });
    S.db.terminations = S.db.terminations.filter(function (item) { return item.targetId !== id; });
    S.db.analyses.forEach(function (item) { if (item.targetId === id) item.targetId = ""; });
    S.db.missions.forEach(function (item) { if (item.targetId === id) item.targetId = ""; });
    S.store.save();
    S.ui.render();
    S.ui.toast("🧨 تم حذف ملف الهدف.");
  };

  S.actions.terminateTarget = function (id) {
    var target = getTarget(id);
    if (!target || !confirm("تأكيد نقل الملف إلى سجل التصفية؟")) return;
    target.status = "تم التصفية";
    target.updatedAt = S.u.now();
    S.db.terminations.push({
      id: S.u.makeId("term"),
      targetId: target.id,
      targetCodename: target.codename,
      date: S.u.today(),
      method: prompt("طريقة التصفية:", "غير مصرح بالإفصاح") || "غير مصرح بالإفصاح",
      operationId: (target.operationIds || [])[0] || "",
      createdAt: S.u.now(),
      updatedAt: S.u.now()
    });
    S.store.save();
    S.ui.render();
    S.ui.toast("☠️ تم تحديث سجل التصفية.");
  };

  S.actions.readTargetImage = function (event) {
    var file = event.target.files[0];
    if (!file) return;
    if (!file.type.startsWith("image/")) {
      S.ui.toast("الملف المختار ليس صورة.");
      return;
    }

    var reader = new FileReader();
    reader.onload = function () {
      S.state.imageCache = String(reader.result || "");
      S.u.$("#imagePreview").innerHTML = '<img src="' + S.state.imageCache + '" alt="">';
    };
    reader.onerror = function () {
      S.ui.toast("تعذر تحميل الصورة.");
    };
    reader.readAsDataURL(file);
  };
})();
