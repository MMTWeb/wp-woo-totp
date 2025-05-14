<h1>📱 TOTP WooCommerce Account Protection Plugin</h1>

<p><strong>A simple plugin to secure WooCommerce user accounts with TOTP (Time-Based One-Time Password) via Google Authenticator or similar apps.</strong></p>

<h2>📌 Description</h2>
<p>This plugin allows WooCommerce users to protect their accounts using <strong>TOTP (Time-Based One-Time Password)</strong> authentication. Users can enable/disable TOTP for their account via Google Authenticator or similar apps to add an extra layer of security to their accounts.</p>

<h2>✅ Current Features</h2>
<ul>
  <li><strong>User TOTP Activation/Deactivation</strong>: Users can enable or disable TOTP for their account.</li>
  <li><strong>TOTP Protection for WooCommerce Accounts</strong>: Users secure their accounts with TOTP via Google Authenticator or similar apps.</li>
  <li><strong>Admin Control</strong>: Admins can override user TOTP settings (disable/enable) if needed.</li>
  <li><strong>Simple Integration</strong>: Just clone the plugin directory into <code>wp-content/plugins/</code> and activate it.</li>
</ul>

<h2>🚧 Future Enhancements</h2>
<ul>
  <li><strong>TOTP Protection for Admin Accounts</strong></li>
  <li><strong>Admin Customization Options</strong>: Allow admins to configure settings (e.g., TOTP enforcement, recovery codes) via the WordPress admin interface.</li>
</ul>

<h2>📦 Installation</h2>
<ol>
  <li><strong>Clone the repository</strong> into your WordPress <code>wp-content/plugins/</code> directory:
    <pre>git clone https://github.com/MMTWeb/wp-woo-totp.git</pre>
  </li>
  <li><strong>Activate the plugin</strong> from the WordPress admin dashboard under <em>Plugins > Installed Plugins</em>.</li>
  <li><strong>Enable TOTP</strong> for your account via the user profile settings (or have an admin enable it for you).</li>
</ol>

<h2>📱 Requirements</h2>
<ul>
  <li>WordPress 5.8+</li>
  <li>WooCommerce 4.0+</li>
  <li>A TOTP-compatible app (e.g., Google Authenticator, Authy)</li>
</ul>

<h2>🤝 Contributing & Feedback</h2>
<ul>
  <li><strong>Suggestions/Improvements</strong>: Share your ideas in the GitHub repository or via email.</li>
  <li><strong>Bug Reports</strong>: Open an issue on GitHub with detailed steps to reproduce.</li>
  <li><strong>Pull Requests</strong>: Contributions are welcome! Ensure code follows WordPress coding standards.</li>
</ul>

<h2>📜 License</h2>
<p>This plugin is open-source and released under the <a href="https://www.gnu.org/licenses/gpl-3.0.html" target="_blank">GPL v3+</a> license.</p>

<h2>📌 Support</h2>
<p>For questions or issues, reach out via:</p>
<ul>
  <li><a href="https://github.com/your-username/your-plugin-repo/issues" target="_blank">GitHub Issues</a></li>
  <li><a href="https://wordpress.org/support/" target="_blank">WordPress Plugin Support Forum</a></li>
</ul>

<p><strong>Secure your WooCommerce accounts with TOTP today! 🔐</strong></p>
<h2>📝 Notes</h2>
<ul>
  <li><strong>User Responsibility</strong>: Users must set up TOTP via their own app. Admins cannot generate or manage TOTP secrets.</li>
  <li><strong>Security</strong>: Always use HTTPS for your site and store recovery codes securely.</li>
</ul>
