var originParams;
var originIframe 	= 'http://' + document.referrer.split('/')[2] + '/emcOriginIframe/emcOriginIframe.html';
var originResponse	= 'http://local.origin_azure/components/com_emc_origin/assets/js/originResponse.js';
var script			= document.getElementsByTagName('script')[document.getElementsByTagName('script').length - 1];

var originRender = (function() {
	var _helper = {
		originResponse: function() {
			if(!window.top.originResponseFlag) {
				var header 		= document.createElement('script');
					header.id	= 'originResponse';
					header.src	= originResponse;
					header.setAttribute('data-xd', originParams.xd);
					window.top.document.getElementsByTagName('head')[0].appendChild(header);
			}
			//Set flag
			window.top.originResponseFlag	= true;
		},
		template: function(params) {
			if(navigator.userAgent.indexOf('MSIE 7.0')>=0) {	
			} else {
				var template		= document.createElement('iframe');
					template.name	= encodeURIComponent(JSON.stringify(originParams));
			}
			
			//Applies attributes
			for(var i in params.attributes) {
				template[i]			= params.attributes[i];
			}
			
			//Applies styles
			for(var i in params.styles) {
				template.style[i]	= params.styles[i];
			}
			
			template.scrolling		= 'no';
			template.frameBorder	= 0;
			//template.src			= 'http://'+originParams.xd+'/index.php?option=com_emc_origin&format=raw&view='+originParams.type+'&id='+originParams.id+'&debug=1';
			template.src 			= 'http://'+'local.origin_azure'+'/index.php?option=com_emc_origin&task=ad&id='+originParams.id;
			template.id				= 'emcOrigin-'+originParams.id;
	
			return template;
		}
	}
		
	var render = {
		ascend: function() {
			var params = {
				attributes: {
					'height':	'90px',
					'width':	'100%'
				},
				styles: {
					'bottom':	'0px',
					'left':		'0px',
					'position':	'fixed',
					'zIndex':	'999999'
				}
			};
			var ad 	= _helper.template(params);
		},
		eclipse: function() {
			var params = {
				attributes: {
					'height':	'90px',
					'width':	'970px'
				},
				styles: {}
			};
			var ad 	= _helper.template(params);
		},
		horizon: function() {
			var params	= {
				attributes: {
					'height':	'50px',
					'width':	'100%'
				},
				styles: {
					'backgroundColor': originParams.bg,
					'display':	'block',
					'margin':	'0px auto'
				}
			};
			
			var originCSS		= document.createElement('style');
				originCSS.id	= 'originCSS';
				originCSS.type 	= 'text/css';
				originCSSText	= 'body{background-position: 50% 50px !important;}';
				if(originCSS.styleSheet) {
					originCSS.styleSheet.cssText	= originCSSText;
				} else {
					originCSS.appendChild(document.createTextNode(originCSSText));
				}
				
			var ad 	= _helper.template(params);
			
			document.body.insertBefore(ad, document.body.firstChild);
			document.body.appendChild(originCSS);
		},
		meridian: function() {
			var params = {
				attributes: {
					'height':	'100%',
					'width':	'100%'
				},
				styles: {
					'left':		'0px',
					'position':	'fixed',
					'top':		'0px',
					'zIndex':	'999999'
				}
			};
			var ad 	= _helper.template(params);
		},
		nova: function() {
			var params = {
				attributes: {
					'height':	'250px',
					'width':	'300px'
				},
				styles: {}
			};
			var ad 	= _helper.template(params);
			script.parentNode.insertBefore(ad, script);
			//originDOM.parentNode.insertBefore(ad, originDOM);
		}
	}
	
	return {
		init: function() {
			originParams= {
				'auto':		script.getAttribute('data-auto'),
				'bg':		script.getAttribute('data-bg'),
				'close':	script.getAttribute('data-close'),
				'dcopt':	script.getAttribute('data-dcopt'),
				'hover':	script.getAttribute('data-hover'),
				'id':		script.getAttribute('data-id'),
				'source':	window.location.href,
				'type':		script.getAttribute('data-type')
				//'xd':		script.getAttribute('data-xd'),
			};

			//Detect iframe
			if(top === self) {
				render[originParams.type]();
				_helper.originResponse();
			} else if(originParams.dcopt === 'true') {
				//Hidden iframe buster
				iframeNode		= document.createElement('iframe');
				iframeNode.name = encodeURIComponent(JSON.stringify(originParams));
				iframeNode.src	= originIframe;
				iframeNode.style.display = 'none';
				document.body.appendChild(iframeNode);
			} else if(originParams.dcopt === 'false') {
				//Redirect iframe buster for inline ad units
				window.name 	= encodeURIComponent(JSON.stringify(originParams));
				window.location = originIframe;
			}
		},
		template: function(params) {
			return _helper.template(params);
		}
	}
})();

if(script.getAttribute('data-init') === 'true') {
	originRender.init();
}