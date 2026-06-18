(function () {
  "use strict";

  S.search = {
    run: function () {
      var q = S.u.normalize(S.els.searchInput.value);
      if (!q) {
        S.els.searchResults.classList.add("hidden");
        S.els.searchResults.innerHTML = "";
        return;
      }

      var results = [];
      S.db.targets.forEach(function (target) {
        if (S.u.normalize([target.codename, target.realName, target.description].join(" ")).includes(q)) {
          results.push({ type: "target", id: target.id, title: target.codename, sub: "🎯 هدف" });
        }
      });
      S.db.operations.forEach(function (op) {
        if (S.u.normalize([op.name, op.description].join(" ")).includes(q)) {
          results.push({ type: "operation", id: op.id, title: op.name, sub: "🔥 عملية" });
        }
      });
      S.db.analyses.forEach(function (analysis) {
        if (S.u.normalize([analysis.title, analysis.body].join(" ")).includes(q)) {
          results.push({ type: "analysis", id: analysis.id, title: analysis.title, sub: "🧠 تحليل" });
        }
      });

      S.els.searchResults.innerHTML = results.length
        ? results.slice(0, 12).map(searchItem).join("")
        : S.u.empty("لا توجد نتائج", "غيّر عبارة البحث.");
      S.els.searchResults.classList.remove("hidden");
    }
  };

  function searchItem(item) {
    return '<button class="search-item" onclick="Agency.openSearch(\'' + item.type + "', '" + item.id + '\')"><b>' + S.u.html(item.title) + '</b><small>' + item.sub + "</small></button>";
  }

  S.actions.openSearch = function (type, id) {
    S.els.searchInput.value = "";
    S.els.searchResults.classList.add("hidden");

    if (type === "target") {
      S.state.page = "targets";
      S.ui.render();
      setTimeout(function () {
        var item = S.u.$("#item-" + id);
        if (item) item.scrollIntoView({ behavior: "smooth", block: "center" });
      }, 20);
    }

    if (type === "operation") {
      S.actions.editOperation(id);
    }

    if (type === "analysis") {
      S.actions.editAnalysis(id);
    }
  };
})();
