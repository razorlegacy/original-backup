<?php defined('_JEXEC') or die('Restricted access');?>

<h2><?php echo JText::_('GROUP_HEADER');?></h2>

	<div id="cartographer_group_create">
	<?php
		echo evolveUi::dialogButton('3', JText::_('GROUP_CREATE'), 'group_create', 'evolve-bg-primary');
	?>
	</div>
	
	<ul id="cartographer_group_list" class="evolve-disable-list-style">
		<?php
		foreach($this->cartographerObj['groups'] as $key=>$value) {
			$content	= json_decode($value->content);
		?>
			<li class="evolve-relative evolve-inline evolve-border evolve-buttons cartographer_group_item" data-id="<?php echo $value->id;?>" data-group="cartographer_group_<?php echo $value->id;?>">
				<div class="evolve-absolute cartographer_group_delete">
					<?php echo evolveUi::dialogButton('186', '', 'group_delete', 'evolve-bg-primary');?>
				</div>
				<img src="<?php echo (isset($content->uploadDir)) ? $content->uploadDir.$content->bg_img:'';?>" class="cartographer_group_thumbnail"/>
				<input type="hidden" name="ordering[]" value="<?php echo $value->id;?>" />
			</li>
		<?php
		}
		?>
	</ul>
	
	
	<div class="evolve-buttons-confirm">
		<?php
		echo evolveUi::dialogButton('56', JText::_('BUTTON_CLOSE'), 'popup_close', 'evolve-bg-primary');
		?>
	</div>