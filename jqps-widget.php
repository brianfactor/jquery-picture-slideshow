<?php 
/*
This file handles creation of the widget object associated with the jQuery Picture Slideshow plugin.
By: Brian Morgan
*/
/**
 * @package HopefulTheme
 * @subpackage jQuery Picture Slideshow
 * @version 0.1
 */

class jqps_widget extends WP_Widget {

	/* Object variables */
	
	public $default_options = array(
			'title'		=> ''
	);
	
	/**
	 * Core widget functions
	 */
	
	/* Constructor method */
	
	function jqps_widget() {
		parent::WP_Widget(
		/* Base ID */	'jqps-widget',
		/* Name */		'jQuery Picture Slider',
						array( 'description' => 'Displays an image slideshow using just javascript.' )
		);
	}
	
	/* Render this widget in the sidebar */
	
	function widget( $args, $instance ) {
		extract($args);
		$jqps_slidelist = get_option('jqps_slidelist');
		$jqps_dimensions = get_option('jqps_img_dimensions');
		
		// Output Title
		$title = apply_filters( 'widget_title', $instance['title'] );
		echo $before_widget;
		if ( !empty($title) ) { echo $before_title . $title . $after_title; }
		
		// Output actual slideshow here
		$counter = 0; ?>
	
		<div class="img-slider">
		<?php foreach ($jqps_slidelist as $image) : $counter++; ?>
			<img class="slide slide-<?php echo $counter; ?>" src="<?php echo $image; ?>"
			 width="<?php echo $jqps_dimensions['width']; ?>" height="<?php echo $jqps_dimensions['height']; ?>" />
		<?php endforeach; ?>
		</div>
		
		<?php echo $after_widget;
	}

	/* Output user options */
	
	function form( $instance ) {
		
		// Update the form variables if there are values stored for this instance.
		// (but there really aren't in this case)
		$title = $instance['title'];
		
		// ** Output input fields - the containing form has already been created. ** ?>
		<p>To customize the look and contents of this widget, go to <a href="<?php echo admin_url('themes.php?page=slideshow-settings'); ?>">Slideshow Settings</a>.</p>
		<p>Slideshow title: <input type="text" name="title" value="<?php echo $title; ?>" /> </p>
		
	<?php }
	
	/* Sanitize and store form input */
	
	function update ( $new_instance, $old_instance ) {
		$instance = $old_instance; // Start with all the variable so we don't loose the ones the user didn't change.
			$instance['title'] = $new_instance['title'];
		return $instance;
	}
	
	/**
	 * Other useful functions for this widget
	 */
	
	
}

/* Register this widget and it's control options */
add_action( 'widgets_init', 'jqps_widget_init' );
function jqps_widget_init() {
	register_widget('jqps_widget');
}

