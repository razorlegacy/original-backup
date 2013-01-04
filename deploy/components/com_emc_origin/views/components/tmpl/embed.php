<?php defined('_JEXEC') or die('Restricted access');?>
<!DOCTYPE HTML>
<?php
	$json		= file_get_contents("http://{$_SERVER['HTTP_HOST']}/index.php?option=com_emc_origin&task=json&id={$this->oid}");
	$jsonObj	= json_decode($json);
	$types		= array('default', 'expand', 'mobile-default', 'mobile-expand', 'tablet-default', 'tablet-expand');

	foreach($jsonObj->content as $schedule) {
		if($schedule->id === $this->sid) {
			foreach($types as $type) {
				foreach($schedule->$type as $id=>$content) {
					if(preg_match('/"id":"'.$this->id.'"/', $content->content_data)) {
						$embed	= json_decode($content->content_data)->content;
						break;
					}
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