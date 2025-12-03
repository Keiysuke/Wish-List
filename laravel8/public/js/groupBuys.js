/******/ (() => { // webpackBootstrap
/*!***********************************!*\
  !*** ./resources/js/groupBuys.js ***!
  \***********************************/
function _createForOfIteratorHelper(r, e) { var t = "undefined" != typeof Symbol && r[Symbol.iterator] || r["@@iterator"]; if (!t) { if (Array.isArray(r) || (t = _unsupportedIterableToArray(r)) || e && r && "number" == typeof r.length) { t && (r = t); var _n = 0, F = function F() {}; return { s: F, n: function n() { return _n >= r.length ? { done: !0 } : { done: !1, value: r[_n++] }; }, e: function e(r) { throw r; }, f: F }; } throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); } var o, a = !0, u = !1; return { s: function s() { t = t.call(r); }, n: function n() { var r = t.next(); return a = r.done, r; }, e: function e(r) { u = !0, o = r; }, f: function f() { try { a || null == t["return"] || t["return"](); } finally { if (u) throw o; } } }; }
function _unsupportedIterableToArray(r, a) { if (r) { if ("string" == typeof r) return _arrayLikeToArray(r, a); var t = {}.toString.call(r).slice(8, -1); return "Object" === t && r.constructor && (t = r.constructor.name), "Map" === t || "Set" === t ? Array.from(r) : "Arguments" === t || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(t) ? _arrayLikeToArray(r, a) : void 0; } }
function _arrayLikeToArray(r, a) { (null == a || a > r.length) && (a = r.length); for (var e = 0, n = Array(a); e < a; e++) n[e] = r[e]; return n; }
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