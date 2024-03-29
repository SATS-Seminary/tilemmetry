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

define(["exports","jquery","./Plugin"],function(exports,_jquery,_Plugin2){"use strict";Object.defineProperty(exports,"__esModule",{value:!0});babelHelpers.interopRequireDefault(_jquery);var _Plugin3=babelHelpers.interopRequireDefault(_Plugin2),Scrollable=function(_Plugin){function Scrollable(){return babelHelpers.classCallCheck(this,Scrollable),babelHelpers.possibleConstructorReturn(this,(Scrollable.__proto__||Object.getPrototypeOf(Scrollable)).apply(this,arguments))}return babelHelpers.inherits(Scrollable,_Plugin),babelHelpers.createClass(Scrollable,[{key:"getName",value:function(){return"scrollable"}},{key:"render",value:function(){this.$el.asScrollable(this.options)}}],[{key:"getDefaults",value:function(){return{namespace:"scrollable",contentSelector:"> [data-role='content']",containerSelector:"> [data-role='container']"}}}]),Scrollable}(_Plugin3.default);_Plugin3.default.register("scrollable",Scrollable),exports.default=Scrollable});