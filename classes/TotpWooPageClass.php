<?php 
/**
 * Add a page callback to the TOTP menu within the WooCommerce user account.
 * @package WP-WOO-TOTP
 */

namespace WpWooTotp\Classes;

class TotpWooPageClass extends TotpBaseClass
{

    /**
     * Constructs the TotpWooPageClass.
	*/
    public function __construct() 
    {
        add_action('woocommerce_account_woo-toptp-menu_endpoint', [$this, 'totpWooPage']);
    }

    /**
     * Create the TOTP management page.
	*/
    public function totpWooPage() 
    {

        $userID = get_current_user_id();

        //If TOTP is not activated, prepare data to generate an activation QR code.
        if(get_user_meta($userID, 'toptp_auth_status', true) != 'active' && empty(get_user_meta($userID, 'toptp_secret_key', true))){

            if(!session_id()){
                session_start();
            }

            //Prepare data for generating the TOTP secret and QR code.
            $currentUser = wp_get_current_user();
            $currentUserEmail = $currentUser->user_email;

            //Check if a TOTP secret is already stored in the session; if not, create one.
            if(empty($_SESSION['totp_secret'])){

                $secret = \WpWooTotp\Classes\TotpHelperClass::totpGenerateSecret(); 
                $_SESSION['totp_secret'] = $secret;

            }else{

                $secret = $_SESSION['totp_secret'];
                
            }

            //Generate the TOTP QR code.
            $qrCode = \WpWooTotp\Classes\TotpHelperClass::totpQrCode($secret,'wp_woo_totp',$currentUserEmail); 

            //Send the data to the totp-manage-page view.
            $data = compact('qrCode');
            $this->renderView('totp-manage-page', $data);

        }else{

            $qrCode = null;
            $data = compact('qrCode');
            $this->renderView('totp-manage-page', $data);

        }
  
    }
    
}