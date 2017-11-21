<?php

/**
 * Plugin Name: Wordpress Plugin
 * Plugin URI: wp-plugin.net
 * Description: Structure for your plugin
 * Version: 0.1
 * Author: Md Adil <md-adil@live.com>
 */

use Adil\WPPlugin\Controllers\Controller;


/**
 * Autoload class name start with prefix
*/

spl_autoload_register(function ($class) {

    // Define your own prefix
    $prefix = 'Adil\\WPPlugin\\';


    $base_dir = __DIR__ . '/';
    $len = strlen($prefix);
    if (strncmp($prefix, $class, $len) !== 0) {
        return;
    }
    $relative_class = substr($class, $len);
    $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Activation Hooks
register_activation_hook(__FILE__, Controller::resolve('ActivationController@activate'));
register_deactivation_hook(__FILE__, Controller::resolve('ActivationController@deactivate'));

require(__DIR__ . './routes.php');
