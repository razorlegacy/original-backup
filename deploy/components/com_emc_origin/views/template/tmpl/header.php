<?php defined('_JEXEC') or die('Restricted access');?>

<?php if($this->debug) { ?>
	<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_emc_origin/assets/css/emcOrigin.css" />
    <script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_emc_origin/assets/js/emcOriginAd.js"></script>

<?php } else { ?>

	<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_emc_origin/assets/css/emcOrigin.min.css" />
    <script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_emc_origin/assets/js/emcOriginAd.min.js"></script>

<?php } ?>

<?php 
//Custom embed scripts
echo json_decode($this->originObj['config']->config)->embed;
?>

<?php
if(json_decode($this->originObj['config']->config)->ga) {
?>
	<script type="text/javascript">
	var _gaq=_gaq||[];_gaq.push(["_setAccount","<?php echo json_decode($this->originObj['config']->config)->ga;?>"]);_gaq.push(["_trackPageview"]);var ga=document.createElement("script");ga.type="text/javascript";ga.async=!0;ga.src=("https:"==document.location.protocol?"https://ssl":"http://www")+".google-analytics.com/ga.js";var s=document.getElementsByTagName("script")[0];s.parentNode.insertBefore(ga,s);
	</script>
<?php
}
?>
<meta name="viewport" content="width=device-width"/>