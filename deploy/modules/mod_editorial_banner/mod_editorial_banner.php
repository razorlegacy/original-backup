<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	//Grab module config
	$link	= $params->get('link');
	$site	= $params->get('site');
	
	$output 	= '<div id="editorial_banner">';
	$output 	.= '<a href="'.$link.'">'.$site.'</a>';
	$output 	.= '</div>';
	
	echo $output;
?>
