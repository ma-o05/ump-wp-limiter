<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://zzani.com/
 * @since      1.0.0
 *
 * @package    Ump_Wp_Limiter
 * @subpackage Ump_Wp_Limiter/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Ump_Wp_Limiter
 * @subpackage Ump_Wp_Limiter/includes
 * @author     Zzani Web Studio <dev@zzani.com>
 */
class Ump_Wp_Limiter {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ump_Wp_Limiter_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'UMP_WP_LIMITER_VERSION' ) ) {
			$this->version = UMP_WP_LIMITER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'ump-wp-limiter';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ump_Wp_Limiter_Loader. Orchestrates the hooks of the plugin.
	 * - Ump_Wp_Limiter_i18n. Defines internationalization functionality.
	 * - Ump_Wp_Limiter_Admin. Defines all hooks for the admin area.
	 * - Ump_Wp_Limiter_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ump-wp-limiter-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ump-wp-limiter-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ump-wp-limiter-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ump-wp-limiter-public.php';

		$this->loader = new Ump_Wp_Limiter_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ump_Wp_Limiter_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ump_Wp_Limiter_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Ump_Wp_Limiter_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'ump_wp_limiter_add_plugin_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'ump_wp_limiter_page_init' );
		$this->loader->add_action( 'admin_head', $plugin_admin, 'umpl_wp_limiter_webinar_list' );
		$this->loader->add_action( 'admin_footer', $plugin_admin, 'umpl_wp_limiter_webinar_hide_paid_webinar' );
		$this->loader->add_action( 'pre_get_posts', $plugin_admin, 'umpl_wp_limiter_pre_get_posts' );
		$this->loader->add_action( 'ihc_admin_dashboard_after_top_menu', $plugin_admin, 'umpl_wp_limiter_level_admin_html' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'umpl_wp_limiter_hide_notices_dashboard' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ump_Wp_Limiter_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
		$this->loader->add_action( 'wp', $plugin_public, 'umpl_wp_limiter_hide_admin_bar' );
		$this->loader->add_action( 'admin_init', $plugin_public, 'umpl_wp_limiter_hide_admin_bar', 9 );
		$this->loader->add_filter( 'login_redirect', $plugin_public, 'umpl_wp_limiter_login_redirect', 10, 3 );
		add_shortcode( 'umpl-wp-limiter', array( $plugin_public, 'umpl_wp_limiter' ) );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Ump_Wp_Limiter_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
