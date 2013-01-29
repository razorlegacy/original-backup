<!DOCTYPE HTML>
<?php
	$this->originConfigObj->config	= json_decode($this->originConfigObj->config);
	//print_r($this->originConfigObj);
?>
<html>
	<head>
		<title><?php echo $this->originConfigObj->name;?></title>
		<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_emc_origin/assets/css/origin-dev.css" />
		<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_emc_origin/assets/js/origin.js"></script>
		<script type="text/javascript" src="http://<?php echo $_SERVER['HTTP_HOST'];?>/components/com_emc_origin/assets/js/origin-dev.js"></script>
		<script type="text/javascript">			
			$(function() {initialize('http://local.origin_azure/index.php?option=com_emc_origin&task=json&id=<?php echo $this->originConfigObj->id;?>');});
		</script>
	</head>
	<body id="emc<?php echo ucfirst($this->originConfigObj->config->type);?>">
		<?php
			$this->assignRef('originConfig', $this->originConfigObj);
			$this->setLayout($this->originConfigObj->config->type);
			echo $this->loadTemplate();
		?>
	</body>
</html>