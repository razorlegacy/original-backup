<?php

	$rssFeed	= $_POST['feed_url'];
	$items		= $_POST['items'];
	//$content 	= file_get_contents($rssFeed);
	$sbXml 		= simplexml_load_file($rssFeed, 'SimpleXMLElement', LIBXML_NOCDATA);
	
	$cont = $items;
	$items = array();
		
	foreach($sbXml->channel->item as $item) {
		if($cont==0) break;
		 $items[] = array(
							'title'=>$item->title,
							'link'=>$item->link,
							'description'=>strip_tags($item->description),
							'pubDate'=>strftime("%Y-%m-%d %H:%M:%S", strtotime($item->pubDate))
		);

		$cont--;
	}
	/*
	$rss		= array(
			"title"=>$sbXml->channel->title,
			"link"=>$sbXml->channel->link,
			"items"=>$items
	);*/
	
	echo json_encode($items);
		
?>