(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["hashtag"],{

/***/ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/Hashtag.vue?vue&type=script&lang=js&":
/*!*************************************************************************************************************************************************************!*\
  !*** ./node_modules/babel-loader/lib??ref--4-0!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/Hashtag.vue?vue&type=script&lang=js& ***!
  \*************************************************************************************************************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! @babel/runtime/regenerator */ "./node_modules/@babel/runtime/regenerator/index.js");
/* harmony import */ var _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
/* harmony import */ var axios__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(axios__WEBPACK_IMPORTED_MODULE_1__);
/* harmony import */ var _components_AppTitle_vue__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../components/AppTitle.vue */ "./resources/js/components/AppTitle.vue");
/* harmony import */ var _components_PostCardList_vue__WEBPACK_IMPORTED_MODULE_3__ = __webpack_require__(/*! ../components/PostCardList.vue */ "./resources/js/components/PostCardList.vue");


function _toConsumableArray(arr) { return _arrayWithoutHoles(arr) || _iterableToArray(arr) || _unsupportedIterableToArray(arr) || _nonIterableSpread(); }

function _nonIterableSpread() { throw new TypeError("Invalid attempt to spread non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method."); }

function _unsupportedIterableToArray(o, minLen) { if (!o) return; if (typeof o === "string") return _arrayLikeToArray(o, minLen); var n = Object.prototype.toString.call(o).slice(8, -1); if (n === "Object" && o.constructor) n = o.constructor.name; if (n === "Map" || n === "Set") return Array.from(o); if (n === "Arguments" || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n)) return _arrayLikeToArray(o, minLen); }

function _iterableToArray(iter) { if (typeof Symbol !== "undefined" && Symbol.iterator in Object(iter)) return Array.from(iter); }

function _arrayWithoutHoles(arr) { if (Array.isArray(arr)) return _arrayLikeToArray(arr); }

function _arrayLikeToArray(arr, len) { if (len == null || len > arr.length) len = arr.length; for (var i = 0, arr2 = new Array(len); i < len; i++) { arr2[i] = arr[i]; } return arr2; }

function asyncGeneratorStep(gen, resolve, reject, _next, _throw, key, arg) { try { var info = gen[key](arg); var value = info.value; } catch (error) { reject(error); return; } if (info.done) { resolve(value); } else { Promise.resolve(value).then(_next, _throw); } }

function _asyncToGenerator(fn) { return function () { var self = this, args = arguments; return new Promise(function (resolve, reject) { var gen = fn.apply(self, args); function _next(value) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "next", value); } function _throw(err) { asyncGeneratorStep(gen, resolve, reject, _next, _throw, "throw", err); } _next(undefined); }); }; }

//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//
//



/* harmony default export */ __webpack_exports__["default"] = ({
  components: {
    AppTitle: _components_AppTitle_vue__WEBPACK_IMPORTED_MODULE_2__["default"],
    PostCardList: _components_PostCardList_vue__WEBPACK_IMPORTED_MODULE_3__["default"]
  },
  data: function data() {
    return {
      hashtag: this.$route.params.hashtag,
      next: null,
      posts: []
    };
  },
  computed: {
    loggedIn: function loggedIn() {
      return this.$store.getters['auth/loggedIn'];
    }
  },
  watch: {
    $route: function $route(to, from) {
      this.hashtag = to.params.hashtag;
      this.next = null;
      this.posts = [];
      this.fetchPost();
    }
  },
  created: function created() {
    this.fetchPost();
  },
  methods: {
    fetchPost: function fetchPost() {
      var _this = this;

      return _asyncToGenerator( /*#__PURE__*/_babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.mark(function _callee() {
        var _this$posts;

        var params, response;
        return _babel_runtime_regenerator__WEBPACK_IMPORTED_MODULE_0___default.a.wrap(function _callee$(_context) {
          while (1) {
            switch (_context.prev = _context.next) {
              case 0:
                params = {
                  hashtag: _this.hashtag
                };

                if (_this.next) {
                  params.maxId = _this.next;
                }

                _context.next = 4;
                return axios__WEBPACK_IMPORTED_MODULE_1___default.a.get('/api/posts', {
                  params: params
                });

              case 4:
                response = _context.sent;

                (_this$posts = _this.posts).push.apply(_this$posts, _toConsumableArray(response.data.posts));

                _this.next = response.data.next;

              case 7:
              case "end":
                return _context.stop();
            }
          }
        }, _callee);
      }))();
    },
    likePost: function likePost(post) {
      if (!this.loggedIn) {
        if (confirm('いいねするにはログインが必要です')) {
          this.$router.push('/login');
        }

        return;
      }

      if (post.liking) {
        axios__WEBPACK_IMPORTED_MODULE_1___default.a["delete"]("/api/post/".concat(post.id, "/unlike")).then(function (response) {
          post.liking = false;
        });
      } else {
        axios__WEBPACK_IMPORTED_MODULE_1___default.a.post("/api/post/".concat(post.id, "/like")).then(function (response) {
          post.liking = true;
        });
      }
    },
    deletePost: function deletePost(post) {
      var _this2 = this;

      axios__WEBPACK_IMPORTED_MODULE_1___default.a["delete"]("/api/post/".concat(post.id), this.form).then(function (response) {
        _this2.posts = _this2.posts.filter(function (p) {
          return p.id !== post.id;
        });
      });
    }
  }
});

/***/ }),

