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
						$content_data	= json_decode($content->content_data);
						$swfObject	= $content_data->swfObject;
						$wmode		= $content_data->wmode;
						$image		= $content_data->imageBackup;
						break;
					}
				}
			}
			break;
		}
	}
	
	$swfPath	= "http://{$_SERVER['HTTP_HOST']}/assets/components/com_emc_origin/{$this->oid}/{$swfObject}";
	$imageBackup= "http://{$_SERVER['HTTP_HOST']}/assets/components/com_emc_origin/{$this->oid}/{$image}";
	$dimensions	= getimagesize($swfPath);
	$width		= $dimensions[0];
	$height		= $dimensions[1];
	
?>
<html>
	<head></head>
	<script type='text/javascript' src='http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_emc_origin/assets/js/components/flash.js'></script>
	<body style="margin: 0;">
		<div id="flash-<?php echo $this->id;?>">
			<?php
			if(getimagesize($imageBackup)) {
				echo "<img src='{$imageBackup}'/>";
			}
			?>
		</div>
		<script type='text/javascript'>
			swfobject.embedSWF('<?php echo $swfPath;?>', 'flash-<?php echo $this->id;?>', '<?php echo $width;?>', '<?php echo $height;?>', '9', false, {}, {wmode: '<?php echo $wmode;?>'}, {});
		</script>
	</body>
</html>