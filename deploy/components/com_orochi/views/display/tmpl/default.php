<!DOCTYPE HTML>
<?php
	if($_GET['id']) {
		$host			= $_SERVER['HTTP_HOST'];
		$cacheBreak		= ($_GET['cache'])? "&cache=".$_GET['cache']: "";
		$orochiJSON		= "http://{$host}/index.php?option=com_orochi&view=jsonp&format=raw&id={$_GET['id']}&type={$_GET['type']}{$cacheBreak}";
		$debug			= $_GET['debug'];
	}
	
	$meta	= json_decode($this->orochi->content);
?>
<html>
	<head>
		<title><?php echo $this->orochi->title;?></title>
		<meta property="og:title" content="<?php echo $meta->social_title;?>"/>
		<meta property="og:description" content="<?php echo $meta->social_description;?>"/>
		<meta property="og:image" content="<?php echo $meta->social_image;?>"/>
			<?php
			if($debug) {
			?>
			<link rel="stylesheet" type="text/css" href="http://<?php echo $host;?>/components/com_orochi/assets/orochi/css/websvc_orochi.css" />
			<script type="text/javascript" src="http://<?php echo $host;?>/components/com_orochi/assets/orochi/js/websvc_orochi.js"></script>
			<script type="text/javascript" src="http://<?php echo $host;?>/components/com_orochi/assets/orochi/js/websvc_orochi-dev.js"></script>
			<?php
			} else {
			?>
			<link rel="stylesheet" type="text/css" href="http://<?php echo $host;?>/components/com_orochi/assets/orochi/css/websvc_orochi.min.css" />
			<script type="text/javascript" src="http://<?php echo $host;?>/components/com_orochi/assets/orochi/js/websvc_orochi.min.js"></script>
			<?php
			}
			?>
		<!--[if LT IE 8]><link rel="stylesheet" type="text/css" href="http://<?php echo $host;?>/components/com_orochi/assets/orochi/css/websvc_orochi_ie.css" /><![endif]-->
		<script type="text/javascript">
			var $j				= jQuery.noConflict();
			$j(function() {
				emcOrochi.init('<?php echo $orochiJSON;?>', '<?php echo $_GET['type'];?>');
 			});
		</script>
	</head>
	<body id="emcOrochi_main">
		<div id="emcOrochi_wrapper" class="emcOrochi_<?php echo $_GET['type'];?>">
			<div id="emcOrochi_header"></div>
			<div id="emcOrochi_body" class="emcOrochi_body"></div>
		</div>
	</body>	
</html>