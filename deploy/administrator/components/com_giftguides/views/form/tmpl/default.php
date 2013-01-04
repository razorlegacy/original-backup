<?php defined('_JEXEC') or die();

	$document 	=& JFactory::getDocument();
	$user 		=& JFactory::getUser();
		
	$giftguideHelper		= new giftguideTemplate();
	
	$modal_template_array	= array('white', 'black');
	$jsFadeIn				= empty($this->giftguide->js_fadeIn) ? "700": $this->giftguide->js_fadeIn;
	$jsFadeOut				= empty($this->giftguide->js_fadeOut) ? "300": $this->giftguide->js_fadeOut;
	$jsModalWidth			= empty($this->giftguide->js_modal_width) ? "820px": $this->giftguide->js_modal_width;
	$jsModalHeight			= empty($this->giftguide->js_modal_height) ? "410px": $this->giftguide->js_modal_height;
	//$jsEase					= empty($this->giftguide->js_featured_ease) ? '': $this->giftguide->js_featured_ease;
	//$jsEaseTime				= empty($this->giftguide->js_featured_easeTime) ? '500': $this->giftguide->js_featured_easeTime;
	
	$output		= "";
	$output		.= "<div id='giftguide_create'>";
	$output			.= "<form action='index.php' method='POST' name='adminForm' id='adminForm' >";
	$output			.= "<div class='gg_category_left'>";
	$output				.= "<fieldset>";
	$output					.= "<legend>".JText::_('FORM_NAME')."</legend>";
	$output					.= "<ul id='gg_name'>";
	$output						.= "<li>{$giftguideHelper->_createInputText('Gift Guide Name', 'giftguide_name', (isset($this->giftguide))? $this->giftguide->giftguide_name: '', '', '', JText::_('TOOLTIP_GIFTGUIDE_NAME'))}</li>";

		//Flag for if loading a pre-existing gift guide
		if(!empty($this->giftguide->id)) {
			$output				.= "<input type='hidden' name='id' value='{$this->giftguide->id}'/>";
		}
		//User select		
		if($this->userObj->checkACL($this->minACL)) {
			//if(!$this->giftguide->author) {
			if(!isset($this->giftguide)) {
				$userDefault	= $user->id;
			} else {
				$userDefault	= $this->giftguide->author;
			}
			
			$userSelect	= $this->userObj->loadUsers(2);
			$output				.= "<li><label>Manager</label><select name='author'>";
			
			foreach($userSelect as $value) {
				if($value->id == $userDefault) {
					$selected	= " SELECTED";
				} else {
					$selected	= "";
				}
				$output			.= "<option value='{$value->id}'{$selected}>{$value->name}</option>\n";
			}
			$output				.= "</select></li>";
		} else {
			$output				.= "<input type='hidden' name='author' value='{$user->id}'/>";
		}
	$output					.= "</ul>";
	$output				.= "</fieldset>";
	
	$output				.= "<fieldset>";
	$output					.= "<legend>".JText::_('FORM_FACEBOOK')."</legend>";
	$output					.= "<ul id='gg_facebook'>";
	$output						.= "<li>{$giftguideHelper->_createInputText('Icon', 'facebook_icon', (isset($this->giftguide))?$this->giftguide->facebook_icon:'', '', '', JText::_('TOOLTIP_FACEBOOK_ICON'))}</li>";
	$output						.= "<li>{$giftguideHelper->_createInputText('Title', 'facebook_title', (isset($this->giftguide))?$this->giftguide->facebook_title:'', '', '', JText::_('TOOLTIP_FACEBOOK_TITLE'))}</li>";
	$output						.= "<li>{$giftguideHelper->_createTextArea('Description', 'facebook_description', (isset($this->giftguide))?$this->giftguide->facebook_description:'', '', JText::_('TOOLTIP_FACEBOOK_DESCRIPTION'))}</li>";
	$output					.= "</ul>";
	$output				.= "</fieldset>";
		
	$output				.= "<fieldset>";
	$output					.= "<legend>".JText::_('FORM_EMAIL')."</legend>";
	$output					.= "<ul id='gg_email'>";
	$output						.= "<li>{$giftguideHelper->_createInputText('Header CDN', 'email_header', (isset($this->giftguide))?$this->giftguide->email_header:'', '', '', JText::_('TOOLTIP_EMAIL_HEADER'))}</li>";
	$output						.= "<li>{$giftguideHelper->_createInputText('Subject', 'email_title', (isset($this->giftguide))?$this->giftguide->email_title:'', '', '', JText::_('TOOLTIP_EMAIL_SUBJECT'))}</li>";
	$output						.= "<li>{$giftguideHelper->_createInputText('Body', 'email_description', (isset($this->giftguide))?$this->giftguide->email_description:'', '', '',  JText::_('TOOLTIP_EMAIL_BODY'))}</li>";
	$output					.= "</ul>";
	$output				.= "</fieldset>";
	
	$output			.= "</div>";
	$output			.= "<div class='gg_category_right'>";
	
	$output				.= "<fieldset>";
	$output					.= "<legend>".JText::_('FORM_TWITTER')."</legend>";
	$output					.= "<ul id='gg_twitter'>";
	$output						.= "<li>{$giftguideHelper->_createTextArea('Tweet', 'twitter_description', (isset($this->giftguide))?$this->giftguide->twitter_description:'', '',  JText::_('TOOLTIP_TWITTER'))}</li>";
	$output						.= "<li><span id='twitter_count'>120</span> characters left</li>";
	$output					.= "</ul>";
	$output				.= "</fieldset>";
	
	$output				.= "<fieldset>";
	$output					.= "<legend>".JText::_('FORM_BANNER')."</legend>";
	$output					.= "<label>".JText::_('FORM_BANNER_OPTION')."</label>";
		if(isset($this->giftguide) && $this->giftguide->super_banner == '[ADTAG]') {
			$banner_hide	= " style='display: none'";
			$banner_yes		= " SELECTED";
			$banner_no		= "";
		} else {
			$banner_hide	= "";
			$banner_yes		= "";
			$banner_no		= " SELECTED";
		}
	$output					.= "<select id='banner_option' name='banner_option'>";
	$output						.= "<option value='1'{$banner_yes}>Yes</option>";
	$output						.= "<option value='0'{$banner_no}>No</option>";
	$output					.= "</select>";
	$output					.= "<ul id='gg_banner'{$banner_hide}>";
	$output						.= "<li>{$giftguideHelper->_createInputText('Banner CDN (Flash)', 'super_banner', (isset($this->giftguide))?$this->giftguide->super_banner:'', '', '',  JText::_('TOOLTIP_SUPER_BANNER'))}</li>";
	$output						.= "<li>{$giftguideHelper->_createInputText('Banner CDN (Static)', 'super_banner_static', (isset($this->giftguide))?$this->giftguide->super_banner_static:'', '', '', JText::_('TOOLTIP_SUPER_BANNER_STATIC'))}</li>";
	$output					.= "</ul>";
	$output				.= "</fieldset>";
	
	$output				.= "<fieldset>";
	$output					.= "<legend id='meta_collapse'>".JText::_('FORM_ADVANCED')."</legend>";
	$output					.= "<div id='giftguide_meta' style='display: none;'>";
	
	$output						.= "<fieldset id='giftguide_meta_transition'>";
	$output							.= "<legend>".JText::_('FORM_ADVANCED_TRANSITION')."</legend>";
	$output							.= "<ul>";
	$output								.= "<li>{$giftguideHelper->_createInputText('Fade In', 'js_fadeIn', $jsFadeIn, '', '', JText::_('TOOLTIP_META_FADEIN'))}ms</li>";
	$output								.= "<li>{$giftguideHelper->_createInputText('Fade Out', 'js_fadeOut', $jsFadeOut, '', '', JText::_('TOOLTIP_META_FADEOUT'))}ms</li>";
	$output							.= "</ul>";
	$output						.= "</fieldset>";
	
	$output						.= "<fieldset id='giftguide_meta_modal'>";
	$output							.= "<legend>".JText::_('FORM_ADVANCED_MODAL')."</legend>";
	$output							.= "<ul>";
	$output								.= "<li><label>Template</label>";
	$output									.= "<select name='js_modal_template'>";
	
		foreach($modal_template_array as $value) {
			if(isset($this->giftguide) && $value == $this->giftguide->js_modal_template) {
				$modal_selected	= " SELECTED";
			} else {
				$modal_selected	= "";
			}
			
			$output								.= "<option value='{$value}'{$modal_selected}>{$value}</option>";
		}
	
	$output									.= "</select>";
	$output								.= "</li>";
	$output								.= "<li>{$giftguideHelper->_createInputText('Width', 'js_modal_width', $jsModalWidth, '', '', JText::_('TOOLTIP_META_MODAL_WIDTH'))}</li>";
	$output								.= "<li>{$giftguideHelper->_createInputText('Height', 'js_modal_height', $jsModalHeight, '', '', JText::_('TOOLTIP_META_MODAL_HEIGHT'))}</li>";
	$output							.= "</ul>";
	$output						.= "</fieldset>";
	
	$output					.= "</div>";
	$output				.= "</fieldset>";
	$output			.= "</div>";

	$output				.= "<input type='hidden' name='option' value='".JRequest::getVar( 'option' )."'/>";
	$output				.= "<input type='hidden' name='published' value='1'/>";
	if(isset($this->giftguide)) {
		$output				.= "<input type='hidden' name='gid' value='{$this->giftguide->id}'/>";    
	} else {
		$output				.= "<input type='hidden' name='gid' value=''/>";    
	}
	$output				.= "<input type='hidden' name='task' value=''/>";
	
	$output			.= "</form>";
	$output		.= "</div>";
	echo $output;
?>