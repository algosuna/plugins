<?php
/*
Plugin Name: Simple Widget Example
Description: A Widget with just a title field. Use this as a base for future widgets.
Version: 1.0
Author: Andy Osuna
Author URI: http://andyosuna.com
*/

/**
  * Tell WP that our widget exists
  * Since Ver. 1.0
  **/
function rad_register_widget(){
	register_widget('Rad_Simple_Widget');
}
add_action('widget_init','rad_register_widget');

/**
  * Use the base Class WP_Widget as the prototype for our widget
  * Sicne Ver. 1.0
  **/
class Rad_Simple_widget extends WP_Widget{
	//REQUIRED - basic settings
	function Rad_simple_Widget(){
		$widget_settings=array(
			'classname'=>'simple-widget',
			'Description'=>'The simplest Widget Ever. Be descriptive here!'
		);
		$control_settings=array(
			//required to make multiple instances work
			'id_base'=>'simple-widget',
			'width'=>300//optional
		);
		//Push the methods and properties of WP_Widget into our widget, along with its unique settings.
		$this->WP_Widget('simple-widget','Simplest Widget',$widget_settings,$control_settings);
	}//end Rad_Simple_widget

	//REQUIRED - the front-end display
	function widget($args,$instance){
		//extract the args from register_sidebar
		extract($args);
		//make widget titles filter-able (this is nice to have)
		$title=apply_filters('widget-title',$instance['title']);
		//BEGIN OUTPUT
		echo $before_widget;
		
	}//end widget

	//REQUIRED - sanitize all fields
	function update($new_instance,$old_instance){
		$instance=$old_instance;
		//sanitize each field here
		$instance['title']=wp_filter_nohtml_kses($new_instance['title']);
		//done, send clean data to the DB
		return $instance;
	}//end update

	//OPTIONAL - adds form fields to the admin panel side
	function form($instance){
		//set up default values
		$defaults=array(
			'title'=>'Simple!'
		);
		//merge defaults into the user-submitted values
		$instance=wp_parse_args((array)$instance,$defaults);
		//form HTML. Leave off the <form> tags and button
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title')?>">Title:</label>
			<input type="text" name="<?php echo $this->get_field_name('title')?>" id="<?php echo $this->get_field_id('title')?>" value="<?php echo $instance['title']?>" />
		</p>
		<?php
	}//end form
}