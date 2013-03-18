<?php /*
Plugin Name: Shortcodes
Plugin URI: http://wordpress.melissacabral.com
Description: Adds shortcodes based off of the rad-options demo
Version: 1.0
Author: Melissa Cabral
Author URI: http://melissacabral.com
License: GPLv3
*/

function rad_phone_code(){
		$options = get_option('rad_options');
		return $options['phone'];
}
//if we type [phone] into the content editor, the function above will run
add_shortcode('phone', 'rad_phone_code');


function rad_address_code(){
		$options = get_option('rad_options');
		return '<address>'.$options['address'].'</address>';
}
//if we type [address] into the content editor, the function above will run
add_shortcode('address', 'rad_address_code');


function rad_email_code(){
		$options = get_option('rad_options');
		return '<a href="mailto:'.$options['email'].'">Email Customer Support</a>';
}
//if we type [email] into the content editor, the function above will run
add_shortcode('email', 'rad_email_code');