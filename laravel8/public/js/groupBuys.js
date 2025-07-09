/******/ (() => { // webpackBootstrap
/*!***********************************!*\
  !*** ./resources/js/groupBuys.js ***!
  \***********************************/
function _createForOfIteratorHelper(o, allowArrayLike) { var it; if (typeof Symbol === "undefined" || o[Symbol.iterator] == null) { if (Array.isArray(o) || (it = _unsupportedIterableToArray(o)) || allowArrayLike && o && typeof o.length === "number") { if (it) o = it; var i = 0; var F = function F() {}; return { s: F, n: function n() { if (i >= o.length) return { done: true }; return { done: false, value: o[i++] }; }, e: function e(_e) { throw _e; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var normalCompletion = true, didErr = false, err; return { s: function s() { it = o[Symbol.iterator](); }, n: function n() { var step = it.next(); normalCompletion = step.done; return step; }, e: function e(_e2) { didErr = true; err = _e2; }, f: function f() { try { if (!normalCompletion && it["return"] != null) it["return"](); } finally { if (didErr) throw err; } } }; }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

(function () {
  /** 
   * Ajoute des écouteurs sur les options dynamiques 
   * @param {event} event - évènement cliqué
  */
  setListeners = function setListeners() {
    var _iterator = _createForOfIteratorHelper(document.getElementsByClassName('product-bought')),
        _step;

    try {
      for (_iterator.s(); !(_step = _iterator.n()).done;) {
        var el = _step.value;
        el.addEventListener('change', handleProductChange);
      }
    } catch (err) {
      _iterator.e(err);
    } finally {
      _iterator.f();
    }

    var _iterator2 = _createForOfIteratorHelper(document.getElementsByClassName('dynamic-selected-product')),
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

    var _iterator3 = _createForOfIteratorHelper(document.getElementsByClassName('dynamic-value-product')),
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
   * Ajoute un nouveau produit sélectionnable pour l'achat groupé
   * @param {event} event - évènement cliqué
  */


  getProducts = function getProducts(event) {
    event.preventDefault();

    for (var i = 0; i < document.getElementById('product-nb-to-add').value; i++) {
      var nb = document.getElementById('max-nb-products').value++;
      var userId = document.getElementById('user-id').value;
      getFetch('user/' + userId + '/group_buys/products/' + nb).then(function (res) {
        document.getElementById('all-products-bought').innerHTML += res.html;
      }).then(function () {
        setListeners();
      });
    }
  };
  /** 
   * Met à jour l'affichage lorsque l'on sélectionne un produit dans la liste
   * @param {event} event - évènement cliqué
  */


  handleProductChange = function handleProductChange(event) {
    event.preventDefault();
    var product_id = event.target.value;
    var nb = event.target.dataset.nb;
    getFetch('products/' + product_id + '/picture').then(function (res) {
      document.getElementById('img-product-bought-' + nb).src = res.html;
      document.getElementById('product-link-' + nb).href = res.link;
    });
    getProductDatas(product_id, nb);
  };
  /** 
   * Gère le moment où l'on affiche/ou non, un achat existant
   * @param {event} event - évènement cliqué
   * @param {string} nb - numéro de la ligne
  */


  handleExistingBuy = function handleExistingBuy(event, nb) {
    if (event.checked) {
      document.getElementById('product-bought-exists-' + nb).setAttribute('checked', true);
      document.getElementById('product-bought-purchase-' + nb).classList.remove('hidden');
      document.getElementById('product-bought-offer-' + nb).classList.add('hidden');
      document.getElementById('div-product-bought-nb-' + nb).classList.add('hidden');
      document.getElementById('product-bought-discount-' + nb).classList.add('hidden');
      document.getElementById('product-bought-customs-' + nb).classList.add('hidden');
    } else {
      document.getElementById('product-bought-exists-' + nb).removeAttribute('checked');
      document.getElementById('product-bought-purchase-' + nb).classList.add('hidden');
      document.getElementById('product-bought-offer-' + nb).classList.remove('hidden');
      document.getElementById('div-product-bought-nb-' + nb).classList.remove('hidden');
      document.getElementById('product-bought-discount-' + nb).classList.remove('hidden');
      document.getElementById('product-bought-customs-' + nb).classList.remove('hidden');
    }
  };
  /** 
   * Récupère les données (offres, achats existants) du produit passé
   * @param {int} productId - Identifiant du produit
   * @param {string} nb - numéro de la ligne
  */


  getProductDatas = function getProductDatas(productId, nb) {
    getFetch('group_buys/offer/' + nb + '/product/' + productId + '/datas/').then(function (res) {
      document.getElementById('product-bought-offer-' + nb).innerHTML = res.html.offers;
      document.getElementById('product-bought-purchase-' + nb).innerHTML = res.html.purchases;
    }).then(function () {
      setListeners();
    });
  };

  document.getElementById('add-product').addEventListener('click', getProducts);
  setListeners();
})();
/******/ })()
;