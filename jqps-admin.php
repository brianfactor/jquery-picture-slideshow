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

	// Register scripts and styles for using the Wordpress Uploader - needed to upload our images
	function wp_uploader_ldscripts2() {
		wp_enqueue_script('jquery');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('media-upload');
	}
	function wp_uploader_ldstyles2() {
		wp_enqueue_style('thickbox');
	}
	if (isset($_GET['page']) && $_GET['page'] == 'slideshow-settings') { // If we're on the option page, enqueue the scripts
		add_action('admin_enqueue_scripts', 'wp_uploader_ldscripts2');
		add_action('admin_print_styles', 'wp_uploader_ldstyles2');
	}

/* Output the settings page */

function jqps_settings_page () {
	$jqps_slidelist = get_option('jqps_slidelist');
	// Right now, order does not matter
	if ( isset($_POST['jqps_settings_submit']) && $_POST['jqps_settings_submit']=='Yesss' ) {
		$new_image = $_POST['upload_image'];
		echo $new_image;
		if ( empty($jqps_slidelist) ) { // Create the array
			$jqps_slidelist = Array();
		}
		array_push($jqps_slidelist, $new_image);
		update_option('jqps_slidelist', $jqps_slidelist);
	}
	
	?>
	<script type="text/javascript">
		jQuery(document).ready (function() {
		// Custom script to connect this form with the wp uploader
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
	
	<div id="wrap">
		<h2>jQuery-based Picture Slideshow Settings</h2>
	
			<h3>Picture List</h3>
				<form method="post" action="">
					<input type="hidden" name="jqps_settings_submit" value="Yesss" />
					
					<p>Upload an image here or import one from the gallery:<br /> 
						<input type="text" id="upload-image" placeholder="http://" name="upload_image" size="50" />
						<input type="button" id="upload-image-button" class="button" value="Upload New Image" />
					</p>
				
					<p>Currently uploaded images:<br />
						<?php if( !empty($jqps_slidelist) ) {
							foreach ($jqps_slidelist as $img_url) {
								echo $img_url . '<br />';
							} 
						} ?>
					</p>
				
					<p class="submit">
						<input type="submit" class="button-primary" value="Save Images" />
					</p>
					
				</form>
			<h3>How to display</h3>
				
				<p>Display this slideshow on your site by adding the slideshow widget to any sidebar. Shortcode coming...</p>
			
	</div>
	
<?php } // End settings page

/* I'll trust the magic php scope gods on this and hope I can still use this fcn.
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
