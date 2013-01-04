<?php
/**
* @version		$Id: mod_feed.php 11371 2008-12-30 01:31:50Z ian $
* @package		Joomla
* @copyright	Copyright (C) 2005 - 2008 Open Source Matters. All rights reserved.
* @license		GNU/GPL, see LICENSE.php
* Joomla! is free software. This version may have been modified pursuant
* to the GNU General Public License, and as distributed it includes or
* is derivative of works licensed under the GNU General Public License or
* other free or open source software licenses.
* See COPYRIGHT.php for copyright notices and details.
*/

/** ensure this file is being included by a parent file */
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

$cms_domain = $params->get('cms_domain', 'cms.springboard.gorillanation.com');
$site_id = $params->get('site_id', 0);
$player_id = $params->get('player_id', '');
$player_width = $params->get('player_width', 410);
$player_height = $params->get('player_height', 330);
$autostart = $params->get('autostart', '0');
$video_id = isset($_GET['video_id']) ? $_GET['video_id'] : 0;
$channel_id = isset($_GET['channel_id']) ? $_GET['channel_id'] : 0;

//check if feed URL has been set
if (empty ($player_id) || empty ($site_id))
{
	echo '<div>';
	echo JText::_('Both player ID and site ID needs to be set.');
	echo '</div>';
	return;
}

if (!empty($video_id)) {
	$rssurl = 'http://'.$cms_domain.'/xml_feeds_advanced/index/'.$site_id.'/3/'.$video_id.'/';
} elseif (!empty($channel_id)) {
	$rssurl = 'http://'.$cms_domain.'/xml_feeds_advanced/index/'.$site_id.'/2/'.$channel_id.'/0/0/1/0/0/0/0/0/';
} else {
	$rssurl = 'http://'.$cms_domain.'/xml_feeds_advanced/index/'.$site_id.'/0/0/0/0/1/0/0/0/0/0/';
}

$options = array();
$options['rssUrl'] = $rssurl;
if ($params->get('cache')) {
	$options['cache_time']  = $params->get('cache_time', 15) ;
	$options['cache_time']	*= 60;
} else {
	$options['cache_time'] = null;
}

$rssDoc =& JFactory::getXMLparser('RSS', $options);

if ($rssDoc != false)
{
	$items = $rssDoc->get_items();
	// channel header and link
	$video_title = $items[0]->get_title();
	$video_desc = $items[0]->get_description();
	
	$data = $items[0]->get_item_tags('', 'channel_name');
	$channel_name = (!empty($data[0]['data'])) ? $data[0]['data'] : 'Latest';
	
	if(!empty($video_id)) {
		$document =& JFactory::getDocument();
		//$document->setTitle($document->title . ' - ' . $video_title);
	} else {
		$document =& JFactory::getDocument();
		$document->setTitle($document->title . ' - ' . $channel_name);
	}
}
	
require(JModuleHelper::getLayoutPath('mod_springboard_video'));
