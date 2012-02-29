/*
 * Javascript for jQuery Picture Slideshow
 * By Brian Morgan
 * Prerequisite: jQuery should be loaded before any of these functions are called.
 */

jQuery(document).ready ( function() {
		var numSlides = jQuery('.slide').length;
		var slideNum = 0;
		// Every 1300ms, call a new slide to fade in and out.
		window.setInterval( function() {
			slideNum = slideNum % numSlides + 1;// cycle through the slide numbers
			fadeInOutSlide(slideNum);		 		// Every second and a half, call the fade in and out on the next slide
		}, 1500 );									// Every 1.5 sec, fade the picture.
});

function fadeInOutSlide(slideNum) {
	// Fade in image for 400 ms, hold for 1.2 sec, and then fade out at same speed.
	jQuery('.img-slider .slide-' + slideNum ).fadeIn(400).delay(1200).fadeOut(400);
	// This should allow for multiple 
}
