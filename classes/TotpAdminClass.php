<?php 
/**
 * This class contains functions that enable system administrators to deactivate TOTP for users who are not able to do so themselves.
 * @package WP-WOO-TOTP
 */

namespace WpWooTotp\Classes;

class TotpAdminClass extends TotpBaseClass
{

    /**
    * Constructs the TotpAdminclass
    **/
    public function __construct() 
    {
        
        add_action( 'show_user_profile',  [$this, 'addTotpDeactivationUserProfile'], 10, 1 );
        add_action( 'edit_user_profile',  [$this, 'addTotpDeactivationUserProfile'], 10, 1 );

    }

    /**
    * Loads the deactivation form view
    **/
    public function addTotpDeactivationUserProfile($profile_user)
    {
        $userID = $profile_user->ID;

        $data = compact('userID');
        $this->renderView('totp-admin-user-profile', $data);

    }

}