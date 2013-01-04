<?php // no direct access
defined('_JEXEC') or die('Restricted access'); 
?>

<?php // replace single quote encodings
$video_desc = str_replace('&apos;', "'", $video_desc);
$video_desc = str_replace('%u2019', "'", $video_desc);
?>
<div class="video_player<?php echo $params->get('moduleclass_sfx'); ?>">
<div id="video_header">
	<div id="video_title"><?php echo $video_title; ?></div>
	<div id="video_blurb"><?php echo $video_desc; ?></div>
</div>
<div id="video_player">	
</div>

<script language="javascript" type="text/javascript" src="http://cdn.springboard.gorillanation.com/storage/js/swfobject.js"></script>
<script language="javascript">
function getVideo() {
	var so = new SWFObject("http://cdn.springboard.gorillanation.com/storage/xplayer/yo033.swf", "mplayer", "<?php echo $player_width; ?>", "<?php echo $player_height; ?>", "8", "#000000");
	so.addParam("swliveconnect", "true");
	so.addParam("allowfullscreen", "true");
	so.addVariable("pid", "<?php echo $player_id; ?>");
	so.addVariable("siteId", "<?php echo $site_id; ?>");
	so.addVariable("videoId", "<?php echo $video_id; ?>");
	so.addVariable("autostart", "<?php echo ($autostart == 1) ? 'true' : 'false'; ?>");
	so.addVariable("file", "<?php echo $rssurl; ?>");
	
	if (typeof(companion_gnm_ord)=='undefined') companion_gnm_ord=Math.random()*10000000000000000;
	so.addVariable('adord', companion_gnm_ord);
	if(typeof(adContentDART) != 'undefined' && adContentDART.length > 0) { 
		adContent = escape(adContentDART); 
	} else {
		adContent = '5x5_sent';
	}
	so.addVariable('adContent', adContent);
	
	so.addVariable("pageUrl", document.location);
	so.write("video_player");
}
</script>
<script language="javascript">getVideo();</script>
</div>
