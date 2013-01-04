<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	//Grab module config
	$cb_site		= $params->get('site');
	$cb_URL			= $params->get('url');
	$cb_channel		= $params->get('channel');
	$cb_width		= $params->get('width');
	$cb_formColor	= $params->get('formColor');
	$cb_dropdown	= $params->get('dropdown');
	$fb				= "http://www.facebook.com/sharer.php?u=http%3A%2F%2F".$params->get('fb');
	$twitter		= $params->get('twt');
	$rss			= $params->get('rss');
	
	//if($cb_dropdown == 1): $cravebar .= '<form name="search" method="get" action="/search.php" style="margin:0px; padding:0px">'; endif;
	$cravebar 	.= '<script language="javascript" type="text/javascript">';
	$cravebar 	.= "var cbBcSite = '".addslashes($cb_site)."';\n";
	$cravebar 	.= "var cbBcSiteUrl = 'http://".$cb_URL."';\n";
	$cravebar 	.= "var cbChannel = '".$cb_channel."';\n";
	$cravebar 	.= "var cbWidth = '".$cb_width."%';\n";
	$cravebar 	.= "var cbFormColor = '".$cb_formColor."';\n";
	$cravebar	.= '</script>';
	$cravebar	.= '<script src="http://cdn.assets.craveonline.com/cravebar/cravebar.js" type="text/javascript"></script>';
	//if($cb_dropdown == 1): $cravebar .= '</form>'; endif;
	
	$cravebar .= "<div id='cb_social'>";
		if($fb != "") {
			$cravebar 	.= "<div id='cb_fb'><a href='{$fb}' target='_blank'>Facebook Share</a></div>";
		}
		
		if($twitter != "" && $twitter != "http://") {
			$cravebar 	.= "<div id='cb_twitter'><a href='{$twitter}' target='_blank'>Twitter Share</a></div>";
		}	
		
		if($rss != "" && $rss != "http://") {
			$cravebar 	.= "<div id='cb_rss'><a href='{$rss}' target='_blank'>RSS</a></div>";
		}
	$cravebar .= "</div>";
	echo $cravebar;
?>
