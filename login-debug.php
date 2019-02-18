<?php
/**
 * Plugin Name: Login Debug
 * Plugin URI:  https://github.com/rtCamp/login-debug
 * Description: Helps debug the issues with User login.
 * Version:     1.0.0
 * Author:      rtCamp
 * Author URI:  https://rtcamp.com/
 * License:     GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: login-debug
 * Domain Path: /languages
 */

class LoginDebug {

	public function __construct() {
		add_action( 'set_logged_in_cookie', array( $this, 'print_logged_in_cookie_variables' ), 10, 6 );
		add_action( 'set_auth_cookie', array( $this, 'print_auth_cookie_variables' ), 10, 6 );
		add_filter( 'auth_cookie_expiration', array( $this, 'auth_cookie_expiration_time' ), 10, 3 );
		add_action( 'clear_auth_cookie', array( $this, 'auth_cookie_cleared' ) );
		add_filter( 'auth_cookie', array( $this, 'print_generated_auth_cookie_variables' ), 10, 5 );
		add_filter( 'secure_auth_cookie', array( $this, 'print_auth_cookie_scheme' ), 10, 2 );
		add_action( 'auth_cookie_malformed', array( $this, 'malformed_auth_cookie' ), 10, 2 );
		add_action( 'auth_cookie_bad_username', array( $this, 'bad_username_auth_cookie' ) );
		add_action( 'auth_cookie_bad_hash', array( $this, 'bad_hash_auth_cookie' ) );
		add_action( 'auth_cookie_bad_session_token', array( $this, 'bad_session_token_auth_cookie' ) );
	}

	/**
	 * Logs the variables used during setting the logged in cookie.
	 *
	 * @param string $logged_in_cookie The logged-in cookie value.
	 * @param int    $expire           The time the login grace period expires as a UNIX timestamp.
	 *                                 Default is 12 hours past the cookie's expiration time.
	 * @param int    $expiration       The time when the logged-in authentication cookie expires as a UNIX timestamp.
	 *                                 Default is 14 days from now.
	 * @param int    $user_id          User ID.
	 * @param string $scheme           Authentication scheme. Default 'logged_in'.
	 * @param string $token            User's session token to use for this cookie.
	 */
	public function print_logged_in_cookie_variables( $logged_in_cookie, $expire, $expiration, $user_id, $scheme, $token ) {
		error_log( print_r( '===========Variables passed while setting the cookie for Logged in user===========', true ) );
		error_log( print_r( $logged_in_cookie, true ) );
		error_log( print_r( $expire, true ) );
		error_log( print_r( $expiration, true ) );
		error_log( print_r( $user_id, true ) );
		error_log( print_r( $scheme, true ) );
		error_log( print_r( $token, true ) );
		error_log( '===========End===========' );
	}

	/**
	 * Logs the variables used during setting the authorization cookie.
	 *
	 * @param string $auth_cookie Authentication cookie value.
	 * @param int    $expire      The time the login grace period expires as a UNIX timestamp.
	 *                            Default is 12 hours past the cookie's expiration time.
	 * @param int    $expiration  The time when the authentication cookie expires as a UNIX timestamp.
	 *                            Default is 14 days from now.
	 * @param int    $user_id     User ID.
	 * @param string $scheme      Authentication scheme. Values include 'auth' or 'secure_auth'.
	 * @param string $token       User's session token to use for this cookie.
	 */
	public function print_auth_cookie_variables( $auth_cookie, $expire, $expiration, $user_id, $scheme, $token ) {
		error_log( print_r( '===========Variables passed while setting the cookie for Authorization===========', true ) );
		error_log( print_r( $auth_cookie, true ) );
		error_log( print_r( $expire, true ) );
		error_log( print_r( $expiration, true ) );
		error_log( print_r( $user_id, true ) );
		error_log( print_r( $scheme, true ) );
		error_log( print_r( $token, true ) );
		error_log( '===========End===========' );
	}

