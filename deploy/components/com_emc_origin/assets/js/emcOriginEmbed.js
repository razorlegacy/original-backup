<script type='text/javascript'>
		(function() {
			var emcOriginScript	= document.createElement('script'),
				emcLocation		= document.getElementsByTagName('script')[document.getElementsByTagName('script').length - 1],
				emcOriginConfig	= 'http://{$_SERVER['HTTP_HOST']}/index.php?option=com_emc_origin&view={$originConfigObj->type}&format=raw&id={$originConfigObj->id}{$debug}{$cache}',
				emcOriginParams	= {$params};
				emcOriginScript.src	= 'http://{$_SERVER['HTTP_HOST']}/components/com_emc_origin/assets/js/emcOrigin.js';

			if(emcOriginScript.addEventListener) {
				emcOriginScript.addEventListener('load', function(){emcOriginInit(emcLocation)}, false);
			} else if (emcOriginScript.readyState) {
				emcOriginScript.onreadystatechange = function() {
					if(emcOriginScript.readyState == 'loaded') {
						emcOriginInit(emcLocation);
					}
				};
			}

			function emcOriginInit(emcLocation) {
				if(window == window.top) {
					emcOriginCreate.init(emcOriginConfig, emcOriginParams, emcLocation);
				} else {
					var url				= 'http://' + document.referrer.split('/')[2] + '/';
						window.name 	= encodeURIComponent(JSON.stringify(emcOriginParams));
						window.location = url + 'emcOriginIframe/emcOriginIframe.html?'+encodeURIComponent(emcOriginConfig);
				}						
			}
			
			emcLocation.parentNode.insertBefore(emcOriginScript, emcLocation)
})();
	</script>