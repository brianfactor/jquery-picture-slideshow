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
	
	//public $current_plugin_dir = dirname(__FILE__);	// Equal to __DIR__ in PHP 5.3
	public $default_options = array(
			'author'	=> 0,	// Start with no user.
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
		
		$jqps_title = $this->get_title($instance['title'], $author_id);
		
		$title = apply_filters( 'widget_title', $jqps_title );
		echo $before_widget;
		if ( !empty( $title ) ) { echo $before_title . $title . $after_title; }
		
		// Output actual slideshow here
		
		echo $after_widget;
	}

	/* Output user options */
	
	function form( $instance ) {
		
		// Update the form variables if there are values stored for this instance.
		if ( $instance ) {
			$title = $this->get_title($instance['title'], $author_id);
		}
		else {
			$title = $this->default_options['title'];
		}
		
		// ** Output input fields - the containing form has already been created. **
		
	}
	
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
add_action( 'widgets_init', 'simpleAMW_init' );
function simpleAMW_init() {
	register_widget('simpleAM_widget');
}

