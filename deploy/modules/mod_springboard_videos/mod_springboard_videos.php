<?php
/**
* @version		$Id: mod_springboard_videos.php 11371 2008-12-30 01:31:50Z ian $
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

// Include the syndicate functions only once
require_once (dirname(__FILE__).DS.'helper.php');

$cms_domain	= $params->get('cms_domain', '');
$site_id = $params->get('site_id', 0);
$rssrtl	= $params->get('rssrtl', 0);
$items_per_page = $params->get('rssitems', 10);
$max_pages = $params->get('rsspages', 10);

//check if cache diretory is writable as cache files will be created for the feed
$cacheDir = JPATH_BASE.DS.'cache';
if (!is_writable($cacheDir))
{
	echo '<div>';
	echo JText::_('Please make cache directory writable.');
	echo '</div>';
	return;
}

//check if feed URL has been set
if (empty ($cms_domain) || !$site_id)
{
	echo '<div>';
	echo JText::_('No content available.');
	echo '</div>';
	return;
}

$page = (!empty($_GET['page'])) ? $_GET['page'] : 1;
$url_channel_id = (!empty($_GET['channel_id'])) ? $_GET['channel_id'] : 0;
$channel_id = $params->get('channel_id', 0);
$feed = modSpringboardVideosHelper::getFeed($params, $page, $url_channel_id);
// use default channel id if nothing is passed in the url
if (empty($url_channel_id) && !empty($channel_id)) $url_channel_id = $channel_id;
require(JModuleHelper::getLayoutPath('mod_springboard_videos'));

if ($params->get('pagination', 1))
{
	$uri = JRequest::getURI();
	$juri = & JURI::getInstance($uri);
	$juri->delVar('page');
	$juri->delVar('video_id');
	$juri->delVar('channel_id');
	$base_link = $juri->toString();
	$item = $feed->items[0];
	$simplepie_feed = $item->get_feed();
	$data = $simplepie_feed->get_channel_tags("", 'total');
	$total = (!empty($data[0]['data'])) ? $data[0]['data'] : null;
	$pages = ceil($total / $items_per_page);

	echo modSpringboardVideosHelper::getPagination($total, $items_per_page, $page, $base_link, true, $max_pages, $url_channel_id);
}