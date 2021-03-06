<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://zzani.com/
 * @since      1.0.0
 *
 * @package    Ump_Wp_Limiter
 * @subpackage Ump_Wp_Limiter/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ump_Wp_Limiter
 * @subpackage Ump_Wp_Limiter/admin
 * @author     Zzani Web Studio <dev@zzani.com>
 */
class Ump_Wp_Limiter_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ump_Wp_Limiter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ump_Wp_Limiter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ump-wp-limiter-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ump_Wp_Limiter_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ump_Wp_Limiter_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ump-wp-limiter-admin.js', array( 'jquery' ), $this->version, false );

	}

	private $ump_wp_limiter_options;

	public function ump_wp_limiter_add_plugin_page() {
		add_menu_page(
			'Ump Wp Limiter', // page_title
			'Ump Wp Limiter', // menu_title
			'manage_options', // capability
			'ump-wp-limiter', // menu_slug
			array( $this, 'ump_wp_limiter_create_admin_page' ), // function
			'dashicons-forms', // icon_url
			80 // position
		);
	}

	public function ump_wp_limiter_create_admin_page() {
		$this->ump_wp_limiter_options = get_option( 'ump_wp_limiter_option_name' ); ?>

		<div class="wrap">
			<h2>Ump Wp Limiter</h2>
			<p></p>
			<?php settings_errors(); ?>

			<form method="post" action="options.php">
				<?php
					settings_fields( 'ump_wp_limiter_option_group' );
					do_settings_sections( 'ump-wp-limiter-admin' );
					submit_button();
				?>
			</form>
		</div>
	<?php }

	public function ump_wp_limiter_page_init() {
		register_setting(
			'ump_wp_limiter_option_group', // option_group
			'ump_wp_limiter_option_name', // option_name
			array( $this, 'ump_wp_limiter_sanitize' ) // sanitize_callback
		);

		add_settings_section(
			'ump_wp_limiter_setting_section', // id
			'Settings', // title
			array( $this, 'ump_wp_limiter_section_info' ), // callback
			'ump-wp-limiter-admin' // page
		);

		add_settings_field(
			'custom_message_text_0', // id
			'Custom message text', // title
			array( $this, 'custom_message_text_0_callback' ), // callback
			'ump-wp-limiter-admin', // page
			'ump_wp_limiter_setting_section' // section
		);

		add_settings_field(
			'custom_button_text_1', // id
			'Custom button text', // title
			array( $this, 'custom_button_text_1_callback' ), // callback
			'ump-wp-limiter-admin', // page
			'ump_wp_limiter_setting_section' // section
		);

		add_settings_field(
			'custom_button_url_2', // id
			'Custom button url', // title
			array( $this, 'custom_button_url_2_callback' ), // callback
			'ump-wp-limiter-admin', // page
			'ump_wp_limiter_setting_section' // section
		);

		add_settings_field( 
			'custom_page_redirect_3', 
			'Tutor after login page redirect', 
			array( $this, 'umpl_wp_limiter_wp_dropdown_pages' ), 
			'ump-wp-limiter-admin', 
			'ump_wp_limiter_setting_section' 
		);
	}

	public function ump_wp_limiter_sanitize($input) {
		$sanitary_values = array();
		if ( isset( $input['custom_message_text_0'] ) ) {
			$sanitary_values['custom_message_text_0'] = sanitize_text_field( $input['custom_message_text_0'] );
		}

		if ( isset( $input['custom_button_text_1'] ) ) {
			$sanitary_values['custom_button_text_1'] = sanitize_text_field( $input['custom_button_text_1'] );
		}

		if ( isset( $input['custom_button_url_2'] ) ) {
			$sanitary_values['custom_button_url_2'] = sanitize_text_field( $input['custom_button_url_2'] );
		}

		if ( isset( $input['custom_page_redirect_3'] ) ) {
			$sanitary_values['custom_page_redirect_3'] = sanitize_text_field( $input['custom_page_redirect_3'] );
		}

		return $sanitary_values;
	}

	public function ump_wp_limiter_section_info() {
		
	}

	public function custom_message_text_0_callback() {
		printf(
			'<input class="regular-text" type="text" name="ump_wp_limiter_option_name[custom_message_text_0]" id="custom_message_text_0" value="%s">',
			isset( $this->ump_wp_limiter_options['custom_message_text_0'] ) ? esc_attr( $this->ump_wp_limiter_options['custom_message_text_0']) : ''
		);
	}

	public function custom_button_text_1_callback() {
		printf(
			'<input class="regular-text" type="text" name="ump_wp_limiter_option_name[custom_button_text_1]" id="custom_button_text_1" value="%s">',
			isset( $this->ump_wp_limiter_options['custom_button_text_1'] ) ? esc_attr( $this->ump_wp_limiter_options['custom_button_text_1']) : ''
		);
	}

	public function custom_button_url_2_callback() {
		printf(
			'<input class="regular-text" type="text" name="ump_wp_limiter_option_name[custom_button_url_2]" id="custom_button_url_2" value="%s">',
			isset( $this->ump_wp_limiter_options['custom_button_url_2'] ) ? esc_attr( $this->ump_wp_limiter_options['custom_button_url_2']) : ''
		);
	}

	public function umpl_wp_limiter_webinar_list(){
		$uid = get_current_user_id();
		$MemberAddEdit = new \Indeed\Ihc\Admin\MemberAddEdit();
		$data = $MemberAddEdit->setUid( $uid )->getUserData();
		$data['subscriptions'] = \Indeed\Ihc\UserSubscriptions::getAllForUser( $uid, false );
		$webinars_limit = 0;
		$webinars_user_count = count_user_posts($uid, 'wswebinars');
		$ump_wp_limiter_options = get_option( 'ump_wp_limiter_option_name' );

		foreach ($data['subscriptions'] as $subscription) {
		    $subscriptionMetas = \Indeed\Ihc\Db\UserSubscriptionsMeta::getAllForSubscription( $subscription['id'] );
		    if ( !empty( $subscriptionMetas['webinars_limit'] ) ){
			    $webinars_limit = $webinars_limit + $subscriptionMetas['webinars_limit'];
		    }
		
		}

		if ( !current_user_can( 'administrator' ) && $webinars_limit <= $webinars_user_count ) {
			?>
			<style>
				.wpws-203.wpws-177.wpws-188.wpws-189.wpws-191.wpws-192{
				  display: none !important;
				}
			</style>
			<?php
		}
	}

	public function umpl_wp_limiter_webinar_hide_paid_webinar(){
		$uid = get_current_user_id();
		$MemberAddEdit = new \Indeed\Ihc\Admin\MemberAddEdit();
		$data = $MemberAddEdit->setUid( $uid )->getUserData();
		$data['subscriptions'] = \Indeed\Ihc\UserSubscriptions::getAllForUser( $uid, false );
		$show_paid_webinar = '';

		foreach ($data['subscriptions'] as $subscription) {
		    $subscriptionMetas = \Indeed\Ihc\Db\UserSubscriptionsMeta::getAllForSubscription( $subscription['id'] );
		    $show_paid_webinar = $subscriptionMetas['webinars_limit'];
		
		}

		if ( !current_user_can( 'administrator' ) && $show_paid_webinar == 'on' ) {
			?>
			<script>
				jQuery(window).load(function(){
					umpl_wp_limiter_hide_paid_webinar();
				});
			</script>
			<?php
		}
	}

	public function umpl_wp_limiter_pre_get_posts($wp_query){
		if ( !current_user_can('administrator') && !current_user_can('editor') ) {
			if ( is_admin() ) {
				$wp_query->set( 'author', get_current_user_id() );
			}
		}

		return $wp_query;
	}

	public function umpl_wp_limiter_level_admin_html(){
		if(isset($_REQUEST['edit_level']) || isset($_REQUEST['new_level'])){
			if(isset($_REQUEST['edit_level'])){
				$level_data = \Indeed\Ihc\Db\Memberships::getOne( $_REQUEST['edit_level'] );
				$webinars_limit = 0;

			    if ( !empty( $level_data['webinars_limit'] ) ){
					$webinars_limit = $level_data['webinars_limit'];				    
			    }
				//$show_paid_webinar = $level_data['show_paid_webinar'];
				?>
				<script>
					jQuery(document).ready(function($) {
						umpl_wp_limiter_custom_fields(<?php echo $webinars_limit; ?>);
					});
				</script>
				<?php
			}else{
				?>
				<script>
					jQuery(document).ready(function($) {
						umpl_wp_limiter_custom_fields();
					});
				</script>
				<?php
			}

		}
	}

	public function umpl_wp_limiter_wp_dropdown_pages(){
		$ump_wp_limiter_options = get_option( 'ump_wp_limiter_option_name' );
		$dropdown_args = array(
	        'selected'         => $ump_wp_limiter_options['custom_page_redirect_3'],
	        'name'             => 'ump_wp_limiter_option_name[custom_page_redirect_3]',
	    );
		wp_dropdown_pages( $dropdown_args );
	}

	public function umpl_wp_limiter_hide_notices_dashboard() {
	    global $wp_filter;

	    if (current_user_can('tutor_instructor')) {
		    if (is_network_admin() and isset($wp_filter["network_admin_notices"])) {
		        unset($wp_filter['network_admin_notices']);
		    } elseif(is_user_admin() and isset($wp_filter["user_admin_notices"])) {
		        unset($wp_filter['user_admin_notices']);
		    } else {
		        if(isset($wp_filter["admin_notices"])) {
		            unset($wp_filter['admin_notices']);
		        }
		    }
		 
		    if (isset($wp_filter["all_admin_notices"])) {
		        unset($wp_filter['all_admin_notices']);
		    }
	    }
	 
	}

}
