(function () {
  "use strict";

  S.views.dashboard = function () {
    var active = S.db.targets.filter(function (t) { return t.status === "نشط"; }).length;
    var watch = S.db.targets.filter(function (t) { return t.status === "تحت المراقبة"; }).length;
    var closed = S.db.targets.filter(function (t) { return t.status === "تم التصفية"; }).length;
    var critical = S.db.operations.filter(function (o) { return o.priority === "حرجة" && o.status !== "مغلقة"; }).length;
    var latest = S.db.missions.slice().sort(S.u.newest).slice(0, 5);

    return [
      S.ui.pageHead("🧿 لوحة التحكم الرئيسية", "مركز قيادة مظلم وواضح للملفات والعمليات ونقاط الدم.", ""),
      '<div class="grid stats-grid">',
      S.ui.stat("🎯 الأهداف النشطة", active, "🎯"),
      S.ui.stat("🧿 تحت المراقبة", watch, "🧿"),
      S.ui.stat("☠️ ملفات مغلقة", closed, "☠️"),
      S.ui.stat("🔥 عمليات حرجة", critical, "🔥"),
      "</div>",
      '<div class="grid two-grid">',
      '<section class="panel"><h3>🎯 آخر الأهداف</h3>' + miniTargets(S.db.targets.slice(-6).reverse()) + "</section>",
      '<section class="panel"><h3>🔥 العمليات الخاصة</h3>' + miniOperations(S.db.operations.slice(-6).reverse()) + "</section>",
      '<section class="panel"><h3>🩸 نقاط الدم</h3>' + locationFeed() + "</section>",
      '<section class="panel"><h3>📓 آخر سجل المهام</h3>' + missionFeed(latest) + "</section>",
      "</div>"
    ].join("");
  };

  function miniTargets(items) {
    if (!items.length) return S.u.empty("لا توجد أهداف", "افتح قسم الأهداف وأضف ملفًا جديدًا.");
    return items.map(function (target) {
      return '<button class="search-item" onclick="Agency.focusMap(\'' + target.id + '\')"><b>🎯 ' + S.u.html(target.codename) + ' ' + S.u.skulls(target.threat) + '</b><small>' + S.u.html(target.status) + " - " + S.u.locationText(target.coords) + "</small></button>";
    }).join("");
  }

  function miniOperations(items) {
    if (!items.length) return S.u.empty("لا توجد عمليات", "أنشئ عملية ثم اربطها بالأهداف.");
    return items.map(function (operation) {
      return '<button class="search-item" onclick="Agency.editOperation(\'' + operation.id + '\')"><b>🔥 ' + S.u.html(operation.name) + '</b><small>' + S.u.html(operation.priority) + " - " + S.u.html(operation.status) + "</small></button>";
    }).join("");
  }

  function locationFeed() {
    var items = S.db.targets.filter(function (target) { return target.coords; }).slice(0, 8);
    if (!items.length) return S.u.empty("لا توجد نقاط دم", "حدد نقطة على خريطة فلسطين من ملف الهدف أو قسم الخريطة.");
    return items.map(function (target) {
      return '<button class="search-item" onclick="Agency.focusMap(\'' + target.id + '\')"><b>🩸 ' + S.u.html(target.codename) + '</b><small>' + S.u.locationText(target.coords) + "</small></button>";
    }).join("");
  }

  function missionFeed(items) {
    if (!items.length) return S.u.empty("السجل صامت", "أضف مدخلات من سجل المهام أو تقارير العمليات.");
    return items.map(function (mission) {
      return '<button class="search-item" onclick="Agency.go(\'missions\')"><b>📓 ' + S.u.dateTime(mission.createdAt) + '</b><small>' + S.u.html(S.u.short(mission.text, 90)) + "</small></button>";
    }).join("");
  }
})();
