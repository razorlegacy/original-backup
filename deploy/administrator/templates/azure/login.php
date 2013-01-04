<?php defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<?php 
	//$iframe	= isset($_GET['iframe'])? 'origin-login-iframe': '';
	$debug	= isset($_GET['debug'])? 'dev': 'min';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $this->language; ?>" lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>" >
	<head>
		<jdoc:include type="head" />
		<link href="templates/<?php echo  $this->template ?>/css/azure.<?php echo $debug;?>.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="/templates/azure/images/favicon.ico"/>
	</head>
	<?php 
	if(isset($_GET['iframe'])) {
	?>	
		<body id="origin-login-iframe" class="originUI">
			<div id="login" class="originForm originUI-bg">
				<h2>publisher login</h2>
				<jdoc:include type="component" />
			</div>
		</body>
	<?php	
	} else {
	?>
		<body id="origin-login" class="originUI">
			<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/azure/template/bar.php');?>
			<div id="content-wrapper" class="azure-bg-glow">
				<div id="login" class="originForm">
					<h2>publisher login</h2>
					<jdoc:include type="component" />
				</div>
				<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/azure/template/footer.php');?>
			</div>
			<script type="text/javascript" src="/templates/azure/js/azure.<?php echo $debug;?>.js"></script>
			<script language="javascript" type="text/javascript">
				$j(function() {azure._originLogin();});
			</script>
			<div id="body-bg">
				<img src="/templates/azure/images/_background/bg-blue.png">
			</div>
		</body>
	<?php
	}
	?>
</html>
