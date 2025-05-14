<?php 
/**
 * Generate a TOTP authentication page when the plugin is activated
 * @package WP-WOO-TOTP
 */

 add_action('init', 'totpWooCreateLoginPageAuth');

function totpWooCreateLoginPageAuth()
{

    //Verify if a page with this functionality already exists.
    $page = get_page_by_path('totp-login-page');

    if(!$page){

        wp_insert_post([
            'post_title'     => 'TOTP Authentication',
            'post_name'      => 'totp-login-page',
            'post_content'   => '[wp_woo_totp_login_page]', 
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'post_author'    => get_current_user_id(),
            'comment_status' => 'closed'
        ]);
            
    }

}

?>