<?php
	
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	$dbConnect = mysql_connect("localhost", "joomla", "gieP4gae");
	mysql_select_db("joomla", $dbConnect);

	$query_polldaddy	= "CREATE TABLE IF NOT EXISTS `websvc_syndi_poll` (
  `poll_id` int(11) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `polldaddy_feed` longblob,
  `polldaddy_key` int(11) NOT NULL,
  `tab_id` int(11) NOT NULL,
  `ordering` int(11) default NULL,
  `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP,
  PRIMARY KEY  (`poll_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";
	
	mysql_query($query_polldaddy) or die(mysql_error());
	echo "done";
?>