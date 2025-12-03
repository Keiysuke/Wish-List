/******/ (() => { // webpackBootstrap
/*!**********************************!*\
  !*** ./resources/js/my_fetch.js ***!
  \**********************************/
function _typeof(o) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (o) { return typeof o; } : function (o) { return o && "function" == typeof Symbol && o.constructor === Symbol && o !== Symbol.prototype ? "symbol" : typeof o; }, _typeof(o); }
function ownKeys(e, r) { var t = Object.keys(e); if (Object.getOwnPropertySymbols) { var o = Object.getOwnPropertySymbols(e); r && (o = o.filter(function (r) { return Object.getOwnPropertyDescriptor(e, r).enumerable; })), t.push.apply(t, o); } return t; }
function _objectSpread(e) { for (var r = 1; r < arguments.length; r++) { var t = null != arguments[r] ? arguments[r] : {}; r % 2 ? ownKeys(Object(t), !0).forEach(function (r) { _defineProperty(e, r, t[r]); }) : Object.getOwnPropertyDescriptors ? Object.defineProperties(e, Object.getOwnPropertyDescriptors(t)) : ownKeys(Object(t)).forEach(function (r) { Object.defineProperty(e, r, Object.getOwnPropertyDescriptor(t, r)); }); } return e; }
function _defineProperty(e, r, t) { return (r = _toPropertyKey(r)) in e ? Object.defineProperty(e, r, { value: t, enumerable: !0, configurable: !0, writable: !0 }) : e[r] = t, e; }
function _toPropertyKey(t) { var i = _toPrimitive(t, "string"); return "symbol" == _typeof(i) ? i : i + ""; }
function _toPrimitive(t, r) { if ("object" != _typeof(t) || !t) return t; var e = t[Symbol.toPrimitive]; if (void 0 !== e) { var i = e.call(t, r || "default"); if ("object" != _typeof(i)) return i; throw new TypeError("@@toPrimitive must return a primitive value."); } return ("string" === r ? String : Number)(t); }
window.myFetch = function (url, headers, datas) {
  // Récupère le token CSRF de façon robuste : meta[name=csrf-token] ou cookie XSRF-TOKEN
  var csrfToken = null;
  if (headers.csrf) {
    var meta = document.querySelector('meta[name="csrf-token"]');
    if (meta && meta.getAttribute('content')) {
      csrfToken = meta.getAttribute('content');
    } else {
      // fallback: chercher le cookie XSRF-TOKEN
      var match = document.cookie.match(new RegExp('(^|; )XSRF-TOKEN=([^;]+)'));
      if (match) csrfToken = decodeURIComponent(match[2]);
    }
  }
  var csrfHeader = headers.csrf && csrfToken ? {
    "X-CSRF-Token": csrfToken
  } : {};
  if (headers.csrf && !csrfToken) console.warn('CSRF token not found in meta or cookie; request may be rejected.');
  return fetch(url, {
    headers: _objectSpread({
      "Content-Type": "application/json",
      "X-Requested-With": "XMLHttpRequest"
    }, csrfHeader),
    method: headers['method'],
    body: JSON.stringify(datas)
  });
};
window.getFetch = function (url) {
  return fetch('http://localhost/00%20-%20API/products-managing/laravel8/public/' + url, {
    headers: {
      "X-Requested-With": "XMLHttpRequest"
    },
    method: 'get'
  }).then(function (response) {
    if (response.ok) return response.json();
  });
};
/******/ })()
;