<?php defined('_JEXEC') or die('Restricted access');?>

	<?php
	if(!empty($this->contentObj->content)) {
		$link = '';
		switch($this->contentObj->content) {
			case 'link':
				$link	= $this->contentObj->link;
				break;
			default:
				$link	= $this->contentObj->content;
				break;
		}
	?>
		<a href="<?php echo $link;?>" id="<?php echo $this->contentObj->content;?>-<?php echo $this->contentObj->id;?>" class="link" target="_blank" data-type="<?php echo $this->contentObj->content;?>"><?php echo $link;?></a>
	<?php
	}
	?>