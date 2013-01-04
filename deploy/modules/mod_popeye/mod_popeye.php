<?php defined('_JEXEC') or die('Restricted access');?>
<?php
    
    $add_to_head 	= &JFactory::getDocument();
	$add_to_head->addStyleSheet('/modules/mod_popeye/include/jquery.popeye.css');
    $add_to_head->addStyleSheet('/modules/mod_popeye/include/jquery.popeye.style.css');
    $add_to_head->addScript('/modules/mod_popeye/include/jquery.popeye.min.js');
    
    //Grab module config
	$cid		= $params->get('category');
	
	$db			=& JFactory::getDBO();
	//MAKE QUERY MORE SPECIFIC
	$query 		= "SELECT #__joomgallery.catid,
							#__joomgallery.imgfilename,
							#__joomgallery.imgthumbname,
							#__joomgallery_catg.cid,
							#__joomgallery_catg.catpath 
					FROM #__joomgallery 
					LEFT JOIN #__joomgallery_catg 
					ON #__joomgallery.catid = #__joomgallery_catg.cid 
					WHERE catid={$cid}";
	$db->setQuery($query);
	$result		= $db->loadObjectList();
?>
<script type="text/javascript">
    <!--//<![CDATA[
    jQuery(document).ready(function () {
        var options = {
            caption:    false,
            navigation: 'permanent',
            direction:  'left'
        }
        jQuery('#ppy2').popeye(options);
    });
    //]]>-->
</script>
<?php

	
	$output 	.= "<div class='ppy' id='ppy2'>\n";
	$output		.= 		"<ul class='ppy-imglist'>\n";
	foreach($result as $key=>$value) {
	$output		.= 		"<li><a href='/components/com_joomgallery/img_pictures/{$result[$key]->catpath}/{$result[$key]->imgfilename}'><img src='/components/com_joomgallery/img_thumbnails/{$result[$key]->catpath}/{$result[$key]->imgthumbname}' alt=''/></a></li>\n";
	}
	$output		.=		"</ul>\n";
	
	
	$output		.= 		"<div class='ppy-outer'>\n";
    $output		.= 			"<div class='ppy-stage-wrap'>\n";
    $output		.= 				"<div class='ppy-stage'>\n";
	$output		.=					"<div class='ppy-counter'>\n";
	$output		.=						"<strong class='ppy-current'></strong> / <strong class='ppy-total'></strong>\n";
	$output		.=					"</div>\n";
	$output		.=				"</div>\n";
	$output		.= 			"</div>\n";
	$output		.=			"<div class='ppy-nav'>\n";
	$output		.=				"<div class='ppy-nav-wrap'>\n";
	$output		.= 					"<a class='ppy-next' title='Next image'>Next image</a>\n";
	$output		.=					"<a class='ppy-prev' title='Previous image'>Previous image</a>\n";
	$output		.=					"<a class='ppy-switch-enlarge' title='Enlarge'>Enlarge</a>\n";
	$output		.=					"<a class='ppy-switch-compact' title='Close'>Close</a>\n";
	$output		.=				"</div>\n";
    $output		.=			"</div>\n";
	$output		.= 		"</div>\n";
	
	
	$output		.= "</div>\n";



	echo $output;
?>