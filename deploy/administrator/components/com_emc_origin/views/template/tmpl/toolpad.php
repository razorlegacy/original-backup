<?php defined('_JEXEC') or die('Restricted access');?>
	<?php
	$originHelper	= new originHelper();
	$toolpadArray	= array('embed', 'flash', 'image', 'link', 'trigger', 'remove');
	foreach($toolpadArray as $type) {	
	?>
		<div class="origin_toolpad_draggable" data-type="<?php echo $type;?>">
			<div class="origin_toolpad_<?php echo $type;?> origin-bg-<?php echo $originHelper->originTypeColor($type);?> origin_toolpad_icon"></div>
			<label class="evolve-ios-label"><?php echo JText::_('TOOLPAD_'.$type);?></label>
		</div>
	
	<?php	
	}
	?>