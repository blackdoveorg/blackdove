/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************!*\
  !*** ./resources/js/interface.js ***!
  \***********************************/
window.jumpBetween = function (from, to) {
  $(from).click(function () {
    $([document.documentElement, document.body]).animate({
      scrollTop: $(to).offset().top
    }, 1000);
  });
};
/******/ })()
;