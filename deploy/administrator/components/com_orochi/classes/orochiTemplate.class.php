<?php
defined('_JEXEC') or die();

class orochiTemplate {
	public $tabsType		= array();
	
	function __construct() {
		//$this->tabsType		= array('article'=>'Article', 'chatterbox'=>'E-mail', 'facebook'=>'Facebook', 'gallery'=>'Gallery', 'poll'=>'Poll', 'rss'=>'RSS', 'twitter'=>'Twitter', 'video'=>'Video', 'template'=>'Templates');
		$this->tabsType		= array('article'=>'Article', 'image'=>'Image', 'video'=>'Video', 'twitter'=>'Twitter', 'rss'=>'RSS', 'embed'=>'Embed Code');
		return $this->tabsType;
	}
	
	function orochiConfig() {
		$configJSON	= array();
		
		$configJSON['syndi_bg_250']			= '';
		$configJSON['syndi_bg_600']			= '';
		$configJSON['header_click_1']		= '';
		//$configJSON['header_click_2']		= '';
		$configJSON['social_show']			= 'false';
		$configJSON['social_title']			= '';
		$configJSON['social_description']	= '';
		$configJSON['social_image']			= '';
		$configJSON['title_hex']			= '#000000';
		$configJSON['content_hex']			= '#000000';
		$configJSON['link_hex']				= '#000000';
		$configJSON['link_hover_hex']		= '#000000';
		$configJSON['scrollbar_hex']		= '#000000';
		$configJSON['pagination_bg_hex']	= '#000000';
		$configJSON['pagination_bg_opacity']= '50';
		$configJSON['pagination_link_hex']	= '#ffffff';
		$configJSON['pagination_link_hover_hex']	= '#ffffff';
		$configJSON['tab_bg_hex']			= '#ffffff';
		$configJSON['tab_bg_hover_hex']		= '#000000';
		$configJSON['tab_text_hex']			= '#000000';
		$configJSON['tab_text_hover_hex']	= '#ffffff';
		$configJSON['tab_position_250']		= 'top';
		$configJSON['tab_position_600']		= 'bottom';
		$configJSON['cycle_fx']				= 'fade';
		$configJSON['cycle_speed']			= '250';
		$configJSON['css']					= '';
		
		return json_encode($configJSON);	
	}

	function _createInputText($label, $id, $value, $class='', $type='', $title='') {
		$class	= empty($class) ? "" : " class = '{$class}'";
		$type 	= empty($type) ? "text" : $type;
		$title	= empty($title) ? "" : " title = '{$title}' placeholder = '{$title}'";

		$value  = stripslashes(htmlspecialchars($value, ENT_QUOTES));
        $output         = "";
        $output         .= "<label>{$label}</label>";
        $output         .= "<input type='{$type}' id='{$id}' name='{$id}' value='{$value}'{$title}{$class}/>";
       
        return $output;
	}
	
	function _createTextArea($label, $id, $value, $class = '', $title='') {
            $output         = "";
            $output         .= "<label>{$label}</label><textarea id='{$id}' name='{$id}' title='{$title}' placeholder='{$title}' {$class}>";
            $output			.= stripslashes($value);
            $output         .= "</textarea>";
           
            return $output;
    }
	
	function _createTabsSelect($name) {
		$output		= "<select name='{$name}' id='{$name}'>";
		
		foreach($this->tabsType as $value) {
			$output		.= "<option value='".strtolower($value)."'>{$value}</option>";
		}
		
		$output		.= "</select>";
		
		return $output;
	}
	
	function _createOption($selectOptions, $selectCheck) {
		$output	= "";

		foreach($selectOptions as $key=>$value) {
			$selected  = ($selectCheck == $key)? " selected='selected'": "";
			$output	.= "<option value='{$key}'{$selected}>{$value}</option>";
		}
		
		return $output;
	}
		
	function _createDropDown($arValues, $name) {
		
			$output		= "<select name='{$name}' id='{$name}'>";
			
			foreach($arValues as $value) {
					$selected	= "";
					$label		= $value;
					$value		= strtolower($value);
					$value		= stripslashes(htmlspecialchars($value, ENT_QUOTES));
					$output		.= "<option value='{$value}'>{$label}</option>";
			}
			$output		.= "</select>";
		
		return $output;
	}
	
	function _createTab($tabsObj) {
		$cont = 1;
		$output 	= "";
		
		$output		.= "<div id='tabs'>";
		$output			.= "<ul>";
		foreach($tabsObj as $tab) {
			$output			.= "<li><a href='#tab{$cont}'>{$tab->title}</a></li>";
			$cont++;
		}
		$output			.= "</ul>";
		$output		.= "</div>";
	
		return $output;
	}
	
	function createMenuType($id = '', $class = '', $name = '', $selected = '') {
	
		$types		= array('250'=>'300x250', '600'=>'300x600');
		$output		= "";
		$output		.= "<select id='{$id}' name='{$name}' class=''>";
		foreach($types as $key=>$value) {
			$default	= ($key == $selected)? " selected='selected'": "";		
			$output		.= "<option value='{$key}'{$default}>{$value}</option>";
		}
		$output		.= "</select>";
		
		return $output;
	}
	
	/**
	* Array of object search by object key/value pair
	* @needle
	* @needle_key
	* @haystack
	* return array of array keys
	**/
	function object_search($needle, $needle_key, $haystack) {
		$returnArray	= array();
		
		foreach($haystack as $key=>$object) {
			if($object->$needle_key == $needle) array_push($returnArray, $key);
		}
		
		return $returnArray;
	}
	
	/*
	* Returns the index of an object array
	* $val can be an array or a single value
	*/	
	function object_array_search($key, $val, $obj) {
		$arrIndex = array();
		for ( $i = 0; $i < count($obj); $i++ )
		{
			if ( is_object($obj[$i]) and property_exists($obj[$i], $key) )
			{
				if(is_array($val)) {
					foreach($val  as $key1=>$value) {
						if ( strtolower($value) == strtolower($obj[$i]->$key) ) {
							$arrIndex[] = $i;
							break;
						}
					}
				}
				else {
					if ( strtolower($val) == strtolower($obj[$i]->$key) ) return $i;
				}
			}
		}
		if(!$arrIndex) {
			return false;
		} 
		else {
			return $arrIndex;
		}
	}
	
	/**
	* Template for uploadify w/preview
	**/
	function uploadify($defaultValue, $inputName, $inputNameUnique = '') {
		$previewClass	= (!$defaultValue)? " orochi-hidden": "";
		$inputNameUnique= ($inputNameUnique)? $inputNameUnique: $inputName;
		
		$output		= "";
		$output		.= "<div class='inline orochi-uploadify-input'>";
		$output			.= "<input type='file' name='image_upload' id='{$inputNameUnique}'/>";
		$output			.= "<input type='hidden' name='{$inputName}' class='uploadify_input' value='{$defaultValue}'/>";
		$output		.= "</div>";
		$output		.= "<div class='inline orochi-uploadify-preview{$previewClass}'>";
		$output			.= "<a href='#' class='button orochi-button orochi-bg-primary orochi_uploadify_reset orochi-tips' title='".JText::_('UPLOAD_DELETE')."'>";
		$output				.= "<span class='icon icon186'></span>";
		$output			.= "</a>";
		$output			.= "<a href='#' class='button orochi-button orochi-bg-primary orochi_tiptip_preview'>";
		$output				.= "<span class='icon icon19'></span>";
		$output			.= "</a>";
		$output		.= "</div>";
		
		return $output;
	}
}