<?php
header("Content-type: text/css; charset: UTF-8");
$width = $_GET['w'];
$height = $_GET['h'];
$sidebar_width = $_GET['sw'];
?>
/* --- Slideshow Containers --- */

/* This element controls the slideshow spacing and border */
#fpss-container {
	position:relative;
	margin:0;
	padding:0;
	clear:both;
	width:<?php echo $width+$sidebar_width; ?>px;
	height:<?php echo $height; ?>px;
}

#fpss-slider {
	float:left;
	background:none;
	overflow:hidden;
	width:<?php echo $width; ?>px;
	height:<?php echo $height; ?>px;
}

#slide-loading {
	background:#000 url(loading_black.gif) no-repeat center center;
	width:<?php echo $width; ?>px;
	height:<?php echo $height; ?>px;
}

#slide-wrapper {display:none;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;}
#slide-wrapper #slide-outer {height:<?php echo $height; ?>px;}
#slide-wrapper #slide-outer .slide {right:<?php echo $sidebar_width; ?>px;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;}

/* --- Slideshow Block --- */
#slide-wrapper #slide-outer .slide {position:absolute;overflow:hidden;}
#slide-wrapper #slide-outer .slide .slide-inner {position:relative;margin:0;overflow:hidden;text-align:left;z-index:8;height:<?php echo $height; ?>px;}
#slide-wrapper #slide-outer .slide .slide-inner a.fpss_img span span span {background:none;}

/* --- Content --- */
.fpss-introtext {margin:0;padding:0;position:absolute;top:0;bottom:0;background:url(transparent_bg.png);left:<?php echo round($width/12); ?>px;}


/* --- Navigation Buttons --- */

#navi-outer {float:left;margin:0/* 0 0 -20px*/;padding:0;overflow:hidden;position:relative;z-index:9;height:<?php echo $height; ?>px;width:<?php echo $sidebar_width; ?>px;}
#navi-outer ul {margin:-1px 0 0 0;padding:0;list-style:none;background:none;text-align:left;}
#navi-outer li {display:inline;padding:0;margin:0;border:none;list-style:none;background:none;}
#navi-outer li.noimages {display:none;}
#navi-outer li a {display:block;padding:0;margin:0;background:#505050 url(nav.gif) repeat-x bottom;overflow:hidden;}
#navi-outer li a:hover,
#navi-outer li a.navi-active {display:block;padding:0;margin:0;background:#d2d2d2 url(nav-active.gif) repeat-x bottom;overflow:hidden;}
#navi-outer li a span.navbar-img,
#navi-outer li a:hover span.navbar-img,
#navi-outer li a.navi-active span.navbar-img {display:block;overflow:hidden;margin:0;padding:0;float:left;}
#navi-outer li a span.navbar-img img {opacity:0.6;-moz-opacity:0.6;filter:alpha(opacity=60);}
#navi-outer li a:hover span.navbar-img img,
#navi-outer li a.navi-active span.navbar-img img {opacity:1.0;-moz-opacity:1.0;filter:alpha(opacity=100);}
#navi-outer li a span.navbar-key {display:none;}
#navi-outer li a span.navbar-title {display:block;margin:0;padding:0;}
#navi-outer li a span.navbar-tagline {margin:0;padding:0;}
span.navbar-clr {display:block;clear:both;}
