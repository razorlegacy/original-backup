<?php defined('_JEXEC') or die('Restricted access');?>

<?php
	$markerContent	= json_decode($this->markerObj->content);
	$coordinates	= json_decode($this->markerObj->coordinates);
	$coordX			= (isset($coordinates->coordX))? $coordinates->coordX: 0;
	$coordY			= (isset($coordinates->coordY))? $coordinates->coordY: 0;
	//$iconHover 		= null;
	$markerLink		= '';
	if($markerContent->tooltip_link_override) {
		$doc	= new DOMDocument();
		$doc->loadHTML($markerContent->content);
		$xml	= simplexml_import_dom($doc);
		$result	= $xml->xpath('//a');
		
		$markerLink	= $result[0]['href'];
	}	
	
	if($markerContent->icon || isset($iconHover)) {
		$iconDefault	= $markerContent->icon;
		$iconHover		= ($markerContent->icon_hover)? $markerContent->icon_hover: $markerContent->icon;
	} else if($this->icon_default || $this->icon_hover) {
		$iconDefault	= $this->icon_default;
		$iconHover		= ($this->icon_hover)? $this->icon_hover: $this->icon_default;
	}
?>

<div id="emcCartographer_marker_<?php echo $this->markerObj->id;?>" class="emcCartographer_marker" style="top: <?php echo $coordY;?>px; left: <?php echo $coordX;?>px;min-width:32px;min-height:32px" data-content='<?php echo $this->markerObj->content;?>' data-id='<?php echo $this->markerObj->id;?>' data-link='<?php echo $markerLink;?>'>
	<?php
	if($markerContent->icon || isset($iconHover)) {
	?>
		<img src="/assets/components/com_emc_cartographer/<?php echo $this->cartographerObj['config']->id;?>/<?php echo $iconDefault;?>" class="emcCartographer_marker_icon"/>
		<img src="/assets/components/com_emc_cartographer/<?php echo $this->cartographerObj['config']->id;?>/<?php echo $iconHover;?>" class="emcCartographer_marker_icon_hover"/>
	<?php
	} else {
	?>
		<div class="emcCartographer_marker_placeholder"></div>
	<?php
	}
	?>	
	<input type="hidden" id="cid" name="cid" value="<?php echo $this->cartographerObj['config']->id; ?>"/>
</div>