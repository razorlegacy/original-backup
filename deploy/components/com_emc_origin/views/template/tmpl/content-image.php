<?php defined('_JEXEC') or die('Restricted access');?>

<?php
	$imageBase		= "http://{$_SERVER['HTTP_HOST']}/assets/components/com_emc_origin/{$this->contentObj->oid}/";
	$imageDefault	= $imageBase.$this->contentObj->imageDefault;
	$imageHover		= $imageBase.$this->contentObj->imageHover;
?>

<?php if(!empty($this->contentObj->link)){ ?><a href="<?php echo $this->contentObj->link;?>" target="_blank"><?php } ?>	
	<?php if(getimagesize($imageDefault) && getimagesize($imageHover)){?><div class="imageHoverWrapper"><?php } ?>
		<?php if(getimagesize($imageDefault)) { ?><img src="<?php echo $imageDefault;?>" class="image imageDefault"/><?php } ?>
		<?php if(getimagesize($imageHover)) { ?><img src="<?php echo $imageHover;?>" class="image imageHover"/><?php } ?>
	<?php if(getimagesize($imageDefault) && getimagesize($imageHover)){?></div><?php } ?>
<?php if(!empty($this->contentObj->link)) { ?> </a> <?php } ?>