<?php // no direct access
	defined('_JEXEC') or die('Restricted access');
	header ("Content-Type:text/xml");
	$total_res = "	<result>\r\n";
	$total_res .= "		<voted>\r\n";
	$total_res .= "			<id>{$this->voteResponse['voted']['id']}</id>\r\n";		
	$total_res .= "			<votes>{$this->voteResponse['voted']['votes']}</votes>\r\n";				
	$total_res .= "		</voted>\r\n";
	$total_res .= "		<rival>\r\n";
	$total_res .= "			<id>{$this->voteResponse['rival']['id']}</id>\r\n";		
	$total_res .= "			<votes>{$this->voteResponse['rival']['votes']}</votes>\r\n";			
	$total_res .= "		</rival>\r\n";
	$total_res .= "	</result>\r\n";
	echo $total_res;
	die();
?>
