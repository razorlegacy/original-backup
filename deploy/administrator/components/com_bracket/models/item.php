<?php

defined('_JEXEC') or die();

jimport('joomla.application.component.model');
jimport('joomla.filesystem.file');

class BracketModelItem extends JModel
{
	
	const ASSETS_PATH = 'assets/components/com_bracket';
	
	function __construct()
	{
		parent::__construct();
	}
	
	function reformatDate($date) {
		$dateParts = strptime($date, '%m-%d-%Y');
			if (isset($dateParts['tm_mon']) && isset($dateParts['tm_mday']) && isset($dateParts['tm_year'])) {
				$reformatted_date = (1900 + $dateParts['tm_year']) . '-' . ($dateParts['tm_mon'] + 1) . '-' . $dateParts['tm_mday'];
			} else {
				$reformatted_date = '0000-00-00';
			}
		return $reformatted_date;
	}
	
	function saveNewBracket($bracketName, $gaTrackingId, $preroll, $backgroundColor, $showInfoScreen, $showWinnerScreen, $useOneImage, $allowMultipleVotes, $netlineColor, $netlineLoseColor, $netlineThickness, $fontFamily, $fontColor, $fontSize, $fontBackColor, $fontBold, $boxBorderColor, $boxOverBorderColor, $boxBorderThickness, $boxRoundness, $boxGradientColor1, $boxGradientColor2, $boxGradientAngle, $boxLoseFillColor, $introscreenWidth, $introscreenHeight, $introscreenStartButtonXPos, $introscreenStartButtonYPos, $winnerscreenWidth, $winnerscreenHeight, $winnerscreenWinnerImageXPos, $winnerscreenWinnerImageYPos, $winnerscreenWinnerImageWidth, $winnerscreenWinnerImageHeight, $winnerscreenCloseButtonXPos, $winnerscreenCloseButtonYPos, $winnerscreenPercentageTextFontColor, $winnerscreenPercentageTextFontFamily, $winnerscreenPercentageTextFontSize, $winnerscreenPercentageTextBold, $winnerscreenPercentageTextXPos, $winnerscreenPercentageTextYPos, $winnerscreenNameTextFontColor, $winnerscreenNameTextFontFamily, $winnerscreenNameTextFontSize, $winnerscreenNameTextBold, $winnerscreenNameTextXPos, $winnerscreenNameTextYPos, $comparescreenWidth, $comparescreenHeight, $comparescreenCloseButtonXPos, $comparescreenCloseButtonYPos, $comparescreenRoundLabelTextFontColor, $comparescreenRoundLabelTextFontFamily, $comparescreenRoundLabelTextFontSize, $comparescreenRoundLabelTextBold, $comparescreenRoundLabelTextXPos, $comparescreenRoundLabelTextYPos, $comparescreenNameTextFontColor, $comparescreenNameTextFontFamily, $comparescreenNameTextFontSize, $comparescreenNameTextBold, $comparescreenNameTextXPos, $comparescreenNameTextYPos, $comparescreenDescriptionTextFontColor, $comparescreenDescriptionTextFontFamily, $comparescreenDescriptionTextFontSize, $comparescreenDescriptionTextBold, $comparescreenDescriptionTextXPos, $comparescreenDescriptionTextYPos, $arrDates) {
		
		global $mainframe;
		
		$db =& JFactory::getDBO();
				
		//Bracket SQL Insert
		$sql = 'INSERT INTO #__bracket (
		 `name`,
		 `ga_tracking_id`,
		 `preroll`,
		 `background_color`,
		 `netline_color`,
		 `netline_thickness`,
		 `netline_losecolor`,
		 `introscreen_width`,
		 `introscreen_height`,
		 `introscreen_start_button_xpos`,
		 `introscreen_start_button_ypos`,
		 `winnerscreen_width`,
		 `winnerscreen_height`,
		 `winnerscreen_winner_image_xpos`,
		 `winnerscreen_winner_image_ypos`,
		 `winnerscreen_winner_image_width`,
		 `winnerscreen_winner_image_height`,
		 `winnerscreen_close_button_xpos`,
		 `winnerscreen_close_button_ypos`,
		 `winnerscreen_percentagetext_font_family`,
		 `winnerscreen_percentagetext_font_size`,
		 `winnerscreen_percentagetext_font_color`,
		 `winnerscreen_percentagetext_xpos`,
		 `winnerscreen_percentagetext_ypos`,
		 `winnerscreen_percentagetext_bold`,
		 `winnerscreen_nametext_font_family`,
		 `winnerscreen_nametext_font_size`,
		 `winnerscreen_nametext_font_color`,
		 `winnerscreen_nametext_xpos`,
		 `winnerscreen_nametext_ypos`,
		 `winnerscreen_nametext_bold`,
		 `comparescreen_width`,
		 `comparescreen_height`,
		 `comparescreen_close_button_xpos`,
		 `comparescreen_close_button_ypos`,
		 `comparescreen_roundlabeltext_font_family`,
		 `comparescreen_roundlabeltext_font_size`,
		 `comparescreen_roundlabeltext_font_color`,
		 `comparescreen_roundlabeltext_xpos`,
		 `comparescreen_roundlabeltext_ypos`,
		 `comparescreen_roundlabeltext_bold`,
		 `comparescreen_nametext_font_family`,
		 `comparescreen_nametext_font_size`,
		 `comparescreen_nametext_font_color`,
		 `comparescreen_nametext_xpos`,
		 `comparescreen_nametext_ypos`,
		 `comparescreen_nametext_bold`,
		 `comparescreen_descriptiontext_font_family`,
		 `comparescreen_descriptiontext_font_size`,
		 `comparescreen_descriptiontext_font_color`,
		 `comparescreen_descriptiontext_xpos`,
		 `comparescreen_descriptiontext_ypos`,
		 `comparescreen_descriptiontext_bold`,
		 `font_family`,
		 `font_color`,
		 `font_size`,
		 `font_back_color`,
		 `font_bold`,
		 `box_border_color`,
		 `box_border_thickness`,
		 `box_gradient_color1`,
		 `box_gradient_color2`,
		 `box_gradient_angle`,
		 `box_roundness`,
		 `box_over_border_color`,
		 `box_lose_fill_color`,
		 `show_info_screen`,
		 `show_winner_screen`,
		 `use_one_image`,
		 `allow_multiple_votes`
		   ) VALUES (\'' 
		   . $db->getEscaped($bracketName) . '\',\''
		   . $db->getEscaped($gaTrackingId) . '\',\'' 
		   . $db->getEscaped($preroll) . '\',\'' 
		   . $db->getEscaped($backgroundColor) . '\',\'' 
		   . $db->getEscaped($netlineColor) . '\',\'' 
		   . $db->getEscaped($netlineThickness) . '\',\'' 
		   . $db->getEscaped($netlineLoseColor) . '\',\'' 
		   . $db->getEscaped($introscreenWidth) . '\',\''
		   . $db->getEscaped($introscreenHeight) . '\',\''
		   . $db->getEscaped($introscreenStartButtonXPos) . '\',\''
		   . $db->getEscaped($introscreenStartButtonYPos) . '\',\''
		   . $db->getEscaped($winnerscreenWidth) . '\',\''
		   . $db->getEscaped($winnerscreenHeight) . '\',\''
		   . $db->getEscaped($winnerscreenWinnerImageXPos) . '\',\''
		   . $db->getEscaped($winnerscreenWinnerImageYPos) . '\',\''
		   . $db->getEscaped($winnerscreenWinnerImageWidth) . '\',\''
		   . $db->getEscaped($winnerscreenWinnerImageHeight) . '\',\''
		   . $db->getEscaped($winnerscreenCloseButtonXPos) . '\',\''
		   . $db->getEscaped($winnerscreenCloseButtonYPos) . '\',\''
		   . $db->getEscaped($winnerscreenPercentageTextFontFamily) . '\',\''
		   . $db->getEscaped($winnerscreenPercentageTextFontSize) . '\',\''
		   . $db->getEscaped($winnerscreenPercentageTextFontColor) . '\',\''
		   . $db->getEscaped($winnerscreenPercentageTextXPos) . '\',\''
		   . $db->getEscaped($winnerscreenPercentageTextYPos) . '\','
		   . $winnerscreenPercentageTextBold . ',\''
		   . $db->getEscaped($winnerscreenNameTextFontFamily) . '\',\''
		   . $db->getEscaped($winnerscreenNameTextFontSize) . '\',\''
		   . $db->getEscaped($winnerscreenNameTextFontColor) . '\',\''
		   . $db->getEscaped($winnerscreenNameTextXPos) . '\',\''
		   . $db->getEscaped($winnerscreenNameTextYPos) . '\','
		   . $winnerscreenNameTextBold . ',\''		   
		   . $db->getEscaped($comparescreenWidth) . '\',\''
		   . $db->getEscaped($comparescreenHeight) . '\',\''
		   . $db->getEscaped($comparescreenCloseButtonXPos) . '\',\''
		   . $db->getEscaped($comparescreenCloseButtonYPos) . '\',\''
		   . $db->getEscaped($comparescreenRoundLabelTextFontFamily) . '\',\''
		   . $db->getEscaped($comparescreenRoundLabelTextFontSize) . '\',\''
		   . $db->getEscaped($comparescreenRoundLabelTextFontColor) . '\',\''
		   . $db->getEscaped($comparescreenRoundLabelTextXPos) . '\',\''
		   . $db->getEscaped($comparescreenRoundLabelTextYPos) . '\','
		   . $comparescreenRoundLabelTextBold . ',\''
		   . $db->getEscaped($comparescreenNameTextFontFamily) . '\',\''		   
		   . $db->getEscaped($comparescreenNameTextFontSize) . '\',\''
		   . $db->getEscaped($comparescreenNameTextFontColor) . '\',\''
		   . $db->getEscaped($comparescreenNameTextXPos) . '\',\''
		   . $db->getEscaped($comparescreenNameTextYPos) . '\','
		   . $comparescreenNameTextBold . ',\''
		   . $db->getEscaped($comparescreenDescriptionTextFontFamily) . '\',\''
		   . $db->getEscaped($comparescreenDescriptionTextFontSize) . '\',\''
		   . $db->getEscaped($comparescreenDescriptionTextFontColor) . '\',\''
		   . $db->getEscaped($comparescreenDescriptionTextXPos) . '\',\''			
		   . $db->getEscaped($comparescreenDescriptionTextYPos) . '\','				
		   . $comparescreenDescriptionTextBold . ',\''
		   . $db->getEscaped($fontFamily) . '\',\''
		   . $db->getEscaped($fontColor) . '\',\'' 
		   . $db->getEscaped($fontSize) . '\',\'' 
		   . $db->getEscaped($fontBackColor) . '\',\''
		   . $db->getEscaped($fontBold) . '\',\''
		   . $db->getEscaped($boxBorderColor) . '\',\'' 
		   . $db->getEscaped($boxBorderThickness) . '\',\'' 
		   . $db->getEscaped($boxGradientColor1) . '\',\'' 
		   . $db->getEscaped($boxGradientColor2) . '\',\'' 
		   . $db->getEscaped($boxGradientAngle) . '\',\'' 
		   . $db->getEscaped($boxRoundness) . '\',\'' 
		   . $db->getEscaped($boxOverBorderColor) . '\',\'' 
		   . $db->getEscaped($boxLoseFillColor) . '\',' 
		   . $showInfoScreen . ',' 
		   . $showWinnerScreen . ',' 
		   . $useOneImage . ',' 
		   . $allowMultipleVotes . ')';
		$db->setQuery($sql);
		$db->query();
		$bracketID = $db->insertid();
		
		//If the SQL Insert is successful, the initialization of the bracket's entries, votes, images, and dates are then performed.
		if ($bracketID != 0) {
			
			// initalize bracket entries table with 16 entries for new bracket to be updated with name/desc/imgs afterwards.
			for ($i = 1; $i <= 16; $i++)	{
				//SQL setup individual entries in entries table. 
				$sql = 'INSERT INTO #__bracket_entries ( `bracket_id`, `position`) VALUES(' . $bracketID . ',' . $i . ')';
				$db->setQuery($sql);
				$db->query();
				$entryID = $db->insertid();
				//SQL setup initial bracket period for each entry. These will be updated as the user votes.
				$sql = 'INSERT INTO #__bracket_votes (`entry_id`, `bracket_id`) VALUES(' . $entryID . ',' . $bracketID . ')';
				$db->setQuery($sql);
				$db->query();
			}
			
			// add bracket period dates into db
			foreach ($arrDates as $i => $date) {
				//$sql = 'UPDATE #__bracket_periods SET `date` = \'' . $insertDate . '\' WHERE bracket_id = ' . $id . ' AND position = ' . $i;
				$sql = 'INSERT INTO #__bracket_periods (`bracket_id`, `position`, `date`) VALUES(' . $bracketID . ',' . $i . ',' . '\'' . BracketModelItem::reformatDate($db->getEscaped($date)) . '\')';
				$db->setQuery($sql);
				//echo $sql . "<br>";
				$db->query();
			}
			
			//Bracket image file uploads
			$image_basedir = JPATH_ROOT.DS.self::ASSETS_PATH.DS.$bracketID;
				
			// if directory does not exist create it
			if (!JFolder::exists($image_basedir)) {
				JFolder::create($image_basedir, 0777);
			}

			//Setup loop to upload images with renamed file name
			$image_relpaths = array();
			$image_types = array('background_image', 'default_box_image', 'default_winner_image', 'introscreen_image', 'introscreen_upstate_image', 'introscreen_overstate_image', 'winnerscreen_image', 'winnerscreen_upstate_image', 'winnerscreen_overstate_image', 'comparescreen_background_image', 'comparescreen_upstate_image', 'comparescreen_overstate_image');
			
			//Iterate through $_FILES array to setup upload, rename of filename, and SQL Update statement. 
			foreach ($image_types as $image_type) {
				$file_key = "{$image_type}";
				if (array_key_exists($file_key, $_FILES) && is_numeric(strpos($_FILES[$file_key]['type'], 'image')) && $_FILES[$image_type]['error'] == 0) {
					$image_relpaths[$image_type] = $bracketID . '_' . $file_key . '_' . $_FILES[$file_key]['name'];
					$uploadResult = JFile::upload($_FILES[$file_key]['tmp_name'], $image_basedir. DS . $image_relpaths[$image_type]);
					
					//Set up SQL update statement with valid filename populated
				switch ($image_type) {
				 case 'background_image':
				 	$sql = "UPDATE #__bracket SET `background_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
				 	$db->setQuery($sql);
					$db->query();
				 	break;
				 case 'default_box_image':
				 	$sql = "UPDATE #__bracket SET `default_box_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
				 	$db->setQuery($sql);
					$db->query();
				 	break;
				 case 'default_winner_image':
				 	$sql = "UPDATE #__bracket SET `default_winner_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
				 	$db->setQuery($sql);
					$db->query();
				 	break;
				 case 'introscreen_image':
				 	$sql = "UPDATE #__bracket SET `introscreen_background_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
				 	$db->setQuery($sql);
					$db->query();
				 	break;
				 case 'introscreen_upstate_image':
				 	$sql = "UPDATE #__bracket SET `introscreen_upstate_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
				 	$db->setQuery($sql);
					$db->query();
				 	break;
				 case 'introscreen_overstate_image':
				 	$sql = "UPDATE #__bracket SET `introscreen_overstate_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
				 	$db->setQuery($sql);
					$db->query();
				 	break;
				 case 'winnerscreen_image':
				 	$sql = "UPDATE #__bracket SET `winnerscreen_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
				 	$db->setQuery($sql);
					$db->query();
				 	break;
				 case 'winnerscreen_upstate_image':
				 	$sql = "UPDATE #__bracket SET `winnerscreen_upstate_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
				 	$db->setQuery($sql);
					$db->query();
				 	break;
				 case 'winnerscreen_overstate_image':
				 	$sql = "UPDATE #__bracket SET `winnerscreen_overstate_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
				 	$db->setQuery($sql);
					$db->query();
				 	break;
				 case 'comparescreen_background_image':
				 	$sql = "UPDATE #__bracket SET `comparescreen_background_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
				 	$db->setQuery($sql);
					$db->query();
				 	break;
				 case 'comparescreen_upstate_image':
				 	$sql = "UPDATE #__bracket SET `comparescreen_upstate_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
				 	$db->setQuery($sql);
					$db->query();
				 	break;
				 case 'comparescreen_overstate_image':
				 	$sql = "UPDATE #__bracket SET `comparescreen_overstate_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
				 	$db->setQuery($sql);
					$db->query();
				 	break;
				}
			}
		}
		} 
	}
	
