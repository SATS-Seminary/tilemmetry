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

define(["exports"],function(exports){"use strict";function get(){for(var data=values,_len=arguments.length,names=Array(_len),_key=0;_key<_len;_key++)names[_key]=arguments[_key];for(var i=0;i<names.length;i++)data=function(data,name){return data[name]}(data,names[i]);return data}function getColor(name,level){if("primary"===name&&((name=get("primaryColor"))||(name="red")),void 0===values.colors)return null;if(void 0!==values.colors[name]){if(level&&void 0!==values.colors[name][level])return values.colors[name][level];if(void 0===level)return values.colors[name]}return null}Object.defineProperty(exports,"__esModule",{value:!0});var values={fontFamily:"Noto Sans, sans-serif",primaryColor:"blue",assets:"../assets"};exports.get=get,exports.set=function(name,value){"string"==typeof name&&void 0!==value?values[name]=value:"object"===(void 0===name?"undefined":babelHelpers.typeof(name))&&(values=$.extend(!0,{},values,name))},exports.getColor=getColor,exports.colors=function(name,level){return getColor(name,level)}});