/***/ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/Hashtag.vue?vue&type=template&id=7b570e53&":
/*!*****************************************************************************************************************************************************************************************************!*\
  !*** ./node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!./node_modules/vue-loader/lib??vue-loader-options!./resources/js/pages/Hashtag.vue?vue&type=template&id=7b570e53& ***!
  \*****************************************************************************************************************************************************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "render", function() { return render; });
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return staticRenderFns; });
var render = function() {
  var _vm = this
  var _h = _vm.$createElement
  var _c = _vm._self._c || _h
  return _c(
    "div",
    { staticClass: "h-full flex justify-center items-center lg:p-6" },
    [
      _c(
        "div",
        { staticClass: "w-full max-w-lg" },
        [
          _c(
            "div",
            { staticClass: "flex items-center bg-gray-900 p-4 mb-2" },
            [
              _c(
                "router-link",
                { staticClass: "text-white mr-2", attrs: { to: "/" } },
                [
                  _c("font-awesome-icon", {
                    staticClass: "mr-4",
                    attrs: { icon: ["fas", "arrow-left"], size: "lg" }
                  })
                ],
                1
              ),
              _vm._v(" "),
              _c(
                "div",
                [
                  _c("app-title", {
                    staticClass: "text-white",
                    attrs: { title: "#" + _vm.hashtag }
                  })
                ],
                1
              )
            ],
            1
          ),
          _vm._v(" "),
          _c("post-card-list", {
            attrs: {
              posts: _vm.posts,
              next: !!_vm.next,
              handleFetchPost: _vm.fetchPost,
              handleLikePost: _vm.likePost,
              handleDeletePost: _vm.deletePost
            }
          })
        ],
        1
      )
    ]
  )
}
var staticRenderFns = []
render._withStripped = true



/***/ }),

/***/ "./resources/js/pages/Hashtag.vue":
/*!****************************************!*\
  !*** ./resources/js/pages/Hashtag.vue ***!
  \****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _Hashtag_vue_vue_type_template_id_7b570e53___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ./Hashtag.vue?vue&type=template&id=7b570e53& */ "./resources/js/pages/Hashtag.vue?vue&type=template&id=7b570e53&");
/* harmony import */ var _Hashtag_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ./Hashtag.vue?vue&type=script&lang=js& */ "./resources/js/pages/Hashtag.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport *//* harmony import */ var _node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__ = __webpack_require__(/*! ../../../node_modules/vue-loader/lib/runtime/componentNormalizer.js */ "./node_modules/vue-loader/lib/runtime/componentNormalizer.js");





/* normalize component */

var component = Object(_node_modules_vue_loader_lib_runtime_componentNormalizer_js__WEBPACK_IMPORTED_MODULE_2__["default"])(
  _Hashtag_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_1__["default"],
  _Hashtag_vue_vue_type_template_id_7b570e53___WEBPACK_IMPORTED_MODULE_0__["render"],
  _Hashtag_vue_vue_type_template_id_7b570e53___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"],
  false,
  null,
  null,
  null
  
)

/* hot reload */
if (false) { var api; }
component.options.__file = "resources/js/pages/Hashtag.vue"
/* harmony default export */ __webpack_exports__["default"] = (component.exports);

/***/ }),

/***/ "./resources/js/pages/Hashtag.vue?vue&type=script&lang=js&":
/*!*****************************************************************!*\
  !*** ./resources/js/pages/Hashtag.vue?vue&type=script&lang=js& ***!
  \*****************************************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Hashtag_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/babel-loader/lib??ref--4-0!../../../node_modules/vue-loader/lib??vue-loader-options!./Hashtag.vue?vue&type=script&lang=js& */ "./node_modules/babel-loader/lib/index.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/Hashtag.vue?vue&type=script&lang=js&");
/* empty/unused harmony star reexport */ /* harmony default export */ __webpack_exports__["default"] = (_node_modules_babel_loader_lib_index_js_ref_4_0_node_modules_vue_loader_lib_index_js_vue_loader_options_Hashtag_vue_vue_type_script_lang_js___WEBPACK_IMPORTED_MODULE_0__["default"]); 

/***/ }),

/***/ "./resources/js/pages/Hashtag.vue?vue&type=template&id=7b570e53&":
/*!***********************************************************************!*\
  !*** ./resources/js/pages/Hashtag.vue?vue&type=template&id=7b570e53& ***!
  \***********************************************************************/
/*! exports provided: render, staticRenderFns */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Hashtag_vue_vue_type_template_id_7b570e53___WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! -!../../../node_modules/vue-loader/lib/loaders/templateLoader.js??vue-loader-options!../../../node_modules/vue-loader/lib??vue-loader-options!./Hashtag.vue?vue&type=template&id=7b570e53& */ "./node_modules/vue-loader/lib/loaders/templateLoader.js?!./node_modules/vue-loader/lib/index.js?!./resources/js/pages/Hashtag.vue?vue&type=template&id=7b570e53&");
/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "render", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Hashtag_vue_vue_type_template_id_7b570e53___WEBPACK_IMPORTED_MODULE_0__["render"]; });

/* harmony reexport (safe) */ __webpack_require__.d(__webpack_exports__, "staticRenderFns", function() { return _node_modules_vue_loader_lib_loaders_templateLoader_js_vue_loader_options_node_modules_vue_loader_lib_index_js_vue_loader_options_Hashtag_vue_vue_type_template_id_7b570e53___WEBPACK_IMPORTED_MODULE_0__["staticRenderFns"]; });



/***/ })

}]);