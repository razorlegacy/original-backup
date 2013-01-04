<?php
defined('_JEXEC') or die();

	$giftguideTemplate	= new giftguideTemplate();
		
	echo $giftguideTemplate->responseCategory($this->category, $this->giftguidesModel);
?>