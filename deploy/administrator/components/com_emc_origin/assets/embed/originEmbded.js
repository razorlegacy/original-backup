(function() {	
	var emcOriginScript	= document.createElement('script'),
		emcLocation		= document.getElementsByTagName('script')[document.getElementsByTagName('script').length - 1],
		emcOriginConfig	= 'http://local.webservices/index.php?option=com_emc_origin&view=nova&format=raw&id=27&debug=1';
		emcOriginScript.src	= 'http://local.webservices/components/com_emc_origin/assets/js/emcOrigin.js',
		emcOriginScript.id	= 'emcOriginScript',
		window.emcOriginFlag	= (typeof window.emcOriginFlag === 'undefined')? true: false;
		
		emcOriginParams27 = {
			'emcOriginDomain':		'local.webservices',
			'bgHex':				'#fff',
			'auto':					'0',
			'close':				'0',
			'hover':				'0',
			'clickthru1':			'http://www.google.com/?q=click-thru-1',
			'clickthru2':			'http://www.google.com/?q=click-thru-2',
			'clickthru3':			'http://www.google.com/?q=click-thru-3',
			'clickthru4':			'http://www.google.com/?q=click-thru-4',
			'clickthru5':			'http://www.google.com/?q=click-thru-5'
		};
		if(typeof emcOriginParamsOverride != 'undefined') {
			for(var i in emcOriginParamsOverride) {
				if(emcOriginParamsOverride[i]) {
					emcOriginParams27[i]	= emcOriginParamsOverride[i];
				}
			}
		}
		
		if(window.emcOriginFlag) emcLocation.parentNode.insertBefore(emcOriginScript, emcLocation);
		
		if(emcOriginScript.addEventListener) {
			document.getElementById('emcOriginScript').addEventListener('load', function(){emcOriginInit(emcLocation)}, false);
		} else if (emcOriginScript.readyState) {
			emcOriginScript.onreadystatechange = function() {
				if(emcOriginScript.readyState === 'loaded') {
					emcOriginInit(emcLocation);
				}
			};
		}
		
		function emcOriginInit(emcLocation) {
			if(top === self) {
				emcOriginCreate.init(emcOriginConfig, emcOriginParams27, emcLocation);
			} else {
				var url				= 'http://' + document.referrer.split('/')[2] + '/';
					window.name 	= encodeURIComponent(JSON.stringify(emcOriginParams27));
					window.location = url + 'emcOriginIframe/emcOriginIframe.html?'+encodeURIComponent(emcOriginConfig);
			}						
		}
})();