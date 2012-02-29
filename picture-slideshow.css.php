<?php header('Content-type: text/css'); ?>
/*
 * Stylesheet for jQuery Picture Slideshow plugin
 * By Brian Morgan
 * Implments dynamic sizing. For example, loading this file with server arguments like:
 * picture-slideshow.css.php?width=100px&height=100px
 * will set the size of .img-slider to 100x100px
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
