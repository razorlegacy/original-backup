/* https://github.com/alpha123/Viper */
(function(i,g){function j(a,b){a.push.apply(a,b?"[object Array]"=={}.toString.call(b)?b:[b]:[])}function k(a,b,d){for(var c=0,e=a.length;c<e;++c)a[c].call(b,d)}function e(a){if(!(this instanceof e))return new e(a);this.object=a.object;this.property=a.property;this.from=this._from=a.from||this.object[this.property];this.to="[object Array]"=={}.toString.call(a.to)?a.to:[a.to];this.target=0;this.parser=a.parser||function(a){var d=e.Parsers,c,f=[],h,g;for(h in d)d.hasOwnProperty(h)&&f.push(d[h]);f.sort(function(a,
b){return(b.priority||0)-(a.priority||0)});h=0;for(g=f.length;h<g;++h)if(c=new f[h],null!=c.parse(a))return c;c=new d.Number;c.parse(a);return c}(this.from);this.transition=a.transition||e.Transitions.linear;this.duration=a.duration||500;this.fps=a.fps||40;this.frameInterval=1E3/this.fps;this.frames=a.frames||~~(this.duration/this.frameInterval+0.5);this.frame=a.frame==g?-1:0;this.running=!1;this.startHandlers=[];this.updateHandlers=[];this.finishHandlers=[];j(this.startHandlers,a.start);j(this.updateHandlers,
a.update);j(this.finishHandlers,a.finish)}var f=e.prototype,l,m=i.Viper;f.start=function(){this.running||(this.resume(),k(this.startHandlers,this,this.object));return this};f.stop=function(){this.running&&(this.pause(),k(this.finishHandlers,this,this.object));return this};f.pause=function(a){if(this.running){this.running=this.time=!1;clearInterval(this.timer);var b=this;a!=g&&setTimeout(function(){b.resume()},a)}return this};f.resume=function(){if(!this.running&&this.frame<this.frames){var a=this;
this.timer=setInterval(function(){a.step(+new Date)},this.frameInterval);this.running=!0}return this};f.step=function(a){this.frame+=(a-(this.time||a))/this.frameInterval;this.time=a;this.object[this.property]=this.parser.compute(this.from,this.to[this.target],this.frame<this.frames?this.transition(this.frame/this.frames):1);k(this.updateHandlers,this,this.object);this.frame>=this.frames&&(this.frame=this.time=0,this.parser.parse(this.from=this.to[this.target++]),this.to[this.target]==g&&(this.parser.parse(this.from=
this._from),this.target=0,this.stop()))};e.Transitions={linear:function(a){return a},sine:function(a){return 1-Math.cos(a*Math.PI/2)},elastic:function(a){return Math.pow(2,10*--a)*Math.cos(20*a*Math.PI/3)},bounce:function(a){for(var b=0,d=1;a<(7-4*b)/11;)b+=d,d/=2;a=(11-6*b-11*a)/4;return d*d-a*a}};for(l in e.Transitions)e.Transitions.hasOwnProperty(l)&&(f=e.Transitions[l],f.out=function(a){return function(b){return 1-a(1-b)}}(f),f.inOut=function(a){return function(b){return(0.5<b?2-a(2*(1-b)):a(2*
b))/2}}(f));e.Parsers={Number:function(){this.parse=function(a,b){var d=/(\D*)(\d+)(.*)?/.exec(a+"")||[,,NaN],c=parseFloat(d[2]);b||(this.prefix=d[1]||"",this.suffix=d[3]||"",this.value=c);return isNaN(c)?g:c};this.compute=function(a,b,d){var a=this.prefix,c=this.value,b=this.parse(b,!0);return a+((b-c)*d+c)+this.suffix}},Color:function(){this.parse=function(a,b){var d=parseInt,c;if(/^#[\da-f]{6}$/i.test(a))c=[d(a.substring(1,3),16),d(a.substring(3,5),16),d(a.substring(5,7),16)];else if(c=/^(rgb\()?(\d+),\s*(\d+),\s*(\d+)\)?$/.exec(a))c=
[d(c[2]),d(c[3]),d(c[4])];b||(this.value=c);return c};this.compute=function(a,b,d){for(var a=[],b=this.parse(b,!0),c=0,e=this.value.length;c<e;++c)a.push(~~((b[c]-this.value[c])*d+this.value[c]+0.5));return"rgb("+a+")"}},String:function(){this.parse=function(a){return""+a};this.compute=function(a,b,d){var a=a+"",b=b+"",c=~~(b.length*d+0.5);return b.substr(0,c)+a.substr(c,a.length-c-~~((a.length-b.length)*d+0.5))}}};e.Parsers.Color.priority=1;e.Parsers.String.priority=-9;e.noConflict=function(){i.Viper=
m;return e};i.Viper=e})(this);

//CrossDomain script
var XD=function(){var e,g,h=1,f,d=this;return{postMessage:function(c,b,a){b&&(a=a||parent,d.postMessage?a.postMessage(c,b.replace(/([^:]+:\/\/[^\/]+).*/,"$1")):b&&(a.location=b.replace(/#.*$/,"")+"#"+ +new Date+h++ +"&"+c))},receiveMessage:function(c,b){if(d.postMessage)if(c&&(f=function(a){if("string"===typeof b&&a.origin!==b||"[object Function]"===Object.prototype.toString.call(b)&&!1===b(a.origin))return!1;c(a)}),d.addEventListener)d[c?"addEventListener":"removeEventListener"]("message",f,!1);
else d[c?"attachEvent":"detachEvent"]("onmessage",f);else e&&clearInterval(e),e=null,c&&(e=setInterval(function(){var a=document.location.hash,b=/^#?\d+&/;a!==g&&b.test(a)&&(g=a,c({data:a.replace(b,"")}))},100))}}}();

var originResponse = (function() {	
	var _helper = {
	}
	
	var ads = {
		ascend: function(data) {
			var animate = {},
				ad 		= document.getElementById(data.emcOriginId);
			
			switch(data.toggle) {
				case 'default':
					animate = {
						duration:	data.duration,
						from:		data.parentTriggered,
						to:			data.parentInitial
					};
					break;
				case 'expand':
					animate = {
						duration:	data.duration,
						from:		data.parentInitial,
						to:			data.parentTriggered
					}
					break;
				case 'remove':
					animate = {
						duration:	data.duration,
						from:		ad.height,
						to:			'0px'
					}
					break;
			}
			
			Viper({
				object:		ad,
				property: 	'height',
				from:		animate.from,
				to:			animate.to,
				duration: 	animate.duration,
				finish:		function() {
					if(data.toggle === 'remove') {
						ad.parentNode.removeChild(ad);
					}
				}
			}).start();
		},
		eclipse: function(data) {
			
		},
		horizon: function(data) {
			var animate	= {},
				ad		= document.getElementById(data.emcOriginId);
			switch(data.toggle) {
				case 'initial':
					animate = {
						duration:data.animateTime,
						from:	data.animateIframeStart,
						to:		data.animateIframeEnd
					};
					break;
				case 'triggered':
					animate = {
						duration:data.animateTime - 200,
						from: 	data.animateIframeEnd,
						to: 	data.animateIframeStart
					};
/*
					if(document.getElementById('emcOriginCSS')) {
						var originCSS 	= document.getElementById('emcOriginCSS');
						originCSS.parentNode.removeChild(originCSS);
					}
*/
					break;
				case 'remove':
					ad.parentNode.removeChild(ad);
					break;
			}
			
			Viper({
				object: 	ad,
				property:	'height',
				from:		animate.from,
				to: 		animate.to,
				duration: 	animate.duration,
				update: function(e) {
					document.body.style.backgroundPosition = '50% '+e.height;
				},
				finish: function() {
					document.body.style.backgroundPosition = '50% '+animate.to;
				}
			}).start();
		},
		meridian: function(data) {
			
		},
		nova: function(data) {
			var ad 			= document.getElementById(data.emcOriginId),
				adExpand	= document.getElementById(data.emcOriginId+'e');
			switch(data.toggle) {
				case 'default':
				case 'remove':
					adExpand.parentNode.removeChild(adExpand);
					break;
				case 'expand':
					var params	= {
						attributes: {
							'height':	'100%',
							'name':		ad.name,
							'width':	'100%'
						},
						styles: {
							'left':		'0px',
							'position':	'fixed',
							'top':		'0px',
							'zIndex':	'999999'
						}
					};
					var expand		= originRender.template(params);
						expand.id	= data.emcOriginId+'e';
						expand.src	= data.url;
					document.body.appendChild(expand);
					break;
			}
		}
	}
	
	return {
		init: function() {
			//console.log('http://'+document.getElementById('originResponse').getAttribute('data-xd'));
			//'http://'+document.getElementById('originResponse').getAttribute('data-xd')
			XD.receiveMessage(function(message) {
				try {
					JSON.parse(message.data);
				} catch(e) {
					return false;
				}
				message		= JSON.parse(message.data);
				if(message.type) ads[message.type](message);
			}, 'http://local.origin_azure');
		}
	}
})();
originResponse.init();