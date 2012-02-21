<?php
/**
 * @package jQuery Picture Slideshow
 * @version 0.1
 */
/*
Plugin Name: jQuery Picture Slideshow
Plugin URI: http://brianfactor.wordpress.com
Description: This is a simple, lean slideshow plugin that fades between a list of images. 
Author: Brian Morgan
Version: 0.1
Author URI: http://brianfactor.wordpress.com
*/


function output_slider_images($img_array) {?>

	<div class="img-slider">
	<?php foreach ($img_array as $image) : ?>
		<img class="slide slide-1" src="<?php echo $image; ?>" />
	<?php endforeach; ?>
	</div>

<?php }

?>
