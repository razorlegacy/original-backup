<?php
	$sbFeed		= "http://cms.springboard.gorillanation.com/xml_feeds_advanced/index/{$_POST['siteId']}/3/{$_POST['videoId']}/";
	$sbXml 		= simplexml_load_file($sbFeed, 'SimpleXMLElement', LIBXML_NOCDATA);
	$sbObj		= $sbXml->channel->item;
	
	echo json_encode($sbObj);
?>