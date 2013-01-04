<?php
	$document	=& JFactory::getDocument();
	$document->setMimeEncoding('text/xml');
	$server		= "http://".$_SERVER['HTTP_HOST'];
	
	$output		= '';
	$output		.= '<?xml version="1.0" encoding="UTF-8"?>';
	$output			.= "<giftguides>";
	$output				.= "<meta>";
	$output					.= "<name>{$this->giftguide->giftguide_name}</name>";
	$output					.= "<facebook>";
	$output						.= "<icon>{$this->giftguide->facebook_icon}</icon>";
	$output						.= "<title>{$this->giftguide->facebook_title}</title>";
	$output						.= "<description>{$this->giftguide->facebook_description}</description>";
	$output					.= "</facebook>";
	$output					.= "<email>";
	$output						.= "<header>{$this->giftguide->email_header}</header>";
	$output						.= "<title>{$this->giftguide->email_title}</title>";
	$output						.= "<description>{$this->giftguide->email_description}</description>";
	$output					.= "</email>";
	$output					.= "<other>";
	$output						.= "<twitter>{$this->giftguide->twitter_description}</twitter>";
	$output						.= "<banner>{$this->giftguide->super_banner}</banner>";
	$output						.= "<banner_static>{$this->giftguide->super_banner_static}</banner_static>";
	$output					.= "</other>";
	$output					.= "<settings>";
	$output						.= "<animation>";
	$output							.= "<fadeIn>{$this->giftguide->js_fadeIn}</fadeIn>";
	$output							.= "<fadeOut>{$this->giftguide->js_fadeOut}</fadeOut>";
	//$output							.= "<easeTime>{$this->giftguide->js_featured_easeTime}</easeTime>";
	//$output							.= "<easeType>{$this->giftguide->js_featured_ease}</easeType>";
	$output						.= "</animation>";
	$output						.= "<modal>";
	$output							.= "<template>{$this->giftguide->js_modal_template}</template>";
	$output							.= "<width>{$this->giftguide->js_modal_width}</width>";
	$output							.= "<height>{$this->giftguide->js_modal_height}</height>";
	$output						.= "</modal>";
	$output					.= "</settings>";
	$output				.= "</meta>";
	$output				.= "<gifts>";
	
	foreach($this->category as $category) {
		$output				.= "<category name='{$category->alias}' featured='{$category->featured}' pixel='{$category->tracking_pixel}'>";
	
		$giftguideProduct	= $this->giftguidesModel->loadGiftGuideProducts($category->id);
	
		foreach($giftguideProduct as $product) {
			$output				.= "<product id='{$product->id}' alias='{$product->alias}' category='{$category->alias}'>";
			$output					.= "<title><![CDATA[{$product->title}]]></title>";
			$output					.= "<description><![CDATA[{$product->description}]]></description>";
			$output					.= "<price><![CDATA[{$product->price}]]></price>";
			$output					.= "<url><![CDATA[{$product->url}]]></url>";
			$output					.= "<thumb><![CDATA[$server{$product->img_large}]]></thumb>";
			$output					.= "<large><![CDATA[$server{$product->img_large}]]></large>";
			$output				.= "</product>";
		}
		$output				.= "</category>";
	}
	
	$output				.= "</gifts>";
	$output			.= "</giftguides>";
	
	echo $output;
?>