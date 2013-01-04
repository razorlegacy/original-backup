<?php
	if(!isset($_GET['feed'])) {
		die('invalid request');
	}

	$sbFeed = preg_match('/^http:\/\/cms.springboard.gorillanation.com\/xml_feeds_advanced\/index\/\d+\/\d+\/\d+\/$/',$_GET['feed']);
	if($sbFeed !== FALSE) {
		$sbXml          = simplexml_load_file($_GET['feed'], 'SimpleXMLElement', LIBXML_NOCDATA);
		$sbObj          = $sbXml->channel->item;

		header('content-type: application/json');
		echo json_encode($sbObj);
	} else {
		die('Invalid request');
	}
