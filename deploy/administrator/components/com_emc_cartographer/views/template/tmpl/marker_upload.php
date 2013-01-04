<?php defined('_JEXEC') or die('Restricted access');?>

	<?php
		$assetsURL		= '/assets/components/com_emc_cartographer/'.$this->cartographerObj['config']->id.'/';
		$uploadIcon		= ($this->thumbnail)? $assetsURL.$this->thumbnail: '/libraries/evolve/images/evolve/evolve-ui-buttons-upload.png';
	?>
	<form class="evolve-ajaxFileUploader-form evolve-buttons evolve-shadow evolve-border evolve-bg-primary evolve-absolute" data-name="icon_hover" style="overflow: hidden">
		<img class="marker_upload_preview" src="<?php echo $uploadIcon;?>"/>
		<input type="file" name="files[]" id="files" class="evolve-buttons-file" multiple>
		<input type="hidden" id="uploadDir" name="uploadDir" value="/assets/components/com_emc_cartographer/temp/"/>
	</form>
	