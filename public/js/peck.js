/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 2);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/peck.js":
/*!******************************!*\
  !*** ./resources/js/peck.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

$(function () {
  var canvas = document.querySelector('#box');
  var ctx = canvas.getContext('2d');

  var interpolate = function interpolate(value, start, end) {
    return (end - start) * value + start;
  };

  var interpolateRGB = function interpolateRGB(value, start, end) {
    return {
      r: interpolate(value, start.r, end.r),
      g: interpolate(value, start.g, end.g),
      b: interpolate(value, start.b, end.b)
    };
  };

  var calcColor = function calcColor(point, topLeft, topRight, bottomLeft, bottomRight) {
    var top = interpolateRGB(point.x, topLeft, topRight);
    var bottom = interpolateRGB(point.x, bottomLeft, bottomRight);
    var result = interpolateRGB(point.y, top, bottom);
    return result;
  };

  var drawCanvas = function drawCanvas() {
    var imageData = ctx.createImageData(canvas.width, canvas.height);

    for (var y = 0; y < canvas.height; y += 1) {
      for (var x = 0; x < canvas.width; x += 1) {
        var colors = [{
          r: 0,
          g: 179,
          b: 255
        }, {
          r: 255,
          g: 59,
          b: 0
        }, {
          r: 0,
          g: 0,
          b: 0
        }, {
          r: 34,
          g: 230,
          b: 92
        }];
        var color = calcColor.apply(void 0, [{
          x: x / (canvas.width - 1),
          y: y / (canvas.height - 1)
        }].concat(colors));
        imageData.data[(y * canvas.width + x) * 4] = color.r;
        imageData.data[(y * canvas.width + x) * 4 + 1] = color.g;
        imageData.data[(y * canvas.width + x) * 4 + 2] = color.b;
        imageData.data[(y * canvas.width + x) * 4 + 3] = 255;
      }
    }

    ctx.putImageData(imageData, 0, 0);
  };

  var resizeCanvas = function resizeCanvas(width, height) {
    canvas.width = width;
    canvas.height = height;
    drawCanvas();
  };

  resizeCanvas(window.innerWidth, window.innerHeight); //Variables

  var canvasx = $('#box').offset().left;
  var canvasy = $('#box').offset().top;
  var last_mousex = last_mousey = 0;
  var mousex = mousey = 0;
  var mousedown = false; //Mousedown

  $('#box').on('mousedown', function (e) {
    last_mousex = parseInt(e.clientX - canvasx);
    last_mousey = parseInt(e.clientY - canvasy);
    mousedown = true;
  }); //Mouseup

  $('#box').on('mouseup', function (e) {
    mousedown = false;
  }); //Mousemove

  $('#box').on('mousemove', function (e) {
    mousex = parseInt(e.clientX - canvasx);
    mousey = parseInt(e.clientY - canvasy);

    if (mousedown) {
      //ctx.clearRect(0,0,canvas.width,canvas.height); //clear canvas
      ctx.beginPath();
      var width = mousex - last_mousex;
      var height = mousey - last_mousey;
      ctx.rect(last_mousex, last_mousey, width, height);
      ctx.strokeStyle = 'black';
      ctx.lineWidth = 10;
      ctx.stroke();
    } //Output


    $('#output').html('current: ' + mousex + ', ' + mousey + '<br/>last: ' + last_mousex + ', ' + last_mousey + '<br/>mousedown: ' + mousedown);
  });
  window.addEventListener('resize', function () {
    return resizeCanvas(window.innerWidth, window.innerHeight);
  });
});

/***/ }),

/***/ 2:
/*!************************************!*\
  !*** multi ./resources/js/peck.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\blackdove\resources\js\peck.js */"./resources/js/peck.js");


/***/ })

/******/ });