<?php
// $HeadURL: https://joomgallery.org/svn/joomgallery/JG-1.5/Module/JoomImages/trunk/helper/resize.php $
// $Id: resize.php 1563 2009-08-23 12:43:42Z aha $
/**
* Resize Image with Different Aspect Ratio
*
* Author: Nash
* License: GPL
* Website: http://nashruddin.com/Resize_Image_to_Different_Aspect_Ratio_on_the_fly
*
* modified by JoomGallery::Team
* 7/2009
*/
header("Content-type: image/jpeg");
/* get parameters */
$f = $_GET['file'];
$w = (int) $_GET['width'];
$h = (int) $_GET['height'];

//check parameters
if ($w==0 || $h==0)
{
  exit;
}
//check the existence of the file
if (!is_file($f)){
  exit;
}

/* expand the thumbnail's aspect ratio
to fit the width/height of the image */
$in = @getimagesize($f);
$sw = $in[0] / $w;
$sh = $in[1] / $h;
$s = $sw < $sh ? $sw : $sh;
/* crop the center of the image */
$x0 = floor( ( $in[0] - ( $w * $s ) ) * 0.5 );
$y0 = floor( ( $in[1] - ( $h * $s ) ) * 0.5 );
/* support JPG, PNG and GIF */
$im = @imagecreatefromjpeg($f) or
$im = @imagecreatefrompng($f) or
$im = @imagecreatefromgif($f) or
$im = false;
if (!$im) {
  /* something went wrong, output the image */
  readfile($f);
}
else
{
  /* create thumbnail */
  $thumb = @imagecreatetruecolor($w, $h);
  @imagecopyresampled($thumb, $im, 0, 0, $x0, $y0, $w, $h, ($w * $s), ($h * $s));
  @imagejpeg($thumb,"",100);
}
?>