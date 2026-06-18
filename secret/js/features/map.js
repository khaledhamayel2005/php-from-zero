(function () {
  "use strict";

  S.views.map = function () {
    return `
      ${S.ui.pageHead("🩸 خريطة فلسطين", "خريطة داكنة محصورة على فلسطين لتعيين نقاط الدم وحفظها داخل ملفات الأهداف.", "")}
      <div class="map-layout">
        <div class="map-box"><div id="palestineMap"></div></div>
        <aside id="mapInfo" class="panel">
          <h3>🧭 تحكم نقاط الدم</h3>
          <label>اختر هدفًا لوضعه أو نقله
            <select id="mapTargetSelect">
              <option value="">اختر الهدف</option>
              ${S.db.targets.map(function (target) {
                var selected = S.state.mapPlaceTarget === target.id || S.state.selectedMapTarget === target.id;
                return `<option value="${target.id}" ${selected ? "selected" : ""}>${S.u.html(target.codename)}</option>`;
              }).join("")}
            </select>
          </label>
          <div class="map-actions">
            <button class="btn small primary" onclick="Agency.enableMapPlacement()">🩸 وضع/نقل نقطة دم</button>
            <button class="btn small danger" onclick="Agency.clearMapTargetLocation()">🧨 مسح النقطة</button>
          </div>
          <p id="mapPlaceHint" class="picker-note">${S.state.mapPlacementActive ? "وضع النقل مفعل: اضغط على فلسطين لحفظ نقطة الدم." : "اختر هدفًا ثم فعّل وضع نقطة الدم."}</p>
          <div class="palestine-scope">🌑 نطاق الحركة محصور على فلسطين. كل نقطة تحفظ بإحداثيات حقيقية.</div>
          <div id="mapDetails">${mapInfo(S.state.selectedMapTarget ? getTarget(S.state.selectedMapTarget) : null)}</div>
        </aside>
      </div>
    `;
  };

  function mapInfo(target) {
    if (!target) {
      return `
        <h3>🩸 ملف النقطة</h3>
        <p class="text">اختر نقطة دم أو حدد هدفًا من القائمة لتعيين موقعه.</p>
        ${S.db.targets.some(function (item) { return item.coords; }) ? "" : S.u.empty("لا توجد نقاط دم", "حدد نقطة من ملف الهدف أو مباشرة من الخريطة.")}
      `;
    }

    return `
      <div class="card-head">
        <div class="thumb">${target.image ? `<img src="${target.image}" alt="">` : "🩸"}</div>
        <div>
          <h3>🎯 ${S.u.html(target.codename)}</h3>
          <small class="muted">${S.u.locationText(target.coords)}</small>
        </div>
      </div>
      <div class="tags">
        <span class="tag ${target.status === "تم التصفية" ? "red" : "green"}">${S.u.statusIcon(target.status)} ${S.u.html(target.status)}</span>
        <span class="tag amber">${S.u.skulls(target.threat)}</span>
      </div>
      <p class="text">${S.u.html(target.description || "لا توجد ملاحظات.")}</p>
      <button class="btn small" onclick="Agency.editTarget('${target.id}')">✒️ فتح الملف</button>
    `;
  }

  S.map = {
    initMain: function () {
      if (!window.L) {
        S.u.$("#palestineMap").innerHTML = S.u.empty("تعذر تحميل الخريطة", "تحقق من الاتصال بالإنترنت.");
        return;
      }

      if (S.state.mainMap) {
        S.state.mainMap.remove();
        S.state.mainMap = null;
      }

      S.state.mainMap = L.map("palestineMap", {
        zoomControl: true,
        maxBounds: S.config.palestineBounds,
        maxBoundsViscosity: 1,
        minZoom: 7
      });

      addTiles(S.state.mainMap);
      drawPalestineScope(S.state.mainMap);
      S.state.mainMarkers = L.layerGroup().addTo(S.state.mainMap);
      S.state.mainMap.on("click", savePointFromMainMap);
      drawMarkers();

      var selected = S.state.selectedMapTarget ? getTarget(S.state.selectedMapTarget) : null;
      if (selected && selected.coords && insidePalestine(selected.coords)) {
        S.state.mainMap.setView([selected.coords.lat, selected.coords.lng], 12);
      } else {
        S.state.mainMap.fitBounds(S.config.palestineBounds);
      }
    }
  };

  function addTiles(map) {
    L.tileLayer("https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png", {
      maxZoom: 20,
      attribution: "&copy; OpenStreetMap &copy; CARTO"
    }).addTo(map);
    L.control.scale({ imperial: false, position: "bottomleft" }).addTo(map);
  }

  function drawPalestineScope(map) {
    L.polygon(S.config.palestinePolygon, {
      color: "#cf1515",
      weight: 2,
      opacity: 0.85,
      fillColor: "#8B0000",
      fillOpacity: 0.12,
      dashArray: "8 8"
    }).addTo(map).bindTooltip("فلسطين", {
      permanent: true,
      direction: "center",
      className: "palestine-label"
    });
  }

  function drawMarkers() {
    if (!S.state.mainMarkers) return;
    S.state.mainMarkers.clearLayers();

    S.db.targets.forEach(function (target) {
      if (!target.coords) return;
      var marker = L.marker([target.coords.lat, target.coords.lng], {
        icon: bloodIcon(),
        bubblingMouseEvents: false
      }).addTo(S.state.mainMarkers);

      marker.bindPopup("<b>🩸 " + S.u.html(target.codename) + "</b><br>" + S.u.html(target.status));
      marker.on("click", function () {
        S.state.selectedMapTarget = target.id;
        S.state.mapPlaceTarget = target.id;
        S.state.mapPlacementActive = false;
        updateMapPanel();
      });
    });
  }

  function bloodIcon() {
    return L.divIcon({
      className: "",
      html: '<div class="blood-marker">🩸</div>',
      iconSize: [36, 36],
      iconAnchor: [18, 18]
    });
  }

  function savePointFromMainMap(event) {
    if (!S.state.mapPlacementActive || !S.state.mapPlaceTarget) return;
    var coords = { lat: S.u.round(event.latlng.lat), lng: S.u.round(event.latlng.lng) };
    if (!insidePalestine(coords)) {
      S.ui.toast("النقطة خارج نطاق فلسطين.");
      return;
    }

    var target = getTarget(S.state.mapPlaceTarget);
    if (!target) {
      S.ui.toast("الهدف المحدد غير موجود.");
      return;
    }

    target.coords = coords;
    target.updatedAt = S.u.now();
    S.state.selectedMapTarget = target.id;
    S.state.mapPlacementActive = false;
    S.store.save();
    drawMarkers();
    updateMapPanel();
    S.ui.toast("💾 تم حفظ نقطة الدم على خريطة فلسطين.");
  }

  function updateMapPanel() {
    var details = S.u.$("#mapDetails");
    var hint = S.u.$("#mapPlaceHint");
    var select = S.u.$("#mapTargetSelect");
    var target = S.state.selectedMapTarget ? getTarget(S.state.selectedMapTarget) : null;

    if (details) details.innerHTML = mapInfo(target);
    if (hint) {
      hint.textContent = S.state.mapPlacementActive
        ? "وضع النقل مفعل: اضغط على فلسطين لحفظ نقطة الدم."
        : "اختر هدفًا ثم فعّل وضع نقطة الدم.";
    }
    if (select && S.state.mapPlaceTarget) select.value = S.state.mapPlaceTarget;
  }

  function getTarget(id) {
    return S.u.getById(S.db.targets, id);
  }

  function insidePalestine(coords) {
    var b = S.config.palestineBounds;
    return coords &&
      coords.lat >= b[0][0] && coords.lat <= b[1][0] &&
      coords.lng >= b[0][1] && coords.lng <= b[1][1];
  }

  S.actions.focusMap = function (id) {
    S.state.selectedMapTarget = id;
    S.state.mapPlaceTarget = id;
    S.state.mapPlacementActive = false;
    S.state.page = "map";
    S.ui.resetForms();
    S.ui.render();
  };

  S.actions.enableMapPlacement = function () {
    var select = S.u.$("#mapTargetSelect");
    S.state.mapPlaceTarget = select ? select.value : "";
    if (!S.state.mapPlaceTarget) {
      S.ui.toast("اختر هدفًا من القائمة أولًا.");
      return;
    }
    S.state.selectedMapTarget = S.state.mapPlaceTarget;
    S.state.mapPlacementActive = true;
    updateMapPanel();
    S.ui.toast("🩸 اضغط على الخريطة لحفظ نقطة الدم.");
  };

  S.actions.clearMapTargetLocation = function () {
    var select = S.u.$("#mapTargetSelect");
    var id = select && select.value ? select.value : S.state.mapPlaceTarget || S.state.selectedMapTarget;
    var target = getTarget(id);
    if (!target) {
      S.ui.toast("اختر هدفًا لمسح نقطته.");
      return;
    }
    if (!confirm("مسح نقطة الدم الخاصة بـ " + target.codename + "؟")) return;
    target.coords = null;
    target.updatedAt = S.u.now();
    S.state.selectedMapTarget = target.id;
    S.state.mapPlaceTarget = target.id;
    S.state.mapPlacementActive = false;
    S.store.save();
    drawMarkers();
    updateMapPanel();
    S.ui.toast("🧨 تم مسح نقطة الدم.");
  };

  S.actions.openMapPicker = function () {
    S.els.modal.classList.remove("hidden");
    S.state.pickerDraftLocation = S.state.formLocation ? S.u.copy(S.state.formLocation) : null;
    S.els.modal.innerHTML = `
      <div class="modal-card">
        <div class="modal-head">
          <h3>🩸 تحديد نقطة دم على فلسطين</h3>
          <button class="btn small ghost" onclick="Agency.closeModal()">إغلاق</button>
        </div>
        <p class="picker-note">اضغط داخل فلسطين لوضع العلامة، اسحب نقطة الدم للتعديل، ثم احفظ.</p>
        <div class="picker-toolbar">
          <span id="pickerCoords" class="tag red">⌖ ${S.u.locationText(S.state.pickerDraftLocation)}</span>
          <button class="btn small primary" type="button" onclick="Agency.savePickedLocation()">💾 حفظ النقطة</button>
          <button class="btn small" type="button" onclick="Agency.useMyLocation()">📍 موقعي</button>
          <button class="btn small danger" type="button" onclick="Agency.clearPickedLocation()">🧨 مسح النقطة</button>
        </div>
        <div class="map-box picker-map-box"><div id="pickerMap"></div></div>
      </div>
    `;
    setTimeout(initPickerMap, 0);
  };

  function initPickerMap() {
    if (!window.L) {
      S.u.$("#pickerMap").innerHTML = S.u.empty("تعذر تحميل الخريطة", "تحقق من الاتصال بالإنترنت.");
      return;
    }

    if (S.state.pickerMap) {
      S.state.pickerMap.remove();
      S.state.pickerMap = null;
    }

    S.state.pickerMap = L.map("pickerMap", {
      maxBounds: S.config.palestineBounds,
      maxBoundsViscosity: 1,
      minZoom: 7
    });

    addTiles(S.state.pickerMap);
    drawPalestineScope(S.state.pickerMap);
    S.state.pickerMap.fitBounds(S.config.palestineBounds);

    if (S.state.pickerDraftLocation) {
      setPickerMarker(S.state.pickerDraftLocation, true);
    }

    S.state.pickerMap.on("click", function (event) {
      setPickerMarker({
        lat: S.u.round(event.latlng.lat),
        lng: S.u.round(event.latlng.lng)
      }, false);
    });

    S.state.pickerMap.invalidateSize();
  }

  function setPickerMarker(coords, centerMap) {
    if (!insidePalestine(coords)) {
      S.ui.toast("النقطة خارج نطاق فلسطين.");
      return;
    }

    S.state.pickerDraftLocation = {
      lat: S.u.round(coords.lat),
      lng: S.u.round(coords.lng)
    };

    if (!S.state.pickerMap) return;

    if (S.state.pickerMarker) {
      S.state.pickerMarker.setLatLng([S.state.pickerDraftLocation.lat, S.state.pickerDraftLocation.lng]);
    } else {
      S.state.pickerMarker = L.marker([S.state.pickerDraftLocation.lat, S.state.pickerDraftLocation.lng], {
        icon: bloodIcon(),
        draggable: true
      }).addTo(S.state.pickerMap);

      S.state.pickerMarker.on("dragend", function () {
        var pos = S.state.pickerMarker.getLatLng();
        setPickerMarker({ lat: pos.lat, lng: pos.lng }, false);
      });
    }

    if (centerMap) S.state.pickerMap.setView([S.state.pickerDraftLocation.lat, S.state.pickerDraftLocation.lng], 12);
    updatePickerText();
  }

  function updatePickerText() {
    var coords = S.u.$("#pickerCoords");
    if (coords) coords.textContent = "⌖ " + S.u.locationText(S.state.pickerDraftLocation);
  }

  S.actions.savePickedLocation = function () {
    if (!S.state.pickerDraftLocation) {
      S.ui.toast("ضع نقطة دم على الخريطة أولًا.");
      return;
    }
    S.state.formLocation = S.u.copy(S.state.pickerDraftLocation);
    var text = S.u.$("#locationText");
    if (text) text.textContent = "🩸 " + S.u.locationText(S.state.formLocation);
    S.ui.closeModal();
    S.ui.toast("💾 تم حفظ نقطة الدم داخل ملف الهدف.");
  };

  S.actions.clearPickedLocation = function () {
    S.state.pickerDraftLocation = null;
    S.state.formLocation = null;
    if (S.state.pickerMarker) {
      S.state.pickerMarker.remove();
      S.state.pickerMarker = null;
    }
    var text = S.u.$("#locationText");
    if (text) text.textContent = "🩸 بلا نقطة دم";
    updatePickerText();
    S.ui.toast("🧨 تم مسح نقطة الدم.");
  };

  S.actions.useMyLocation = function () {
    if (!navigator.geolocation) {
      S.ui.toast("المتصفح لا يدعم تحديد الموقع.");
      return;
    }

    S.ui.toast("📍 جار تحديد الموقع...");
    navigator.geolocation.getCurrentPosition(function (position) {
      setPickerMarker({
        lat: position.coords.latitude,
        lng: position.coords.longitude
      }, true);
      S.ui.toast("📍 تم وضع العلامة على موقع الجهاز.");
    }, function () {
      S.ui.toast("تعذر الوصول للموقع. اختر نقطة يدويًا.");
    }, {
      enableHighAccuracy: true,
      timeout: 8000,
      maximumAge: 0
    });
  };
})();
