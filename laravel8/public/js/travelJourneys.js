/******/ (() => { // webpackBootstrap
/*!****************************************!*\
  !*** ./resources/js/travelJourneys.js ***!
  \****************************************/
function _createForOfIteratorHelper(r, e) { var t = "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (!t) { if (Array.isArray(r) || (t = _unsupportedIterableToArray(r)) || e && r && "number" == typeof r.length) { t && (r = t); var _n = 0, F = function F() {}; return { s: F, n: function n() { return _n >= r.length ? { done: !0 } : { done: !1, value: r[_n++] }; }, e: function e(r) { throw r; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var o, a = !0, u = !1; return { s: function s() { t = t.call(r); }, n: function n() { var r = t.next(); return a = r.done, r; }, e: function e(r) { u = !0, o = r; }, f: function f() { try { a || null == t["return"] || t["return"](); } finally { if (u) throw o; } } }; }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
(function () {
  /** 
   * Ajoute des écouteurs sur les options dynamiques 
   * @param {event} event - évènement cliqué
  */
  setListeners = function setListeners() {
    var _iterator = _createForOfIteratorHelper(document.getElementsByClassName('travel-step-city')),
      _step;
    try {
      for (_iterator.s(); !(_step = _iterator.n()).done;) {
        var el = _step.value;
        el.addEventListener('change', handleCityChange);
      }
    } catch (err) {
      _iterator.e(err);
    } finally {
      _iterator.f();
    }
    var _iterator2 = _createForOfIteratorHelper(document.getElementsByClassName('dynamic-selected-travel-step')),
      _step2;
    try {
      for (_iterator2.s(); !(_step2 = _iterator2.n()).done;) {
        var _el = _step2.value;
        _el.addEventListener('change', setSelectData);
      }
    } catch (err) {
      _iterator2.e(err);
    } finally {
      _iterator2.f();
    }
    var _iterator3 = _createForOfIteratorHelper(document.getElementsByClassName('dynamic-value-travel-step')),
      _step3;
    try {
      for (_iterator3.s(); !(_step3 = _iterator3.n()).done;) {
        var _el2 = _step3.value;
        _el2.addEventListener('change', setValueData);
      }
    } catch (err) {
      _iterator3.e(err);
    } finally {
      _iterator3.f();
    }
  };

  /** 
   * Ajoute une nouvelle étape
   * @param {event} event - évènement cliqué
  */
  getSteps = function getSteps(event) {
    event.preventDefault();
    for (var i = 0; i < document.getElementById('travel-step-nb-to-add').value; i++) {
      var nb = document.getElementById('max-nb-travel-steps').value++;
      var userId = document.getElementById('user-id').value;
      getFetch('user/' + userId + '/travel_journeys/steps/' + nb).then(function (res) {
        document.getElementById('all-travel-steps').innerHTML += res.html;
      }).then(function () {
        setListeners();
      });
    }
  };

  /** 
   * Met à jour l'affichage lorsque l'on sélectionne une ville dans la liste
   * @param {event} event - évènement cliqué
  */
  handleCityChange = function handleCityChange(event) {
    event.preventDefault();
    var nb = event.target.dataset.nb;
    var nbStep = parseInt(nb, 10) + 1;
    var select = document.getElementById('travel-step-city-id-' + nb);
    var cityName = select.options[select.selectedIndex].text;
    document.getElementById('travel-step-name-' + nb).innerHTML = nbStep + ' - Arrêt à ' + cityName;
  };
  document.getElementById('add-travel-step').addEventListener('click', getSteps);
  var _iterator4 = _createForOfIteratorHelper(document.getElementsByName('add-travel-step-products')),
    _step4;
  try {
    for (_iterator4.s(); !(_step4 = _iterator4.n()).done;) {
      var el = _step4.value;
      el.addEventListener('click', function (event) {
        event.preventDefault();
        getStepProducts(event, event.target.dataset.step);
      });
    }
  } catch (err) {
    _iterator4.e(err);
  } finally {
    _iterator4.f();
  }
  setListeners();
})();
/******/ })()
;