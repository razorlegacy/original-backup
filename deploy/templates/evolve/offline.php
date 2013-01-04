<?php  
/*------------------------------------------------------------------------
# author    your name or company
# copyright Copyright (C) 2011 example.com. All rights reserved.
# @license  http://www.gnu.org/licenses/gpl-2.0.html GNU/GPL
# Website   http://www.example.com
-------------------------------------------------------------------------*/

defined( '_JEXEC' ) or die;

// variables
$app = JFactory::getApplication();
$doc = JFactory::getDocument(); 
$tpath = $this->baseurl.'/templates/'.$this->template;

$this->setGenerator(null);

// load sheets and scripts
$doc->addStyleSheet($tpath.'/css/offline.css?v=1.0.0'); 
$doc->addScript($tpath.'/js/modernizr.js');

?><!doctype html>
<!--[if IEMobile]><html class="iemobile" lang="<?=$this->language?>"> <![endif]-->
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="<?=$this->language?>"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="<?=$this->language?>"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="<?=$this->language?>"> <![endif]-->
<!--[if gt IE 8]><!-->  <html class="no-js" lang="<?=$this->language?>"> <!--<![endif]-->

	<head>
		<jdoc:include type="head" />
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;" /> <!-- mobile viewport optimized -->
		<link rel="apple-touch-icon-precomposed" href="<?=$tpath?>/apple-touch-icon-57x57.png"> <!-- iphone, ipod, android -->
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="<?=$tpath?>/apple-touch-icon-72x72.png"> <!-- ipad -->
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="<?=$tpath?>/apple-touch-icon-114x114.png"> <!-- iphone retina -->
		<link href="<?=$tpath?>/favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" /> <!-- favicon -->
	</head>
	
	<body>
		<jdoc:include type="message" />
		<div id="frame" class="outline">
			<p><?=$app->getCfg('offline_message')?></p>
			<form action="<?php echo JRoute::_('index.php', true); ?>" method="post" name="login" id="form-login">
				<fieldset class="input">
					<p id="form-login-username">
						<label for="username"><?=JText::_('JGLOBAL_USERNAME')?></label><br />
						<input name="username" id="username" type="text" class="inputbox" alt="<?=JText::_('JGLOBAL_USERNAME')?>" size="18" />
					</p>
					<p id="form-login-password">
						<label for="passwd"><?=JText::_('JGLOBAL_PASSWORD')?></label><br />
						<input type="password" name="passwd" class="inputbox" size="18" alt="<?=JText::_('JGLOBAL_PASSWORD')?>" id="passwd" />
					</p>
					<p id="form-login-remember">
						<label for="remember"><?=JText::_('JGLOBAL_REMEMBER_ME')?></label>
						<input type="checkbox" name="remember" value="yes" alt="<?=JText::_('JGLOBAL_REMEMBER_ME')?>" id="remember" />
					</p>
					<p id="form-login-submit">
						<label></label>
						<input type="submit" name="Submit" class="button" value="<?=JText::_('JLOGIN')?>" />
					</p>
				</fieldset>
				<input type="hidden" name="option" value="com_users" />
				<input type="hidden" name="task" value="user.login" />
				<input type="hidden" name="return" value="<?=base64_encode(JURI::base())?>" />
				<?=JHTML::_( 'form.token' )?>
			</form>
		</div>
	</body>

</html>