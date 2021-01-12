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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/wave.js":
/*!******************************!*\
  !*** ./resources/js/wave.js ***!
  \******************************/
/*! no static exports found */
/***/ (function(module, exports) {

window.wave = function () {
  var c = document.getElementById('c'),
      ctx = c.getContext('2d'),
      cw = c.width = $('#container').width(),
      ch = c.height = 200,
      points = [],
      tick = 0,
      opt = {
    count: 10,
    range: {
      x: 0,
      y: 15
    },
    duration: {
      min: 15,
      max: 75
    },
    thickness: 13,
    strokeColor: '#808000',
    level: .25,
    curved: true
  },
      rand = function rand(min, max) {
    return Math.floor(Math.random() * (max - min + 1) + min);
  },
      ease = function ease(t, b, c, d) {
    if ((t /= d / 2) < 1) return c / 2 * t * t + b;
    return -c / 2 * (--t * (t - 2) - 1) + b;
  };

  ctx.lineJoin = 'round';
  ctx.lineWidth = opt.thickness;
  ctx.strokeStyle = opt.strokeColor;

  var Point = function Point(config) {
    this.anchorX = config.x;
    this.anchorY = config.y;
    this.x = config.x;
    this.y = config.y;
    this.setTarget();
  };

  Point.prototype.setTarget = function () {
    this.initialX = this.x;
    this.initialY = this.y;
    this.targetX = this.anchorX + rand(0, opt.range.x * 2) - opt.range.x;
    this.targetY = this.anchorY + rand(0, opt.range.y * 2) - opt.range.y;
    this.tick = 0;
    this.duration = rand(opt.duration.min, opt.duration.max);
  };

  Point.prototype.update = function () {
    var dx = this.targetX - this.x;
    var dy = this.targetY - this.y;
    var dist = Math.sqrt(dx * dx + dy * dy);

    if (Math.abs(dist) <= 0) {
      this.setTarget();
    } else {
      var t = this.tick;
      var b = this.initialY;
      var c = this.targetY - this.initialY;
      var d = this.duration;
      this.y = ease(t, b, c, d);
      b = this.initialX;
      c = this.targetX - this.initialX;
      d = this.duration;
      this.x = ease(t, b, c, d);
      this.tick++;
    }
  };

  Point.prototype.render = function () {
    ctx.beginPath();
    ctx.arc(this.x, this.y, 3, 0, Math.PI * 2, false);
    ctx.fillStyle = '#000';
    ctx.fill();
  };

  var updatePoints = function updatePoints() {
    var i = points.length;

    while (i--) {
      points[i].update();
    }
  };

  var renderPoints = function renderPoints() {
    var i = points.length;

    while (i--) {
      points[i].render();
    }
  };

  var fillPoints = function fillPoints() {
    var i;

    for (i = 0; i < pointCount - 1; i++) {
      var c = (points[i].x + points[i + 1].x) / 2;
      var d = (points[i].y + points[i + 1].y) / 2;
      ctx.quadraticCurveTo(points[i].x, points[i].y, c, d);
    }
  };

  var renderShape = function renderShape() {
    ctx.beginPath();
    var pointCount = points.length;
    ctx.moveTo(points[0].x, points[0].y);
    var i;

    for (i = 0; i < pointCount - 1; i++) {
      var c = (points[i].x + points[i + 1].x) / 2;
      var d = (points[i].y + points[i + 1].y) / 2;
      ctx.quadraticCurveTo(points[i].x, points[i].y, c, d);
    }

    ctx.lineTo(-opt.range.x - opt.thickness, ch + opt.thickness);
    ctx.lineTo(cw + opt.range.x + opt.thickness, ch + opt.thickness);
    ctx.closePath();
    ctx.fillStyle = '#222'; // ctx.fill();  

    ctx.stroke();
  };

  var clear = function clear() {
    ctx.clearRect(0, 0, cw, ch);
  };

  var loop = function loop() {
    window.requestAnimFrame(loop, c);
    tick++;
    clear(); // fillPoints();

    updatePoints();
    renderShape(); // renderPoints();
  };

  var i = opt.count + 2;
  var spacing = (cw + opt.range.x * 2) / (opt.count - 1);

  while (i--) {
    points.push(new Point({
      x: spacing * (i - 1) - opt.range.x,
      y: ch - ch * opt.level
    }));
  }

  window.requestAnimFrame = function () {
    return window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame || function (a) {
      window.setTimeout(a, 1E3 / 60);
    };
  }();

  loop();
};

wave();

/***/ }),

/***/ 3:
/*!************************************!*\
  !*** multi ./resources/js/wave.js ***!
  \************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\xampp\htdocs\blackdove\resources\js\wave.js */"./resources/js/wave.js");


/***/ })

/******/ });