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
/******/ 	return __webpack_require__(__webpack_require__.s = 1);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/zaposljavanje/kreirajIspit.js":
/*!****************************************************!*\
  !*** ./resources/js/zaposljavanje/kreirajIspit.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

window.Questions = function (options) {
  /* Variables accessible in the class */
  var vars = {
    wrapper: $("#questions-body"),
    exam: 0,
    url: '',
    questions: 0,
    current: 0,
    data: '',
    percent: 0,
    total: 0,
    first: 'p0',
    what: '',
    konkurs: ''
  };
  /*
   |--------------------------------------------------------------------------------------------------------------
   |      X-CSRF TOKEN - LARAVEL
   |--------------------------------------------------------------------------------------------------------------
   |
   |     There is one great thing, we can set by default X-CSRF token for laravel. If we do not use Laravel,
   |     we can disable this option. By default, it's enabled !!
   |
   */

  var setCSRF = function setCSRF() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
  };

  this.enableCSRF = function () {
    vars.csrf = true;
  };

  this.disableCSRF = function () {
    vars.csrf = false;
  };
  /* Can access this.method inside other methods using root.method() */


  var root = this;
  /* Constructor */

  this.construct = function (options) {
    $.extend(vars, options);
    createRequest();
  };

  var createRequest = function createRequest() {
    setCSRF();
    vars.percent = parseInt(100 / vars.questions);
    $.ajax({
      type: 'POST',
      url: vars.url,
      data: {
        "ispit": vars.exam,
        'pitanja': vars.questions,
        'id_ispita': vars.exam
      },
      success: function success(data) {
        vars.data = JSON.parse(data);
        appendThem();
      }
    });
  };

  var appendThem = function appendThem() {
    var interval = setInterval(function () {
      if (vars.current < vars.data.length) {
        vars.total += vars.percent;
        changeCircle(vars.total);
        var val = '<tr>';
        val += '<th scope="col" class="text-center" width="40px">' + (vars.current + 1) + '</th><th scope="col"> ' + vars.data[vars.current++]['pitanje'] + ' </th>';
        val += '<th scope="col" class="text-center" width="120px"> <a href="" title="Obrišite pitanje"> <i class="fas fa-trash"></i> Obriši </a> </th>';
        val += '</tr>';
        $("#questions-body").append(val);
      } else {
        console.log("we are now here !!" + vars.what);
        clearInterval(interval);
        window.location = vars.what;
        return false;
      }
    }, 300);
  };

  var changeCircle = function changeCircle(total) {
    var classes = $(".c100").removeClass(vars.first).addClass("p" + total);
    vars.first = 'p' + total;
    $("#percentage-values").html(total + '%');
  };
  /* Pass options when class instantiated */


  this.construct(options);
};
/**********************************************************************************************************************/

/***/ }),

/***/ 1:
/*!**********************************************************!*\
  !*** multi ./resources/js/zaposljavanje/kreirajIspit.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\core-fbih\resources\js\zaposljavanje\kreirajIspit.js */"./resources/js/zaposljavanje/kreirajIspit.js");


/***/ })

/******/ });