<?php defined('_JEXEC') or die('Restricted access');?>

<?php
	switch($this->contentObj->content) {
		case "click":
			$event	= "click";
			break;
		case "hover":
			$event	= "mouseenter";
			break;
	}
?>
<div id="trigger-<?php echo $this->contentObj->id;?>" class="trigger" data-type="<?php echo $event;?>"></div>