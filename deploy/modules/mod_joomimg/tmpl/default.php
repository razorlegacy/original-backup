<?php
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/Module/JoomImages/trunk/tmpl/default.php $
// $Id: default.php 1934 2010-03-07 12:49:07Z aha $
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

// Defining sectiontableentry class
$sectiontableentry = "sectiontableentry";
$secnr = 1;
$count_img_per_row = 0;

$csstag=$joomimgObj->getConfig("csstag");

if($joomimgObj->getConfig('sectiontableentry')==1) {
  $rowclass = $sectiontableentry.$secnr." ".$csstag."row";
} else {
  $rowclass = "joomimg_row";
}

//global module div
?>
<div class="<?php echo $csstag; ?>main">
<?php
if($joomimgObj->getConfig('scrollthis'))
{
?>
  <marquee behavior="scroll" direction="<?php echo $joomimgObj->getConfig('scrolldirection'); ?>" loop="infinite"
  height="<?php echo $joomimgObj->getConfig('scrollheight'); ?>" width="<?php echo $joomimgObj->getConfig('scrollwidth'); ?>"
  scrollamount="<?php echo $joomimgObj->getConfig('scrollamount'); ?>" scrolldelay="<?php echo $joomimgObj->getConfig('scrolldelay'); ?>"
  <?php echo $joomimgObj->scrollmousecode; ?> class="<?php echo $joomimgObj->getConfig('csstag');?>scroll">
<?php
}


//first row
?>
  <div class="<?php echo $rowclass;?>">

<?php

