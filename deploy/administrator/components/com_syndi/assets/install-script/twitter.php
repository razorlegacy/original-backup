<?php
	
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	$dbConnect = mysql_connect("localhost", "joomla", "gieP4gae");
	mysql_select_db("joomla", $dbConnect);

	$query_twitter	= "CREATE TABLE `websvc_syndi_twitter` (
  `twitter_id` int(11) NOT NULL AUTO_INCREMENT,
  `twitter_config` longblob NOT NULL,
  `tab_id` int(11) NOT NULL,
  `ordering` int(11) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`twitter_id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;";
	
	mysql_query($query_twitter) or die(mysql_error());
	echo "done";
?>