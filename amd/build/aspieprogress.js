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

define(["exports","jquery","./Plugin"],function(exports,_jquery,_Plugin2){"use strict";Object.defineProperty(exports,"__esModule",{value:!0});var _jquery2=babelHelpers.interopRequireDefault(_jquery),_Plugin3=babelHelpers.interopRequireDefault(_Plugin2),PieProgress=function(_Plugin){function PieProgress(){return babelHelpers.classCallCheck(this,PieProgress),babelHelpers.possibleConstructorReturn(this,(PieProgress.__proto__||Object.getPrototypeOf(PieProgress)).apply(this,arguments))}return babelHelpers.inherits(PieProgress,_Plugin),babelHelpers.createClass(PieProgress,[{key:"getName",value:function(){return"pieProgress"}},{key:"render",value:function(){_jquery2.default.fn.asPieProgress&&this.$el.asPieProgress(this.options)}}],[{key:"getDefaults",value:function(){return{namespace:"pie-progress",speed:30,classes:{svg:"pie-progress-svg",element:"pie-progress",number:"pie-progress-number",content:"pie-progress-content"}}}}]),PieProgress}(_Plugin3.default);_Plugin3.default.register("pieProgress",PieProgress),exports.default=PieProgress});