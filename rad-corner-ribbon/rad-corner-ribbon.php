<?php
/*
Plugin Name: Corner Ribbon - Subscribe to RSS
Description: Adds an eye-catching ribbon to the top cor ner of each page
Plugin URI: http://andyosuna.com
Author: Andy Osuna
Version: 1.0
License: GPLv3
*/

/**
 * Generate HTML output for Ribbon
 * Since Ver. 1.0
 **/
function rad_ribbon_display(){
	//get the absolute path to the image
	//with plugins_url(relative path, __FILE__ constant)
	$image_path=plugins_url('images/corner-ribbon.png',__FILE__);
?>
	<!-- begin rad ribbon plugin output -->
	<a href="<?php bloginfo('rss2_url'); ?>" id="rad-corner-ribbon">
		<img src="<?php echo $image_path; ?>" alt="Subscribe to RSS Feed" />
	</a>
<?php
}
add_action('wp_footer','rad_ribbon_display');

/**
 * Attach Style Sheet
 * Since Ver. 1.0
 **/
function rad_ribbon_style(){
	//get the path for the style file
	$style_path=plugins_url('css/style.css',__FILE__);
	//tell WP that this stylesheet exists
	wp_register_style('rad-ribbon-css',$style_path);
	//put the stylesheet in line
	wp_enqueue_style('rad-ribbon-css');
}
add_action('wp_enqueue_scripts','rad_ribbon_style');