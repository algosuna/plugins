<?php
/*
Plugin Name: Global Company Options Page
Description: Adds a page under "settings" for managing company info settings
Author: Melissa Cabral
Version: 1.0
*/

/**
 * Add a section to the admin under "Settings"
 * Since ver. 1.0
 */
function rad_options_page(){
	//(title tag, nav label, user access capability, slug, callback for page content)
	add_options_page('Company Information', 'Company Info', 'manage_options', 'rad-options-page', 'rad_options_build_form');	
}
add_action('admin_menu', 'rad_options_page');

/**
 * Add a group of settings so it is allowed in the DB
 * Since ver. 1.0
 */
function rad_options_register(){
	//(name of settings group, label in DB, sanitizing callback function)
	register_setting('rad_options_group', 'rad_options', 'rad_options_sanitize');
}
add_action('admin_init', 'rad_options_register');

/**
 * Callback function for the HTML on the options page
 * Since ver. 1.0
 */
function rad_options_build_form(){ ?>
	<div class="wrap">
		<div id="icon-options-general" class="icon32">
			<br />
		</div>
		<h2>Company Info</h2>
		
		<form action="options.php" method="post">
		<?php 
		//connects the settings group we registered to this form and does some nice security stuff. must match the first arg of our register_setting above
		settings_fields('rad_options_group');

		//get the current values for all fields. must match second arg of register_setting
		$values = get_option('rad_options');
		 ?>
			<ul>
				<li>
					<label>Company Phone:</label> <br />
					<input type="tel" class="regular-text" name="rad_options[phone]" id="rad_options[phone]" value="<?php echo $values['phone']; ?>" />
				</li>
				
				<li>
					<label>Company Address:</label> <br />
					<textarea name="rad_options[address]" id="rad_options[address]" cols="40" rows="5"><?php echo $values['address']; ?></textarea>
				</li>
				
				<li>
					<label>Customer Support Email:</label> <br />
					<input type="email" class="regular-text" name="rad_options[email]" id="rad_options[email]" value="<?php echo $values['email']; ?>" />
				</li>
			</ul>
		
		<div id="icon-index" class="icon32">
			<br />
		</div>	
		<h2>Home Page Settings</h2>
		
			<ul>
				<li>
					<input type="checkbox" name="rad_options[show-quote]" id="rad_options[show-quote]" value="1" <?php checked( '1', $values['show-quote'] ); ?> />
					<label>Display the quote on the Home Page</label>
				</li>
				
				<li>
					<label>Home page message or quote:</label> <br />
					<textarea name="rad_options[quote]" id="rad_options[quote]" cols="40" rows="5"><?php echo $values['quote']; ?></textarea>
				</li>
				
				<li>
					<label>Quote Source:</label> <br />
					<input type="text" class="regular-text" name="rad_options[quote-source]" id="rad_options[quote-source]" value="<?php echo $values['quote-source']; ?>" />
 				</li>
				
				<li>
				   <input type="submit" class="button-primary" value="Save Settings" />
				</li>
			</ul>  
		</form>
	</div>
<?php
}

/**
 * Callback function for sanitizing data
 * $input = array of all values submitted
 * Since ver. 1.0
 */
function rad_options_sanitize($input){
	//fields that need all tags stripped out
	$input['phone'] = wp_filter_nohtml_kses( $input['phone'] );
	$input['email'] = wp_filter_nohtml_kses( $input['email'] );
	$input['quote-source'] = wp_filter_nohtml_kses( $input['quote-source'] );

	//fields that have allowed tags
	$allowed_tags = array(
		'p' => array(),
		'a' => array(
			'href' => array(),
			'title' => array()
		),
		'br' => array(),
		'strong' => array()
	);
	$input['address'] = wp_kses( $input['address'], $allowed_tags );
	$input['quote'] = wp_kses( $input['quote'], $allowed_tags );

	//all done!  send the clean output back to the DB
	return $input;
}