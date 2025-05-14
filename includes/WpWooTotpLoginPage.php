<?php 
/**
 * Adds a TOTP verification shortcode.
 * The shortcode is configured automatically when a new page is created.
 * @package WP-WOO-TOTP
 */

    function wpWooTotpLoginPage() 
    {

        if(!session_id()){
            session_start();
        }

        if(empty($_SESSION['toptp-verification-page-visited']) && !empty($_SESSION['pending_totp'])){

            $_SESSION['toptp-verification-page-visited'] = true;
    
            ob_start();

?>
            <div class="wp-woo-totp-verification-code-container">
            
                <h2><?= bloginfo() ?></h2>

                <div class="wp-woo-totp-notifications">
                    <?php 
                        if(!empty($_GET['totp_status']) && $_GET['totp_status'] == 'login_failed_wrong_code'):
                            echo '<div class="notification failure"><strong>Invalid Verification Code.</strong> Please double-check your code and try again.</div>';
                        endif;
                    ?>
                </div>

                <p>
                    Please enter the 6-digit code from your authenticator app to continue.
                </p>

                <form method="POST" action="<?php echo esc_url(admin_url('admin-post.php')); ?>">

                    <?php wp_nonce_field('woo_totp_login_verify_nonce', 'woo_totp_login_verify_nonce'); ?>

                    <input type="hidden" name="action" value="woo_totp_login_verify">

                    <input type="text" name="totp-login-check-code" pattern="\d{6}" maxlength="6" placeholder="Enter 6-digit code" required 
                    autofocus>

                    <button type="submit">Verify</button>
                    
                </form>

                <p style="font-size: 13px; color: #999; text-align: center; margin-top: 15px;">
                    Trouble? Please contact support.
                </p>

            </div>
<?php 
        }else{

            if(!session_id()) {
                session_start();
            }

            session_unset();
            session_destroy();

            wp_safe_redirect(get_permalink(wc_get_page_id('myaccount')));
            exit;

        }

        return ob_get_clean();

    }

    add_shortcode('wp_woo_totp_login_page', 'wpWooTotpLoginPage');
?>