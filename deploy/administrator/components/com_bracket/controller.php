<?php

defined('_JEXEC') or die();

jimport('joomla.application.component.controller');

class BracketController extends JController
{
	/**
	 * Menu Items
	 */
	const MENU_NAME			= 'bracket';
	const RESULT_MENU_NAME	= 'bracket-result';
	
	function execute($task) {
		switch($task) {
			case 'add':
				$this->displayAddBracket();
				break;
			case 'edit':
				$this->displayEditBracket();
				break;
			case 'save':
				$this->saveBracket();
				$this->display();
				break;
			case 'remove':
				$this->remove();
				$this->display();
				break;
			case 'entry':
				$this->displayEntry();
				break;
			case 'entryedit':
				$this->displayEditEntry();
				break;
			case 'entryupdate':
				$this->displayUpdateEntry();
				break;
			case 'entrypositionupdate':
				$this->updateEntryPositions();
				break;
			case 'main':
				$this->display();
				break;
			case 'resetentry':
				$this->resetEntry();
				break;
			default:
				$this->display();
		}
	}
	
	function updateEntryPositions() {
		$positions = JRequest::getVar('positions', '');
		$cid = JRequest::getVar('cid', '');
		$modelBracket =& $this->getModel('entry');
		$modelBracket->updatePositions($positions, $cid);  
	}
	
	function resetEntry() {
		$eid 	= JRequest::getVar('eid', '');
		$cid = JRequest::getVar('cid', '');
		$modelBracket =& $this->getModel('entry');
		$modelBracket->resetEntry($eid, $cid);  			
	}
	
	
	function displayUpdateEntry() {
		$name 				= JRequest::getVar('name', '');
		$description		= JRequest::getVar('description', '');
		$position			= JRequest::getVar('position', '');
		$eid					= JRequest::getVar('id', '');
		$cid					= JRequest::getVar('cid', '');
		$modelBracket 	=& $this->getModel('entry');
		$modelBracket->updateEntry($name, $description, $position, $eid, $cid);
		$this->displayEntry();
	}
	
	function displayEditEntry() {
		$session 					=& JFactory::getSession();
		$view 						=& $this->getView('entryedit');
		$eid 							= JRequest::getVar('eid', '');
		$modelBracket 			=& $this->getModel('entry');
		$entryData = $modelBracket->getEntryDetail($eid);
		$view->display($entryData);
	}
	
	function displayEntry() {
		global $mainframe, $option;
		
		$session 					=& JFactory::getSession();
		$view 						=& $this->getView('entry');
		$cid 							= JRequest::getVar('cid', '');
		$modelBracketCheck =& $this->getModel('item');
		$modelBracket 			=& $this->getModel('entry');
		$viewName				= JRequest::getVar('view', 'entry');
		$viewLayout				= JRequest::getVar('layout', 'default');
		$view->setLayout($viewLayout);
		if (!$modelBracketCheck->isValidId($cid)) {
			//given id wasn't valid; return to list view and display an error
			$this->display();
			return;
		}
		$bracketDetails = $modelBracketCheck->getCompleteBracketData($cid);
		$bracketData = $modelBracket->getBracketEntries($cid);
		$view->display($bracketData,$bracketDetails);
	}
	
	
	function remove() {
		$items = JRequest::getVar('cid', array());
		if ($items) {
			$modelBracket =& $this->getModel('item');
			$modelBracket->removeItems($items);  			
		}
	}
	
