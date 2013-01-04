<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	$swfPath	= "http://{$_SERVER['HTTP_HOST']}/assets/components/com_emc_origin/{$this->contentObj->oid}/{$this->contentObj->swfObject}";
	$dimensions	= getimagesize($swfPath);
	$width		= $dimensions[0];
	$height		= $dimensions[1];
	
	$backup		= "";
	
	if(isset($this->contentObj->imageBackup)) {
		if(getimagesize("http://{$_SERVER['HTTP_HOST']}/assets/components/com_emc_origin/{$this->contentObj->oid}/{$this->contentObj->imageBackup}")) {
			$backup = "<img src='http://{$_SERVER['HTTP_HOST']}/assets/components/com_emc_origin/{$this->contentObj->oid}/{$this->contentObj->imageBackup}'/>";
		}
	}

	$content	= "<script type='text/javascript'>swfobject.embedSWF('{$swfPath}', 'swfobject-{$this->contentObj->id}', '{$width}', '{$height}', '9', {}, {wmode: '{$this->contentObj->wmode}'}, {});</script><div id='swfobject-{$this->contentObj->id}'>{$backup}</div>";
	
/* 	$content	= "<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' width='{$width}' height='{$height}' id='flash-{$this->contentObj->id}' align='middle'><param name='movie' value='{$swfPath}'/><param name='wmode' value='{$this->contentObj->wmode}'><!--[if !IE]>--><object type='application/x-shockwave-flash' data='{$swfPath}' width='{$width}' height='{$height}'><param name='wmode' value='{$this->contentObj->wmode}'></object><!--<![endif]--><img src='{$imgPath}'/></object>"; */
	
?>
<div class="data-embed" data-content="<?php echo rawurlencode($content);?>">
	<?php echo $content;?>
</div>