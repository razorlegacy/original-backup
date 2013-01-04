<?php 
defined('_JEXEC') or die();
	$document	=& JFactory::getDocument();
	$document->setMimeEncoding('text/xml');
	$output		= "";
	$output		.= "<?xml version='1.0' encoding='UTF-8'?>\n";
	$output		.= "<sweepstakes>\n";
	
	foreach($this->sweepstakes as $value) {
		$output	.= "\t<sweeps id='{$value->id}' name='{$value->name}'></sweeps>\n";
	}
	$output		.= "</sweepstakes>";
	echo $output;
?>