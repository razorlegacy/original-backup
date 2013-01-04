<?php defined('_JEXEC') or die();?>
<?php

	$formInputs	= new formHelper();
	
	$sweeps		= $this->sweepstake;
	$fields		= unserialize($sweeps->fields);
	$form		= "";
	$form		.= "<div id='sweeps_embed'>";
	$form		.= "<script type='text/javascript'>var websvc_sid = '{$sweeps->id}';var websvc_endDate = '{$sweeps->date_end}'; var websvc_me = '{$sweeps->multiple_entrants}'</script>\n";
	$form		.= "<script type='text/javascript' src='http://webservices.evolvemediacorp.com/websvc/js/sweepstakes_rollup.min.js'></script>\n";
	$form		.= "<link href='http://webservices.evolvemediacorp.com/websvc/css/sweepstakes.css' type='text/css' rel='stylesheet'/>\n";
	$form		.= "<div id='websvc_message'>\n";
	$form		.= "<span id='websvc_closed' class='websvc_hidden'>{$sweeps->close}</span>\n";
	$form		.= "<span id='websvc_response' class='websvc_hidden'></span>\n";
	$form		.= "</div>\n";	
	$form		.= "<form id='websvc_form_".$sweeps->id."'>\n";
	$form		.= "<ul>\n";
	for($i=0; $i<sizeof($fields['name']); $i++) {
		$inputType	= explode("_", $fields['type'][$i]);
		$inputType	= $inputType[0];
		switch($inputType) {
			case "state": 		$form	.= "<li><label>{$fields['name'][$i]}</label>{$formInputs->selectStates($fields['type'][$i])}</li>\n";
								break;
			case "province": 	$form	.= "<li><label>{$fields['name'][$i]}</label>{$formInputs->selectProvinces($fields['type'][$i])}</li>\n";
								break;
			case "birthdate":	$form	.= "<li><label>{$fields['name'][$i]}</label><span id='{$fields['type'][$i]}'>{$formInputs->selectBirthdate($fields['type'][$i])}</span></li>\n";
								break;
			default:			$required = ($fields['required'][$i] == 1) ? " class=\"validate[required]\"" : "";
								$form	.= "<li><label>{$fields['name'][$i]}</label><input type='{$inputType}' name='{$fields['type'][$i]}' id='{$fields['type'][$i]}'{$required}/></li>\n";
								break;
		}
	}	
	$form		.= "<li id='legal'>";
	if(!empty($sweeps->rules)) {
		$form	.= "<a href='http://webservices.evolvemediacorp.com/index.php?option=com_sweepstakes&view=rules&format=raw&sid={$sweeps->id}' class='websvc_rules'>Rules</a> | ";
	}
	if(!empty($sweeps->privacy)) {
		$form	.= "<a href='{$sweeps->privacy}' class='websvc_privacy' target='_blank'>Privacy Policy</a> | ";
	}
	if(!empty($sweeps->terms)) {
		$form	.= "<a href='{$sweeps->terms}' class='websvc_terms' target='_blank'>Terms &amp; Conditions</a>";
	}
	$form		.= "</li>\n";
	$form		.= "<li><input type='submit' name='submit' value='Submit'/></li>\n";
	$form		.= "</ul>\n";
	$form		.= "<input type='hidden' name='option' value='com_sweepstakes'/>\n";
	$form		.= "<input type='hidden' name='controller' value='sweepstakes'/>\n";
	$form		.= "<input type='hidden' name='task' value='entrant_save'/>\n";
	$form		.= "<input type='hidden' name='sid' value='{$sweeps->id}' />\n";
	$form		.= "</form>\n";
	$form		.= "</div>\n";
	
	echo "<textarea readonly style='width: 785px; height: 550px' id='form_embed'>{$form}</textarea>";
?>