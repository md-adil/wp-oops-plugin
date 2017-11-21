<?php
/**
 * This is supposed to get called automatically when try to uninstall the plugin
 */
// if uninstall.php is not called by WordPress, die

if (!defined('WP_UNINSTALL_PLUGIN')) {
    die;
}
 
$option_name = 'wporg_option';
 
// delete_option(/*Optionname*/);
 
// for site options in Multisite
// delete_site_option(/*Sitename*/);
