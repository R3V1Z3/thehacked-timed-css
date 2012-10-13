<?php

/*
Plugin Name: Timed CSS Plugin
Plugin URI: http://thehacked.com/timed-css
Description: A simple plugin that adds css to a page after a certain time period.
Version: 1.0
Author: DavidM
Author URI: http://thehacked.com
License: GPL 2
*/

// Initialization function
function timed_css_init() {
    
	// Enqueue jQuery and necessary javascript
	wp_enqueue_script( 'jquery' );
	$plugin_url = plugins_url() . "/" . basename(dirname(__FILE__));
	wp_register_script( 'thehacked-timed-css', $plugin_url . '/thehacked-timed-css.js' );
	wp_enqueue_script( 'thehacked-timed-css' );

	// Add options to database if they don't already exist
	add_option( 'delay_time', '1000' );
	add_option( 'css_to_add', '.thehacked-timed-css {display:none;}' );

	// Get options
	$delay_time = get_option( 'delay_time' );
	$css_to_add = "<style>" . get_option( 'css_to_add' ) . "</style>";
	
	// Display options on page for javascript to access
	$data = array( 'delay_time' => __( $delay_time ), 'css_to_add' => __( $css_to_add ) );
	wp_localize_script( 'thehacked-timed-css', 'thehacked_timed_css_data', $data );
}

// Call initialization function
timed_css_init();

// Create settings submenu
function timed_css_settings_page_init() {
	add_submenu_page( 'options-general.php', 'Timed CSS Settings', 'Timed CSS', 'manage_options', 'timed_css_submenu', 'timed_css_submenu_callback');
}

add_action('admin_menu', 'timed_css_settings_page_init');

// Create settings section and fields
function timed_css_settings_section_init() {
 	
	// Add a settings section
	add_settings_section( 'timed_css_settings_section', 'Settings', 'timed_css_settings_section_callback', 'timed_css_submenu' );
	
	// Add the fields to the section
	add_settings_field( 'delay_time', 'Delay time', 'delay_time_callback', 'timed_css_submenu', 'timed_css_settings_section' );
	add_settings_field( 'css_to_add', 'CSS to add', 'css_to_add_callback', 'timed_css_submenu', 'timed_css_settings_section' );

	// Register options
	register_setting('timed_css_option_group','delay_time');
	register_setting('timed_css_option_group','css_to_add');
}

add_action('admin_init', 'timed_css_settings_section_init');

// Callback for submenu page
function timed_css_submenu_callback() {
	echo '<h3>TheHacked.com Timed CSS</h3>';
	echo '<p>This plugin will append the specified CSS to your page(s) after the specified delay time has passed.</p>';
	echo '<div class="thehacked-timed-css-settings">';
	echo '<form method="post" action="options.php">';
	settings_fields( 'timed_css_option_group' );
	do_settings_sections( 'timed_css_submenu' );
	echo '<br />';
	echo '<input type="submit" value="Save" />';
	echo '</form>';
	echo '</div>';
}

// Callback for timed_css_settings section
 function timed_css_settings_section_callback() {
	echo '<p>Delay time is in miliseconds (1000 = 1 second).</p>';
 }
 
// Callback functions for delay_time
function delay_time_callback() {
	echo '<input name="delay_time" id="delay_time" class="code" type="text" value="' . get_option('delay_time') . '" />';
}

// Callback functions for css_to_add
function css_to_add_callback() {
	echo '<textarea name="css_to_add" id="css_to_add" class="code">' . get_option('css_to_add') . '</textarea>';
}
		
?>