	function saveBracket() {
		$mode = JRequest::getVar('mode', 'new');
		$numEntries = JRequest::getVar('numEntries', 16);
		$numRanges = sqrt($numEntries) + 1;
		
		//bracket info
		$bracketName = JRequest::getVar('bracket_name', '');
		$gaTrackingId = JRequest::getVar('ga_tracking_id', '');
		$preroll = JRequest::getVar('preroll', '');
		
		//bracket background
		$backgroundColor = JRequest::getVar('background_color', '');
		
		//bracket options
		$showInfoScreen = JRequest::getVar('show_info_screen', 1);
		$showWinnerScreen = JRequest::getVar('show_winner_screen', 1);
		$useOneImage = JRequest::getVar('use_one_image', 1);
		$allowMultipleVotes = JRequest::getVar('allow_multiple_votes', 1);
		
		//netline
		$netlineColor = JRequest::getVar('netline_color', '');
		$netlineLoseColor = JRequest::getVar('netline_lose_color', '');
		$netlineThickness = JRequest::getVar('netline_thickness', '');
		
		//bracket font
		$fontFamily = JRequest::getVar('font_family', '');
		$fontColor = JRequest::getVar('font_color', '');
		$fontSize = JRequest::getVar('font_size', '');
		$fontBackColor = JRequest::getVar('font_back_color', '');
		$fontBold = JRequest::getVar('font_bold', '');
		
		//entry boxes
		$boxBorderColor = JRequest::getVar('box_border_color', '');
		$boxOverBorderColor = JRequest::getVar('box_over_border_color', '');
		$boxBorderThickness = JRequest::getVar('box_border_thickness', '');
		$boxRoundness = JRequest::getVar('box_roundness', '');
		$boxGradientColor1 = JRequest::getVar('box_gradient_color1', '');
		$boxGradientColor2 = JRequest::getVar('box_gradient_color2', '');
		$boxGradientAngle = JRequest::getVar('box_gradient_angle', '');
		$boxLoseFillColor = JRequest::getVar('box_lose_fill_color', '');
		
		//intro screen
		$introscreenWidth = JRequest::getVar('introscreen_width', '');
		$introscreenHeight = JRequest::getVar('introscreen_height', '');
		$introscreenStartButtonXPos = JRequest::getVar('introscreen_start_button_xpos', '');
		$introscreenStartButtonYPos = JRequest::getVar('introscreen_start_button_ypos', '');
				
		//winner screen
		$winnerscreenWidth = JRequest::getVar('winnerscreen_width', '');
		$winnerscreenHeight = JRequest::getVar('winnerscreen_height', '');
		$winnerscreenWinnerImageXPos = JRequest::getVar('winnerscreen_winner_image_xpos', '');
		$winnerscreenWinnerImageYPos = JRequest::getVar('winnerscreen_winner_image_ypos', '');
		$winnerscreenWinnerImageWidth = JRequest::getVar('winnerscreen_winner_image_width', '');
		$winnerscreenWinnerImageHeight = JRequest::getVar('winnerscreen_winner_image_height', '');
		$winnerscreenCloseButtonXPos = JRequest::getVar('winnerscreen_close_button_xpos', '');
		$winnerscreenCloseButtonYPos = JRequest::getVar('winnerscreen_close_button_ypos', '');
		$winnerscreenPercentageTextFontColor = JRequest::getVar('winnerscreen_percentagetext_font_color', '');
		$winnerscreenPercentageTextFontFamily = JRequest::getVar('winnerscreen_percentagetext_font_family', '');
		$winnerscreenPercentageTextFontSize = JRequest::getVar('winnerscreen_percentagetext_font_size', '');
		$winnerscreenPercentageTextBold = JRequest::getVar('winnerscreen_percentagetext_bold', '');
		$winnerscreenPercentageTextXPos = JRequest::getVar('winnerscreen_percentagetext_xpos', '');
		$winnerscreenPercentageTextYPos = JRequest::getVar('winnerscreen_percentagetext_ypos', '');
		$winnerscreenNameTextFontColor = JRequest::getVar('winnerscreen_nametext_font_color', '');
		$winnerscreenNameTextFontFamily = JRequest::getVar('winnerscreen_nametext_font_family', '');
		$winnerscreenNameTextFontSize = JRequest::getVar('winnerscreen_nametext_font_size', '');
		$winnerscreenNameTextBold = JRequest::getVar('winnerscreen_nametext_bold', '');
		$winnerscreenNameTextXPos = JRequest::getVar('winnerscreen_nametext_xpos', '');
		$winnerscreenNameTextYPos = JRequest::getVar('winnerscreen_nametext_ypos', '');
		
		//compare screen
		$comparescreenWidth = JRequest::getVar('comparescreen_width', '');
		$comparescreenHeight = JRequest::getVar('comparescreen_height', '');
		$comparescreenCloseButtonXPos = JRequest::getVar('comparescreen_close_button_xpos', '');
		$comparescreenCloseButtonYPos = JRequest::getVar('comparescreen_close_button_ypos', '');
		$comparescreenRoundLabelTextFontColor = JRequest::getVar('comparescreen_roundlabeltext_font_color', '');
		$comparescreenRoundLabelTextFontFamily = JRequest::getVar('comparescreen_roundlabeltext_font_family', '');
		$comparescreenRoundLabelTextFontSize = JRequest::getVar('comparescreen_roundlabeltext_font_size', '');
		$comparescreenRoundLabelTextBold = JRequest::getVar('comparescreen_roundlabeltext_bold', '');
		$comparescreenRoundLabelTextXPos = JRequest::getVar('comparescreen_roundlabeltext_xpos', '');
		$comparescreenRoundLabelTextYPos = JRequest::getVar('comparescreen_roundlabeltext_ypos', '');
		$comparescreenNameTextFontColor = JRequest::getVar('comparescreen_nametext_font_color', '');
		$comparescreenNameTextFontFamily = JRequest::getVar('comparescreen_nametext_font_family', '');
		$comparescreenNameTextFontSize = JRequest::getVar('comparescreen_nametext_font_size', '');
		$comparescreenNameTextBold = JRequest::getVar('comparescreen_nametext_bold', '');
		$comparescreenNameTextXPos = JRequest::getVar('comparescreen_nametext_xpos', '');
		$comparescreenNameTextYPos = JRequest::getVar('comparescreen_nametext_ypos', '');
		$comparescreenDescriptionTextFontColor = JRequest::getVar('comparescreen_descriptiontext_font_color', '');
		$comparescreenDescriptionTextFontFamily = JRequest::getVar('comparescreen_descriptiontext_font_family', '');
		$comparescreenDescriptionTextFontSize = JRequest::getVar('comparescreen_descriptiontext_font_size', '');
		$comparescreenDescriptionTextBold = JRequest::getVar('comparescreen_descriptiontext_bold', '');
		$comparescreenDescriptionTextXPos = JRequest::getVar('comparescreen_descriptiontext_xpos', '');
		$comparescreenDescriptionTextYPos = JRequest::getVar('comparescreen_descriptiontext_ypos	', '');	

		//bracket dates
		$arrDates = array();
		for ($i = 1; $i <= $numRanges; $i++) {
			$arrDates[$i] = JRequest::getVar('startdate_' . $i, '');
		}
		
		$modelBracket =& $this->getModel('item');
		switch ($mode) {
			case 'new':
				$modelBracket->saveNewBracket($bracketName, $gaTrackingId, $preroll, $backgroundColor, $showInfoScreen, $showWinnerScreen, $useOneImage, $allowMultipleVotes, $netlineColor, $netlineLoseColor, $netlineThickness, $fontFamily, $fontColor, $fontSize, $fontBackColor, $fontBold, $boxBorderColor, $boxOverBorderColor, $boxBorderThickness, $boxRoundness, $boxGradientColor1, $boxGradientColor2, $boxGradientAngle, $boxLoseFillColor, $introscreenWidth, $introscreenHeight, $introscreenStartButtonXPos, $introscreenStartButtonYPos, $winnerscreenWidth, $winnerscreenHeight, $winnerscreenWinnerImageXPos, $winnerscreenWinnerImageYPos, $winnerscreenWinnerImageWidth, $winnerscreenWinnerImageHeight, $winnerscreenCloseButtonXPos, $winnerscreenCloseButtonYPos, $winnerscreenPercentageTextFontColor, $winnerscreenPercentageTextFontFamily, $winnerscreenPercentageTextFontSize, $winnerscreenPercentageTextBold, $winnerscreenPercentageTextXPos, $winnerscreenPercentageTextYPos, $winnerscreenNameTextFontColor, $winnerscreenNameTextFontFamily, $winnerscreenNameTextFontSize, $winnerscreenNameTextBold, $winnerscreenNameTextXPos, $winnerscreenNameTextYPos, $comparescreenWidth, $comparescreenHeight, $comparescreenCloseButtonXPos, $comparescreenCloseButtonYPos, $comparescreenRoundLabelTextFontColor, $comparescreenRoundLabelTextFontFamily, $comparescreenRoundLabelTextFontSize, $comparescreenRoundLabelTextBold, $comparescreenRoundLabelTextXPos, $comparescreenRoundLabelTextYPos, $comparescreenNameTextFontColor, $comparescreenNameTextFontFamily, $comparescreenNameTextFontSize, $comparescreenNameTextBold, $comparescreenNameTextXPos, $comparescreenNameTextYPos, $comparescreenDescriptionTextFontColor, $comparescreenDescriptionTextFontFamily, $comparescreenDescriptionTextFontSize, $comparescreenDescriptionTextBold, $comparescreenDescriptionTextXPos, $comparescreenDescriptionTextYPos, $arrDates);
				break;
			case 'edit':
				$id = JRequest::getVar('id', -1);
				$modelBracket->editBracket($id, $bracketName, $gaTrackingId, $preroll, $backgroundColor, $showInfoScreen, $showWinnerScreen, $useOneImage, $allowMultipleVotes, $netlineColor, $netlineLoseColor, $netlineThickness, $fontFamily, $fontColor, $fontSize, $fontBackColor, $fontBold, $boxBorderColor, $boxOverBorderColor, $boxBorderThickness, $boxRoundness, $boxGradientColor1, $boxGradientColor2, $boxGradientAngle, $boxLoseFillColor, $introscreenWidth, $introscreenHeight, $introscreenStartButtonXPos, $introscreenStartButtonYPos, $winnerscreenWidth, $winnerscreenHeight, $winnerscreenWinnerImageXPos, $winnerscreenWinnerImageYPos, $winnerscreenWinnerImageWidth, $winnerscreenWinnerImageHeight, $winnerscreenCloseButtonXPos, $winnerscreenCloseButtonYPos, $winnerscreenPercentageTextFontColor, $winnerscreenPercentageTextFontFamily, $winnerscreenPercentageTextFontSize, $winnerscreenPercentageTextBold, $winnerscreenPercentageTextXPos, $winnerscreenPercentageTextYPos, $winnerscreenNameTextFontColor, $winnerscreenNameTextFontFamily, $winnerscreenNameTextFontSize, $winnerscreenNameTextBold, $winnerscreenNameTextXPos, $winnerscreenNameTextYPos, $comparescreenWidth, $comparescreenHeight, $comparescreenCloseButtonXPos, $comparescreenCloseButtonYPos, $comparescreenRoundLabelTextFontColor, $comparescreenRoundLabelTextFontFamily, $comparescreenRoundLabelTextFontSize, $comparescreenRoundLabelTextBold, $comparescreenRoundLabelTextXPos, $comparescreenRoundLabelTextYPos, $comparescreenNameTextFontColor, $comparescreenNameTextFontFamily, $comparescreenNameTextFontSize, $comparescreenNameTextBold, $comparescreenNameTextXPos, $comparescreenNameTextYPos, $comparescreenDescriptionTextFontColor, $comparescreenDescriptionTextFontFamily, $comparescreenDescriptionTextFontSize, $comparescreenDescriptionTextBold, $comparescreenDescriptionTextXPos, $comparescreenDescriptionTextYPos, $arrDates);
				break;
		}
	}
	
