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

/* Output function */
 
function output_slider_images($img_array) {
	$counter = 0; ?>

	<div class="img-slider">
	<?php foreach ($img_array as $image) : $counter++; ?>
		<img class="slide slide-<?php echo $counter; ?>" src="<?php echo $image; ?>" />
	<?php endforeach; ?>
	</div>

<?php }

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
