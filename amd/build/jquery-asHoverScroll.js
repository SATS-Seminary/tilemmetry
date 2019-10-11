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

!function(global,factory){if("function"==typeof define&&define.amd)define(["jquery"],factory);else if("undefined"!=typeof exports)factory(require("jquery"));else{var mod={exports:{}};factory(global.jQuery),global.jqueryAsHoverScrollEs=mod.exports}}(this,function(_jquery){"use strict";function _classCallCheck(instance,Constructor){if(!(instance instanceof Constructor))throw new TypeError("Cannot call a class as a function")}var _jquery2=function(obj){return obj&&obj.__esModule?obj:{default:obj}}(_jquery),_typeof="function"==typeof Symbol&&"symbol"==typeof Symbol.iterator?function(obj){return typeof obj}:function(obj){return obj&&"function"==typeof Symbol&&obj.constructor===Symbol?"symbol":typeof obj},_createClass=function(){function defineProperties(target,props){for(var i=0;i<props.length;i++){var descriptor=props[i];descriptor.enumerable=descriptor.enumerable||!1,descriptor.configurable=!0,"value"in descriptor&&(descriptor.writable=!0),Object.defineProperty(target,descriptor.key,descriptor)}}return function(Constructor,protoProps,staticProps){return protoProps&&defineProperties(Constructor.prototype,protoProps),staticProps&&defineProperties(Constructor,staticProps),Constructor}}(),DEFAULTS={namespace:"asHoverScroll",list:"> ul",item:"> li",exception:null,direction:"vertical",fixed:!1,mouseMove:!0,touchScroll:!0,pointerScroll:!0,useCssTransforms:!0,useCssTransforms3d:!0,boundary:10,throttle:20,onEnter:function(){$(this).siblings().removeClass("is-active"),$(this).addClass("is-active")},onLeave:function(){$(this).removeClass("is-active")}},support={};!function(support){var events={transition:{end:{WebkitTransition:"webkitTransitionEnd",MozTransition:"transitionend",OTransition:"oTransitionEnd",transition:"transitionend"}},animation:{end:{WebkitAnimation:"webkitAnimationEnd",MozAnimation:"animationend",OAnimation:"oAnimationEnd",animation:"animationend"}}},prefixes=["webkit","Moz","O","ms"],style=(0,_jquery2.default)("<support>").get(0).style,tests={csstransforms:function(){return Boolean(test("transform"))},csstransforms3d:function(){return Boolean(test("perspective"))},csstransitions:function(){return Boolean(test("transition"))},cssanimations:function(){return Boolean(test("animation"))}},test=function(property,prefixed){var result=!1,upper=property.charAt(0).toUpperCase()+property.slice(1);return void 0!==style[property]&&(result=property),result||_jquery2.default.each(prefixes,function(i,prefix){return void 0===style[prefix+upper]||(result="-"+prefix.toLowerCase()+"-"+upper,!1)}),prefixed?result:!!result},prefixed=function(property){return test(property,!0)};tests.csstransitions()&&(support.transition=new String(prefixed("transition")),support.transition.end=events.transition.end[support.transition]),tests.cssanimations()&&(support.animation=new String(prefixed("animation")),support.animation.end=events.animation.end[support.animation]),tests.csstransforms()&&(support.transform=new String(prefixed("transform")),support.transform3d=tests.csstransforms3d()),"ontouchstart"in window||window.DocumentTouch&&document instanceof window.DocumentTouch?support.touch=!0:support.touch=!1,window.PointerEvent||window.MSPointerEvent?support.pointer=!0:support.pointer=!1,support.convertMatrixToArray=function(value){return!(!value||"matrix"!==value.substr(0,6))&&value.replace(/^.*\((.*)\)$/g,"$1").replace(/px/g,"").split(/, +/)},support.prefixPointerEvent=function(pointerEvent){return window.MSPointerEvent?"MSPointer"+pointerEvent.charAt(9).toUpperCase()+pointerEvent.substr(10):pointerEvent}}(support);var instanceId=0,asHoverScroll=function(){function asHoverScroll(element,options){_classCallCheck(this,asHoverScroll),this.element=element,this.$element=(0,_jquery2.default)(element),this.options=_jquery2.default.extend({},DEFAULTS,options,this.$element.data()),this.$list=(0,_jquery2.default)(this.options.list,this.$element),this.classes={disabled:this.options.namespace+"-disabled"},"vertical"===this.options.direction?this.attributes={page:"pageY",axis:"Y",position:"top",length:"height",offset:"offsetTop",client:"clientY",clientLength:"clientHeight"}:"horizontal"===this.options.direction&&(this.attributes={page:"pageX",axis:"X",position:"left",length:"width",offset:"offsetLeft",client:"clientX",clientLength:"clientWidth"}),this._states={},this._scroll={time:null,pointer:null},this.instanceId=++instanceId,this.trigger("init"),this.init()}return _createClass(asHoverScroll,[{key:"init",value:function(){this.initPosition(),this.updateLength(),this.bindEvents()}},{key:"bindEvents",value:function(){var _this=this,that=this,enterEvents=["enter"],leaveEvents=[];this.options.mouseMove&&(this.$element.on(this.eventName("mousemove"),_jquery2.default.proxy(this.onMove,this)),enterEvents.push("mouseenter"),leaveEvents.push("mouseleave")),this.options.touchScroll&&support.touch&&(this.$element.on(this.eventName("touchstart"),_jquery2.default.proxy(this.onScrollStart,this)),this.$element.on(this.eventName("touchcancel"),_jquery2.default.proxy(this.onScrollEnd,this))),this.options.pointerScroll&&support.pointer&&(this.$element.on(this.eventName(support.prefixPointerEvent("pointerdown")),_jquery2.default.proxy(this.onScrollStart,this)),this.$element.on(this.eventName(support.prefixPointerEvent("pointercancel")),_jquery2.default.proxy(this.onScrollEnd,this))),this.$list.on(this.eventName(enterEvents.join(" ")),this.options.item,function(){that.is("scrolling")||that.options.onEnter.call(_this)}),this.$list.on(this.eventName(leaveEvents.join(" ")),this.options.item,function(){that.is("scrolling")||that.options.onLeave.call(_this)}),(0,_jquery2.default)(window).on(this.eventNameWithId("orientationchange"),function(){that.update()}),(0,_jquery2.default)(window).on(this.eventNameWithId("resize"),this.throttle(function(){that.update()},this.options.throttle))}},{key:"unbindEvents",value:function(){this.$element.off(this.eventName()),this.$list.off(this.eventName()),(0,_jquery2.default)(window).off(this.eventNameWithId())}},{key:"onScrollStart",value:function(event){var _this2=this,that=this;if(3!==event.which&&!((0,_jquery2.default)(event.target).closest(this.options.exception).length>0)){this._scroll.time=(new Date).getTime(),this._scroll.pointer=this.pointer(event),this._scroll.start=this.getPosition(),this._scroll.moved=!1;var callback=function(){_this2.enter("scrolling"),_this2.trigger("scroll")};this.options.touchScroll&&support.touch&&((0,_jquery2.default)(document).on(this.eventName("touchend"),_jquery2.default.proxy(this.onScrollEnd,this)),(0,_jquery2.default)(document).one(this.eventName("touchmove"),_jquery2.default.proxy(function(){(0,_jquery2.default)(document).on(that.eventName("touchmove"),_jquery2.default.proxy(this.onScrollMove,this)),callback()},this))),this.options.pointerScroll&&support.pointer&&((0,_jquery2.default)(document).on(this.eventName(support.prefixPointerEvent("pointerup")),_jquery2.default.proxy(this.onScrollEnd,this)),(0,_jquery2.default)(document).one(this.eventName(support.prefixPointerEvent("pointermove")),_jquery2.default.proxy(function(){(0,_jquery2.default)(document).on(that.eventName(support.prefixPointerEvent("pointermove")),_jquery2.default.proxy(this.onScrollMove,this)),callback()},this))),(0,_jquery2.default)(document).on(this.eventName("blur"),_jquery2.default.proxy(this.onScrollEnd,this)),event.preventDefault()}}},{key:"onScrollMove",value:function(event){this._scroll.updated=this.pointer(event);var distance=this.distance(this._scroll.pointer,this._scroll.updated);if((Math.abs(this._scroll.pointer.x-this._scroll.updated.x)>10||Math.abs(this._scroll.pointer.y-this._scroll.updated.y)>10)&&(this._scroll.moved=!0),this.is("scrolling")){event.preventDefault();var postion=this._scroll.start+distance;this.canScroll()&&(postion>0?postion=0:postion<this.containerLength-this.listLength&&(postion=this.containerLength-this.listLength),this.updatePosition(postion))}}},{key:"onScrollEnd",value:function(event){var _this3=this;this.options.touchScroll&&support.touch&&(0,_jquery2.default)(document).off(this.eventName("touchmove touchend")),this.options.pointerScroll&&support.pointer&&(0,_jquery2.default)(document).off(this.eventName(support.prefixPointerEvent("pointerup"))),(0,_jquery2.default)(document).off(this.eventName("blur")),this._scroll.moved||(0,_jquery2.default)(event.target).trigger("tap"),this.is("scrolling")&&setTimeout(function(){_this3.leave("scrolling"),_this3.trigger("scrolled")},500)}},{key:"pointer",value:function(event){var result={x:null,y:null};return(event=this.getEvent(event)).pageX&&!this.options.fixed?(result.x=event.pageX,result.y=event.pageY):(result.x=event.clientX,result.y=event.clientY),result}},{key:"getEvent",value:function(event){return event=event.originalEvent||event||window.event,event=event.touches&&event.touches.length?event.touches[0]:event.changedTouches&&event.changedTouches.length?event.changedTouches[0]:event}},{key:"distance",value:function(first,second){return"vertical"===this.options.direction?second.y-first.y:second.x-first.x}},{key:"onMove",value:function(event){if(event=this.getEvent(event),!this.is("scrolling")&&this.isMatchScroll(event)){var distance=void 0,offset=void 0;(offset=(event[this.attributes.page]&&!this.options.fixed?event[this.attributes.page]:event[this.attributes.client])-this.element[this.attributes.offset])<this.options.boundary?distance=0:(distance=(offset-this.options.boundary)*this.multiplier)>this.listLength-this.containerLength&&(distance=this.listLength-this.containerLength),this.updatePosition(-distance)}}},{key:"isMatchScroll",value:function(event){return!(this.is("disabled")||!this.canScroll())&&(!this.options.exception||0===(0,_jquery2.default)(event.target).closest(this.options.exception).length)}},{key:"canScroll",value:function(){return this.listLength>this.containerLength}},{key:"getContainerLength",value:function(){return this.element[this.attributes.clientLength]}},{key:"getListhLength",value:function(){return this.$list[0][this.attributes.clientLength]}},{key:"updateLength",value:function(){this.containerLength=this.getContainerLength(),this.listLength=this.getListhLength(),this.multiplier=(this.listLength-this.containerLength)/(this.containerLength-2*this.options.boundary)}},{key:"initPosition",value:function(){var style=this.makePositionStyle(0);this.$list.css(style)}},{key:"getPosition",value:function(){var value=void 0;if(this.options.useCssTransforms&&support.transform){if(!(value=(this.options.useCssTransforms3d&&support.transform3d,support.convertMatrixToArray(this.$list.css(support.transform)))))return 0;value="X"===this.attributes.axis?value[12]||value[4]:value[13]||value[5]}else value=this.$list.css(this.attributes.position);return parseFloat(value.replace("px",""))}},{key:"makePositionStyle",value:function(value){var property=void 0,x="0px",y="0px";this.options.useCssTransforms&&support.transform?("X"===this.attributes.axis?x=value+"px":y=value+"px",property=support.transform.toString(),value=this.options.useCssTransforms3d&&support.transform3d?"translate3d("+x+","+y+",0px)":"translate("+x+","+y+")"):property=this.attributes.position;var temp={};return temp[property]=value,temp}},{key:"updatePosition",value:function(value){var style=this.makePositionStyle(value);this.$list.css(style)}},{key:"update",value:function(){this.is("disabled")||(this.updateLength(),this.canScroll()||this.initPosition())}},{key:"eventName",value:function(events){if("string"!=typeof events||""===events)return".asHoverScroll";for(var length=(events=events.split(" ")).length,i=0;i<length;i++)events[i]=events[i]+".asHoverScroll";return events.join(" ")}},{key:"eventNameWithId",value:function(events){if("string"!=typeof events||""===events)return"."+this.options.namespace+"-"+this.instanceId;for(var length=(events=events.split(" ")).length,i=0;i<length;i++)events[i]=events[i]+"."+this.options.namespace+"-"+this.instanceId;return events.join(" ")}},{key:"trigger",value:function(eventType){for(var _len=arguments.length,params=Array(_len>1?_len-1:0),_key=1;_key<_len;_key++)params[_key-1]=arguments[_key];var data=[this].concat(params);this.$element.trigger("asHoverScroll::"+eventType,data);var onFunction="on"+(eventType=eventType.replace(/\b\w+\b/g,function(word){return word.substring(0,1).toUpperCase()+word.substring(1)}));"function"==typeof this.options[onFunction]&&this.options[onFunction].apply(this,params)}},{key:"is",value:function(state){return this._states[state]&&this._states[state]>0}},{key:"enter",value:function(state){void 0===this._states[state]&&(this._states[state]=0),this._states[state]++}},{key:"leave",value:function(state){this._states[state]--}},{key:"throttle",value:function(func,wait){var _this4=this,_now=Date.now||function(){return(new Date).getTime()},timeout=void 0,context=void 0,args=void 0,result=void 0,previous=0,later=function(){previous=_now(),timeout=null,result=func.apply(context,args),timeout||(context=args=null)};return function(){for(var _len2=arguments.length,params=Array(_len2),_key2=0;_key2<_len2;_key2++)params[_key2]=arguments[_key2];var now=_now(),remaining=wait-(now-previous);return context=_this4,args=params,remaining<=0||remaining>wait?(timeout&&(clearTimeout(timeout),timeout=null),previous=now,result=func.apply(context,args),timeout||(context=args=null)):timeout||(timeout=setTimeout(later,remaining)),result}}},{key:"enable",value:function(){this.is("disabled")&&(this.leave("disabled"),this.$element.removeClass(this.classes.disabled),this.bindEvents()),this.trigger("enable")}},{key:"disable",value:function(){this.is("disabled")||(this.enter("disabled"),this.initPosition(),this.$element.addClass(this.classes.disabled),this.unbindEvents()),this.trigger("disable")}},{key:"destroy",value:function(){this.$element.removeClass(this.classes.disabled),this.unbindEvents(),this.$element.data("asHoverScroll",null),this.trigger("destroy")}}],[{key:"setDefaults",value:function(options){_jquery2.default.extend(DEFAULTS,_jquery2.default.isPlainObject(options)&&options)}}]),asHoverScroll}(),info={version:"0.3.2"},OtherAsHoverScroll=_jquery2.default.fn.asHoverScroll,jQueryAsHoverScroll=function(options){for(var _this5=this,_len3=arguments.length,args=Array(_len3>1?_len3-1:0),_key3=1;_key3<_len3;_key3++)args[_key3-1]=arguments[_key3];if("string"==typeof options){var _ret=function(){var method=options;if(/^_/.test(method))return{v:!1};if(!/^(get)/.test(method))return{v:_this5.each(function(){var instance=_jquery2.default.data(this,"asHoverScroll");instance&&"function"==typeof instance[method]&&instance[method].apply(instance,args)})};var instance=_this5.first().data("asHoverScroll");return instance&&"function"==typeof instance[method]?{v:instance[method].apply(instance,args)}:void 0}();if("object"===(void 0===_ret?"undefined":_typeof(_ret)))return _ret.v}return this.each(function(){(0,_jquery2.default)(this).data("asHoverScroll")||(0,_jquery2.default)(this).data("asHoverScroll",new asHoverScroll(this,options))})};_jquery2.default.fn.asHoverScroll=jQueryAsHoverScroll,_jquery2.default.asHoverScroll=_jquery2.default.extend({setDefaults:asHoverScroll.setDefaults,noConflict:function(){return _jquery2.default.fn.asHoverScroll=OtherAsHoverScroll,jQueryAsHoverScroll}},info)});