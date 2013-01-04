<?php
/**
* @version		$Id: helper.php 10381 2008-06-01 03:35:53Z pasamio $
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

class modSpringboardVideosHelper
{
	function getFeed($params, $page = 0, $url_channel_id = 0)
	{
		// module params
		$cms_domain	= $params->get('cms_domain', 'http://cms.springboard.gorillanation.com');
		$site_id = $params->get('site_id', 60);
		$data_source = $params->get('data_source', 'channel');
		$channel_id = $params->get('channel_id', 0);
		$playlist_id = $params->get('playlist_id', 0);
		$items = $params->get('rssitems', 10);
		$feed_param = ($channel_id != 0) ? 2 : 0;
		if ($data_source == 'channel' && !empty($url_channel_id)) {
			$rssurl = "$cms_domain/xml_feeds_advanced/index/$site_id/2/$url_channel_id/0/$page/$items/";
		} elseif ($data_source == 'channel' && !empty($channel_id)) {
			$rssurl = "$cms_domain/xml_feeds_advanced/index/$site_id/$feed_param/$channel_id/0/$page/$items/";
		} elseif ($data_source == 'channel') {
			$rssurl = "$cms_domain/xml_feeds_advanced/index/$site_id/0/0/0/$page/$items/";
		} elseif ($data_source == 'channel_list') { 
			$rssurl = "$cms_domain/xml_feeds_channels/index/$site_id";
		}
		else {
			$rssurl = "$cms_domain/xml_feeds_advanced/index/$site_id/1/$playlist_id/";
		}

		//  get RSS parsed object
		$options = array();
		$options['rssUrl'] = $rssurl;
		if ($params->get('cache')) {
			$options['cache_time']  = $params->get('cache_time', 15) ;
			$options['cache_time']	*= 60;
		} else {
			$options['cache_time'] = null;
		}

		$rssDoc =& JFactory::getXMLparser('RSS', $options);

		$feed = new stdclass();

		if ($rssDoc != false)
		{
			// channel header and link
			$feed->title = $rssDoc->get_title();
			$feed->link = $rssDoc->get_link();
			$feed->description = $rssDoc->get_description();

			// channel image if exists
			$feed->image->url = $rssDoc->get_image_url();
			$feed->image->title = $rssDoc->get_image_title();

			// items
			$items = $rssDoc->get_items();

			// feed elements
			$feed->items = array_slice($items, 0, $params->get('rssitems', 5));
		} else {
			$feed = false;
		}

		return $feed;
	}
	
	function getPagination($numRecords, $recordsPerPage, $currentPage, $baseLink, $nextPrev=true, $pages, $url_channel_id)
	{	
		global $page_properties;
		
		// Total Number of pages
		$totalPages = ceil($numRecords/$recordsPerPage);
		
		if (!$numRecords || !$recordsPerPage || !$currentPage || $totalPages == 1) {
			return false;
		}
		
		$file_end = strrpos($baseLink, '?');
		if($file_end == 0) {
			$page_parameter = '?page=';
		} else {
			$page_parameter = '&page=';
		}
		
		$channel_parameter = (!empty($url_channel_id)) ? '&channel_id=' . $url_channel_id : '';
		
		// display text
		$recordLast = $currentPage * $recordsPerPage;
		$recordFirst = ($recordLast - $recordsPerPage) + 1;
		if ($recordLast < $numRecords) {
			$displayText = "<div class=\"header\">Displaying $recordFirst - $recordLast of $numRecords</div>";
		} else {
			$displayText = "<div class=\"header\">Displaying $recordFirst - $numRecords of $numRecords</div>";
		}
		$pageText = "<div class=\"header\">Page $currentPage of $totalPages</div>";
		
		if (!$p = $pages%2) {
			$toRenderMax = $pages/2;
			$toRenderMin = $pages/2;
		} elseif ($p = $pages%2) {
			$toRenderMax = ceil($pages/2)-1;
			$toRenderMin = ceil($pages/2);
		}
		
		if ($currentPage < ceil($pages/2)) {
			$min =  1;
			$max = ($currentPage + $toRenderMax > $totalPages) ? $totalPages : $currentPage + ($pages - $currentPage);
		} elseif ($currentPage == ceil($pages/2)) {
			$min = ($currentPage - $toRenderMin < $totalPages && $currentPage - $toRenderMin > 0) ? $currentPage - $toRenderMin : 1;
			$max = ($currentPage + $toRenderMax > $totalPages) ? $totalPages : $currentPage + $toRenderMax;
		} elseif ($currentPage > ceil($pages/2)) {
			$min = ($currentPage - $toRenderMin < $totalPages && $currentPage - $toRenderMin > 0) ? $currentPage - $toRenderMin : 1;
			$max = ($currentPage + ($toRenderMax-1) > $totalPages) ? $totalPages : $currentPage + ($toRenderMax-1);
		}
		
		// Variable for the actual page links
		$pageLinks = '';
		
		if ($max > $totalPages) {
			$max = $totalPages;
		}
		
		// Loop to generate the page links
		for ($i=$min; $i<=$max; $i++) {
			if ($currentPage==$i) {
				// Current Page
				$pageLinks .= ' <span class="current_page">'.$i.'</span> ';
			} else {
				/*
				if($i == 1) {
					$page_suffix = '';
					if(substr($baseLink, -1) == '/') {
						$actual_link = substr($baseLink, 0, -1);
					}
					else {
						$actual_link = $baseLink;
					}      	
				}
				else {
					$page_suffix = $i;
					$actual_link = $baseLink;
				}
				*/
				$page_suffix = $i;
				$actual_link = $baseLink;
				$pageLinks .= ' <a href="'.$actual_link.$page_parameter.$page_suffix.$channel_parameter.'">'.$i.'</a> ';
			}
		}
		
		if ($nextPrev) {
			if(substr($baseLink, -1) == '/') {
				$pageone_link = substr($baseLink, 0, -1).$page_parameter.'1';
			}
			else {
				$pageone_link = $baseLink.$page_parameter.'1';
			}
			$pageone_link = $baseLink.$page_parameter.'1';
			$next_page = $currentPage +1;
			if($currentPage == 2) {
				$prev_link = $pageone_link;
			}
			elseif($currentPage >=1) {
				$previous_page = $currentPage -1;
				$prev_link = $baseLink.$page_parameter.$previous_page;
			} else {
				$previous_page = $currentPage;
				$prev_link = '';
			}
			// Next and previous links
			$next = ($currentPage + 1 > $totalPages) ? false : ' <span class="divider">|</span> <a href="'.$baseLink.$page_parameter.$next_page.$channel_parameter.'" class="next">Next &raquo;</a> <a href="'.$baseLink.$page_parameter.$totalPages.$channel_parameter.'" class="last">End &raquo;&raquo;</a> ';
			$prev = ($currentPage - 1 <= 0 ) ? false : ' <a href="'.$pageone_link.$channel_parameter.'" class="first">&laquo;&laquo; Start</a> <a href="'.$prev_link.$channel_parameter.'" class="prev">&laquo; Previous</a> <span class="divider">|</span> ';
		}
		return "
		<div class='pagination'>
		$prev $pageLinks $next
		$displayText
		$pageText
		</div>
		";
	}
}