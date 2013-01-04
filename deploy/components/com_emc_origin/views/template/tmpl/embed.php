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
		</script>
	</body>
</html>