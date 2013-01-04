<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
	$orochiTemplate	= new orochiTemplate();
	$arTemplates		= array('none', 'poll', 'chatterbox');
?>
	<h3 class="orochi-title"><?php echo JText::_('ADD_EMBED');?></h3>
	<ul class="disable-list-style">
		<li>
			<label class="inline"><?php echo JText::_('EMBED_TITLE');?></label>
			<input type="text" class="websvc-required" name="title" id="embed_title" value="" placeholder="<?php echo JText::_('EMBED_TITLE');?>" title="<?php echo JText::_('REQUIRED');?>"/>
		</li>
		<li>
			<label class="inline"><?php echo JText::_('EMBED_TEMPLATE');?></label>
			<?php echo $orochiTemplate->_createDropDown($arTemplates, 'template' );?>
		</li>
		<li>
			<label class="inline"><?php echo JText::_('EMBED_CONTENT');?></label>
			<textarea name="embed" id="embed" placeholder="<?php echo JText::_('EMBED_CONTENT_PLACEHOLDER');?>"></textarea>
		</li>
	</ul>