<?php

/*
Plugin Name: Snow Storm
Description: Display falling snow flakes on the front of your WordPress website for a festive presentation.
Plugin URI: http://tribulant.com
Author: Tribulant Software
Author URI: http://tribulant.com
Version: 1.2.1
*/

if (!defined('DS')) { define('DS', DIRECTORY_SEPARATOR); }

function snow_storm_activate() {
	add_option('snowstorm_flakesMax', "128");
	add_option('snowstorm_flakesMaxActive', "64");
	add_option('snowstorm_animationInterval', "35");
	add_option('snowstorm_excludeMobile', "Y");
	add_option('snowstorm_followMouse', "N");
	add_option('snowstorm_snowColor', "#FFFFFF");
	add_option('snowstorm_snowCharacter', "&bull;");
	add_option('snowstorm_snowStick', "Y");
	add_option('snowstorm_useMeltEffect', "Y");
	add_option('snowstorm_useTwinkleEffect', "N");
	
}

function snow_storm_links($links = array()) {
	$settings_link = '<a href="' . admin_url('options-general.php?page=snow-storm') . '">' . __('Settings', "snow-storm") . '</a>'; 
	array_unshift($links, $settings_link); 
	return $links;
}

function snow_storm() {
	if (!is_admin()) {
		wp_enqueue_script('snow-storm', plugins_url() . DS . 'snow-storm' . DS . 'snow-storm.js', false, '1.41');
	} else {
		if (!empty($_GET['page']) && $_GET['page'] == "snow-storm") {
			wp_enqueue_script('farbtastic');
			wp_enqueue_style('snow-storm', plugins_url() . '/snow-storm/css/snow-storm.css', false, "1.0", "all");
			wp_enqueue_style('farbtastic');
		}
	}
}

function snow_storm_head() {
	include dirname(__FILE__) . DS . 'views' . DS . 'default' . DS . 'head.php';
}

function snow_storm_menu() {
	add_options_page(__('Snow Storm', "snow-storm"), __('Snow Storm', "snow-storm"), 'manage_options', 'snow-storm', 'snow_storm_admin');
}

function snow_storm_admin() {
	if (!empty($_POST)) {
		foreach ($_POST as $pkey => $pval) {
			update_option('snowstorm_' . $pkey, $pval);
		}
		
		$message = __('Settings have been saved.', "snow-storm");
		include dirname(__FILE__) . DS . 'views' . DS . 'admin' . DS . 'message.php';
	}
	
	include dirname(__FILE__) . DS . 'views' . DS . 'admin' . DS . 'index.php';
}

$plugin = plugin_basename(__FILE__); 
add_filter("plugin_action_links_" . $plugin, 'snow_storm_links', 10, 1);
add_action('init', 'snow_storm', 10);
add_action('wp_head', 'snow_storm_head', 10);
add_action('admin_menu', 'snow_storm_menu', 10);
register_activation_hook(__FILE__, 'snow_storm_activate');

?>