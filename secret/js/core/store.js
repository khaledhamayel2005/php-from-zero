(function () {
  "use strict";

  function emptyDB() {
    return {
      loggedIn: false,
      codename: "",
      targets: [],
      operations: [],
      terminations: [],
      analyses: [],
      missions: []
    };
  }

  function normalizeData(data) {
    return {
      loggedIn: !!data.loggedIn,
      codename: data.codename || "",
      targets: Array.isArray(data.targets) ? data.targets : [],
      operations: Array.isArray(data.operations) ? data.operations : [],
      terminations: Array.isArray(data.terminations) ? data.terminations : [],
      analyses: Array.isArray(data.analyses) ? data.analyses : [],
      missions: Array.isArray(data.missions) ? data.missions : []
    };
  }

  S.store = {
    load: function () {
      try {
        var saved = localStorage.getItem(S.config.storageKey) || localStorage.getItem(S.config.oldStorageKey);
        return saved ? normalizeData(JSON.parse(saved)) : emptyDB();
      } catch (error) {
        return emptyDB();
      }
    },
    save: function () {
      try {
        localStorage.setItem(S.config.storageKey, JSON.stringify(S.db));
      } catch (error) {
        S.ui.toast("تعذر حفظ البيانات. مساحة التخزين قد تكون ممتلئة.");
      }
    },
    migrateLocations: function () {
      var changed = false;

      S.db.targets.forEach(function (target) {
        if (target.coords && typeof target.coords.x === "number" && typeof target.coords.y === "number") {
          target.coords = {
            lat: S.u.round(29.55 + (1 - target.coords.y / 600) * 3.65),
            lng: S.u.round(34.18 + (target.coords.x / 1000) * 1.7)
          };
          changed = true;
        }
      });

      if (changed) S.store.save();
    }
  };

  S.db = S.store.load();
})();
