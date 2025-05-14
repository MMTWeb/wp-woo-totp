<div class="wp-woo-totp-page">

    <h3><?= esc_html__('Manage TOTP Authentication', 'wp-woo-totp') ?> </h3>

    <div class="wp-woo-totp-notifications">
        <?php 
            if(!empty($_GET['totp_status'])){
                \WpWooTotp\Classes\TotpHelperClass::notificationOutput($_GET['totp_status']);
            }
        ?>
    </div>

    <?php if(empty($qrCode)): ?>

        <p><span style="font-weight: 700;"><?= esc_html__('TOTP is already activated on your account. To deactivate it, please enter the verification code displayed in your TOTP authentication app.', 'wp-woo-totp') ?></span></p>

        <form method="POST" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
            <?php wp_nonce_field('woo_totp_deactivate_nonce', 'woo_totp_deactivate_nonce'); ?>
            <input type="hidden" name="action" value="woo_totp_deactivate">
            <input type="text" name="deactivation-verification-code" placeholder="Enter the code here" class="verification-code-form">
            <button type="submit" class="verification-code-form"><?= esc_html__('Deactivate', 'wp-woo-totp') ?></button>
        </form>

    <?php else: ?>

        <p><?= esc_html__('To activate TOTP, simply scan the QR code with your TOTP authentication app (e.g., Google Authenticator, Authy). This will add the account to your app, providing a secure layer of protection against unauthorized access.', 'wp-woo-totp') ?></p>

        <div class="wp-woo-totp-activation">
            <div>
                <?= '<img src="'. $qrCode.'" alt="TOTP QR Code" />'; ?>
            </div>

            <form method="POST" action="<?php echo esc_url( admin_url('admin-post.php') ); ?>">
                <?php wp_nonce_field('woo_totp_activate_nonce', 'woo_totp_activate_nonce'); ?>
                <input type="hidden" name="action" value="woo_totp_activate">
                <input type="text" name="activation-code" placeholder="<?= esc_html__('Enter the code here', 'wp-woo-totp') ?>" class="verification-code-form">
                <button type="submit" class="verification-code-form"><?= esc_html__('Activate', 'wp-woo-totp') ?></button>
            </form>

        </div>
   
    <?php endif ?>

 </div>