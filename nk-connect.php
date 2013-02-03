<?php
/*
	Plugin Name: NK-Connect
	Plugin URI: http://blog.meloniq.net/
	Description: WordPress plugin which allow to login/signup by using NK (nasza-klasa).
	Author: MELONIQ.NET
	Version: 1.0
	Author URI: http://blog.meloniq.net
*/


/**
 * Avoid calling file directly
 */
if ( ! function_exists( 'add_action' ) )
	die( 'Whoops! You shouldn\'t be doing that.' );


/**
 * Plugin version and textdomain constants
 */
define( 'NKSC_VERSION', '1.0' );
define( 'NKSC_TD', 'nk-connect' );


/**
 * Process actions on plugin activation
 */
register_activation_hook( plugin_basename( __FILE__ ), 'nksc_activate' );


/**
 * Load Text-Domain
 */
load_plugin_textdomain( NKSC_TD, false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );


/**
 * Initialize admin menu
 */
if ( is_admin() ) {
	add_action( 'admin_menu', 'nksc_add_menu_links' );
}


/**
 * Load front-end scripts
 */
function nksc_load_scripts() {

}
add_action( 'wp_print_scripts', 'nksc_load_scripts' );


/**
 * Load back-end scripts
 */
function nksc_load_admin_scripts() {
  wp_enqueue_script( 'jquery-ui-tabs' );
}
add_action( 'admin_enqueue_scripts', 'nksc_load_admin_scripts' );


/**
 * Load front-end styles
 */
function nksc_load_styles() {
	wp_register_style( 'nksc_style', plugins_url( 'style.css', __FILE__ ) );
	wp_enqueue_style( 'nksc_style' );
}
add_action( 'wp_print_styles', 'nksc_load_styles' );


/**
 * Load back-end styles
 */
function nksc_load_admin_styles() {
	wp_register_style( 'nksc_admin_style', plugins_url( 'admin-style.css', __FILE__ ) );
	wp_enqueue_style( 'nksc_admin_style' );
}
add_action( 'admin_enqueue_scripts', 'nksc_load_admin_styles' );


/**
 * Populate administration menu of the plugin
 */
function nksc_add_menu_links() {

	add_options_page( __( 'NK-Connect', NKSC_TD ), __( 'NK-Connect', NKSC_TD ), 'administrator', 'nksc', 'nksc_menu_settings' );
}


/**
 * Create settings page in admin
 */
function nksc_menu_settings() {

	include_once( dirname( __FILE__ ) . '/admin_settings.php' );
}


/**
 * Create announcement on setting page
 */
function nksc_announcement() {

	if ( get_option( 'nksc_announcement' ) )
		return;

	$enabled = array( true, false );
	shuffle( $enabled );

	if ( ! nksc_is_theme_provider( 'appthemes' ) && $enabled[0] ) {
		echo '<div class="update-nag">';
		_e( 'You are not using any of AppThemes Premium Themes, check what You are missing.', NKSC_TD );
		printf( __( ' <a target="_blank" href="%s">Show me themes!</a>', NKSC_TD ), 'http://bit.ly/s23oNj' );
		echo '</div>';
		return;
	}

	if ( ! nksc_is_theme_provider( 'elegantthemes' ) && $enabled[1] ) {
		echo '<div class="update-nag">';
		_e( 'You are not using any of Elegant Premium Themes, check what You are missing.', NKSC_TD );
		printf( __( ' <a target="_blank" href="%s">Show me themes!</a>', NKSC_TD ), 'http://bit.ly/11A8EmR' );
		echo '</div>';
		return;
	}

}


/**
 * Check theme provider, used for announcement
 */
function nksc_is_theme_provider( $provider ) {

	if ( $provider == 'appthemes' )
		return ( function_exists( 'appthemes_init' ) );

	if ( $provider == 'elegantthemes' )
		return ( function_exists( 'et_setup_theme' ) );

	return false;
}


/**
 * Initialize WP App Store Installer
 */
function nksc_wpappstore_init() {
	if ( ! is_admin() )
		return;

	if ( class_exists( 'WP_App_Store_Installer' ) )
		return;

	require_once( 'includes/wp-app-store.php' );
	$wp_app_store_installer = new WP_App_Store_Installer( 3788 );
}
add_action( 'init', 'nksc_wpappstore_init', 9 );


/**
 * Action on plugin activate
 */
function nksc_activate() {
	// install default options
	nksc_install_options();
}


/**
 * Install default options
 */
function nksc_install_options() {

	$previous_version = get_option( 'nksc_version' );

	// fresh install
	if ( ! $previous_version ) {

	}

	//Update DB version
	update_option( 'nksc_version', NKSC_VERSION );
	delete_option( 'nksc_announcement' );
}

