<!DOCTYPE HTML>
<?php
	if($_GET['sid']) {
		$host			= $_SERVER['HTTP_HOST'];
		$cacheBreak		= ($_GET['cache'])? "&cache=".$_GET['cache']: "";
		$syndiJSON		= "http://{$host}/index.php?option=com_syndi&view=jsonp&format=raw&sid={$_GET['sid']}{$cacheBreak}";
		$minified		= $_GET['minified'];
	}
	
	$meta	= json_decode($this->syndi->config);
?>
<html>
	<head>
		<title><?php echo $this->syndi->syndi_name;?></title>
		<meta property="og:title" content="<?php echo $meta->social_title;?>"/>
		<meta property="og:description" content="<?php echo $meta->social_description;?>"/>
		<meta property="og:image" content="<?php echo $meta->social_image;?>"/>
		<?php
			if($minified) {
		?>
			<link rel="stylesheet" type="text/css" href="http://<?php echo $host;?>/components/com_syndi/assets/syndi/css/websvc_syndi.min.css" />
			<script type="text/javascript" src="http://<?php echo $host;?>/components/com_syndi/assets/syndi/js/websvc_syndi.min.js"></script>
		<?php
			} else { 
		?>
			<link rel="stylesheet" type="text/css" href="http://<?php echo $host;?>/components/com_syndi/assets/syndi/css/websvc_syndi.css" />
			<script type="text/javascript" src="http://<?php echo $host;?>/components/com_syndi/assets/syndi/js/websvc_syndi.js"></script>
			<script type="text/javascript" src="http://<?php echo $host;?>/components/com_syndi/assets/syndi/js/websvc_syndi-dev.js"></script>
		<?php
			}
		?>
		<!--[if LT IE 8]><link rel="stylesheet" type="text/css" href="http://<?php echo $host;?>/components/com_syndi/assets/syndi/css/websvc_syndi_ie.css" /><![endif]-->
		<script type="text/javascript">
			syndiWebsvc.init('<?php echo $syndiJSON;?>');
		</script>
	</head>
	<body style="margin: 0; padding: 0">
		<div id="emcSyndi_wrapper"></div>
	</body>	
</html>