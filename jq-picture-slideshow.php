<?php
/*
Plugin Name: jQuery Picture Slideshow
Plugin URI: http://brianfactor.wordpress.com
Description: This is a simple, lean slideshow plugin that fades between a list of images. 
Author: Brian Morgan
Version: 0.1
Author URI: http://brianfactor.wordpress.com
*/
/**
 * @package HopefulTheme
 * @subpackage jQuery Picture Slideshow
 * @version 0.1
 */

/* Random setup */

function jqsp_support() {
	add_theme_support( 'post-thumbnails' );
}
add_action('after_setup_theme','jqsp_support');

	// Enqueue scripts and styles
	function enqueue_slideshow_scripts() {
		$jqps_dimensions = get_option('jqps_img_dimensions');
		wp_register_script( 'jqps_slideshow_js', plugins_url('picture-slideshow.js', __FILE__), array('jquery') );
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'jqps_slideshow_js' );
		$style_url = plugin_dir_url(__FILE__) . 'picture-slideshow.css.php' . '?width=' . $jqps_dimensions['width'] . '&height=' . $jqps_dimensions['height'];
		/*wp_register_style( 'jqps_slideshow_style', $style_file );
		wp_enqueue_style( 'jqps_slideshow_style' ); -- These guys are encoding the urls so that I can't be the get variables I want */
		echo '<link rel="stylesheet" id="jqps_slideshow_style-css" href="' . $style_url . '" type="text/css" media="all"" />';
		
	}
	add_action('wp_enqueue_scripts', 'enqueue_slideshow_scripts');
	
/* Admin Interface */
include ("jqps-admin.php");

/* Shortcode declaration */
add_shortcode( 'pictureslideshow', 'jqps_shortcode' );
function jqps_shortcode ( $atts ) {	// This shortcode has no arguments yet
	// Somehow, get an array with links to all the images
	
	$out = '<div class="img-slider">';
	
	$counter = 0;
	foreach ($img_array as $image) { 
		$counter++;
		$img_size = getimagesize($image);
		if ($img_size != false) {		// If the image can't be read, this returns false;
			$width = $img_size[0];
			$height = $img_size[1];
			
			$out .= '<img class="slide slide-' . $counter . '" src="' . $image . '" width="' . $width . '" height="' . $height . '" />';
		}
	}
	
	$out .= '</div>';
	
	return $out;
}

/* Widget declaration */
include("jqps-widget.php");

?>
