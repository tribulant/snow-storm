<?php

/*
Plugin Name: Snow Storm
Description: Display falling snow flakes on the front of your WordPress website for a festive presentation.
Plugin URI: http://tribulant.com
Author: Tribulant Software
Author URI: http://tribulant.com
Version: 1.3
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

function snow_storm_textdomain() {
	load_plugin_textdomain('snow-storm', false, dirname(plugin_basename(__FILE__)) . '/languages/');
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
	$page = add_options_page(__('Snow Storm', "snow-storm"), __('Snow Storm', "snow-storm"), 'manage_options', 'snow-storm', 'snow_storm_admin');
	add_action('admin_head-' . $page, 'snow_storm_admin_head');
}

function snow_storm_admin_head() {
	add_meta_box('submitdiv', __('Settings', 'snow-storm'), 'snow_storm_metabox_submit', 'settings_page_snow-storm', 'side', 'core');
	add_meta_box('plugins', __('Recommended Plugin', 'snow-storm'), 'snow_storm_metabox_plugins', 'settings_page_snow-storm', 'side', 'core');
	add_meta_box('settings', __('Settings', 'snow-storm'), 'snow_storm_metabox_settings', 'settings_page_snow-storm', 'normal', 'core');
}

function snow_storm_metabox_submit() {
	include dirname(__FILE__) . DS . 'views' . DS . 'admin' . DS . 'metaboxes' . DS . 'submit.php';
}

function snow_storm_metabox_plugins() {
	include dirname(__FILE__) . DS . 'views' . DS . 'admin' . DS . 'metaboxes' . DS . 'plugins.php';
}

function snow_storm_metabox_settings() {
	include dirname(__FILE__) . DS . 'views' . DS . 'admin' . DS . 'metaboxes' . DS . 'settings.php';
}

function snow_storm_admin_enqueue_scripts() {
	wp_enqueue_script('jquery');
	wp_enqueue_script('common', false, false, false, true);
	wp_enqueue_script('wp-lists', false, false, false, true);
	wp_enqueue_script('postbox', false, false, false, true);
	wp_enqueue_script('snow-storm-postboxes', plugins_url() . '/snow-storm/js/postboxes.js', array('jquery'), false, true);
	wp_enqueue_script('plugin-install');
	add_thickbox();
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
add_action('plugins_loaded', 'snow_storm_textdomain', 10, 1);
add_filter('plugin_action_links_' . $plugin, 'snow_storm_links', 10, 1);
add_action('init', 'snow_storm', 10);
add_action('wp_head', 'snow_storm_head', 10);
add_action('admin_menu', 'snow_storm_menu', 10);
add_action('admin_enqueue_scripts', 'snow_storm_admin_enqueue_scripts', 10);
register_activation_hook(__FILE__, 'snow_storm_activate');

?>