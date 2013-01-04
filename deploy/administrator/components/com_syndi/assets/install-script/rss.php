<?php
	
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	$dbConnect = mysql_connect("localhost", "joomla", "gieP4gae");
	mysql_select_db("joomla", $dbConnect);

	$query_polldaddy	= "CREATE TABLE `websvc_syndi_rss` (
  `rss_id` int(11) NOT NULL AUTO_INCREMENT,
  `feed_url` varchar(255) DEFAULT NULL,
  `articles_number` int(11) NOT NULL,
  `tab_id` int(11) NOT NULL,
  `ordering` int(11) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`rss_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;";
	
	mysql_query($query_polldaddy) or die(mysql_error());
	echo "done";
?>