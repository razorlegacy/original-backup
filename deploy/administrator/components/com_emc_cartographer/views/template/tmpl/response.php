<?php defined('_JEXEC') or die('Restricted access');?>

<?php
	$this->_addPath( 'template', JPATH_COMPONENT_ADMINISTRATOR . DS . 'views' . DS . 'template' . DS . 'tmpl' );
	
	$this->setLayout($this->template);
	echo $this->loadTemplate();		
?>