$countobjects=count($imgobjects);
foreach ($imgobjects as $obj)
{
  // Checks if a new row should be started
  if($count_img_per_row>=$joomimgObj->getConfig('img_per_row')) {
?>
  </div>
  <div class="joomimg_clr"></div>
<?php
    $count_img_per_row = 0;

    if($joomimgObj->getConfig('sectiontableentry')==1)
    {
      $secnr = ($secnr==1) ? 2 : 1;
      $rowclass = $sectiontableentry.$secnr." joomimg_row";
    }
    else
    {
      $rowclass = "joomimg_row";
    }
    //new row
?>
  <div class="<?php echo $rowclass;?>">
<?php
  }

  // Make wordwrap for imgtitle
  if($joomimgObj->getConfig('strtitlewrap') && $joomimgObj->getConfig('strtitlewrap')>0) {
    $obj->imgtitle = wordwrap($obj->imgtitle, $joomimgObj->getConfig('strtitlewrap'), "<br />" ,1);
  }
  // Make wordwrap for imgdescription
  if($joomimgObj->getConfig('strdeswrap') && $joomimgObj->getConfig('strdeswrap')>0
    && isset($img->imgtext) && strlen($img->imgtext)>0)
  {
    $obj->imgtext = wordwrap($obj->imgtext, $joomimgObj->getConfig('strdeswrap'), "<br />" ,1);
  }
  //Make wordwrap for commenttext
  if($joomimgObj->getConfig('strcmtwrap') && $joomimgObj->getConfig('strcmtwrap')>0
    && isset($obj->cmttext) && strlen($obj->cmttext))
  {
    $obj->cmttext = wordwrap($obj->cmttext, $joomimgObj->getConfig('strcmtwrap'), "<br />" ,1);
  }

  //check for link to category
  if($joomimgObj->getConfig('piclink') == 1){
    $link = JRoute::_('index.php?option=com_joomgallery'.$joomimgObj->getConfig('itemidtxt').'&func=viewcategory&catid='.$obj->catid);
  }
  else
  {
    //otherwise link to detail view
    $link = $joomimgObj->getPictureLinkO($obj);
    if ($joomimgObj->getConfig('itemid')!=0)
    {
      $link=preg_replace('/[I|i]temid=[0-9]*/','Itemid='.$joomimgObj->getConfig('itemid'),$link,1);
    }
    //change rel tags of slimbox/thickbox to separate it from same tags in joomgallery
    $link=str_replace('rel="lightbox[joomgallery]"','rel="lightbox[joomgallerymodji]"',$link);
    $link=str_replace('rel="joomgallery"','rel="joomgallerymodji"',$link);
  }

  // Make css settings and calls functions of interface to retrieve images and texts

  // if auto_resize activated, check the dimensions of the thumb and generate the inline
  // styles of height/width, not with activated cropping
  $css_styledimension="";
  if ($joomimgObj->getConfig('auto_resize') && !$joomimgObj->getConfig('crop_img'))
  {
    $thmpath   = JPATH_SITE.DS.$joomimgObj->getJConfig('jg_paththumbs');
    $thmsize   = getimagesize($thmpath.$obj->catpath.'/'.$obj->imgthumbname);

    $thmWidth  = $thmsize[0];
    $thmHeight = $thmsize[1];

    //get the max dimension
    $maxdim=(int) $joomimgObj->getConfig('auto_resize_max');

    if ($thmWidth > $thmHeight)
    {
      //width is the max. dimension
      $ratio=$thmWidth/$maxdim;
      $destWidth  = $maxdim;
      $destHeight = (int)($thmHeight / $ratio);
    }
    else
    {
      //height is the max. dimension
      $ratio=$thmHeight/$maxdim;
      $destHeight  = $maxdim;
      $destWidth = (int)($thmWidth / $ratio);
    }
    $css_styledimension=" style=\"height:".$destHeight."px;width:".$destWidth."px;\" ";
  }
?>
    <div class="<?php echo $csstag;?>imgct">
<?php

  if ($joomimgObj->getConfig('image_position') != 0)
  {
    $imagetype  = $joomimgObj->getConfig('imagetype');
    if($joomimgObj->getConfig('crop_img'))
    {
      $doc=JPATH_SITE;
    }
    else
    {
      $doc =JURI::base( true );
    }
    switch ($imagetype)
    {
      case 0:
        $imagesource=$doc."/".$joomimgObj->getJConfig('jg_paththumbs');
        break;
      case 1:
        $imagesource=$doc."/".$joomimgObj->getJConfig('jg_pathimages');
        break;
      case 2:
        $imagesource=$doc."/".$joomimgObj->getJConfig('jg_pathoriginalimages');
        break;
      default:
        $imagesource=$doc."/".$joomimgObj->getJConfig('jg_paththumbs');
        break;
    }
  }

  switch ($joomimgObj->getConfig('image_position'))
  {
    case 0:
      //no image
      $imgelem = "<div class=\"".$csstag."txt\">\n"
              .$joomimgObj->showText($obj)."\n"
              ."</div>\n";
      break;
    case 1:
    case 2:
    case 3:
      //image above (1) or left (2) or right(3) to text
      //delete the  / from catpath
      $catpath = trim($obj->catpath,'/');

      $imgelem = "<div class=\"".$csstag."img\">\n";
      $imgelem .= "  <a href=\"".$link."\" >";

      if ($joomimgObj->getConfig('crop_img'))
      {
        //crop the pictures
        $cropsizewidth=$joomimgObj->getConfig('crop_sizewidth');
        $cropsizeheight=$joomimgObj->getConfig('crop_sizeheight');

        $imgelem .= "    <img src=\"modules/mod_joomimg/helper/resize.php?"
           ."width=".$cropsizewidth
           ."&height=".$cropsizeheight
           ."&file="
           .$imagesource
           .$catpath.DS
           .$obj->imgthumbname."\""
           ."alt=\""
           .$obj->imgtitle."\""
           ."title=\""
           .$obj->imgtitle."\" />";
      }
      else
      {
        $imgelem .= "    <img src=\""
                 .$imagesource
                 .$catpath."/"
                 .$obj->imgthumbname."\""
                 .$css_styledimension
                 ."alt=\""
                 .$obj->imgtitle."\""
                 ."title=\""
                 .$obj->imgtitle."\" />";
      }
      $imgelem .= "  </a>";

      $imgelem .= "</div>\n";
      $imgelem .= "<div class=\"".$csstag."txt\">\n"
               . $joomimgObj->showText($obj)."\n"
               . "</div>\n";
      break;
    case 4:
      //image below text
      //delete the  / from catpath
      $catpath = trim($obj->catpath,'/');

      $imgelem = "<div class=\"".$csstag."txt\">\n"
               . $joomimgObj->showText($obj)."\n"
               . "</div>\n";

      $imgelem .= "  <a href=\"".$link."\" >";

      //crop the pictures
      if ($joomimgObj->getConfig('crop_img')){
        $cropsizewidth=$joomimgObj->getConfig('crop_sizewidth');
        $cropsizeheight=$joomimgObj->getConfig('crop_sizeheight');

        //crop
        $imgelem .= "    <img src=\"modules/mod_joomimg/helper/resize.php?"
           ."width=".$cropsizewidth
           ."&height=".$cropsizeheight
           ."&file="
           .$imagesource
           .$catpath.DS
           .$obj->imgthumbname."\""
           ."alt=\""
           .$obj->imgtitle."\""
           ."title=\""
           .$obj->imgtitle."\" />";
      }
      else
      {
        $imgelem .= "    <img src=\""._JOOM_LIVE_SITE
                 .$imagesource
                 .$catpath."/"
                 .$obj->imgthumbname."\""
                 .$css_styledimension
                 ."alt=\""
                 .$obj->imgtitle."\""
                 ."title=\""
                 .$obj->imgtitle."\" />";
      }
      $imgelem .= "  </a>";
      break;
  }
  $count_img_per_row++;
?>
      <?php echo $imgelem;?>
    </div>
<?php
}
// close last row
?>
  </div>
  <div class="joomimg_clr"></div>
<?php
if($countobjects==0)
{
  if ($joomimgObj->getConfig('show_empty_message'))
  {
    echo JText::_('JINO_PICTURES_AVAILABLE');
  }
}
?>
<?php
if($joomimgObj->getConfig('scrollthis') == 1)
{
?>
</marquee>
<?php
}
?>
</div>