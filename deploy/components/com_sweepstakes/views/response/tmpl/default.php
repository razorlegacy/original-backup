<?php
defined('_JEXEC') or die();
	$document	=& JFactory::getDocument();
	$document->setMimeEncoding('text/xml');
	
	$output		= "";
	$output		.= "<?xml version='1.0' encoding='UTF-8'?>\n";
	$output		.= "<sweepstake id='{$this->sid}'>\n";
	
	if(empty($this->validate)) {
		$output	.= "<response error='0'>\n";
	} else {
		$output	.= "<response error='1'>\n";
		foreach($this->validate as $key=>$value) {
			$output .= "<error field='{$value}'></error>\n";
		}
	}
		$output	.= "</response>\n";
	$output		.= "</sweepstake>\n";
	echo $output;
?>