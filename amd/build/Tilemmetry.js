define(["exports","jquery","./Site","core/event"],function(e,t,n,a){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.getInstance=e.run=e.Tilemmetry=void 0;var o=i(t),r=i(n),u=i(a);function i(e){return e&&e.__esModule?e:{default:e}}var l=function(e,t,n){return t&&s(e.prototype,t),n&&s(e,n),e};function s(e,t){for(var n=0;n<t.length;n++){var a=t[n];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(e,a.key,a)}}document,(0,o.default)(document);var c=(0,o.default)("body"),f=(function(e,t){if("function"!=typeof t&&null!==t)throw new TypeError("Super expression must either be null or a function, not "+typeof t);e.prototype=Object.create(t&&t.prototype,{constructor:{value:e,enumerable:!1,writable:!0,configurable:!0}}),t&&(Object.setPrototypeOf?Object.setPrototypeOf(e,t):e.__proto__=t)}(p,r.default),l(p,[{key:"initialize",value:function(){var e=this;this.initializePluginAPIs(),this.initializePlugins(),this.initComponents(),setTimeout(function(){e.setDefaultState()},500)}},{key:"process",value:function(){this.polyfillIEWidth(),this.initBootstrap(),this.setupMenubar(),this.setupFullScreen(),this.setupMegaNavbar(),this.setupNavbarCollpase(),this.asscrollTilemmetryElements(),this.moodleEvents(),this.$el.on("click",".dropdown-menu-media",function(e){e.stopPropagation()})}},{key:"asscrollTilemmetryElements",value:function(){var e=(0,o.default)("div.card div.divScroll");if(0<e.length){var t=e.data("asScrollable");t?t.update():e.asScrollable({namespace:"scrollable",contentSelector:"> [data-role='content']",containerSelector:"> [data-role='container']"})}}},{key:"moodleEvents",value:function(){var t=this;u.default.getLegacyEvents().done(function(e){jQuery(document).on(e.FILTER_CONTENT_UPDATED,function(){t.asscrollTilemmetryElements()})})}},{key:"_getDefaultMeunbarType",value:function(){var e=this.getCurrentBreakpoint(),t=!1;switch(!1!==c.data("autoMenubar")&&!c.is(".site-menubar-keep")||(c.hasClass("site-menubar-fold")?t="fold":c.hasClass("site-menubar-unfold")&&(t="unfold")),e){case"lg":t=t||"unfold";break;case"md":case"sm":t="fold";break;case"xs":t="hide"}return t}},{key:"setupMenubar",value:function(){var t=this;(0,o.default)(document).on("click",'[data-toggle="menubar"]:visible',function(){var e=t.menubar.type;switch(e){case"fold":e="unfold";break;case"unfold":e="fold";break;case"open":e="hide";break;case"hide":e="open"}return"lg"==t.getCurrentBreakpoint()&&M.util.set_user_preference("menubar_state",e),t.menubar.change(e),t.menubarType(e),!1}),Breakpoints.on("change",function(){t.menubar.type=t._getDefaultMeunbarType(),t.menubar.change(t.menubar.type)})}}]),p);function p(){return function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,p),function(e,t){if(!e)throw new ReferenceError("this hasn't been initialised - super() hasn't been called");return!t||"object"!=typeof t&&"function"!=typeof t?e:t}(this,(p.__proto__||Object.getPrototypeOf(p)).apply(this,arguments))}var d=null;function b(){return d||(d=new f),d}e.default=f,e.Tilemmetry=f,e.run=function(){b().run()},e.getInstance=b});