	function editBracket($id, $bracketName, $gaTrackingId, $preroll, $backgroundColor, $showInfoScreen, $showWinnerScreen, $useOneImage, $allowMultipleVotes, $netlineColor, $netlineLoseColor, $netlineThickness, $fontFamily, $fontColor, $fontSize, $fontBackColor, $fontBold, $boxBorderColor, $boxOverBorderColor, $boxBorderThickness, $boxRoundness, $boxGradientColor1, $boxGradientColor2, $boxGradientAngle, $boxLoseFillColor, $introscreenWidth, $introscreenHeight, $introscreenStartButtonXPos, $introscreenStartButtonYPos, $winnerscreenWidth, $winnerscreenHeight, $winnerscreenWinnerImageXPos, $winnerscreenWinnerImageYPos, $winnerscreenWinnerImageWidth, $winnerscreenWinnerImageHeight, $winnerscreenCloseButtonXPos, $winnerscreenCloseButtonYPos, $winnerscreenPercentageTextFontColor, $winnerscreenPercentageTextFontFamily, $winnerscreenPercentageTextFontSize, $winnerscreenPercentageTextBold, $winnerscreenPercentageTextXPos, $winnerscreenPercentageTextYPos, $winnerscreenNameTextFontColor, $winnerscreenNameTextFontFamily, $winnerscreenNameTextFontSize, $winnerscreenNameTextBold, $winnerscreenNameTextXPos, $winnerscreenNameTextYPos, $comparescreenWidth, $comparescreenHeight, $comparescreenCloseButtonXPos, $comparescreenCloseButtonYPos, $comparescreenRoundLabelTextFontColor, $comparescreenRoundLabelTextFontFamily, $comparescreenRoundLabelTextFontSize, $comparescreenRoundLabelTextBold, $comparescreenRoundLabelTextXPos, $comparescreenRoundLabelTextYPos, $comparescreenNameTextFontColor, $comparescreenNameTextFontFamily, $comparescreenNameTextFontSize, $comparescreenNameTextBold, $comparescreenNameTextXPos, $comparescreenNameTextYPos, $comparescreenDescriptionTextFontColor, $comparescreenDescriptionTextFontFamily, $comparescreenDescriptionTextFontSize, $comparescreenDescriptionTextBold, $comparescreenDescriptionTextXPos, $comparescreenDescriptionTextYPos, $arrDates) {
		
		$db =& JFactory::getDBO();
		$bracketID = $id;
		//Bracket image file uploads - This is done before updating the other parameters in order to verify the file uploads work before the field entries are updated. The images are uploaded on an as needed basis.
		$image_basedir = JPATH_ROOT.DS.self::ASSETS_PATH.DS.$bracketID;
			
		// if directory does not exist create it
		if (!JFolder::exists($image_basedir)) {
			JFolder::create($image_basedir, 0777);
		}

		//Setup loop to upload images with renamed file name
		$image_relpaths = array();
		$image_types = array('background_image', 'default_box_image', 'default_winner_image', 'introscreen_image', 'introscreen_upstate_image', 'introscreen_overstate_image', 'winnerscreen_background_image', 'winnerscreen_upstate_image', 'winnerscreen_overstate_image', 'comparescreen_background_image', 'comparescreen_upstate_image', 'comparescreen_overstate_image');
		
		//Iterate through $_FILES array to setup upload, rename of filename, and SQL Update statement. 
		foreach ($image_types as $image_type) {
			$file_key = "{$image_type}";
			if (array_key_exists($file_key, $_FILES) && is_numeric(strpos($_FILES[$file_key]['type'], 'image')) && $_FILES[$image_type]['error'] == 0) {
				$image_relpaths[$image_type] = $bracketID . '_' . $file_key . '_' . $_FILES[$file_key]['name'];
				$uploadResult = JFile::upload($_FILES[$file_key]['tmp_name'], $image_basedir. DS . $image_relpaths[$image_type]);
				
				//Set up SQL update statement with valid filename populated
			switch ($image_type) {
			 case 'background_image':
			 	$sql = "UPDATE #__bracket SET `background_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
			 	$db->setQuery($sql);
				$db->query();
			 	break;
			 case 'default_box_image':
			 	$sql = "UPDATE #__bracket SET `default_box_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
			 	$db->setQuery($sql);
				$db->query();
			 	break;
			 case 'default_winner_image':
			 	$sql = "UPDATE #__bracket SET `default_winner_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
			 	$db->setQuery($sql);
				$db->query();
			 	break;
			 case 'introscreen_image':
			 	$sql = "UPDATE #__bracket SET `introscreen_background_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
			 	$db->setQuery($sql);
				$db->query();
			 	break;
			 case 'introscreen_upstate_image':
			 	$sql = "UPDATE #__bracket SET `introscreen_upstate_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
			 	$db->setQuery($sql);
				$db->query();
			 	break;
			 case 'introscreen_overstate_image':
			 	$sql = "UPDATE #__bracket SET `introscreen_overstate_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
			 	$db->setQuery($sql);
				$db->query();
			 	break;
			 case 'winnerscreen_background_image':
			 	$sql = "UPDATE #__bracket SET `winnerscreen_background_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
			 	$db->setQuery($sql);
				$db->query();
			 	break;
			 case 'winnerscreen_upstate_image':
			 	$sql = "UPDATE #__bracket SET `winnerscreen_upstate_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
			 	$db->setQuery($sql);
				$db->query();
			 	break;
			 case 'winnerscreen_overstate_image':
			 	$sql = "UPDATE #__bracket SET `winnerscreen_overstate_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
			 	$db->setQuery($sql);
				$db->query();
			 	break;
			 case 'comparescreen_background_image':
			 	$sql = "UPDATE #__bracket SET `comparescreen_background_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
			 	$db->setQuery($sql);
				$db->query();
			 	break;
			 case 'comparescreen_upstate_image':
			 	$sql = "UPDATE #__bracket SET `comparescreen_upstate_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
			 	$db->setQuery($sql);
				$db->query();
			 	break;
			 case 'comparescreen_overstate_image':
			 	$sql = "UPDATE #__bracket SET `comparescreen_overstate_image` = '".$db->getEscaped($image_relpaths[$image_type]) . "' WHERE id = " . $bracketID;
			 	$db->setQuery($sql);
				$db->query();
			 	break;
			}
		}
	}		
	
	//Bracket SQL Update to update all remaining parameters.
	$sql = 'UPDATE #__bracket SET 
			`name` = \'' . $db->getEscaped($bracketName) . '\',
			`ga_tracking_id` = \'' . $db->getEscaped($gaTrackingId) . '\',
			`background_color` = \'' . $db->getEscaped($backgroundColor) . '\',
			`netline_color` = \'' . $db->getEscaped($netlineColor) . '\',
			`netline_thickness` = \'' . $db->getEscaped($netlineThickness) . '\',
			`netline_losecolor` = \'' . $db->getEscaped($netlineLoseColor) . '\',
			`introscreen_width` = \'' . $db->getEscaped($introscreenWidth) . '\',
			`introscreen_height` = \'' . $db->getEscaped($introscreenHeight) . '\',
			`introscreen_start_button_xpos` = \'' . $db->getEscaped($introscreenStartButtonXPos) . '\',
			`introscreen_start_button_ypos` = \'' . $db->getEscaped($introscreenStartButtonYPos) . '\',
			`winnerscreen_width` = \'' . $db->getEscaped($winnerscreenWidth) . '\',
			`winnerscreen_height` = \'' . $db->getEscaped($winnerscreenHeight) . '\',
			`winnerscreen_winner_image_xpos` = \'' . $db->getEscaped($winnerscreenWinnerImageXPos) . '\',
			`winnerscreen_winner_image_ypos` = \'' . $db->getEscaped($winnerscreenWinnerImageYPos) . '\',
			`winnerscreen_winner_image_width` = \'' . $db->getEscaped($winnerscreenWinnerImageWidth) . '\',
			`winnerscreen_winner_image_height` = \'' . $db->getEscaped($winnerscreenWinnerImageHeight) . '\',
			`winnerscreen_close_button_xpos` = \'' . $db->getEscaped($winnerscreenCloseButtonXPos) . '\',
			`winnerscreen_close_button_ypos` = \'' . $db->getEscaped($winnerscreenCloseButtonYPos) . '\',
			`winnerscreen_percentagetext_font_family` = \'' . $db->getEscaped($winnerscreenPercentageTextFontFamily) . '\',
			`winnerscreen_percentagetext_font_size` = \'' . $db->getEscaped($winnerscreenPercentageTextFontSize) . '\',
			`winnerscreen_percentagetext_font_color` = \'' . $db->getEscaped($winnerscreenPercentageTextFontColor) . '\',
			`winnerscreen_percentagetext_xpos` = \'' . $db->getEscaped($winnerscreenPercentageTextXPos) . '\',
			`winnerscreen_percentagetext_ypos` = \'' . $db->getEscaped($winnerscreenPercentageTextYPos) . '\',
			`winnerscreen_percentagetext_bold` = \'' . $db->getEscaped($winnerscreenPercentageTextBold) . '\',
			`winnerscreen_nametext_font_family` = \'' . $db->getEscaped($winnerscreenNameTextFontFamily) . '\',
			`winnerscreen_nametext_font_size` = \'' . $db->getEscaped($winnerscreenNameTextFontSize) . '\',
			`winnerscreen_nametext_font_color` = \'' . $db->getEscaped($winnerscreenNameTextFontColor) . '\',
			`winnerscreen_nametext_xpos` = \'' . $db->getEscaped($winnerscreenNameTextXPos) . '\',
			`winnerscreen_nametext_ypos` = \'' . $db->getEscaped($winnerscreenNameTextYPos) . '\',
			`winnerscreen_nametext_bold` = \'' . $db->getEscaped($winnerscreenNameTextBold) . '\',
			`comparescreen_width` = \'' . $db->getEscaped($comparescreenWidth) . '\',
			`comparescreen_height` = \'' . $db->getEscaped($comparescreenHeight) . '\',
			`comparescreen_close_button_xpos` = \'' . $db->getEscaped($comparescreenCloseButtonXPos) . '\',
			`comparescreen_close_button_ypos` = \'' . $db->getEscaped($comparescreenCloseButtonYPos) . '\',
			`comparescreen_roundlabeltext_font_family` = \'' . $db->getEscaped($comparescreenRoundLabelTextFontFamily) . '\',
			`comparescreen_roundlabeltext_font_size` = \'' . $db->getEscaped($comparescreenRoundLabelTextFontSize) . '\',
			`comparescreen_roundlabeltext_font_color` = \'' . $db->getEscaped($comparescreenRoundLabelTextFontColor) . '\',
			`comparescreen_roundlabeltext_xpos` = \'' . $db->getEscaped($comparescreenRoundLabelTextXPos) . '\',
			`comparescreen_roundlabeltext_ypos` = \'' . $db->getEscaped($comparescreenRoundLabelTextYPos) . '\',
			`comparescreen_roundlabeltext_bold` = \'' . $db->getEscaped($comparescreenRoundLabelTextBold) . '\',
			`comparescreen_nametext_font_family` = \'' . $db->getEscaped($comparescreenNameTextFontFamily) . '\',
			`comparescreen_nametext_font_size` = \'' . $db->getEscaped($comparescreenNameTextFontSize) . '\',
			`comparescreen_nametext_font_color` = \'' . $db->getEscaped($comparescreenNameTextFontColor) . '\',
			`comparescreen_nametext_xpos` = \'' . $db->getEscaped($comparescreenNameTextXPos) . '\',
			`comparescreen_nametext_ypos` = \'' . $db->getEscaped($comparescreenNameTextYPos) . '\',
			`comparescreen_nametext_bold` = \'' . $db->getEscaped($comparescreenNameTextBold) . '\',
			`comparescreen_descriptiontext_font_family` = \'' . $db->getEscaped($comparescreenDescriptionTextFontFamily) . '\',
			`comparescreen_descriptiontext_font_size` = \'' . $db->getEscaped($comparescreenDescriptionTextFontSize) . '\',
			`comparescreen_descriptiontext_font_color` = \'' . $db->getEscaped($comparescreenDescriptionTextFontColor) . '\',
			`comparescreen_descriptiontext_xpos` = \'' . $db->getEscaped($comparescreenDescriptionTextXPos) . '\',
			`comparescreen_descriptiontext_ypos` = \'' . $db->getEscaped($comparescreenDescriptionTextYPos) . '\',
			`comparescreen_descriptiontext_bold` = \'' . $db->getEscaped($comparescreenDescriptionTextBold) . '\',
			`font_family` = \'' . $db->getEscaped($fontFamily) . '\', 
			`font_color` = \'' . $db->getEscaped($fontColor) . '\', 
			`font_size` = \'' . $db->getEscaped($fontSize) . '\', 
			`font_back_color` = \'' . $db->getEscaped($fontBackColor) . '\',
			`font_bold` = \'' . $db->getEscaped($fontBold) . '\',
			`box_border_color` = \'' . $db->getEscaped($boxBorderColor) . '\', 
			`box_border_thickness` = \'' . $db->getEscaped($boxBorderThickness) . '\', 
			`box_gradient_color1` = \'' . $db->getEscaped($boxGradientColor1) . '\', 
			`box_gradient_color2` = \'' . $db->getEscaped($boxGradientColor2) . '\',
			`box_gradient_angle` = \'' . $db->getEscaped($boxGradientAngle) . '\',
			`box_roundness` = \'' . $db->getEscaped($boxRoundness) . '\',
			`box_over_border_color` = \'' . $db->getEscaped($boxOverBorderColor) . '\',
			`box_lose_fill_color` = \'' . $db->getEscaped($boxLoseFillColor) . '\',
			`show_info_screen` = \'' . $db->getEscaped($showInfoScreen) . '\',
			`show_winner_screen` = \'' . $db->getEscaped($showWinnerScreen) . '\',
			`use_one_image` = \'' . $db->getEscaped($useOneImage) . '\',
			`allow_multiple_votes` = \'' . $db->getEscaped($allowMultipleVotes) . '\'
			WHERE id = ' . $id;
			
		$db->setQuery($sql);
		$db->query();
		
		//Bracket periods SQL Update
		foreach ($arrDates as $i => $date) {
			$sql = 'UPDATE #__bracket_periods SET `date` = \'' . BracketModelItem::reformatDate($db->getEscaped($date)) . '\' WHERE bracket_id = ' . $id . ' AND position = ' . $i;
			$db->setQuery($sql);
			$db->query();
		}	
	}
	
