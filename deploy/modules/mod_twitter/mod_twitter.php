<?php defined('_JEXEC') or die('Restricted access');?>
<?php
	//Grab module config
	$username		= $params->get('username');
	$tweets			= $params->get('tweets');
	$marquee		= $params->get('marquee');
	$direction		= $params->get('direction');
	$speed			= $params->get('speed');
	$container		= $params->get('container');
	$wrap			= $params->get('wrap');
	$marquee_hover	= $params->get('marquee_hover');
	
	$marquee_start 	= $marquee_end	= $marquee_init;
	$add_to_head 	= &JFactory::getDocument();
	
	//http://plugins.jquery.com/project/jtwitter	
	$add_to_head->addScript('/modules/mod_twitter/include/jquery.jtwitter.min.js');
	
	if($marquee) {
		$add_to_head->addScript('/modules/mod_twitter/include/jquery.scroller.js');
		$add_to_head->addStyleSheet('/modules/mod_twitter/include/jquery.scroller.css');
		$marquee_init	= "jQuery('#tweets').jStockTicker({interval: {$speed}, containerClass: '{$container}', wrapClass: '{$wrap}', hover: '{$marquee_hover}'});";
	}
?>
	<script type="text/javascript">
	jQuery(document).ready(function(){
	    //Load Twitter Feed
	    jQuery.jTwitter('<?php echo $username;?>', <?php echo $tweets;?>, function(data){
	        jQuery('#tweets').empty();
	        jQuery.each(data, function(i, post){
	            jQuery('#tweets').append(
	                ' <span>'
	                +    post.text.replace(/(http:\/\/[^ ]*)/g, "<a href='$1' target='_blank'>$1</a>")
	                +' </span> | '
	            );
	        });
	    <?php echo $marquee_init; ?>
	    });
	});
	</script>
<?php
		
		$output 	.= "<div id='twitter'>";
		$output			.= "<a href='http://www.twitter.com/{$username}' id='twitter_username' target='_blank'><span>{$username}</span></a>";
		$output 		.= "<div id='tweets' class='twitter_updates'>";
		$output			.= "<span>Loading Tweets...</span>";
		$output 		.= "</div>";
		$output 	.= "</div>";
		echo $output;
?>
