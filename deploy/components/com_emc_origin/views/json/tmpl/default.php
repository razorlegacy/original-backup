<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	if($_GET['debug']) {
		print_r($this->origin);	
	} else {
		echo json_encode($this->origin);
	}
?>