<?php
/*
Plugin Name: Instant Conversion Analytics
Version: 1.4.2
Description: Add the user's analytics in emails sent from Contact Form 7, Ninja Forms, WPForms, and WooCommerce.
Author: riseofweb
Author URI: https://www.riseofweb.com
*/


define('Instant_Conversion_Analytics', '1.4.2'); 

// add actions
add_action( 'admin_init', 'ica_register_settings' );
add_action( 'admin_menu', 'ica_create_menu' );
add_action( 'wp_enqueue_scripts', 'ica_js', 0 );

// add filters
add_filter( 'plugin_action_links', 'ica_create_settings_link',10,2 );
add_filter('script_loader_tag', 'ica_async', 10, 3);

// Include Plugin Files
require_once plugin_dir_path( __FILE__ ) . 'includes/core.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/admin.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/integrations.php';

/* Public Includes */
// add the js to the header option
function ica_js(){
	$options = get_option('ica');
	if($options['integration'] === 'standard' || $options['integration'] === 'async'){
		wp_register_script( 'instant-conversion-analytics',  plugin_dir_url( __FILE__ ) . 'js/ica.min.js', array(), Instant_Conversion_Analytics, false);
		wp_enqueue_script('instant-conversion-analytics');
	}
}
// add async to js option
function ica_async($tag, $handle, $src) {
	$options = get_option('ica');
	if($options['integration'] === 'async'){
		if ($handle === 'instant-conversion-analytics') {
			if (false === stripos($tag, 'async')) {
				$tag = str_replace(' src=', ' async="async" src=', $tag);
			}
		}
	}
	return $tag;
}

// plugin activation
function ica_activate() {
	ica_register_settings();
	$ica_options = get_option('ica');
	if ( empty( $ica_options ) ) {
		$ica_options['referral'] = '1';
		$ica_options['query'] = '1';
		$ica_options['journey'] = 'full';
		$ica_options['url'] = '0';
		$ica_options['user_time'] = '1';
		$ica_options['ip'] = '1';
		$ica_options['browser'] = '1';
		$ica_options['mobile'] = '1';
		$ica_options['integration'] = 'async';
		$ica_options['cf7_append'] = '0';
		$ica_options['nf_append'] = '0';
		$ica_options['woo_append'] = '0';
		$ica_options['wpf_append'] = '0';
		add_option('ica', $ica_options);
	}
}
register_activation_hook( __FILE__, 'ica_activate' );

// add to settings menu
function ica_create_menu() {
	add_submenu_page('options-general.php', 'Instant Conversion Analytics', 'Instant Conversion Analytics', 'administrator', 'instant-conversion-analytics', 'ica_settings_page');
	add_action('admin_init', 'ica_register_settings');
}

// add settings link to plugins page
function ica_create_settings_link($action_links,$plugin_file){
	if($plugin_file==plugin_basename(__FILE__)){
		$lc_settings_link = '<a href="options-general.php?page=instant-conversion-analytics">Settings</a>';
		array_unshift($action_links,$lc_settings_link);
	}
	return $action_links;
}

// add support link to the plugins page
function ica_append_links( $links_array, $plugin_file_name, $plugin_data, $status ) {
	if ( strpos( $plugin_file_name, basename(__FILE__) ) ) {
		$links_array[] = '<a href="https://wordpress.org/support/plugin/instant-conversion-analytics/" target="_blank">Support</a>';
		$links_array[] = '<a href="https://wordpress.org/support/plugin/instant-conversion-analytics/reviews/#new-post" target="_blank">Leave a review</a>';
	}
	return $links_array;
}
 
add_filter( 'plugin_row_meta', 'ica_append_links', 10, 4 );

// register the settings
function ica_register_settings() {
	register_setting( 'ica_settings', 'ica', 'ica_validate');
}

//plugin uninstall
function ica_uninstall() {
	delete_option('ica');
}
register_uninstall_hook(__FILE__, 'ica_uninstall');

?>