	function getBracketList($limit = -1, $offset = -1) {
		$db =& JFactory::getDBO();

		//REFACTOR THIS QUERY IF MORE THAN 4 ROUNDS WILL BE ADDED
		$sql = "
		SELECT b.*, jbp1.`date` AS start_date, jbp2.`date` AS end_date, x.num_entries 
		FROM #__bracket b JOIN #__bracket_periods jbp1 ON jbp1.bracket_id = b.id 
			JOIN #__bracket_periods jbp2 ON jbp2.bracket_id = b.id 
			JOIN (
				SELECT b.id, count(*) AS num_entries 
				FROM #__bracket b 
					JOIN #__bracket_entries be 
					ON b.id = be.bracket_id 
					GROUP BY b.id
			) AS x ON x.id = b.id
			WHERE jbp1.position = 1 AND jbp2.position = 5
		";
		$db->setQuery($sql);
		$db->query();
		return $db->loadAssocList();
	}
	
	function removeItems($items) {
		$db =& JFactory::getDBO();
		
		if (is_array($items)) {
			foreach ($items as $item) {
				if (!is_numeric ($item)) {
					return false;
				}
			}
			$strIds = implode(',', $items);

			$sql = "DELETE FROM #__bracket WHERE id IN($strIds)";
			$db->setQuery($sql);
			$db->query();
			$sql = "DELETE FROM #__bracket_entries WHERE bracket_id IN($strIds)";
			$db->setQuery($sql);
			$db->query();
			$sql = "DELETE FROM #__bracket_periods WHERE bracket_id IN($strIds)";
			$db->setQuery($sql);
			$db->query();
			$sql = "DELETE FROM #__bracket_votes WHERE bracket_id IN($strIds)";
			$db->setQuery($sql);
			$db->query();
			
			//Delete corresponding image folder
			$image_basedir = JPATH_ROOT.DS.self::ASSETS_PATH.DS.$strIds;
			if (JFolder::exists($image_basedir)) {
				JFolder::delete($image_basedir);
			}
		}
	}
	
	function getCompleteBracketData($id) {
		$db =& JFactory::getDBO();
		
		$ret = array();
		
		$sql = "SELECT * FROM #__bracket WHERE id = $id";
		$db->setQuery($sql);
		$db->query();
		$resultArray = $db->loadAssoc();
		foreach ($resultArray as $key => $val) {
			$ret[$key] = $val;
		}
		
		$sql = "SELECT `id`, `bracket_id`, `position`, DATE_FORMAT(`date`, '%m-%d-%Y') AS `date` FROM #__bracket_periods WHERE bracket_id = $id ORDER BY `position` ASC";
		$db->setQuery($sql);
		$db->query();
		$resultArray = $db->loadAssocList();
		$ret['periods'] = $resultArray;
		
		return $ret;
		
	}
	
	function isValidId($id) {
		$db =& JFactory::getDBO();
		
		if (!is_numeric($id)) {
			return false;
		}
		
		$sql = "SELECT COUNT(*) FROM #__bracket WHERE id = $id";
		$db->setQuery($sql);
		$db->query();
		if ($db->loadResult() == 1) {
			return true;
		} else {
			return false;
		}
	}
}