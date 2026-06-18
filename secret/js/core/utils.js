(function () {
  "use strict";

  S.u = {
    $: function (selector) {
      return document.querySelector(selector);
    },
    $$: function (selector) {
      return Array.from(document.querySelectorAll(selector));
    },
    clean: function (value) {
      return String(value || "").trim();
    },
    html: function (value) {
      return String(value || "")
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
    },
    attr: function (value) {
      return S.u.html(value).replace(/`/g, "&#096;");
    },
    short: function (value, max) {
      value = String(value || "");
      return value.length > max ? value.slice(0, max - 3) + "..." : value;
    },
    normalize: function (value) {
      return S.u.clean(value).toLowerCase()
        .replace(/[إأآا]/g, "ا")
        .replace(/ى/g, "ي")
        .replace(/ؤ/g, "و")
        .replace(/ئ/g, "ي")
        .replace(/ة/g, "ه");
    },
    makeId: function (prefix) {
      return prefix + "_" + Date.now().toString(36) + "_" + Math.random().toString(36).slice(2, 7);
    },
    now: function () {
      return new Date().toISOString();
    },
    today: function () {
      return new Date().toISOString().slice(0, 10);
    },
    newest: function (a, b) {
      return new Date(b.createdAt || b.updatedAt || 0) - new Date(a.createdAt || a.updatedAt || 0);
    },
    dateTime: function (value) {
      if (!value) return "";
      try {
        return new Intl.DateTimeFormat("ar", { dateStyle: "medium", timeStyle: "short" }).format(new Date(value));
      } catch (error) {
        return value;
      }
    },
    options: function (list, selected) {
      return list.map(function (item) {
        return '<option value="' + S.u.attr(item) + '" ' + (item === selected ? "selected" : "") + ">" + S.u.html(item) + "</option>";
      }).join("");
    },
    empty: function (title, text) {
      return '<div class="empty"><strong>' + S.u.html(title) + '</strong><span>' + S.u.html(text) + "</span></div>";
    },
    skulls: function (value) {
      var count = Math.max(1, Math.min(5, Number(value) || 1));
      return '<span class="skulls">' + "☠️".repeat(count) + "</span>";
    },
    statusIcon: function (status) {
      if (status === "نشط") return "🔥";
      if (status === "تحت المراقبة") return "🧿";
      return "☠️";
    },
    locationText: function (coords) {
      if (!coords || typeof coords.lat !== "number" || typeof coords.lng !== "number") return "بلا نقطة دم";
      return "Lat " + coords.lat.toFixed(4) + " / Lng " + coords.lng.toFixed(4);
    },
    copy: function (value) {
      return JSON.parse(JSON.stringify(value));
    },
    round: function (value) {
      return Math.round(Number(value) * 1000000) / 1000000;
    },
    getById: function (list, id) {
      return list.find(function (item) { return item.id === id; }) || null;
    },
    replaceById: function (list, item) {
      var index = list.findIndex(function (row) { return row.id === item.id; });
      if (index !== -1) list[index] = item;
    }
  };
})();
