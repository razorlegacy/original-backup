<?php
	defined('_JEXEC') or die('Restricted access'); 
	// I hate typing out echo htmlspecialchars for each variable...
	function h($content){
		echo htmlspecialchars($content,ENT_QUOTES,'UTF-8');
	}
	
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Coloring Book</title>
	<script type="text/javascript" src="components/com_coloringbooks/js/swfobject.js"></script>
	<script type="text/javascript">

		var flashvars = {config:'<?php echo urlencode($this->feed); ?>'};
		var params = {};
		params.scale = "noscale";
		params.wmode = "transparent";
		params.allowscriptaccess = "always"; 
		params.allownetworking = "all"
		var attributes = {};
		attributes.align = "top";

		swfobject.embedSWF("<?php h($this->coloringBook->swf_uri ?$this->coloringBook->swf_uri :'/components/com_coloringbooks/swfs/IN_ColoringBook.swf'); ?>", "coloring", "<?php h($this->coloringBook->embed_width); ?>", "<?php h($this->coloringBook->embed_height); ?>", "10.0.0","js/expressInstall.swf", flashvars, params, attributes);

</script>

<style type="text/css" media="screen">
	    body  {
            background-attachment:scroll !important;
            background-position:center top !important;
            background-repeat: no-repeat;
            background-color:#ffffff;
            background-image:url("");
            margin: 0;
            padding: 0;
        }
        #coloring {
	position: absolute;
	top: 0px;
	left: 0px;
	background-color: #ffffff;
	width: 100%;
	height: 100%;
        }
	</style>

</head>

<body>
   <div id="site_container">
        <div id="coloring">
			<a href="http://www.adobe.com/go/getflashplayer">
							<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
						</a>
		</div>
       </div>
</body>
</html>
