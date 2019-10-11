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

define(["exports","jquery","./Plugin","./Site"],function(exports,_jquery,_Plugin,_Site2){"use strict";Object.defineProperty(exports,"__esModule",{value:!0});var _jquery2=babelHelpers.interopRequireDefault(_jquery),BaseApp=function(_Site){function BaseApp(){return babelHelpers.classCallCheck(this,BaseApp),babelHelpers.possibleConstructorReturn(this,(BaseApp.__proto__||Object.getPrototypeOf(BaseApp)).apply(this,arguments))}return babelHelpers.inherits(BaseApp,_Site),babelHelpers.createClass(BaseApp,[{key:"processed",value:function(){babelHelpers.get(BaseApp.prototype.__proto__||Object.getPrototypeOf(BaseApp.prototype),"processed",this).call(this),this.handlSlidePanelPlugin()}},{key:"handlSlidePanelPlugin",value:function(){var self=this;this.slidepanelOptions=_jquery2.default.extend({},(0,_Plugin.getDefaults)("slidePanel"),{template:function(options){return'<div class="'+options.classes.base+" "+options.classes.base+"-"+options.direction+'">\n                  <div class="'+options.classes.base+'-scrollable">\n                    <div><div class="'+options.classes.content+'"></div></div>\n                  </div>\n                  <div class="'+options.classes.base+'-handler"></div>\n                </div>'},afterLoad:function(){this.$panel.find("."+this.options.classes.base+"-scrollable").asScrollable({namespace:"scrollable",contentSelector:">",containerSelector:">"}),self.initializePlugins(this.$panel)},afterShow:function(){var _this2=this;(0,_jquery2.default)(document).on("click.slidePanelShow",function(e){0===(0,_jquery2.default)(e.target).closest(".slidePanel").length&&1===(0,_jquery2.default)(e.target).closest("body").length&&_this2.hide()})},afterHide:function(){(0,_jquery2.default)(document).off("click.slidePanelShow"),(0,_jquery2.default)(document).off("click.slidePanelDatepicker")}},this.getSlidePanelOptions()),(0,_jquery2.default)(document).on("click",'[data-toggle="slidePanel"]',function(e){self.openSlidePanel((0,_jquery2.default)(this).data("url")),e.stopPropagation()})}},{key:"getSlidePanelOptions",value:function(){return{}}},{key:"openSlidePanel",value:function(){var url=arguments.length>0&&void 0!==arguments[0]?arguments[0]:"";_jquery2.default.slidePanel.show({url:url,settings:{cache:!1}},this.slidepanelOptions)}}]),BaseApp}(babelHelpers.interopRequireDefault(_Site2).default);exports.default=BaseApp});