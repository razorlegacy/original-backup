<?php
	
	ini_set('display_errors', 1);
	error_reporting(E_ALL);
	
	$dbConnect = mysql_connect("localhost", "joomla", "gieP4gae");
	mysql_select_db("joomla", $dbConnect);

	$query = "ALTER TABLE `websvc_slivers` ADD `autoClose` SMALLINT( 5 ) NOT NULL DEFAULT '0'";
	
	mysql_query($query) or die(mysql_error());
	
	echo 'Done';
?>
