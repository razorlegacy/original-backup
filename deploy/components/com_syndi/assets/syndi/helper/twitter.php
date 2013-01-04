<!DOCTYPE HTML>
<?php
	$host					= $_SERVER['HTTP_HOST'];
	$username			= $_GET['username'];
	$tweets					= $_GET['tweets'];
	$avatar					= $_GET['avatar'];
	$timestamp			= $_GET['timestamp'];
	$hashtag				= $_GET['hashtag'];
?>
<html>
	<head>
		<script type="text/javascript" src="http://<?php echo $host;?>/components/com_syndi/assets/syndi/js/websvc_syndi.js"></script>
		<script type="text/javascript">
			window.onload = function() {
			    if (parent) {
			        var oHead = document.getElementsByTagName("head")[0];
			        var arrStyleSheets = parent.document.getElementsByTagName("style");
			        for (var i = 0; i < arrStyleSheets.length; i++)
			            oHead.appendChild(arrStyleSheets[i].cloneNode(true));
			    }
			}
			
		    jQuery(function($){
		        $("#tweets").tweet({
		            username: "veronica",
		            join_text: "auto",
		            avatar_size: 32,
		            count: 3,
		            auto_join_text_default: "we said,",
		            auto_join_text_ed: "we",
		            auto_join_text_ing: "we were",
		            auto_join_text_reply: "we replied to",
		            auto_join_text_url: "we were checking out",
		            loading_text: "loading tweets..."
		        });
		    });
			
		</script>
		<link rel="stylesheet" type="text/css" href="http://<?php echo $host;?>/components/com_syndi/assets/syndi/css/websvc_syndi_iframe.css" />
	</head>
	<body id="emcSyndi_iframe" class="emcSyndi_twitter">
		<div id="tweets"></div>
<!--
		<script src="http://widgets.twimg.com/j/2/widget.js"></script>
		<script>
		new TWTR.Widget({
		  version: 2,
		  type: 'profile',
		  rpp: <?php echo $tweets; ?>,
		  interval: 30000,
		  width: 280,
		  height: 100,
		  features: {
			scrollbar: false,
			loop: false,
			live: false,
			hashtags: <?php echo $hashtag; ?>,
			timestamp: <?php echo $timestamp; ?>,
			avatars: <?php echo $avatar; ?>,
			behavior: 'all'
		  }
		}).render().setUser('<?php echo $username; ?>').start();
		</script>
-->
	</body>
</html>