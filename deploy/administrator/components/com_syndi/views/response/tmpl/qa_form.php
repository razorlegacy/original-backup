<?php // no direct access
    defined('_JEXEC') or die('Restricted access');
?>

<h3><a href="#"><?php echo JText::_('ADD_QANDA');?></a></h3>
<div id="syndi_qa_form" class="syndi_fieldset qa_form syndi_add_form">
	<ul>
		<li>
			<label><?php echo JText::_('QA_TITLE');?></label>
			<input type="text" name="title" id="qa_title" placeholder="<?php echo JText::_('QA_TITLE_PLACEHOLDER');?>"/>
		</li>
		<li>
			<label><?php echo JText::_('QA_DESCRIPTION');?></label>
			<textarea class="elastic" name="description" id="qa_description"></textarea>
		</li>
		<li>
			<label><?php echo JText::_('QA_EMAIL');?></label>
			<input type="text" name="email" id="qa_email" class="required" value="<?php echo $qa_email;?>"  placeholder="<?php echo JText::_('QA_EMAIL_PLACEHOLDER');?>" />
		</li>
	</ul>
	<input type="hidden" id="id" name="qa_id"/>
	<input type="button" id="form_reset" name="form_reset" value="<?php echo JText::_('FORM_RESET');?>"/>
	<input type="button" id="form_add" name="form_add" value="<?php echo JText::_('FORM_SUBMIT');?>"/>
</div>