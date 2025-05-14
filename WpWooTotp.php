<?php
/*
Plugin Name: WP WOO TOTP
Plugin URI: https://mtdev.ovh
Description: This plugin allows WooCommerce users to protect their accounts using TOTP (Time-Based One-Time Password)
Version: 1.0
Author URI: MT
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
