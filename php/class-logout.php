<?php
/**
 * Class Logout
 *
 * @package mkdo\front_end_login
 */

namespace mkdo\front_end_login;

/**
 * Logout controller.
 */
class Logout {

	/**
	 * Constructor
	 */
	function __construct() {}

	/**
	 * Do Work
	 */
	public function run() {
		add_action( 'wp', array( $this, 'do_logout' ) );
	}

	/**
	 * Logout of WordPress
	 */
	public function do_logout() {

		global $wp_query;

		// Get the logout slug.
		$logout_slug = apply_filters(
			MKDO_FRONT_END_LOGIN_PREFIX . '_logout_slug',
			'logout'
		);

		// Get the login slug.
		$login_slug = apply_filters(
			MKDO_FRONT_END_LOGIN_PREFIX . '_login_slug',
			'login'
		);

		// Get the login URL.
		$login_url = home_url( '/' . $login_slug . '/' );

		// Check if this page is the logout page (dosn't mattter if the page
		// exists or not).
		if (
			property_exists( $wp_query, 'query' ) &&
			isset( $wp_query->query['pagename'] ) &&
			$logout_slug === $wp_query->query['pagename']
		) {
			wp_logout();
			// We cannot use `auth_redirect()` here, because it will throw us into
			// an infinate loop.
			//
			// Instead lets do a manual redirect.
			wp_safe_redirect( $login_url, 302 );
			exit;
		}
	}
}