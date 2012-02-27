<?php
/*
This file handles creation outputting the admin page for the jQuery Picture Slideshow plugin 
By: Brian Morgan
*/
/**
 * @package HopefulTheme
 * @subpackage jQuery Picture Slideshow
 * @version 0.1
 */


$plugin_root_url = plugin_dir_url(__FILE__);

/* Register the settings page and other stuff we need to register */

function jqps_create_admin_pg() {
	// Create the settings page
	add_submenu_page( 
		'themes.php',					// Subpage of this 
		'Picture Slideshow Settings',	// Long title 
		'Slideshow Settings', 			// Title in menu
		'edit_theme_options', 			// Capabilities required to view
		'slideshow-settings',  			// Page slug
		'jqps_settings_page'			// Function that renders settings form
	);
}
add_action('admin_menu', 'jqps_create_admin_pg');

// To make a dynamic admin interface, include:
function enqueue_draggable() {
	wp_enqueue_script('jquery-ui-core');
	wp_enqueue_script('jquery-ui-wdiget');
	wp_enqueue_script('jquery-ui-mouse');
	wp_enqueue_script('jquery-ui-draggable');
}

// Register scripts and styles for using the Wordpress Uploader - needed to upload our images
function wp_uploader_ldscripts2() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('thickbox');
	wp_enqueue_script('media-upload');
}
function wp_uploader_ldstyles2() {
	wp_enqueue_style('thickbox');
}

// JS written just for this plugin
function enqueue_jqps_admin() {
	//wp_register_script('jqps-admin', )
}

if (isset($_GET['page']) && $_GET['page'] == 'slideshow-settings') { // If we're on the option page, enqueue the scripts
	add_action('admin_enqueue_scripts', 'wp_uploader_ldscripts2');
	add_action('admin_print_styles', 'wp_uploader_ldstyles2');
}

/* Output the settings page */

function jqps_settings_page () {
	$jqps_slidelist = get_option('jqps_slidelist');
	$jqps_dimensions = get_option('jqps_img_dimensions');
	// Right now, order does not matter
	if ( isset($_POST['jqps_settings_submit']) && $_POST['jqps_settings_submit']=='Yesss' ) {
		// * Update list of images in the slideshow
		if ( empty($jqps_slidelist) ) { // Create the array
			$jqps_slidelist = Array();
		}
		// Remove images
		if ( !empty($_POST['remove-imgs']) ) {
			$del_images = $_POST['remove-imgs'];	// This returns an array of checkbox values
			foreach ($del_images as $i) {
				unset( $jqps_slidelist[$i] );
			}
			$jqps_slidelist = array_values($jqps_slidelist);	// Re-index the array
		}
		// Add new images
		$new_image = _img_url_sanitizer($_POST['upload_image']);
		if ( !empty($new_image) ) {
			array_push($jqps_slidelist, $new_image);
		}
		// Update the database entry for slide list
		update_option('jqps_slidelist', $jqps_slidelist);
		
		// * Update the image dimensions
		if ( empty ($jqps_dimentions) ) { // If the database entry doesn't exist yet
			$jqps_dimentions = array( 'width' => 100, 'height' => 100);
		}
		$jqps_dimensions['width'] = $_POST['img-width'];
		$jqps_dimensions['height'] = $_POST['img-height'];
		update_option('jqps_img_dimensions', $jqps_dimensions);
	}
	
	?>
	<script type="text/javascript">
		jQuery(document).ready (function() {
		/* Custom functions to connect this form with the wp uploader*/
		var img_field;
		
		// Create handlers for each form
		jQuery('#upload-image-button').click(function(){
			callUploader('#upload-image');
		});
		
		function callUploader (text_field) {
			window.img_field = text_field;				// Make it a global
			formfield = jQuery(text_field).attr('name');
			tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true');
			return false;
		}
		
		window.send_to_editor = function(html) { // Overwrite default function
			imgurl = jQuery('img',html).attr('src');
			jQuery(window.img_field).val(imgurl);
			tb_remove();
		}
		
		});
	</script>
	<style type="text/css">
		ul#slideshow-images {
			border: 2px solid #21759B;
			margin-right: 15px;
		}
		ul#slideshow-images:hover {
			border: 2px solid #fff;
		}
		ul#slideshow-images li {
			display: inline-block;
			padding: 3px;
			border: 5px solid #fff;
		}
		ul#slideshow-images li:hover {
			border: 5px solid #21759B;
		}
	</style>
	
	<div id="wrap">
		<h2>jQuery-based Picture Slideshow Settings</h2>
	
			<form method="post" action="">
				<input type="hidden" name="jqps_settings_submit" value="Yesss" />
				
				<h3>Slideshow Configuration</h3>
					<p>Dimentions: <input type="text" name="img-width" placeholder="100px" value="<?php echo $jqps_dimensions['width']; ?>" size="5" />
						 x <input type="text" name="img-height" placeholder="100px" value="<?php echo $jqps_dimensions['height']; ?>" size="5" /></p>
				
				<h3>Picture List</h3>
				
					<p>Upload an image here or import one from the gallery:<br /> 
						<input type="text" id="upload-image" placeholder="http://" name="upload_image" size="50" />
						<input type="button" id="upload-image-button" class="button" value="Upload New Image" />
					</p>
				
					<p>Images currently in the slider (at the size you chose above):<br />
						<?php if( !empty($jqps_slidelist) ) {
							echo '<ul id="slideshow-images">';
							$count=0;
							foreach ($jqps_slidelist as $img_url) {
								echo '<li id="pic' . $count .'"><img src="' . $img_url . '" alt="slideshow-img-' . $count . '" 
									width="' . $jqps_dimensions['width'] . '" height="' . $jqps_dimensions['height'] . '" /><br />';
								echo '<input type="checkbox" name="remove-imgs[]" value="' . $count . '" /> Remove';
								echo '</li>'; 
								$count++;
							}
							echo '</ul>';
						} ?>
					</p>
					
					<p style="margin-bottom:0;">Submit after you upload a file to add it to the slideshow.</p>
					<p class="submit">
						<input type="submit" class="button-primary" value="Save Images" />
					</p>
					
				</form>
			<h3>How to display</h3>
				
				
				<p>Display this slideshow on your site by adding the slideshow widget to any sidebar. (<a href="<?php echo admin_url('widgets.php'); ?>">Goto Widgets</a>) Shortcode coming...</p>
			
	</div>
	
<?php } // End settings page

/* I'll trust the magic php scope gods on this and hope I can still use this fcn. - this function is in the theme, so that could create problems.
function _img_url_sanitizer( $logo_url ) {
	if ( empty($logo_url) ) {
		return '';
	}

	$valid_imgs = array ( 'png', 'jpg', 'jpeg', 'ico', 'bmp', 'gif', 'svg' );
	$extension = end( explode('.', $logo_url) );
	if ( !in_array($extension, $valid_imgs) ) {	// If this does not have a valid image extension
		echo 'Invalid Logo input; wrong filetype. It needs to have one of these file extensions:';
		foreach ( $valid_imgs as $ext )
			echo ' ' . $ext;
		echo '. Or just leave blank to use text.<br />';
	}
	$sanitized_url = esc_url_raw($logo_url);
	if ( $sanitized_url ) {
		return $sanitized_url;
	}
	else {
		echo 'Invalid Logo input. Perhaps it\'s a bad protocol.<br />';
		return $default_hopeful_settings['logo_url'];
	}
}
*/
