<!DOCTYPE HTML>
<html>
	<head>
		<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_orochi/assets/orochi/js/websvc_orochi.js"></script>
		<script type="text/javascript">
			window.onload=function(){if(parent)for(var c=document.getElementsByTagName("head")[0],b=parent.document.getElementsByTagName("style"),a=0;a<b.length;a++)c.appendChild(b[a].cloneNode(!0))};
			
			var $j				= jQuery.noConflict();
			var contentObj		= window.parent.iframeContent['emcContent_<?php echo $_GET['cid'];?>'];
			var contentEmbed	= contentObj.embed;
			var emcOrochi_iframe;
				
			if(contentObj.type == 'video') {
				var	flowplayer		= new Object();
				
				var sbEmbed			= '<div>'+contentEmbed+'</div>';
				var playerClass		= $j('object.SpringboardPlayer', sbEmbed).attr('id');
				
				flowplayer.fireEvent = function(playerId, action) {
					if(action == 'onLoad' && !parent.document.getElementById('orochi')) {
		
						var playlist		= document[playerClass].fp_getPlaylist();
						var newPlaylist 	= new Array();
						for(var i in playlist) {
							newPlaylist.push(playlist[i].completeUrl);
						}

						if(contentObj.playlistRandom == 'true') {
							newPlaylist.sort(function() {return 0.5 - Math.random();});
						}
						
						if(contentObj.autoplay == 'true') {
							document[playerClass].fp_play(newPlaylist);
						}
						
						if(contentObj.automute == 'true') {
							document[playerClass].fp_mute();
						} else {
							document[playerClass].fp_unmute();
						}
						
					}
				}
			}
			
			(function($j) {
				emcOrochi_iframe	= {
					init: function(command) {
						switch(command) {
							case "hide":	$j('body').empty();
											$j('body').addClass('emcOrochi_iframe_hidden');
											break;
							case "show":	$j('body').append($j('body').data('iframe_clone'));
											$j('body').removeClass('emcOrochi_iframe_hidden');
											break;
						}
					}
				};
			})(jQuery);
			
			$j(function() {
				//For workspace purposes
				if(parent.document.getElementById('orochi')) {
					$j('body').append(contentEmbed);
				}
				$j('head').append('<style>iframe{height: '+$j(window.frameElement).height()+'px}</style>');
				$j('body').data('iframe_clone', contentEmbed);
 			});

		</script>
	</head>
	<body id="" class="" style="margin:0;padding:0;"></body>
</html>