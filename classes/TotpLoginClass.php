<?php 
/**
 * Remove TOTP authentication if the user navigates away before completing the TOTP verification.
 * Maintain the userID in the session and log the user out, redirecting them to the TOTP verification form.
 * @package WP-WOO-TOTP
 */

namespace WpWooTotp\Classes;

class TotpLoginClass
{

    /**
	 * Constructs the TotpLoginClass
	*/
    public function __construct() 
    {
        add_action( 'wp', [$this, 'destroyTotpVerificationPage']);
        add_filter( 'wp_login', [$this, 'totpCheckBeforeLogin'], 10, 2);
    }

    /**
	 * Remove the TOTP authentication page if the user navigates away
	*/
    public function destroyTotpVerificationPage()
    {

        if(!session_id()){
            session_start();
        }

        if(!empty($_SESSION['toptp-verification-page-visited'])){
            session_unset();
            session_destroy();
        }

    }

    /**
	 * Fallback to the TOTP authentication step
	*/
    public function totpCheckBeforeLogin($user_login, $user) 
    {

        $user_data = get_user_by('login', $user_login);

        if(get_user_meta($user_data->ID, 'toptp_auth_status', true) === 'active'){

            if(empty($_SESSION['pending_totp'])){
                \WpWooTotp\Classes\TotpHelperClass::setUserIdSession($user_data->ID);
            }

            wp_logout();

            $redirect_url = get_permalink( get_page_by_path( 'totp-login-page' ) );

            wp_safe_redirect($redirect_url);
            exit;

        }

    }

}