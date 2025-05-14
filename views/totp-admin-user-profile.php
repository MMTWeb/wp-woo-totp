<table class="form-table">
	<tr>
		<th>
			<label for="wp-woo-totp-admin-userprofile"><?php esc_html_e( 'TOTP' ); ?></label>
		</th>
		<td>

            <?php if(get_user_meta($userID, 'toptp_auth_status', true) === 'active' && !empty(get_user_meta($userID, 'toptp_secret_key', true))): ?>

                <form method="post">
                    <input type="hidden" name="delete_totp_usermeta_user_id" value="<?php echo esc_attr($userID); ?>">
                    <input type="hidden" name="delete_totp_usermeta_nonce" value="<?php echo esc_attr(wp_create_nonce('delete_totp_usermeta_nonce')); ?>">
                    <input type="submit" name="delete_totp_usermeta_submit" value="Remove TOTP auth for this profil" class="button">
                </form>
            
            <?php else: ?>
                TOTP is not enable for this user.
            <?php endif; ?>
			
		</td>
	</tr>
</table>