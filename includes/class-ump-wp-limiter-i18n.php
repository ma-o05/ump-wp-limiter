<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://zzani.com/
 * @since      1.0.0
 *
 * @package    Ump_Wp_Limiter
 * @subpackage Ump_Wp_Limiter/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ump_Wp_Limiter
 * @subpackage Ump_Wp_Limiter/includes
 * @author     Zzani Web Studio <dev@zzani.com>
 */
class Ump_Wp_Limiter_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ump-wp-limiter',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
