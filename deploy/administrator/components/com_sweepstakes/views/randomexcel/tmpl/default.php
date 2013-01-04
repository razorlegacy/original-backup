<?php
	defined('_JEXEC') or die();
	
	$filename	= urlencode($this->sweeps->name);

	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename={$filename}.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	
	$header		= "";
	$data		= "";

	foreach($this->fields['name'] as $value) {
		$header	.= $value."\t";
	}
	
	//Append Timestamp field
	$header		.= "Timestamp\t";
	
	foreach($this->entrants as $row) {
		$entrantData	= unserialize($row->fields);
		$line 			= '';
		foreach($entrantData as $value) {
			if((!isset($value)) || ($value == "")) {
				$value	= "null\t";
			} else {
				$value	= str_replace('"', '""', $value);
				$value	= '"'.$value.'"'."\t";
			}
			$line		.= $value;
		}
		//Add timestamp
		$line			.= $row->timestamp;
		$data			.= trim($line)."\n";
	}
	$data = str_replace("\r", "", $data);	
	if ($data == "") {
		$data = "\n(0) Records Found!\n";
	}

	print "$header\n$data";
?>