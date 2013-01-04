<?php defined('_JEXEC') or die('Restricted access');?>
<!DOCTYPE HTML>
<?php
	//$originConfig	= json_decode($this->originConfig->config);
	//http://local.origin_azure/index.php?option=com_emc_origin&task=json&id=55
	//$sid, $oid, $id
	
	
	$json		= file_get_contents("http://{$_SERVER['HTTP_HOST']}/index.php?option=com_emc_origin&task=json&id={$this->oid}");
	$jsonObj	= json_decode($json);
	
	$originContent	= $jsonObj->content;
	
	foreach($originContent as $content) {
		if($content->id === $this->sid) {
			foreach($content->default as $item) {
				$content_data = json_decode($item->content_data);
				if($content_data->id === $this->id) {
					$content 	= $content_data->content;
					break;
				}
			}
			foreach($content->expand as $item) {
				$content_data = json_decode($item->content_data);
				if($content_data->id === $this->id) {
					$content 	= $content_data->content;
					break;
				}
			}
		}	
		break;
	}
?>
<html>
	<head></head>
	<body style="margin: 0;">
		<?php
			echo $content;
		?>
		<script>
			var $ = jQuery = window.parent.$;
			
			$(function() {
				console.log($('.SpringboardPlayer'));
			});
		
		
			if(document.querySelectorAll('.SpringboardPlayer').length > 0) {
				console.log('here');
				//parent.emcOriginAd.video(document.querySelectorAll('.SpringboardPlayer')[0].name);
			}
			
			
			var video = (function() {
				
				return {
					
				}
				
				/*
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
*/
			})();
		</script>
	</body>
</html>