<?php 
/**
 * This class handles all plugin forms by leveraging the admin_post hook.
 * @package WP-WOO-TOTP
 */

namespace WpWooTotp\Classes;

class TotpPostRequestsClass
{

    private $userID;
    
    /**
     * Constructs the TotpPostRequestsClass.
	*/
    public function __construct() 
    {

        add_action('init', [$this, 'currentUserID']);
        add_action( 'admin_post_woo_totp_activate', [$this, 'totpActivate']);
        add_action( 'admin_post_woo_totp_deactivate', [$this, 'totpDeactivate']);
        add_action( 'admin_post_woo_totp_login_verify', [$this, 'totpLoginVerify']);
        add_action( 'admin_post_nopriv_woo_totp_login_verify', [$this, 'totpLoginVerify']);
        add_action( 'admin_init', [$this, 'totpAdminDeactivate']);
        
    }

    /**
     * Retrieve the current user's ID from the session
	*/
    public function currentUserID()
    {
        $this->userID = get_current_user_id();
    }

    /**
     * Handle TOTP activation form
	*/
    public function totpActivate()
    {
        $nonceField = 'woo_totp_activate_nonce';

        if(!isset($_POST[$nonceField]) || !wp_verify_nonce($_POST[$nonceField], $nonceField)){
            wp_die('Invalid nonce');
        }

        if(!session_id()){
            session_start();
        }

        $activationCode = sanitize_text_field($_POST['activation-code']);

        $totpVerifyActivation = \WpWooTotp\Classes\TotpHelperClass::totpCodeVerification($_SESSION['totp_secret'],$activationCode);

        if($totpVerifyActivation){

            if(update_user_meta($this->userID, 'toptp_auth_status', 'active') && update_user_meta($this->userID, 'toptp_secret_key', $_SESSION['totp_secret']) ){

                if(!session_id()){
                    session_destroy();
                }
                
                \WpWooTotp\Classes\TotpHelperClass::notificationRedirection('totp_status','activation_success');
                
            }else{

                \WpWooTotp\Classes\TotpHelperClass::notificationRedirection('totp_status','activation_failed');

            }

        }else{

            \WpWooTotp\Classes\TotpHelperClass::notificationRedirection('totp_status','activation_failed_wrong_code');

        }

    }

    /**
     * Handle TOTP deactivation form
	*/
    public function totpDeactivate()
    {

        $nonceField = 'woo_totp_deactivate_nonce';

        if(!isset($_POST[$nonceField]) || !wp_verify_nonce($_POST[$nonceField], $nonceField)) {
            wp_die('Invalid nonce');
        }

        if(!empty($_POST['deactivation-verification-code'])){

            $verificationCode = $_POST['deactivation-verification-code'];
            $userSecretKey = get_user_meta($this->userID,'toptp_secret_key',true);

            $totpVerifyActivation = \WpWooTotp\Classes\TotpHelperClass::totpCodeVerification($userSecretKey,$verificationCode);

            if($totpVerifyActivation){

                if(delete_user_meta($this->userID, 'toptp_auth_status') && delete_user_meta($this->userID, 'toptp_secret_key')){

                    \WpWooTotp\Classes\TotpHelperClass::notificationRedirection('totp_status','deactivation_success');

                }else{

                    \WpWooTotp\Classes\TotpHelperClass::notificationRedirection('totp_status','deactivation_failed');
                    
                }

            }else{

                \WpWooTotp\Classes\TotpHelperClass::notificationRedirection('totp_status','deactivation_wrong_code');

            }

        }

    }

    /**
     * Verify TOTP login form
	*/
    public function totpLoginVerify()
    {
        $nonceField = 'woo_totp_login_verify_nonce';
    
        if(!isset($_POST[$nonceField]) || !wp_verify_nonce($_POST[$nonceField], $nonceField)) {
            wp_die('Invalid nonce');
        }
    
        if(!session_id()) {
            session_start();
        }
    
        if(!empty($_SESSION['pending_totp']) && !empty($_POST['totp-login-check-code'])){
    
            $userID = $_SESSION['pending_totp'];
            $user = get_userdata($userID);
            $userSecretKey = get_user_meta($userID, 'toptp_secret_key', true);
            $verificationCode = sanitize_text_field($_POST['totp-login-check-code']);
    
            if($user && $userSecretKey){

                $totpVerifyActivation = \WpWooTotp\Classes\TotpHelperClass::totpCodeVerification($userSecretKey,$verificationCode);

                if($totpVerifyActivation) {

                    if($user){
                        $this->setUserSession($user);
                    }else{
                        wp_die('Invalid user ID.');
                    }

                }else{

                    \WpWooTotp\Classes\TotpHelperClass::setUserIdSession($userID);

                    $redirect_url = get_permalink( get_page_by_path( 'totp-login-page' ) );
                    wp_safe_redirect(add_query_arg('totp_status', 'login_failed_wrong_code', $redirect_url));
                    exit;

                }
            }

        }else{

            wp_die('Something wrong. Please try again.');

        }
        
    }

    /**
     * Store user session after successful TOTP verification
	*/
    public function totpAdminDeactivate()
    {

        if(!isset($_POST['delete_totp_usermeta_submit'])) return;

        if(!isset($_POST['delete_totp_usermeta_nonce']) || !wp_verify_nonce($_POST['delete_totp_usermeta_nonce'], 'delete_totp_usermeta_nonce')) {
            wp_die('Nonce verification failed');
        }

        // Check permissions
        if(!current_user_can('manage_options')) {
            wp_die('Insufficient permissions');
        }

        $userID = intval($_POST['delete_totp_usermeta_user_id']);

        delete_user_meta($userID, 'toptp_auth_status'); 
        delete_user_meta($userID, 'toptp_secret_key');

        // Optional: redirect to remove POST data
        wp_redirect(add_query_arg('meta_deleted', '1', wp_get_referer()));
        exit;

    } 

    /**
     * Store user session after success TOTP verification 
	*/
    private function setUserSession($user)
    {

        clean_user_cache($user->ID);
        wp_clear_auth_cookie();
        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID, true, false);
        update_user_caches($user);

        // AFTER exit (technically never reached, but cleaner)
        if(!session_id()){
            session_unset();
            session_destroy();
        }
        session_write_close();
                
        wp_safe_redirect(get_permalink(wc_get_page_id('myaccount')));
        exit;

    }

}