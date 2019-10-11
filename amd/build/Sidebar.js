/*!
 * SATS (www.wisdmlabs.com)
 * Copyright 2019 SATS
 * Licensed under the http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
/*!
 * remark (http://getbootstrapadmin.com/remark)
 * Copyright 2019 amazingsurge
 * Licensed under the Themeforest Standard Licenses
 */

define(["exports","jquery","./Base","./Plugin"],function(exports,_jquery,_Base2,_Plugin){"use strict";Object.defineProperty(exports,"__esModule",{value:!0});var _jquery2=babelHelpers.interopRequireDefault(_jquery),_class=function(_Base){function _class(){return babelHelpers.classCallCheck(this,_class),babelHelpers.possibleConstructorReturn(this,(_class.__proto__||Object.getPrototypeOf(_class)).apply(this,arguments))}return babelHelpers.inherits(_class,_Base),babelHelpers.createClass(_class,[{key:"processed",value:function(){if(void 0!==_jquery2.default.slidePanel){var sidebar=this;(0,_jquery2.default)(document).on("click",'[data-toggle="site-sidebar"]',function(){var $this=(0,_jquery2.default)(this),direction="right";(0,_jquery2.default)("body").hasClass("site-menubar-flipped")&&(direction="left");var options=_jquery2.default.extend({},(0,_Plugin.getDefaults)("slidePanel"),{direction:direction,skin:"site-sidebar",dragTolerance:80,template:function(options){return'<div class="'+options.classes.base+" "+options.classes.base+"-"+options.direction+'">\n\t    <div class="'+options.classes.content+' site-sidebar-content"></div>\n\t    <div class="slidePanel-handler"></div>\n\t    </div>'},afterLoad:function(){var self=this;this.$panel.find(".tab-pane").asScrollable({namespace:"scrollable",contentSelector:"> div",containerSelector:"> div"}),sidebar.initializePlugins(self.$panel),this.$panel.on("shown.bs.tab",function(){self.$panel.find(".tab-pane.active").asScrollable("update")})},beforeShow:function(){$this.hasClass("active")||$this.addClass("active")},afterHide:function(){$this.hasClass("active")&&$this.removeClass("active")}});if($this.hasClass("active"))_jquery2.default.slidePanel.hide();else{var url=$this.data("url");url||(url=(url=$this.attr("href"))&&url.replace(/.*(?=#[^\s]*$)/,"")),_jquery2.default.slidePanel.show({url:url},options)}}),(0,_jquery2.default)(document).on("click",'[data-toggle="show-chat"]',function(){(0,_jquery2.default)("#conversation").addClass("active")}),(0,_jquery2.default)(document).on("click",'[data-toggle="close-chat"]',function(){(0,_jquery2.default)("#conversation").removeClass("active")})}}}]),_class}(babelHelpers.interopRequireDefault(_Base2).default);exports.default=_class});