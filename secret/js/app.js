(function () {
  "use strict";

  S.app = {
    init: function () {
      S.els.loginPage = S.u.$("#loginPage");
      S.els.appPage = S.u.$("#appPage");
      S.els.loginForm = S.u.$("#loginForm");
      S.els.agentName = S.u.$("#agentName");
      S.els.codenameInput = S.u.$("#codenameInput");
      S.els.content = S.u.$("#content");
      S.els.toast = S.u.$("#toast");
      S.els.modal = S.u.$("#modal");
      S.els.searchInput = S.u.$("#searchInput");
      S.els.searchResults = S.u.$("#searchResults");
      S.els.sidebar = S.u.$("#sidebar");

      S.els.loginForm.addEventListener("submit", login);
      S.els.codenameInput.addEventListener("input", saveCodename);
      S.els.searchInput.addEventListener("input", S.search.run);

      S.u.$("#menuBtn").addEventListener("click", function () {
        S.els.sidebar.classList.toggle("open");
      });

      S.u.$("#logoutBtn").addEventListener("click", logout);

      S.u.$$(".nav").forEach(function (btn) {
        btn.addEventListener("click", function () {
          S.actions.go(btn.dataset.page);
          S.els.sidebar.classList.remove("open");
        });
      });

      document.addEventListener("click", function (event) {
        if (!S.els.searchResults.contains(event.target) && event.target !== S.els.searchInput) {
          S.els.searchResults.classList.add("hidden");
        }
        if (event.target === S.els.modal) S.ui.closeModal();
      });

      S.store.migrateLocations();

      if (S.db.loggedIn) S.ui.openApp();
      else S.ui.showLogin();
    },

    bindPageEvents: function () {
      var imageInput = S.u.$("#targetImage");
      if (imageInput) imageInput.addEventListener("change", S.actions.readTargetImage);

      var threat = S.u.$("#targetThreat");
      if (threat) {
        threat.addEventListener("input", function () {
          S.u.$("#threatText").innerHTML = S.u.skulls(threat.value);
        });
      }

      var status = S.u.$("#targetStatus");
      if (status) {
        status.addEventListener("change", function () {
          S.u.$("#terminationFields").classList.toggle("hidden", status.value !== "تم التصفية");
        });
      }
    },

    afterRender: function () {
      if (S.state.page === "map") {
        setTimeout(S.map.initMain, 0);
      }
    }
  };

  function login(event) {
    event.preventDefault();
    S.db.loggedIn = true;
    S.db.codename = S.u.clean(S.els.agentName.value) || "العميل الأسود";
    S.store.save();
    S.ui.openApp();
    S.ui.toast("🗝️ تم فتح البوابة.");
  }

  function logout() {
    if (!confirm("تسجيل خروج من وكالة الظل؟")) return;
    S.db.loggedIn = false;
    S.store.save();
    S.ui.resetForms();
    S.ui.closeModal();
    S.ui.showLogin();
    S.ui.toast("🚪 تم إغلاق البوابة.");
  }

  function saveCodename() {
    S.db.codename = S.u.clean(S.els.codenameInput.value) || "العميل الأسود";
    S.store.save();
  }

  window.Agency = S.actions;
  document.addEventListener("DOMContentLoaded", S.app.init);
})();
