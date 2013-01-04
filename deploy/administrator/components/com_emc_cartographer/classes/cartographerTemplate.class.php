<?php
defined('_JEXEC') or die();

class cartographerTemplate {
	
	function __construct() {

	}
	
	function cartographerConfig($name) {
		$configJSON	= array();
		
		$configJSON['name']					= $name;
		$configJSON['ga']					= 'UA-12310597-3';
		$configJSON['tooltip_style']		= 'custom';
		$configJSON['tooltip_trigger']		= 'click';
		$configJSON['popup_border_hex']		= '#FFFFFF';
		$configJSON['popup_bg_hex']			= '#FFFFFF';
		$configJSON['popup_title_hex']		= '#000000';
		$configJSON['popup_text_hex']		= '#000000';
		$configJSON['popup_link_hex']		= '#000000';
		$configJSON['css']					= '';
		
		return json_encode($configJSON);	
	}

}