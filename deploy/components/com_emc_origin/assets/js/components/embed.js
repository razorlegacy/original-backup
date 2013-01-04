var $ = window.parent.$, jQuery = window.parent.jQuery;

//Springboard API
function emcOriginSpringboard(sid, override) {
	
	var defaults = {
		'autoClose': 5,
		'autoMute':	true,
		'autoPlay':	true
	},
	params	= new Object();
	
	var params	= $.extend(defaults, override);
	
	$sb(sid).onLoad(function() {
		
		(params.autoPlay)? $sb(sid).play(): $sb(sid).pause();
		(params.autoMute)? $sb(sid).mute(): $sb(sid).unmute();
	});
}

		/*
		var springboardDefaults = {
					"autoClose": "5",
					"autoMute": true,
					"autoPlay": true,
					"playerMute": "off",
					"unmuteHover": true,
					"unmuteRestart": false
				}
		
		
		
		
		var springboard = {
		autoClose: function(timer) {
			$sb(springboardPlayerId).onFinish(function() {
				setTimeout(function(){emcOriginAd.adClose();}, timer * 1000);
			});	
		},
		autoMute: function() {
			if(autoOpen) {
				$sb(springboardPlayerId).mute();
			}
		},
		autoPlay: function() {
			$sb(springboardPlayerId).play();
		},
		playerMute: function(toggle) {
			if(!autoOpen && toggle === "off") {
				$sb(springboardPlayerId).unmute();
			} else if(!autoOpen && toggle === "on") {
				$sb(springboardPlayerId).mute();
			}
		},
		unmuteHover: function() {
			$sb(springboardPlayerId).onMouseOver(function() {
				if($sb(springboardPlayerId).getStatus().muted) {
					$sb(springboardPlayerId).unmute();
				}
			});
		},
		unmuteRestart: function() {
			$sb(springboardPlayerId).onUnmute(function() {
				$sb(springboardPlayerId).seek(0);
			});
		}
	}
		
		
		
		
		
		
		
		
		
		
		
		springboard: function(id, override) {
			springboardPlayerId		= id;
			$sb(springboardPlayerId).onLoad(function() {
			
				var springboardDefaults = {
					"autoClose": "5",
					"autoMute": true,
					"autoPlay": true,
					"playerMute": "off",
					"unmuteHover": true,
					"unmuteRestart": false
				}

				if(typeof override != 'undefined') {
					for(var i in override) {
						if(override[i] != 'undefined') {
							springboardDefaults[i]	= override[i];
						}
					}
				}
				for (var i in springboardDefaults) {
					if (springboardDefaults.hasOwnProperty(i) && springboardDefaults[i]) {
						springboard[i](springboardDefaults[i]);
					}
				}
			});
		},
		*/


/*
$(function() {
	//Detect if SB is used
	if($('.SpringboardPlayer', document).length > 0) {
		var sid	= $('.SpringboardPlayer', document).attr('id');
		//console.log(sid);
	}
});	
*/