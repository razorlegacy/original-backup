<?php  
defined( '_JEXEC' ) or die; 

// variables
$app = JFactory::getApplication();
$doc = JFactory::getDocument(); 
$params = &$app->getParams();
$pageclass = $params->get('pageclass_sfx');
$tpath = $this->baseurl.'/templates/'.$this->template;

$this->setGenerator(null);

// load sheets and scripts
$doc->addStyleSheet($tpath.'/css/style.css'); 

// unset scripts in head and put them to the end of the page (before </body>) for better page loading
//unset($doc->_scripts[$this->baseurl.'/media/system/js/caption.js']);
//$scripts .= '<script src="'.$this->baseurl.'/media/system/js/caption.js" type="text/javascript"></script>';

?>

<!doctype html>
<html>
	<head>
		<jdoc:include type="head" />
	</head>
	<body class="">
		<div id="header">
			<div id="logo" class="wrapper"></div>
		</div>
		
		<div id="main" class="wrapper">
			<a href="/administrator" id="login">login</a>
		</div>
		
		<div id="footer">
			<p id="footer_content">
				&copy; 2012 All Rights Reserved. EVOLVE MEDIA CORP.
				<a href="http://www.evolvemediacorp.com/privacy-policy">PRIVACY POLICY</a> | 
				<a href="http://www.evolvemediacorp.com/terms-of-service">TERMS OF SERVICE</a>
			</p>
		</div>
		
		<jdoc:include type="modules" name="debug" />
		<?=$scripts?>
	</body>
</html>

