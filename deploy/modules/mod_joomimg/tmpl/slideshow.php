<?php
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/Module/JoomImages/trunk/tmpl/slideshow.php $
// $Id: slideshow.php 1965 2010-03-20 16:35:37Z aha $
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

// no direct access
defined('_JEXEC') or die('Restricted access');
$imagetype  = $joomimgObj->getConfig('imagetype');

$doc =JURI::base( true );
switch ($imagetype)
{
  case 1:
    $imagePath=$doc."/".$joomimgObj->getJConfig('jg_pathimages');
    break;
  case 2:
    $imagePath=$doc."/".$joomimgObj->getJConfig('jg_pathoriginalimages');
    break;
  default:
    $imagePath=$doc."/".$joomimgObj->getJConfig('jg_paththumbs');
    break;
}

$showLink         = $joomimgObj->getConfig('piclinkslideshow');
$showCaption      = $joomimgObj->getConfig('showCaption');
$showTitleCaption = $joomimgObj->getConfig('showTitleCaption');
$heightCaption    = $joomimgObj->getConfig('heightCaption');
$width            = $joomimgObj->getConfig('width');
$height           = $joomimgObj->getConfig('height');
$imageDuration    = $joomimgObj->getConfig('imageDuration');
$transDuration    = $joomimgObj->getConfig('transDuration');
$transType        = $joomimgObj->getConfig('transType');
$transition       = $joomimgObj->getConfig('transition');
$pan              = $joomimgObj->getConfig('pan');
$zoom             = $joomimgObj->getConfig('zoom');
$loadingDiv       = $joomimgObj->getConfig('loadingDiv');
$imageResize      = $joomimgObj->getConfig('imageResize');
$titleSize        = $joomimgObj->getConfig('titleSize');
$titleColor       = $joomimgObj->getConfig('titleColor');
$descSize         = $joomimgObj->getConfig('descSize');
$descColor        = $joomimgObj->getConfig('descColor');

$strip_arr= array("'","\r\n", "\n", "\r");
?>
<div class="modjoomimg">
  <div id="slidewrap">
    <div id="slideshow<?php echo $moduleid;?>"></div>
    <div id="loadingDiv"></div>
  </div>
  <script type="text/javascript">
    window.addEvent('domready', function(){
      var imgs = [];
<?php
    $countobjects=count($imgobjects);
    foreach ($imgobjects as $img)
    {
?>
      imgs.push({
        file: '<?php echo $img->catpath."/".$img->imgthumbname; ?>',
<?php if ($showCaption==1)
      {
?>
        desc: '<?php echo strip_tags(str_replace($strip_arr,"",$img->imgtext)); ?>',
<?php }
      else
      {
?>
        desc: '',
<?php }
      if ($showTitleCaption==1)
      {
?>
        title: '<?php echo strip_tags(str_replace($strip_arr,"",$img->imgtitle)); ?>',
<?php }
      else
      {
?>
        title: '',
<?php }
      if ($showLink==1)
      {
?>
        url: '<?php echo JRoute::_('index.php?option=com_joomgallery'.$joomimgObj->getConfig("itemidtxt").'&catid='.$img->catid.'&func=viewcategory'); ?>'
      });
<?php
      }
      else
      {
?>
        url: ''
      });
<?php
      }
    }
?>

      var myshow<?php echo $moduleid;?> = new Slideshow('slideshow<?php echo $moduleid;?>', {
        type: '<?php echo $transType; ?>',
        showTitleCaption: <?php echo $showTitleCaption; ?>,
        captionHeight: <?php echo $heightCaption; ?>,
        width: <?php echo $width; ?>,
        height: <?php echo $height; ?>,
        pan: <?php echo $pan; ?>,
        zoom: <?php echo $zoom; ?>,
        loadingDiv: <?php echo $loadingDiv; ?>,
        resize: <?php echo($imageResize==1?'true':'false'); ?>,
        duration: [<?php echo $transDuration; ?>, <?php echo $imageDuration; ?>],
        transition: Fx.Transitions.<?php echo $transition; ?>,
        images: imgs,
        path: '<?php echo $imagePath; ?>'
      });

      myshow<?php echo $moduleid;?>.caps.h2.setStyles({
        color: '<?php echo $titleColor; ?>',
        fontSize: '<?php echo $titleSize; ?>'
      });

      myshow<?php echo $moduleid;?>.caps.p.setStyles({
        color: '<?php echo $descColor; ?>',
        fontSize: '<?php echo $descSize; ?>'
      });
    });
  </script>
</div>