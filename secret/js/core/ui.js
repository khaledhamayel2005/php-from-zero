(function () {
  "use strict";

  S.ui = {
    pageHead: function (title, text, action) {
      return [
        '<div class="page-head">',
        '<div><h2>' + title + '</h2><p>' + text + "</p></div>",
        action || "",
        "</div>"
      ].join("");
    },
    stat: function (label, value, icon) {
      return '<div class="stat" data-icon="' + icon + '"><small>' + label + '</small><b>' + value + '</b><span class="muted">⛓️ ' + S.u.skulls(3) + "</span></div>";
    },
    toast: function (message) {
      clearTimeout(S.state.toastTimer);
      S.els.toast.textContent = message;
      S.els.toast.classList.add("show");
      S.state.toastTimer = setTimeout(function () {
        S.els.toast.classList.remove("show");
      }, 2400);
    },
    updateCounters: function () {
      S.u.$("#activeTargets").textContent = S.db.targets.filter(function (t) { return t.status === "نشط"; }).length;
      S.u.$("#activeOperations").textContent = S.db.operations.filter(function (o) { return o.status === "نشطة"; }).length;
    },
    setActiveNav: function () {
      S.u.$$(".nav").forEach(function (btn) {
        btn.classList.toggle("active", btn.dataset.page === S.state.page);
      });
    },
    render: function () {
      S.ui.setActiveNav();
      var view = S.views[S.state.page] || S.views.dashboard;
      S.els.content.innerHTML = view();
      S.ui.updateCounters();
      S.app.bindPageEvents();
      S.app.afterRender();
    },
    showLogin: function () {
      S.els.loginPage.classList.remove("hidden");
      S.els.appPage.classList.add("hidden");
    },
    openApp: function () {
      S.els.loginPage.classList.add("hidden");
      S.els.appPage.classList.remove("hidden");
      S.els.codenameInput.value = S.db.codename || "العميل الأسود";
      S.ui.render();
    },
    resetForms: function () {
      S.state.editingTarget = null;
      S.state.editingOperation = null;
      S.state.editingAnalysis = null;
      S.state.imageCache = "";
      S.state.formLocation = null;
    },
    closeModal: function () {
      if (S.state.pickerMap) {
        S.state.pickerMap.remove();
        S.state.pickerMap = null;
      }
      S.state.pickerMarker = null;
      S.state.pickerDraftLocation = null;
      S.els.modal.classList.add("hidden");
      S.els.modal.innerHTML = "";
    },
    linkedTargets: function (items) {
      if (!items.length) return '<span class="tag">⛓️ لا توجد أهداف</span>';
      return '<div class="mini-list">' + items.map(function (target) {
        return [
          '<span class="tag"><span class="mini-thumb">',
          target.image ? '<img src="' + target.image + '" alt="">' : "🩸",
          "</span>",
          S.u.html(target.codename),
          "</span>"
        ].join("");
      }).join("") + "</div>";
    }
  };

  S.actions.go = function (name) {
    if (!S.config.pages.includes(name)) name = "dashboard";
    S.state.page = name;
    S.state.mapPlacementActive = false;
    S.ui.resetForms();
    S.ui.render();
  };

  S.actions.cancelForms = function () {
    S.ui.resetForms();
    S.ui.render();
  };

  S.actions.closeModal = S.ui.closeModal;
})();
