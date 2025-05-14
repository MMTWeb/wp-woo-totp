<?php
/**
 * Load all plugin classes during this loader initialization within the main plugin file.
 * @package WP-WOO-TOTP
 */

namespace WpWooTotp\Src;

class TotpAutoloaderClass
{

    public static function init()
    {

        new \WpWooTotp\Classes\TotpAdminClass();
        new \WpWooTotp\Classes\TotpWooMenuClass();
        new \WpWooTotp\Classes\TotpWooPageClass();
        new \WpWooTotp\Classes\TotpPostRequestsClass();
        new \WpWooTotp\Classes\TotpLoginClass();

    }

}