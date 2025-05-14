<?php 
/**
 * Add TOTP menu to user woocommerce account
 * @package WP-WOO-TOTP
 */

namespace WpWooTotp\Classes;

class TotpWooMenuClass
{

    /**
     * Constructs the TotpWooMenuClass.
	*/
    public function __construct() 
    {
        add_action( 'init', [$this, 'wooOtpEndPoint']);
        add_filter( 'woocommerce_account_menu_items', [$this, 'wooOtpMenuClientSide']);
    }

    /**
     * Add /woo-totp-menu endpoint.
	*/
    public function wooOtpEndPoint()
    {

        add_rewrite_endpoint( 'woo-toptp-menu', EP_ROOT | EP_PAGES );

    }

    /**
     * Add Totp menu to Woocommerce user Account before logout url.
	*/
    public function wooOtpMenuClientSide($menu_links)
    {

        if(current_user_can('administrator')){
            return $menu_links;
        }

        $logout = $menu_links['customer-logout'];
        unset($menu_links['customer-logout']);

        $menu_links['woo-toptp-menu'] = __( 'TOTP Authentication', 'woocommerce' );

        $menu_links['customer-logout'] = $logout;

        return $menu_links;

    }

}

?>