	function displayEditBracket() {
		global $mainframe, $option;	
		$session =& JFactory::getSession();
		$view =& $this->getView('edit');
		$id = JRequest::getVar('cid', '');
		$modelBracket =& $this->getModel('item');
		if (!$modelBracket->isValidId($id)) {
			//given id wasn't valid; return to list view and display an error
			$this->display();
			return;
		}
		$bracketData = $modelBracket->getCompleteBracketData($id);
		foreach ($bracketData as $key => $val) {
			$view->assign($key, $val);
		}		
		$viewLayout	= JRequest::getVar('layout', 'default');
		$view->setLayout($viewLayout);
		$view->display();
	}
	
	function displayAddBracket() {
		global $mainframe, $option;		
		$session =& JFactory::getSession();
		$view =& $this->getView('add');		
		$viewLayout	= JRequest::getVar('layout', 'default');
		$view->setLayout($viewLayout);
		$view->display();
	}
	
	function display() {
		global $mainframe, $option;		
		$session =& JFactory::getSession();
		$view =& $this->getView('list');
		$modelBracket =& $this->getModel('item');
		$bracketList = $modelBracket->getBracketList();	
		$view->set('bracketList', $bracketList);
		
		// set default view layout/template
		$viewLayout	= JRequest::getVar('layout', 'default');
		$view->setLayout($viewLayout);
		$view->display();
	}
}