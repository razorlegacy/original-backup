<?php defined('_JEXEC') or die();

	$document 	=& JFactory::getDocument();
	$document->addStyleSheet('components'.DS.'com_giftguides'.DS.'css'.DS.'jquery.ui.css');
	$document->addStyleSheet('components'.DS.'com_giftguides'.DS.'css'.DS.'giftguides.css');
	$document->addStyleSheet('components'.DS.'com_giftguides'.DS.'css'.DS.'uploadify.css');
	
	$giftguideTemplate	= new giftguideTemplate();
	$giftguidesModel	= $this->getModel('giftguides');
	//$folder_name		= $this->giftguide->id."_".strtolower(str_replace(' ', '_', $this->giftguide->giftguide_name));
		
	$output			= "";
	
	//$output			.= "<a href='#' id='debug'>debug</a>";
	//$output			.= "<a href='#' id='reload'>reload</a>";
	$output			.= "<form name='categoryForm' id='categoryForm'>";
	$output				.= "<input type='text' id='category_name' name='category_name' title='Category Name' placeholder='Category Name'/>";
	$output				.= "<input type='button' id='category_submit' value='".JText::_('PRODUCT_CREATE_CATEGORY')."'/>";
	$output				.= "<input type='hidden' name='gid' value='{$this->giftguide->id}'/>";
	$output				.= "<input type='hidden' id='folder_name' name='folder_name' value='{$this->giftguide->id}'/>";
	$output				.= "<input type='hidden' name='option' value='".JRequest::getVar('option')."'/>";
	$output				.= "<input type='hidden' name='task' value='saveCategory'/>";
	$output			.= "</form>";
	
	$output			.= "<div id='giftguide_category'>";
	$output				.= $giftguideTemplate->responseCategory($this->category, $giftguidesModel);
	$output			.= "</div>";
	$output			.= "<form name='adminForm' id='adminForm'>";
	$output				.= "<input type='hidden' name='option' value='".JRequest::getVar('option')."'/>";
	$output				.= "<input type='hidden' name='cid' value='{$this->giftguide->id}'/>";    
	$output				.= "<input type='hidden' name='task' value=''/>";
	$output			.= "</form>";

	echo $output;
?>