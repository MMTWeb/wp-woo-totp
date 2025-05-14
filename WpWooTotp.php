<?php
/*
Plugin Name: WP WOO TOTP
Plugin URI: mtdev.ovh
Description: Activate and deactivate TOTP authentification
Version: 1.0
Author URI: mtdev.ovh
License: free
Text Domain: wp_woo_totp
*/

/** Plugin CSS file **/

add_action( 'wp_enqueue_scripts', 'wpWooTotpStylesheet' );

function wpWooTotpStylesheet()
{

    wp_register_style('wp-woo-totp-stylesheet', plugin_dir_url( __FILE__ ) .'assets/css/style.css');
    wp_enqueue_style ('wp-woo-totp-stylesheet');
    
}

/** dependencies and plug classes */
require_once __DIR__ . '/vendor/autoload.php';

\WpWooTotp\Src\TotpAutoloaderClass::init(); 

/** Include Wordpress functions */
require_once __DIR__ . '/includes/wpWooTotpHideTitle.php';
require_once __DIR__ . '/includes/WpWooTotpLoginPageCreate.php';
require_once __DIR__ . '/includes/WpWooTotpLoginPage.php';

?>