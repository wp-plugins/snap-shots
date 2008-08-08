<?php
/*
Plugin Name: Snap Shots&trade; Integrator
Version: 1.0
Plugin URI: http://ajaydsouza.com/wordpress/plugins/snap-shots/
Description: Add <a href="http://www.snap.com/snapshots.php">Snap Shots&trade;</a> to your blog. Go to <a href="options-general.php?page=ssi_options">Options &gt;&gt; Snap Shots Integrator</a> to configure.
Author: Ajay D'Souza
Author URI: http://ajaydsouza.com/
*/ 

if (!defined('ABSPATH')) die("Aren't you supposed to come here via WP-Admin?");

function ald_ssi_init() {
     load_plugin_textdomain('myald_ssi_plugin', PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)));
}
add_action('init', 'ald_ssi_init');

define('ALD_Snap_Shots_DIR', dirname(__FILE__));

/*********************************************************************
*				Main Function (Do not edit)							*
********************************************************************/
function ald_ssi()
{
	$ssi_settings = ssi_read_options();
	
	if($ssi_settings[key]=='')
	{
		$str = __('Please visit WP-Admin &gt; Settings &gt; Snap Shots and enter the key.','ald_ssi_plugin');
		$str .= '<a href="http://ajaydsouza.com/snap-shots/#key">';
		$str .= __('How to find your key','ald_ssi_plugin');
		$str .= '</a>';
	}
	else
	{
		$str = '<script defer="defer" type="text/javascript" src="http://shots.snap.com/ss/';
		$str .= $ssi_settings[key];
		$str .= '/snap_shots.js"></script>';
	}
	
	return $str;
}

function ssi_read_options() 
{
	if(!is_array(get_option('ald_ssi_settings')))
	{
		$ssi_settings = ssi_default_options();
		update_option('ald_ssi_settings', $ssi_settings);
	}
	else
	{
		$ssi_settings = get_option('ald_ssi_settings');
	}
	return $ssi_settings;
}

// Functions to echo the necessary code
add_action('wp_footer', 'ald_ssi_display');
function ald_ssi_display($force = false) {
	$ssi_settings = ssi_read_options();

	if ($force || $ssi_settings['footer'])
	{
		echo ald_ssi();
	}
}

// Add an action called echo_ssi so that it can be called using do_action('echo_ssi');
add_action('echo_ssi', 'echo_ssi_function');
function echo_ssi_function() {
	$ssi_settings = ssi_read_options();
	if (!$ssi_settings['footer'])
	{
		ald_ssi_display(true);
	}
}


// This function adds an Options page in WP Admin
if (is_admin() || strstr($_SERVER['PHP_SELF'], 'wp-admin/')) {
	require_once(ALD_Snap_Shots_DIR . "/admin.inc.php");
}


?>