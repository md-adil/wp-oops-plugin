<?php

use Adil\WPPlugin\Controllers\Controller;

// Adding menus
add_action('admin_menu', function () {
    add_menu_page(
        'WP Plugin',
        'Wordpress Plugin',
        'manage_options',
        'wp-simple-plugin',
        Controller::resolve('HomeController@index'),
        plugin_dir_url(__FILE__) . 'settings',
        20
    );
});

// Ajax routes
add_action('wp_ajax_some-ajax-request', Controller::resolve('AjaxController@doRequest'));

// Some Hooks
