<?php 
/**
 * Hide the page title in TOTP verification.
 * @package WP-WOO-TOTP
 */

add_action('wp_head','hideTotpVerificationTitle');

function hideTotpVerificationTitle()
{

    if(is_page('totp-login-page')){
        echo '<style> .wp-block-post-title{ display:none; }</style>';
    }

}

?>