	/**
	 * Log if auth cookie is cleared by some plugin or theme.
	 */
	public function auth_cookie_cleared() {
		error_log( '==========Start===========' );
		error_log( print_r( 'Please check clear_auth_hookie action hook. As auth cookie is cleard using wp_clear_auth_cookie', true ) );
		error_log( '==========End===========' );
	}

	/**
	 * Logs the expiration time for the user as well as if the login should be remembered or not.
	 *
	 * @param $expiration_time string The Logged in Cookie Expiration time.
	 * @param $user_id         int The User ID.
	 * @param $remember        bool Remember login.
	 */
	public function auth_cookie_expiration_time( $expiration_time, $user_id, $remember ) {
		error_log( '==========Log the expiration time for the authorization cookie.===========' );
		error_log( print_r( 'Current Expiration time is ' . $expiration_time, true ) );
		error_log( print_r( 'User ID is ' . $user_id, true ) );
		error_log( print_r( 'Remember user login( 1/0 or null ): ' . $remember, true ) );
		error_log( '==========End===========' );
	}

	/**
	 * Logs if the auth cookie stored is secure or not.
	 *
	 * @param bool $secure  Whether the connection is secure.
	 * @param int  $user_id User ID.
	 */
	public function print_auth_cookie_scheme( $secure, $user_id ) {
		error_log( '==========Log the schema for Auth Cookie.===========' );
		error_log( print_r( 'User ID: ' . $user_id, true ) );
		error_log( print_r( 'Secure Cookie: ' . $secure, true ) );
		error_log( '==========End===========' );

	}

	/**
	 * Log the generated auth cookie variables.
	 *
	 * @param string $cookie     Authentication cookie.
	 * @param int    $user_id    User ID.
	 * @param int    $expiration The time the cookie expires as a UNIX timestamp.
	 * @param string $scheme     Cookie scheme used. Accepts 'auth', 'secure_auth', or 'logged_in'.
	 * @param string $token      User's session token used.
	 */
	public function print_generated_auth_cookie_variables( $cookie, $user_id, $expiration, $scheme, $token ) {
		error_log( '==========Variables set during generating the auth cookie.===========' );
		error_log( print_r( 'Cookie: ' . $cookie, true ) );
		error_log( print_r( 'User ID: ' . $user_id, true ) );
		error_log( print_r( 'Expiration Time: ' . $expiration, true ) );
		error_log( print_r( 'Scheme: ' . $scheme, true ) );
		error_log( print_r( 'Token: ' . $token, true ) );
		error_log( '==========End===========' );
	}

	/**
	 * Print malformed cookie variables.
	 *
	 * @param string $cookie Cookie
	 * @param bool   $schema Schema
	 */
	public function malformed_auth_cookie( $cookie, $schema ) {
		error_log( '==========Malformed Cookie===========' );
		error_log( print_r( 'Cookie: ' . $cookie, true ) );
		error_log( print_r( 'Schema: ' . $schema, true ) );
		error_log( '==========End===========' );

	}

	/**
	 * Print bad username cookie elements.
	 *
	 * @param array $cookie_elements Cookie elements.
	 */
	public function bad_username_auth_cookie( $cookie_elements ) {
		error_log( '==========Bad Username Cookie===========' );
		error_log( print_r( 'Cookie Elements: ' . $cookie_elements, true ) );
		error_log( '==========End===========' );

	}

	/**
	 * Print bad hash cookie elements.
	 *
	 * @param array $cookie_elements Cookie elements.
	 */
	public function bad_hash_auth_cookie( $cookie_elements ) {
		error_log( '==========Bad Hash Cookie===========' );
		error_log( print_r( 'Cookie Elements: ' . $cookie_elements, true ) );
		error_log( '==========End===========' );

	}

	/**
	 * Print bad session token cookie elements.
	 *
	 * @param array $cookie_elements Cookie elements.
	 */
	public function bad_session_token_auth_cookie( $cookie_elements ) {
		error_log( '==========Bad session token Cookie===========' );
		error_log( print_r( 'Cookie Elements: ' . $cookie_elements, true ) );
		error_log( '==========End===========' );

	}
}

$instance = new LoginDebug();
