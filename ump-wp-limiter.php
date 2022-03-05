<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://zzani.com/
 * @since             1.0.0
 * @package           Ump_Wp_Limiter
 *
 * @wordpress-plugin
 * Plugin Name:       UMP WebinarPress limit
 * Plugin URI:        https://zzani.com/
 * Description:       This plugin adds custom fields to Ultimate Membership Pro membership forms and validates the number of webinars from Webinarpress a user can create based on their membership, in addition to hiding the admin bar and redirecting to the "Tutor" user after login
 * Version:           1.0.0
 * Author:            Zzani Web Studio
 * Author URI:        https://zzani.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ump-wp-limiter
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'UMP_WP_LIMITER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ump-wp-limiter-activator.php
 */
function activate_ump_wp_limiter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ump-wp-limiter-activator.php';
	Ump_Wp_Limiter_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ump-wp-limiter-deactivator.php
 */
function deactivate_ump_wp_limiter() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ump-wp-limiter-deactivator.php';
	Ump_Wp_Limiter_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ump_wp_limiter' );
register_deactivation_hook( __FILE__, 'deactivate_ump_wp_limiter' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ump-wp-limiter.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ump_wp_limiter() {

	$plugin = new Ump_Wp_Limiter();
	$plugin->run();

}
run_ump_wp_limiter();
