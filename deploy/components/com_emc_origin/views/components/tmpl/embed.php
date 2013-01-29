<?php defined('_JEXEC') or die('Restricted access');?>
<!DOCTYPE HTML>
<?php
	$json		= file_get_contents("http://{$_SERVER['HTTP_HOST']}/index.php?option=com_emc_origin&task=json&id={$this->oid}");
	$jsonObj	= json_decode($json);
	$types		= array('initial_desktop', 'triggered_desktop', 'initial_mobile', 'triggered_mobile', 'initial_tablet', 'triggered_tablet');

	foreach($jsonObj->content as $schedule) {
		if($schedule->id === $this->sid) {
			foreach($types as $type) {
				foreach($schedule->$type as $id=>$content) {
					if($this->id === $content->id) {
						$embed	= $content->content_data->embed;
						break;
					}
/*
					if(preg_match('/"id":"'.$this->id.'"/', $content)) {
						echo 'here';
						$embed	= json_decode($content->content_data)->embed;
						break;
					}
*/
				}
			}
			break;
		}
	}
?>
<html>
	<head></head>
	<body style="margin: 0;">
		<?php
			echo $embed;
		?>
	<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_emc_origin/assets/js/components/embed.js"></script>
	<script>
		if($('.SpringboardPlayer', document).length > 0) {
			var sid	= $('.SpringboardPlayer', document).attr('id');
			emcOriginSpringboard(sid, {'autoPlay': true, 'autoMute': false});
		}
	</script>
	</body>
</html>