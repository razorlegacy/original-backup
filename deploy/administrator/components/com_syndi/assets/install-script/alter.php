<?php
	
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	$dbConnect = mysql_connect("localhost", "joomla", "gieP4gae");
	mysql_select_db("joomla", $dbConnect);

	$query_alter	= "ALTER TABLE websvc_syndi_video ADD sbFeed longblob";
	
	mysql_query($query_alter) or die(mysql_error());
	echo 'here';
?>
