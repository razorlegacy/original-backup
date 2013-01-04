var emcOriginDomain,
	emcOriginJSAd,
	emcOriginConfig;

/* https://github.com/alpha123/Viper */
(function(i,g){function j(a,b){a.push.apply(a,b?"[object Array]"=={}.toString.call(b)?b:[b]:[])}function k(a,b,d){for(var c=0,e=a.length;c<e;++c)a[c].call(b,d)}function e(a){if(!(this instanceof e))return new e(a);this.object=a.object;this.property=a.property;this.from=this._from=a.from||this.object[this.property];this.to="[object Array]"=={}.toString.call(a.to)?a.to:[a.to];this.target=0;this.parser=a.parser||function(a){var d=e.Parsers,c,f=[],h,g;for(h in d)d.hasOwnProperty(h)&&f.push(d[h]);f.sort(function(a,
b){return(b.priority||0)-(a.priority||0)});h=0;for(g=f.length;h<g;++h)if(c=new f[h],null!=c.parse(a))return c;c=new d.Number;c.parse(a);return c}(this.from);this.transition=a.transition||e.Transitions.linear;this.duration=a.duration||500;this.fps=a.fps||40;this.frameInterval=1E3/this.fps;this.frames=a.frames||~~(this.duration/this.frameInterval+0.5);this.frame=a.frame==g?-1:0;this.running=!1;this.startHandlers=[];this.updateHandlers=[];this.finishHandlers=[];j(this.startHandlers,a.start);j(this.updateHandlers,
a.update);j(this.finishHandlers,a.finish)}var f=e.prototype,l,m=i.Viper;f.start=function(){this.running||(this.resume(),k(this.startHandlers,this,this.object));return this};f.stop=function(){this.running&&(this.pause(),k(this.finishHandlers,this,this.object));return this};f.pause=function(a){if(this.running){this.running=this.time=!1;clearInterval(this.timer);var b=this;a!=g&&setTimeout(function(){b.resume()},a)}return this};f.resume=function(){if(!this.running&&this.frame<this.frames){var a=this;
this.timer=setInterval(function(){a.step(+new Date)},this.frameInterval);this.running=!0}return this};f.step=function(a){this.frame+=(a-(this.time||a))/this.frameInterval;this.time=a;this.object[this.property]=this.parser.compute(this.from,this.to[this.target],this.frame<this.frames?this.transition(this.frame/this.frames):1);k(this.updateHandlers,this,this.object);this.frame>=this.frames&&(this.frame=this.time=0,this.parser.parse(this.from=this.to[this.target++]),this.to[this.target]==g&&(this.parser.parse(this.from=
this._from),this.target=0,this.stop()))};e.Transitions={linear:function(a){return a},sine:function(a){return 1-Math.cos(a*Math.PI/2)},elastic:function(a){return Math.pow(2,10*--a)*Math.cos(20*a*Math.PI/3)},bounce:function(a){for(var b=0,d=1;a<(7-4*b)/11;)b+=d,d/=2;a=(11-6*b-11*a)/4;return d*d-a*a}};for(l in e.Transitions)e.Transitions.hasOwnProperty(l)&&(f=e.Transitions[l],f.out=function(a){return function(b){return 1-a(1-b)}}(f),f.inOut=function(a){return function(b){return(0.5<b?2-a(2*(1-b)):a(2*
b))/2}}(f));e.Parsers={Number:function(){this.parse=function(a,b){var d=/(\D*)(\d+)(.*)?/.exec(a+"")||[,,NaN],c=parseFloat(d[2]);b||(this.prefix=d[1]||"",this.suffix=d[3]||"",this.value=c);return isNaN(c)?g:c};this.compute=function(a,b,d){var a=this.prefix,c=this.value,b=this.parse(b,!0);return a+((b-c)*d+c)+this.suffix}},Color:function(){this.parse=function(a,b){var d=parseInt,c;if(/^#[\da-f]{6}$/i.test(a))c=[d(a.substring(1,3),16),d(a.substring(3,5),16),d(a.substring(5,7),16)];else if(c=/^(rgb\()?(\d+),\s*(\d+),\s*(\d+)\)?$/.exec(a))c=
[d(c[2]),d(c[3]),d(c[4])];b||(this.value=c);return c};this.compute=function(a,b,d){for(var a=[],b=this.parse(b,!0),c=0,e=this.value.length;c<e;++c)a.push(~~((b[c]-this.value[c])*d+this.value[c]+0.5));return"rgb("+a+")"}},String:function(){this.parse=function(a){return""+a};this.compute=function(a,b,d){var a=a+"",b=b+"",c=~~(b.length*d+0.5);return b.substr(0,c)+a.substr(c,a.length-c-~~((a.length-b.length)*d+0.5))}}};e.Parsers.Color.priority=1;e.Parsers.String.priority=-9;e.noConflict=function(){i.Viper=
m;return e};i.Viper=e})(this);

var JSON;JSON||(JSON={});
(function(){function k(a){return 10>a?"0"+a:a}function o(a){p.lastIndex=0;return p.test(a)?'"'+a.replace(p,function(a){var c=r[a];return"string"===typeof c?c:"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4)})+'"':'"'+a+'"'}function m(a,j){var c,d,h,n,g=e,f,b=j[a];b&&"object"===typeof b&&"function"===typeof b.toJSON&&(b=b.toJSON(a));"function"===typeof i&&(b=i.call(j,a,b));switch(typeof b){case "string":return o(b);case "number":return isFinite(b)?""+b:"null";case "boolean":case "null":return""+b;
case "object":if(!b)return"null";e+=l;f=[];if("[object Array]"===Object.prototype.toString.apply(b)){n=b.length;for(c=0;c<n;c+=1)f[c]=m(c,b)||"null";h=0===f.length?"[]":e?"[\n"+e+f.join(",\n"+e)+"\n"+g+"]":"["+f.join(",")+"]";e=g;return h}if(i&&"object"===typeof i){n=i.length;for(c=0;c<n;c+=1)"string"===typeof i[c]&&(d=i[c],(h=m(d,b))&&f.push(o(d)+(e?": ":":")+h))}else for(d in b)Object.prototype.hasOwnProperty.call(b,d)&&(h=m(d,b))&&f.push(o(d)+(e?": ":":")+h);h=0===f.length?"{}":e?"{\n"+e+f.join(",\n"+
e)+"\n"+g+"}":"{"+f.join(",")+"}";e=g;return h}}"function"!==typeof Date.prototype.toJSON&&(Date.prototype.toJSON=function(){return isFinite(this.valueOf())?this.getUTCFullYear()+"-"+k(this.getUTCMonth()+1)+"-"+k(this.getUTCDate())+"T"+k(this.getUTCHours())+":"+k(this.getUTCMinutes())+":"+k(this.getUTCSeconds())+"Z":null},String.prototype.toJSON=Number.prototype.toJSON=Boolean.prototype.toJSON=function(){return this.valueOf()});var q=/[\u0000\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,
p=/[\\\"\x00-\x1f\x7f-\x9f\u00ad\u0600-\u0604\u070f\u17b4\u17b5\u200c-\u200f\u2028-\u202f\u2060-\u206f\ufeff\ufff0-\uffff]/g,e,l,r={"\u0008":"\\b","\t":"\\t","\n":"\\n","\u000c":"\\f","\r":"\\r",'"':'\\"',"\\":"\\\\"},i;"function"!==typeof JSON.stringify&&(JSON.stringify=function(a,j,c){var d;l=e="";if(typeof c==="number")for(d=0;d<c;d=d+1)l=l+" ";else typeof c==="string"&&(l=c);if((i=j)&&typeof j!=="function"&&(typeof j!=="object"||typeof j.length!=="number"))throw Error("JSON.stringify");return m("",
{"":a})});"function"!==typeof JSON.parse&&(JSON.parse=function(a,e){function c(a,d){var g,f,b=a[d];if(b&&typeof b==="object")for(g in b)if(Object.prototype.hasOwnProperty.call(b,g)){f=c(b,g);f!==void 0?b[g]=f:delete b[g]}return e.call(a,d,b)}var d,a=""+a;q.lastIndex=0;q.test(a)&&(a=a.replace(q,function(a){return"\\u"+("0000"+a.charCodeAt(0).toString(16)).slice(-4)}));if(/^[\],:{}\s]*$/.test(a.replace(/\\(?:["\\\/bfnrt]|u[0-9a-fA-F]{4})/g,"@").replace(/"[^"\\\n\r]*"|true|false|null|-?\d+(?:\.\d*)?(?:[eE][+\-]?\d+)?/g,
"]").replace(/(?:^|:|,)(?:\s*\[)+/g,""))){d=eval("("+a+")");return typeof e==="function"?c({"":d},""):d}throw new SyntaxError("JSON.parse");})})();

var XD=function(){var e,g,h=1,f,d=this;return{postMessage:function(c,b,a){b&&(a=a||parent,d.postMessage?a.postMessage(c,b.replace(/([^:]+:\/\/[^\/]+).*/,"$1")):b&&(a.location=b.replace(/#.*$/,"")+"#"+ +new Date+h++ +"&"+c))},receiveMessage:function(c,b){if(d.postMessage)if(c&&(f=function(a){if("string"===typeof b&&a.origin!==b||"[object Function]"===Object.prototype.toString.call(b)&&!1===b(a.origin))return!1;c(a)}),d.addEventListener)d[c?"addEventListener":"removeEventListener"]("message",f,!1);
else d[c?"attachEvent":"detachEvent"]("onmessage",f);else e&&clearInterval(e),e=null,c&&(e=setInterval(function(){var a=document.location.hash,b=/^#?\d+&/;a!==g&&b.test(a)&&(g=a,c({data:a.replace(b,"")}))},100))}}}();

var emcOriginResponse = (function() {
	//Cross Domain Listener
	XD.receiveMessage(function(message) {
		try {
			JSON.parse(message.data);
		} catch(e) {
			return false;
		}
		message		= JSON.parse(message.data);
		if(message.type) emcOriginToggle[message.type](message);
	}, emcOriginDomain);
	
	//Helper Function
	var emcOriginHelper	= {
		animate: function(selector, type, from, to, duration) {
			Viper({
				object: selector,
				property: type,
				from: from,
				to: to,
				duration: duration
			}).start();
		},
		iframe: function(paramsObj, paramsStyle) {
			emcIframe		= document.createElement('iframe');
		
			for(var index in paramsObj) {
				emcIframe[index]	= paramsObj[index];
			}
			
			for(var index in paramsStyle) {
				emcIframe.style[index] = paramsStyle[index];
			}
							
			return emcIframe;
		}
	};
	
	var emcOriginToggle = {
		ascend: function(config) {
			var to, from;
			emcAscend	= document.getElementById(config.emcOriginId);

			switch(config.toggle) {
				case 'default':
					from 	= '550px';
					to		= '90px';
					break;
				case 'expand':
					from 	= '90px';
					to 		= '550px';
					break;
				case 'remove':
					from	= emcAscend.height;
					to 		= '0px';
					break;
			}
			
			Viper({
				object:		emcAscend,
				property: 	'height',
				from:		from,
				to:			to,
				duration: 	config.duration,
				finish:		function() {
					if(config.toggle === 'remove') document.getElementById(config.emcOriginId).parentNode.removeChild(document.getElementById(config.emcOriginId));
				}
			}).start();
		},
		eclipse: function(config) {
			var to, from;
			switch(config.toggle) {
				case 'default':
					from 	= 415;
					to 		= 90;
					break;
				case 'expand':
					from 	= 90;
					to 		= 415;
					break;
			}
			emcEclipse		= document.getElementById(config.emcOriginId);
			emcOriginHelper.animate(emcPushdown, 'height', from, to, config.duration);
		},
		horizon: function(config) {
			var to, from;
			switch(config.toggle) {
				case 'default':
					from 	= '250px';
					to 		= '50px';
					bg 		= 250;
					config.duration 	= config.duration - 200;
					break;
				case 'expand':
					from 	= '50px';
					to 		= '250px';
					bg 		= 50;
					break;
				case 'remove':
					document.getElementById(config.emcOriginId).parentNode.removeChild(document.getElementById(config.emcOriginId));
					return false;
					break;
			}
			emcHorizon		= document.getElementById(config.emcOriginId);
			Viper({
				object: emcHorizon,
				property: 'height',
				from: from,
				to: to,
				duration: config.duration,
				update: function(e) {
					document.body.style.backgroundPosition = '50% '+e.height;
				},
				finish: function() {
					document.body.style.backgroundPosition = '50% '+to;
				}
			}).start();
		},
		meridian: function(config) {
			var meridian 	= JSON.parse(decodeURIComponent(document.getElementById(config.emcOriginId).name)).meridian;
			if(meridian) {
				window.location.href 	= meridian;
			} else {
				document.getElementById(config.emcOriginId).parentNode.removeChild(document.getElementById(config.emcOriginId));
			}
		},
		nova: function(config) {
			switch(config.toggle) {
				case 'default':
				case 'remove':
					document.getElementById(config.emcOriginId+'e').parentNode.removeChild(document.getElementById(config.emcOriginId+'e'));
					break;
				case 'expand':						
					emcExpandObj = {
						'id':		config.emcOriginId+'e',
						'scrolling':'no',
						'frameBorder':0,
						'width':	'100%',
						'height':	'100%',
						'name':		document.getElementById(config.emcOriginId).name
					},
					emcExpandStyle = {
						'position':	'fixed',
						'top':		'0px',
						'left':		'0px',
						'zIndex':	'999999'
					};
					
					emcExpand		= emcOriginHelper.iframe(emcExpandObj, emcExpandStyle);
					emcExpand.src	= config.url;
					
					document.body.appendChild(emcExpand);
					break;
			}
		}
	};
})();

var emcOriginGeneral = (function() {
	var publicMethods = {
		header: function() {
			if(!window.top.emcOriginHeader) {
				var header 		= document.createElement('script');
					header.src	= emcOriginJSAd;
					
				window.top.document.getElementsByTagName('head')[0].appendChild(header);
			}
			//Set flag
			window.top.emcOriginHeader	= true;
		},
		mobileViewport: function(emcDOM) {
			var meta 		= document.createElement('meta');
				meta.name 	= 'viewport';
				meta.content= 'width=device-width, initial-scale=1.0';
				meta.id		= 'emcOriginViewport';
				emcDOM.appendChild(meta);
		},
		orientationChange: function(emcOriginAd) {
			var supportsOrientationChange = "onorientationchange" in window,
				orientationEvent = supportsOrientationChange ? "orientationchange" : "resize";
					
				window.addEventListener(orientationEvent, function() {
				   	setTimeout(function() {emcOriginAd.src = emcOriginAd.src;}, 200);
				}, false);	
		},
		query: function(string, variable) {
	        var vars = string.split("&");
	        for(var i = 0; i < vars.length; i++) {
	            var pair = vars[i].split('=');
	            if (pair[0] == variable) {
	                return unescape(pair[1]);
	            }
	        }
		}
	};
	
	return {
		header: function() {
			publicMethods.header();
		},
		orientationChange: function(emcOriginAd) {
			publicMethods.orientationChange(emcOriginAd);	
		},
		mobileViewport: function(emcDOM) {
			publicMethods.mobileViewport(emcDOM);	
		},
		query: function(string, variable) {
			return publicMethods.query(string, variable);
		}
	}
})();

var emcOriginIframe = (function() {
	var publicMethods = {
		garbage: function() {
			frameElement.parentNode.removeChild(frameElement);
		}
	};
	
	return {
		init: function() {
			emcConfig			= decodeURIComponent(window.location.search.substring(1));
			emcOriginAd			= emcOriginCreate.create(emcConfig);
						
			var emcOriginParams	= JSON.parse(decodeURIComponent(emcOriginAd.name));
			emcOriginDomain		= 'http://'+emcOriginParams.emcOriginDomain;
			emcOriginJSAd		= emcOriginDomain+'/components/com_emc_origin/assets/js/emcOrigin.min.js'
			
			emcOriginGeneral.header();
			emcOriginCreate.layout(emcOriginGeneral.query(emcConfig, 'view'), emcOriginAd, frameElement, true);
			
			publicMethods.garbage();
		}
	}
})();

var emcOriginCreate	= (function() {
	
	var publicMethods = {
		iframe: function(paramsObj, paramsStyle) {
		
			if(window.frameElement != null) {
				emcOriginConfig			= JSON.parse(decodeURIComponent(window.name));
				emcOriginConfig.source	= window.parent.location.href;
			} else {
				emcOriginConfig.source	= document.location.href;
			}
			
			var emcIframeName			= encodeURIComponent(JSON.stringify(emcOriginConfig));
			
			//IE7 Iframe name fix
			if(navigator.userAgent.indexOf('MSIE 7.0')>=0){
				emcIframe				= document.createElement('<iframe name="'+emcIframeName+'">');
			} else {
				emcIframe				= document.createElement('iframe');
				emcIframe.name			= emcIframeName;
			}
			
			emcIframe.scrolling				= 'no';
			emcIframe.frameBorder			= 0;
			
			for(var index in paramsObj) {
				emcIframe[index]	= paramsObj[index];
			}
			
			for(var index in paramsStyle) {
				emcIframe.style[index] = paramsStyle[index];
			}
			return emcIframe;
		},
		layouts: function(emcConfig) {
			var paramsObj	= {
				'id':		'emcOrigin-' + emcOriginGeneral.query(emcConfig, 'id'),
				'src':		emcConfig
			};

			switch(emcOriginGeneral.query(emcConfig, 'view')) {
				case 'ascend':
					paramsObj.height	= '90px';
					paramsObj.width		= '100%';
					var stylesObj = {
						'position':	'fixed',
						'left':		'0px',
						'bottom':	'0px',
						'zIndex':	'10000'
					};
					break;
				case 'eclipse':
					paramsObj.height	= '90px';
					paramsObj.width		= '970px';
					var stylesObj 		= {};
					break;
				case 'horizon':
					paramsObj.height	= '50px';
					paramsObj.width		= '100%';
					var stylesObj = {
						'display':	'block',
						'margin': 	'0px auto'
					};
					break;
				case 'meridian':
					paramsObj.height	= '100%';
					paramsObj.width		= '100%';
					var stylesObj = {
						'position':	'fixed',
						//'position':	'absolute',
						'top':		'0px',
						'left':		'0px',
						'zIndex':	'999999'
					};
					break;
				case 'nova':
					paramsObj.height	= '250px';
					paramsObj.width		= '300px';
					var stylesObj 		= {};
					break;
			}
			
			return publicMethods.iframe(paramsObj, stylesObj);
		}
	};
	
	return {
		init: function(emcConfig, emcOriginParams, emcLocation) {
			emcOriginConfig		= emcOriginParams;
			emcOriginDomain		= 'http://'+emcOriginParams.emcOriginDomain;
			emcOriginJSAd		= emcOriginDomain+'/components/com_emc_origin/assets/js/emcOrigin.min.js';
			
			var emcOriginAd		= emcOriginCreate.create(emcConfig);
			emcOriginCreate.layout(emcOriginGeneral.query(emcConfig, 'view'), emcOriginAd, emcLocation);
		},
		create: function(emcConfig) {
			return publicMethods.layouts(emcConfig);
		},
		layout: function(template, emcOriginAd, emcLocation, iframe) {
			var emcDOM		= (iframe)? window.top.document.body: document.body;
			
			switch(template) {
				case 'horizon':
					emcOriginAd.style.backgroundColor 	= JSON.parse(decodeURIComponent(emcOriginAd.name)).bgHex;
					emcDOM.style.backgroundPosition 	= '50% 50px';
					emcDOM.insertBefore(emcOriginAd, emcDOM.firstChild);
					break;
				case 'meridian':
					function meridian(e) {
						var target		= e.target? e.target: e.srcElement;						
						if(target) tag 	= target.tagName;
						if(target && !/^(a)$/i.test(tag)) {
							target		= target.parentNode;
							if(target) tag = target.tagName;
						}
						
						if(target.tagName === 'A' && (/^(http:|https:|mailto:)/i.test(target.href) && (target.href.search('#')<=0)) && (/^(_self|_top)/i.test(target.target) || target.target === '')) {
							if(e.preventDefault) {
								e.preventDefault();
							} else {
								event.returnValue = false;
							}
							emcOriginConfig			= JSON.parse(decodeURIComponent(emcOriginAd.name));
							emcOriginConfig.meridian= target.href;
							emcOriginAd.name		= encodeURIComponent(JSON.stringify(emcOriginConfig));
							emcDOM.appendChild(emcOriginAd);
							
							emcOriginGeneral.mobileViewport(emcDOM);
							emcOriginGeneral.orientationChange(emcOriginAd);
						} else {
							if(e.preventDefault) {
								e.preventDefault();
							} else {
								event.returnValue = false;
							}
						}
					}
					
					if(emcOriginConfig.auto >= 1) {
						//Ante-meridian
						emcDOM.appendChild(emcOriginAd);
						//emcOriginGeneral.mobileViewport(emcDOM);
						emcOriginGeneral.orientationChange(emcOriginAd);
					} else {
						//Post-meridian
						if(emcDOM.addEventListener) {
							emcDOM.addEventListener('click', meridian, false);
						} else {
							emcDOM.attachEvent('onclick', meridian)
						}	
					}
					
					break;
				default:
					emcLocation.parentNode.insertBefore(emcOriginAd, emcLocation);
					break;
			}
			
		}
	};
})();