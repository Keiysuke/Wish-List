/******/ (() => { // webpackBootstrap
/*!****************************************!*\
  !*** ./resources/js/travelJourneys.js ***!
  \****************************************/
function _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

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