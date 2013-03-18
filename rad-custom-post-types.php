<?php
/*
Plugin Name: Product Custom Post Types
Description: Adds support for displaying products 
Plugin URI: http://melissacabral.com
Author: Melissa Cabral
Version:1.0
License:GPLv3
*/

//tell WP to build the admin sections for our products
add_action('init', 'rad_setup_products');
function rad_setup_products(){
	register_post_type( 'product', array(
		'public' => true,
		'has_archive' => true,
		'rewrite' => array( 'slug' => 'shop' ), // http://mysite.com/shop
		'labels' => array(
			'name' => 'Products',
			'singular_name' => 'Product',
			'add_new_item' => 'Add New Product'
		)
	) );
	//activate admin panel features
	$supports = array('thumbnail', 'excerpt', 'custom-fields', 'comments', 'revisions', 'page-attributes', 'author');
	add_post_type_support('product', $supports);
	
	//add Brand taxonomy to products (tax slug, post type slug, args)
	register_taxonomy( 'brand', 'product', array(
		'hierarchical' => true, //like categories
		'rewrite' => array('slug' => 'brands'), //http://mysite.com/brands
		'labels' => array(
			'name' => 'Brands',
			'singular_name' => 'Brand',
			'add_new_item' => 'Add New Brand',
			'search_items' => 'Search Brands'
		)
	) );
	//add Brand taxonomy to products (tax slug, post type slug, args)
	register_taxonomy( 'feature', 'product', array(
		'hierarchical' => false, //flat, like tags
		'rewrite' => array('slug' => 'features'), //http://mysite.com/brands
		'labels' => array(
			'name' => 'Features',
			'singular_name' => 'Features',
			'add_new_item' => 'Add New Feature',
			'search_items' => 'Search Features'
		)
	) );
	
			
}


/**
 * Rebuild permalink rules when the plugin is activated
 * Since ver. 1.0
 */
function rad_rewrite_flush(){
	rad_setup_products();
	flush_rewrite_rules();	
}
register_activation_hook( __FILE__, 'rad_rewrite_flush' );
