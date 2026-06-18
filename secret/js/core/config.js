(function () {
  "use strict";

  window.S = window.S || {};

  S.config = {
    storageKey: "shadowAgency.blackOps.v2",
    oldStorageKey: "shadowAgency.blackOps.v1",
    pages: ["dashboard", "targets", "operations", "terminations", "analysis", "map", "missions"],
    statuses: ["نشط", "تحت المراقبة", "تم التصفية"],
    priorities: ["منخفضة", "متوسطة", "عالية", "حرجة"],
    operationStatuses: ["تخطيط", "نشطة", "مغلقة"],
    palestineCenter: [31.9, 35.2],
    palestineBounds: [[29.45, 34.1], [33.45, 36.05]],
    palestinePolygon: [
      [33.32, 35.1],
      [32.88, 35.55],
      [32.15, 35.48],
      [31.45, 35.42],
      [31.02, 34.95],
      [31.25, 34.25],
      [31.75, 34.3],
      [32.35, 34.65],
      [33.05, 34.9]
    ]
  };

  S.state = {
    page: "dashboard",
    editingTarget: null,
    editingOperation: null,
    editingAnalysis: null,
    imageCache: "",
    formLocation: null,
    selectedMapTarget: null,
    mapPlaceTarget: "",
    mapPlacementActive: false,
    mainMap: null,
    mainMarkers: null,
    pickerMap: null,
    pickerMarker: null,
    pickerDraftLocation: null,
    toastTimer: null
  };

  S.els = {};
  S.views = {};
  S.actions = {};
})();
