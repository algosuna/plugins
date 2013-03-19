<?php /*
Plugin Name: Latest News Widget with Thumbnail
Description: A Widget that allows you to choose how many posts to display and shows featured images
Version: 1.0
Author: Melissa Cabral
Author URI: http://melissacabral.com
License: GPLv3
*/

/**
 * Set up Image Size
 * Since ver. 1.0
 */
function rad_news_image(){
	add_image_size('rad-news', 94, 70, true);	
}
add_action('admin_init', 'rad_news_image');

/**
 * Attach Stylesheet
 * Since ver. 1.0
 */
function rad_news_style(){
	$style_path = plugins_url('style.css', __FILE__);	
	wp_register_style('rad_news_stylesheet', $style_path);
	wp_enqueue_style('rad_news_stylesheet');
}
add_action('wp_enqueue_scripts','rad_news_style');




/**
 * Tell WP that our widget exists
 * Since ver. 1.0
 */
function rad_register_news_widget(){
	register_widget('Rad_News_Widget');	
}
add_action('widgets_init', 'rad_register_news_widget');  

/**
 * Use the base Class WP_Widget as the prototype for our widget
 * Since ver. 1.0
 */
class Rad_News_Widget extends WP_Widget{
	//REQUIRED - basic settings
	function Rad_News_Widget(){
		$widget_settings = array(
			'classname' => 'news-widget',
			'description' => 'Shows a list of posts with their featured images'
		);
		$control_settings = array(
			//required to make multiple instances work
			'id_base' => 'news-widget',
			'width' => 300  //optional
		);
		
		//push the methods and properties of WP_Widget into our widget, along with its unique settings
		//(id-base, Title, widget ops, control ops)
		$this->WP_Widget('news-widget', 'Latest News with Thumbnails', $widget_settings, $control_settings);
		
	} //end Rad_News_Widget
	
	//REQUIRED - the front-end display
	function widget( $args, $instance ){
		//extract the args from register_sidebar
		extract($args);
		
		//make widget titles filter-able (this is nice to have)
		$title = apply_filters( 'widget-title', $instance['title'] );
		
		//BEGIN OUTPUT
		echo $before_widget;
		
		if($title):
			echo $before_title . $title . $after_title;
		endif;
		?>
		<ul>
		
		<?php  //get the latest posts with a new instance of WP_Query
		$news_query = new WP_Query( array(
			'showposts' => $instance['number'],
			'ignore_sticky_posts' => 1,
			'orderby' => 'post_date',
			'order' => 'desc'
		) );
		
		while( $news_query->have_posts() ):
			$news_query->the_post();
		 ?>
			<li>
				<a href="<?php the_permalink(); ?>" class="thumbnail-link">
					<?php the_post_thumbnail('rad-news'); ?>
				</a>
				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
				<p><?php the_excerpt(); ?></p>
			</li>
		<?php endwhile;
		//clean up after our custom query
		wp_reset_query();
		?>
		
		</ul>		
		<?php 
		echo $after_widget;	
		
	} //end widget
	
	//REQUIRED - sanitize all fields
	function update( $new_instance, $old_instance ){
		$instance = $old_instance;
		
		//santize each field here
		$instance['title'] = wp_filter_nohtml_kses($new_instance['title']);
		$instance['number'] = wp_filter_nohtml_kses($new_instance['number']);
		
		//done. send clean data to the DB
		return $instance;
		
	} //end update
	
	//optional - adds form fields to the admin panel side
	function form( $instance ){
		//set up default values
		$defaults = array(
			'title' => 'Latest News',
			'number' => 5
		);
		//merge defaults into the user-submitted values
		$instance = wp_parse_args( (array) $instance, $defaults );
		
		//Form HTML!  Leave off the <form> tags and button 
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title') ?>">Title:</label>
			
			<input type="text" name="<?php echo $this->get_field_name('title') ?>" 
			id="<?php echo $this->get_field_id('title') ?>" 
			value="<?php echo $instance['title'] ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('number'); ?>">
			Number of Posts:</label>
			
			<input type="number" name="<?php echo $this->get_field_name('number'); ?>" 
			id="<?php echo $this->get_field_id('number'); ?>" 
			value="<?php echo $instance['number'] ?>" style="width:20%" />
		</p>
		
		
<?php
	} //end form
}
