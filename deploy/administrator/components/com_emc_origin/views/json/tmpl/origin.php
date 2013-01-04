<?php defined('_JEXEC') or die('Restricted access');?>
<?php	
	$originObj		= $this->origin;
	$originObj['config']->config	= json_decode($originObj['config']->config);
	$originObj['config']->content	= json_decode($originObj['config']->content);
	
	//print_r($originObj);
	if(isset($_GET['debug'])) {
		print_r($originObj);
	} else {
		echo json_encode($originObj);
	}
	//echo json_encode($originObj);
?>