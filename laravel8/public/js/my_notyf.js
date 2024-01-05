/******/ (() => { // webpackBootstrap
/*!**********************************!*\
  !*** ./resources/js/my_notyf.js ***!
  \**********************************/
window.notyfJS = function (msg, kind) {
  var notyf = new Notyf();
  notyf.open({
    'position': {
      'x': 'right',
      'y': 'top'
    },
    'type': kind,
    'message': msg,
    'duration': 3000,
    'dismissible': true
  });
};

window.my_notyf = function (r) {
  if (r.notyf) {
    var notyf = new Notyf();
    notyf.open(r.notyf);
  }
};
/******/ })()
;