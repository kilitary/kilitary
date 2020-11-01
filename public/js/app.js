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
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports) {

var flagTimer;
var shitHappensOnce = false;
var humanWorks = false;

function toggleHuman() {
  humanWorks = !humanWorks;
}

function flagsMovement() {
  var top = parseInt($('#flagright').css('top'));

  if (top < -31 && humanWorks) {
    $('#flagright').css('top', top + 1 + 'px');
  }

  var topl = parseInt($('#flagleft').css('top'));

  if (topl < 12 && rando(true, false) && topl > -116) {
    $('#flagleft').css('top', topl - 1 + 'px');
  }

  prev = parseInt($('#flagleft').css('left'));

  if (topl > -115) {
    $('#flagleft').css('left', prev + rando(-10, 10) + 'px');
  }

  clearTimeout(flagTimer);
  flagTimer = setInterval(flagsMovement, rando(10, 120));
}

function rotateKrysaClass() {
  var rotate = rando(-6, 6); //'.crysa-class').css('transform');

  $('.crysa-class').css('transform', 'rotate(' + rotate + 'deg)');

  if (rando(true, false)) {
    prev = parseInt($('.crysa-class').css('height'));
    $('.crysa-class').css('height', prev + rando(-25, 25) + 'px');
  }
}

$(function () {
  $.protip();
  $('#flagright').css('top', '-100px');
  flagTimer = setInterval(flagsMovement, 20);
  setInterval(toggleHuman, 800);
  setInterval(rotateKrysaClass, 200);

  window.onerror = function (message, source, lineno, columnNumber, error) {
    var errorInfo = {
      column: columnNumber,
      component: component,
      line: lineno,
      message: error.message,
      name: error.name,
      source_url: source,
      stack: error.stack
    };
    chrome.errorReporting.reportError(errorInfo);
    console.log('error ' + errorInfo);
  };
});

/***/ }),

/***/ 0:
/*!***********************************!*\
  !*** multi ./resources/js/app.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! F:\projects\kilitary.ru\resources\js\app.js */"./resources/js/app.js");


/***/ })

/******/ });