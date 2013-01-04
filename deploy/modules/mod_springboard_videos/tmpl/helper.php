<?php

function getShortTitle($string) {
	$shorttitle = html_entity_decode(trim(strip_tags($string)), ENT_QUOTES, 'UTF-8');
	$shorttitle = preg_replace("/\s+/", '-', strtolower(substr($shorttitle, 0, 100)));
	$shorttitle = preg_replace("/[^a-z0-9\-]/i", '', $shorttitle);
	$shorttitle = preg_replace("/\-{2,}/", '-', $shorttitle);
	return $shorttitle;
}

?>