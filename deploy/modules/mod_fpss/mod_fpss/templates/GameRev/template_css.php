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
	overflow: hidden;
	position: absolute;
	left: 0;
	top: 0;
}

#slide-loading {
	background:#000 url(loading_black.gif) no-repeat center center;
	width:<?php echo $width; ?>px;
	height:<?php echo $height; ?>px;
}

#slide-wrapper {display:none;width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;}
#slide-wrapper #slide-outer {height:<?php echo $height; ?>px;}
#slide-wrapper #slide-outer .slide {width:<?php echo $width; ?>px;height:<?php echo $height; ?>px;}

/* --- Slideshow Block --- */
#slide-wrapper #slide-outer .slide {position:absolute;overflow:hidden;}
#slide-wrapper #slide-outer .slide .slide-inner {position:relative;margin:0;overflow:hidden;text-align:left;z-index:8;height:<?php echo $height; ?>px;}
#slide-wrapper #slide-outer .slide .slide-inner a.fpss_img span span span {background:none;}

/* --- Content --- */
.fpss-introtext {
	margin:0;
	padding:0;
	position:absolute;
}

/* --- Navigation Buttons --- */

#navi-outer {
	overflow: hidden;
	position: absolute;
	top: 0;
	right: 0;
	z-index: 9;
}

#navi-outer ul {
	margin:-1px 0 0 0;
	padding:0;
	list-style:none;
}

#navi-outer li {
	padding:0;
	margin:0;
	list-style:none;
}

#navi-outer li.noimages {
	display:none;
}

#navi-outer li a {
	overflow:hidden;
}

#navi-outer li a:hover,
#navi-outer li a.navi-active {
	overflow:hidden;
}

#navi-outer li a span.navbar-img,
#navi-outer li a:hover span.navbar-img,
#navi-outer li a.navi-active span.navbar-img {
	overflow:hidden;
	margin:0;
	padding:0;
}

#navi-outer li a span.navbar-img img {
	opacity:0.6;
	-moz-opacity:0.6;
	filter:alpha(opacity=60);
}

#navi-outer li a:hover span.navbar-img img,
#navi-outer li a.navi-active span.navbar-img img {
	opacity:1.0;
	-moz-opacity:1.0;
	filter:alpha(opacity=100);
}

#navi-outer li a span.navbar-key {
	display:none;
}

/*
#navi-outer li a span.navbar-title {
	display:block;margin:0;padding:0;}
#navi-outer li a span.navbar-tagline {margin:0;padding:0;}
*/
span.navbar-clr {
	clear:both;
}