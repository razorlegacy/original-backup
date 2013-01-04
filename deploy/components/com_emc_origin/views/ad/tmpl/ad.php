<!DOCTYPE HTML>
<?php
	$originConfig	= json_decode($this->originConfig->config);
?>
<html>
	<head>
		<title><?php echo $originConfig->name;?></title>
		<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_emc_origin/assets/css/origin-dev.css" />
		<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_emc_origin/assets/js/origin.js"></script>
		<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_emc_origin/assets/js/origin-dev.js"></script>
		<script type="text/javascript">			
			$(function() {initialize('http://local.origin_azure/index.php?option=com_emc_origin&task=json&id=<?php echo $this->originConfig->id;?>');});
		</script>
	</head>
	<body id="emc<?php echo ucfirst($originConfig->type);?>">
		<?php
			$this->assignRef('originConfig', $originConfig);
			$this->setLayout($originConfig->type);
			echo $this->loadTemplate();
		?>
	</body>
</html>