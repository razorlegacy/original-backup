<?php defined('_JEXEC') or die('Restricted access');?>
<?php
//header('Content-Type: application/json');
$feed = new DOMDocument();
$feed->load('http://cms.springboardplatform.com/xml_feeds_advanced/index/1307/');
$json = array();

$json['title'] = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('title')->item(0)->firstChild->nodeValue;
$json['description'] = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('description')->item(0)->firstChild->nodeValue;
$json['link'] = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('link')->item(0)->firstChild->nodeValue;

$items = $feed->getElementsByTagName('channel')->item(0)->getElementsByTagName('item');

$json['item'] = array();
$i = 0;

foreach($items as $item) {

   $title = $item->getElementsByTagName('title')->item(0)->firstChild->nodeValue;
   $user_id = $item->getElementsByTagName('user_id')->item(0)->firstChild->nodeValue;
   $video_id = $item->getElementsByTagName('id')->item(0)->firstChild->nodeValue;
   $created = $item->getElementsByTagName('created')->item(0)->firstChild->nodeValue;
   $link = $item->getElementsByTagName('link')->item(0)->firstChild->nodeValue;
   $image = $item->getElementsByTagName('image')->item(0)->firstChild->nodeValue;
   $description = $item->getElementsByTagName('description')->item(0)->firstChild->nodeValue;
   $snapshot = $item->getElementsByTagName('snapshot')->item(0)->firstChild->nodeValue;
   $channel = $item->getElementsByTagName('channel_name')->item(0)->firstChild->nodeValue;
   $tags = $item->getElementsByTagName('tags')->item(0)->firstChild->nodeValue;
   $duration = $item->getElementsByTagName('duration')->item(0)->firstChild->nodeValue;
   
   $json['item'][$i]['title'] = $title;
   $json['item'][$i]['user_id'] = $user_id;
   $json['item'][$i]['video_id'] = $video_id;
   $json['item'][$i]['created'] = $created;
   $json['item'][$i]['link'] = $link;
   $json['item'][$i]['image'] = $image;
   $json['item'][$i]['description'] = $description;
   $json['item'][$i]['snapshot'] = $snapshot;
   $json['item'][$i]['channel'] = $channel;
   $json['item'][$i]['tags'] = $tags;
   $json['item'][$i]['duration'] = $duration;
   $i++;
}

echo json_encode($json);