<!DOCTYPE HTML>
<?php

	$rssFeed	= $_GET['feed_url'];
	$items		= $_GET['items'];
	//$sbXml 	= file_get_contents($rssFeed);
	$sbXml 		= simplexml_load_file($rssFeed, 'SimpleXMLElement', LIBXML_NOCDATA);
	
	$cont = $items;
	$items = array();
	
	function truncate($string, $length, $stopanywhere=false) {
        //truncates a string to a certain char length, stopping on a word if not specified otherwise.
        if (strlen($string) > $length) {
            //limit hit!
            $string = substr($string,0,($length -3));
            if ($stopanywhere) {
                //stop anywhere
                $string .= '…';
            } else{
                //stop on a word.
                $string = substr($string,0,strrpos($string,' ')).'…';
            }
        }
        return $string;
    }	
?>
<html>
	<head>
		<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_orochi/assets/orochi/css/websvc_orochi.css" />
		<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_orochi/assets/orochi/js/websvc_orochi.js"></script>
		<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_orochi/assets/orochi/js/websvc_orochi-dev.js"></script>
		<script type="text/javascript">
			var $j				= jQuery.noConflict();
			
			window.onload = function() {
			    
			}
			
			$j(function() {
			
				if (parent) {
			        var oHead = document.getElementsByTagName("head")[0];
			        var arrStyleSheets = parent.document.getElementsByTagName("style");
			        for (var i = 0; i < arrStyleSheets.length; i++)
			            oHead.appendChild(arrStyleSheets[i].cloneNode(true));
			    }
			    
			    
			    
			    
			    
			    
			    
			    
			    var win = $j(window);
				// Full body scroll
				var isResizing = false;
				win.bind(
					'resize',
					function()
					{
						if (!isResizing) {
							isResizing = true;
							var container = $j('.emcOrochi_rss');
							// Temporarily make the container tiny so it doesn't influence the
							// calculation of the size of the document
							container.css(
								{
									'width': 1,
									'height': 1
								}
							);
							// Now make it the size of the window…
							container.css(
								{
									'width': win.width(),
									'height': win.height()
								}
							);
							isResizing = false;
							container.jScrollPane(
								{
									'showArrows': true
								}
							);
						}
					}
				).trigger('resize');

				// Workaround for known Opera issue which breaks demo (see
				// http://jscrollpane.kelvinluck.com/known_issues.html#opera-scrollbar )
				$j('body').css('overflow', 'hidden');

				// IE calculates the width incorrectly first time round (it
				// doesn't count the space used by the native scrollbar) so
				// we re-trigger if necessary.
				if ($j('#full-page-container').width() != win.width()) {
					win.trigger('resize');
				}
			    
			    
			    
			    
			    $j('body').mousemove(function() {emcOrochi._scrollbar();}).scroll(function() {emcOrochi._scrollbar();});
			});
		</script>
	</head>
	<body style="margin:5px;padding:0;">
		<div class="emcOrochi_rss emcOrochi-scrollable ">
			<?php
			foreach($sbXml->channel->item as $item) {
				if($cont==0) break;
				$description = strip_tags($item->description);
			?>
				<div class="emcOrochi_rss_item">
					<h2 class="emcOrochi_title"><?php echo $item->title;?></h2>
					<div class="emcOrochi_content"><?php echo truncate($description, 175);?></div>
					<?php if($item->link)?><a href="<?php echo $item->link;?>" target="_blank" class="emcOrochi_link emcClickOff">Read More</a>
				</div>
			<?php
				$cont--;
			}
			?>
		</div>
	</body>
</html>