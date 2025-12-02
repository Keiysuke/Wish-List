/******/ (() => { // webpackBootstrap
/*!**********************************!*\
  !*** ./resources/js/my_fetch.js ***!
  \**********************************/
function ownKeys(object, enumerableOnly) { var keys = Object.keys(object); if (Object.getOwnPropertySymbols) { var symbols = Object.getOwnPropertySymbols(object); if (enumerableOnly) symbols = symbols.filter(function (sym) { return Object.getOwnPropertyDescriptor(object, sym).enumerable; }); keys.push.apply(keys, symbols); } return keys; }

function _objectSpread(target) { for (var i = 1; i < arguments.length; i++) { var source = arguments[i] != null ? arguments[i] : {}; if (i % 2) { ownKeys(Object(source), true).forEach(function (key) { _defineProperty(target, key, source[key]); }); } else if (Object.getOwnPropertyDescriptors) { Object.defineProperties(target, Object.getOwnPropertyDescriptors(source)); } else { ownKeys(Object(source)).forEach(function (key) { Object.defineProperty(target, key, Object.getOwnPropertyDescriptor(source, key)); }); } } return target; }

function _defineProperty(obj, key, value) { if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }

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