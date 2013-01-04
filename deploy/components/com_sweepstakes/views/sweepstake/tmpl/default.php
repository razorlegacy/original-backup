<?php 
defined('_JEXEC') or die();
	print_r($this->sweepstake[0]);
	$output		= "";
	$output		.= "<h1>{$this->sweepstake[0]->name}</h1>\n";
	$output		.= "<fieldset>\n";
	
	$output		.= "<form action='index.php' method='post'>\n";		
	$fields		= unserialize($this->sweepstake[0]->fields);
	if(!empty($fields)) {
		$output		.= "<ul>\n";
		foreach($fields as $key=>$value) {
			$type			= explode("_", $value);
			$type			= $type[0];
			$output	.= "<li><label>{$key}</label><input type='{$type}' name='{$value}' /></li>\n";
		}
		$output		.= "</ul>\n";
	}
	$output		.= "<input type='submit' name='SubmitButton' value='Save' />\n";
	$output		.= "<input type='hidden' name='option' value='com_sweepstakes' />\n";
	$output		.= "<input type='hidden' name='controller' value='sweepstakes' />\n";
	$output		.= "<input type='hidden' name='task' value='entrant_save' />\n";
	$output		.= "<input type='hidden' name='sid' value='{$this->sweepstake[0]->id}' />\n";
	$output		.= "</form>\n";
	$output		.= "</fieldset>\n";
	
	echo $output;
?>
