<?php header('Content-type: text/css'); ?>
/*
 * Stylesheet for jQuery Picture Slideshow plugin
 * By Brian Morgan
 */

.img-slider {
	width: <?php echo $_GET['width']; ?>;
	height: <?php echo $_GET['height']; ?>;
	position: relative;
	margin: 10px auto;
}

.img-slider .slide {
	display: none;
	position: absolute;
}
