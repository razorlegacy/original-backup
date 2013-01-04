<?php defined( '_JEXEC' ) or die( 'Restricted access' );?>
<!DOCTYPE html>
<?php
jimport('evolve.classes.evolveUserHelper');
$user 			=& JFactory::getUser();
$acl			= new evolveUserHelper();

//jimport('evolve.classes.azureUi');
//require_once(dirname(__FILE__).DS.'helper.php');
//AdminPraiseHelper::checkLogin();
$azureRoute		= JRequest::getCMD('page');
$azureRoute     = JRequest::getCmd('azureRoute');
$bodyClass		= (JRequest::getCmd('azureRoute'))? JRequest::getCmd('azureRoute'): JRequest::getCmd('option');
$bodyClass		= (JRequest::getCmd('task'))? $bodyClass.'_'.JRequest::getCmd('task'): $bodyClass;
$debug			= isset($_GET['debug'])? 'dev': 'min';
?>
<html>
	<head>
		<title>Origin</title>
		<link href="templates/<?php echo $this->template ?>/css/azure.<?php echo $debug;?>.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="/templates/azure/images/favicon.ico"/>
		<!--[if IE]>
		<link href="templates/<?php echo $this->template ?>/css/azure-ie.css" rel="stylesheet" type="text/css" />
		<![endif]-->
		<script type="text/javascript" src="/templates/azure/js/azure.<?php echo $debug;?>.js"></script>
		<script language="javascript" type="text/javascript">
			$j(function() {azure._originBar();});
		</script>
		<?php if ($option =="com_cpanel" && !$azureRoute) { ?>
		<script type="text/javascript">if(top !== self) window.top.location.href 	= 'http://'+document.domain+'/administrator/';</script>
		<?php } ?>
		<jdoc:include type="head" />
	</head>
	<body id="" class="template_<?php echo $bodyClass;?> originUI">
		<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/azure/template/bar.php');?>
			<div id="content-wrapper">
				<?php 
				if ($option =="com_cpanel" && !$azureRoute) {
					require_once('templates/home'.DS.'home.php');
				} else if ($azureRoute == 'settings') {
					require_once('templates/settings'.DS.'settings.php');
				} else if ($option !="com_cpanel") {
				?>
					<jdoc:include type="message" />
					<div id="originToolbar">
						<h1><jdoc:include type="modules" name="title" /></h1>
						<jdoc:include type="modules" name="toolbar" />
					</div>
					<div class="clear"></div>
					<?php if (!JRequest::getInt('hidemainmenu')): ?>
					<div id="azure-submenu">
						<jdoc:include type="modules" name="submenu" style="rounded" id="submenu-box" />
					</div>
					<?php endif; ?>
					<div id="content">
						<jdoc:include type="component" />
					</div>
				<?php } ?>
				<?php require_once($_SERVER['DOCUMENT_ROOT'].'/templates/azure/template/footer.php');?>
			</div>
<!--
		<div id="body-bg">
			<img src="/templates/azure/images/_background/bg-blue.png">
		</div>
-->
	</body>
</html>