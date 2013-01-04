<?php
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/Module/JoomImages/trunk/mod_joomimg.php $
// $Id: mod_joomimg.php 1959 2010-03-16 09:23:03Z aha $
/**
* Module JoomImages 1.5
* by JoomGallery::Project Team
* based on module for PonyGallery ML by Benjamin Malte Meier 10/08/2007"
* @package JoomGallery
* @Copyright JoomGallery team and b2m
* @ All rights reserved
* @ Joomla Open Source is Free Stuff
* @ Released under GnuGPL License.
**/

/// no direct access
defined('_JEXEC') or die('Restricted access');
jimport('joomla.filesystem.file');

// Check existence of interface to decide if joomgallery is installed
if (!JFile::exists(JPATH_ROOT.DS.'components'.DS.'com_joomgallery'.DS.'classes'.DS.'interface.class.php'))
{
  echo JText::_('JIJGNOTINSTALLED');
  return;
}

//get the interface
require_once(JPATH_ROOT.DS.'components'.DS.'com_joomgallery'.DS.'classes'.DS.'interface.class.php');

// Include the helper class only once
require_once (dirname(__FILE__).DS.'helper.php');

//id of actual module instance
$moduleid=$module->id;

//create helper object
$joomimgObj=new modJoomImagesHelper();

//fill the interface object and get the images
$imgobjects=$joomimgObj->fillObject($params,$moduleid);

//slideshow or default view
if($joomimgObj->getConfig('slideshowthis') == 1)
{
  $path = JModuleHelper::getLayoutPath('mod_joomimg', 'slideshow');
}
else
{
  $path = JModuleHelper::getLayoutPath('mod_joomimg', 'default');
}
if (JFile::exists($path))
{
  require($path);
}
?>