<?php
	$postURL	= $_SERVER['PHP_SELF']."?option=com_sweepstakes";
	
	$document	=& JFactory::getDocument();
	$document->setMimeEncoding('text/xml');
	
	$sweeps		= $this->sweepstake;
	$fields		= unserialize($sweeps->fields);
	
	$output		= '';
	$output		.= '<?xml version="1.0" encoding="UTF-8"?>'."\n";
	$output		.= "<sweepstake id='{$sweeps->id}'>\n";
	$output		.= "\t<name><![CDATA[{$sweeps->name}]]></name>\n";
	$output		.= "\t<dateStart><![CDATA[{$sweeps->date_start}]]></dateStart>\n";
	$output		.= "\t<dateEnd><![CDATA[{$sweeps->date_end}]]></dateEnd>\n";
	$output		.= "\t<min_age><![CDATA[{$sweeps->min_age}]]></min_age>\n";
	$output		.= "\t<multi_entrants><![CDATA[{$sweeps->multiple_entrants}]]></multi_entrants>\n";
	$output		.= "\t<closing_text><![CDATA[{$sweeps->close}]]></closing_text>\n";
	$output		.= "\t<postURL><![CDATA[{$postURL}]]></postURL>\n";
	$output		.= "\t<fields>\n";
		
	for($i=0; $i<sizeof($fields['name']); $i++) {
		$type	= explode("_", $fields['type'][$i]);
		$type	= $type[0];
		
		switch($type) {
			case "birthdate":	$name	= explode("_", $fields['type'][$i]);
								$output	.= "\t\t<input type='{$type}' name='{$name[0]}_month_{$name[1]}' label='{$fields['name'][$i]}' required='{$fields['required'][$i]}'></input>\n";
								$output	.= "\t\t<input type='{$type}' name='{$name[0]}_day_{$name[1]}' label='{$fields['name'][$i]}' required='{$fields['required'][$i]}'></input>\n";
								$output	.= "\t\t<input type='{$type}' name='{$name[0]}_year_{$name[1]}' label='{$fields['name'][$i]}' required='{$fields['required'][$i]}'></input>\n";
								break;
			default:			$output	.= "\t\t<input type='{$type}' name='{$fields['type'][$i]}' label='{$fields['name'][$i]}' required='{$fields['required'][$i]}'></input>\n";
								break;
		} 
	}
	$output		.= "\t</fields>\n";
	$output		.= "\t<fields_hidden>\n";
	$output		.= "\t\t<input type='hidden' name='option' value='com_sweepstakes'/>\n";
	$output		.= "\t\t<input type='hidden' name='controller' value='sweepstakes'/>\n";
	$output		.= "\t\t<input type='hidden' name='task' value='entrant_save'/>\n";
	$output		.= "\t\t<input type='hidden' name='sid' value='{$sweeps->id}' />\n";
	$output		.= "\t</fields_hidden>\n";
	$output		.= "</sweepstake>\n";
	echo $output;
?>