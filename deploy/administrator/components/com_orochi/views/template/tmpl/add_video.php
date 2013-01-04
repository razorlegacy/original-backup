<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
	$orochiTemplate      = new orochiTemplate();
	$arOptions = array('true', 'false');
?>
<h3 class="orochi-title"><?php echo JText::_('ADD_VIDEO');?></h3>
<div id="orochi_video_form" class="">
	<ul class="disable-list-style">
		<li>
			<label class="inline"><?php echo JText::_('VIDEO_TITLE');?></label>
			<input type="text" id="title" name="title" class="websvc-required" placeholder="<?php echo JText::_('VIDEO_TITLE_PLACEHOLDER');?>" title="<?php echo JText::_('REQUIRED');?>">
		</li>
		<li>
			<label class="inline"><?php echo JText::_('VIDEO_AUTOPLAY');?></label>
			<?php echo $orochiTemplate->_createDropDown($arOptions, 'autoplay' );?>
		</li>
		<li>
			<label class="inline"><?php echo JText::_('VIDEO_AUTOMUTE');?></label>
			<?php echo $orochiTemplate->_createDropDown($arOptions, 'automute' );?>
		</li>
		<li>
			<label class="inline"><?php echo JText::_('VIDEO_PLAYLIST_RANDOM');?></label>
			<?php echo $orochiTemplate->_createDropDown($arOptions, 'playlistRandom' );?>
		</li>
		<li>
			<label class="inline"><?php echo JText::_('VIDEO_EMBED');?></label>
			<textarea id="embed" name="embed" class="" value="" placeholder="<?php echo JText::_('VIDEO_EMBED_PLACEHOLDER');?>"></textarea>
		</li>
	</ul>
</div>