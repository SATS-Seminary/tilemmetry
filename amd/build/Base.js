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

define(["exports","jquery","./Component","./Plugin"],function(exports,_jquery,_Component2,_Plugin){"use strict";Object.defineProperty(exports,"__esModule",{value:!0});var _jquery2=babelHelpers.interopRequireDefault(_jquery),_class=function(_Component){function _class(){return babelHelpers.classCallCheck(this,_class),babelHelpers.possibleConstructorReturn(this,(_class.__proto__||Object.getPrototypeOf(_class)).apply(this,arguments))}return babelHelpers.inherits(_class,_Component),babelHelpers.createClass(_class,[{key:"initializePlugins",value:function(){var context=arguments.length>0&&void 0!==arguments[0]&&arguments[0];(0,_jquery2.default)("[data-plugin]",context||this.$el).each(function(){var $this=(0,_jquery2.default)(this),name=$this.data("plugin"),plugin=(0,_Plugin.pluginFactory)(name,$this,$this.data());plugin&&plugin.initialize()})}},{key:"initializePluginAPIs",value:function(){var context=arguments.length>0&&void 0!==arguments[0]?arguments[0]:document,apis=(0,_Plugin.getPluginAPI)();for(var name in apis)(0,_Plugin.getPluginAPI)(name)("[data-plugin="+name+"]",context)}}]),_class}(babelHelpers.interopRequireDefault(_Component2).default);exports.default=_class});