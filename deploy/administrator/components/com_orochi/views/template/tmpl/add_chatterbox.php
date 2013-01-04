<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
?>
	<h3 class="orochi-title"><?php echo JText::_('ADD_CB');?></h3>
	<div id="orochi_cb_form" class="">
		<ul class="disable-list-style">
			<li>
				<label><?php echo JText::_('CB_TITLE');?></label>
				<input type="text" name="title" id="cb_title" placeholder="<?php echo JText::_('CB_TITLE_PLACEHOLDER');?>"/>
			</li>
			<li>
				<label><?php echo JText::_('CB_DESCRIPTION');?></label>
				<textarea class="elastic" name="description" id="cb_description"></textarea>
			</li>
			<li>
				<label><?php echo JText::_('CB_EMAIL');?></label>
				<input type="text" name="email" id="cb_email" class="required" value="<?php echo $qa_email;?>"  placeholder="<?php echo JText::_('CB_EMAIL_PLACEHOLDER');?>" />
			</li>
			<li>
				<label><?php echo JText::_('CB_CC_EMAIL');?></label>
				<input type="text" name="cc_email" id="cb_cc_email" class="required" value="<?php echo $qa_email;?>"  placeholder="<?php echo JText::_('CB_CC_EMAIL_PLACEHOLDER');?>" />
			</li>
		</ul>
	</div>