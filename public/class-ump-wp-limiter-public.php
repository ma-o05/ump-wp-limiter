<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://zzani.com/
 * @since      1.0.0
 *
 * @package    Ump_Wp_Limiter
 * @subpackage Ump_Wp_Limiter/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Ump_Wp_Limiter
 * @subpackage Ump_Wp_Limiter/public
 * @author     Zzani Web Studio <dev@zzani.com>
 */
class Ump_Wp_Limiter_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ump-wp-limiter-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ump-wp-limiter-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'popper', 'https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js' );
		wp_enqueue_script( 'bootstrap', 'https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js' );

	}

	/**
	 * Show the webinar form if the user has not exceeded the membership limit
	 *
	 * @param array   {}
	 * @param string  Shortcode content.
	 *
	 * @return string HTML content to display the shortcode.
	 */
	public function umpl_wp_limiter( $atts, $content = null ) {
	    $atts = shortcode_atts( array(
	        'id' => 'umpl_wp_limiter',
	    ), $atts, 'umpl-wp-limiter' );

	    $uid = get_current_user_id();
	    $MemberAddEdit = new \Indeed\Ihc\Admin\MemberAddEdit();
	    $data = $MemberAddEdit->setUid( $uid )->getUserData();
	    $data['subscriptions'] = \Indeed\Ihc\UserSubscriptions::getAllForUser( $uid, false );
	    $webinars_limit = 0;
	    $webinars_user_count = count_user_posts($uid, 'wswebinars');
	    $ump_wp_limiter_options = get_option( 'ump_wp_limiter_option_name' );

	    foreach ($data['subscriptions'] as $subscription) {
	        $subscriptionMetas = \Indeed\Ihc\Db\UserSubscriptionsMeta::getAllForSubscription( $subscription['id'] );
	        $webinars_limit = $webinars_limit + $subscriptionMetas['webinars_limit'];
	    
	    }
	    if ($webinars_limit <= $webinars_user_count) {
	    	$html = '<div class="alert alert-danger">';
	    	$html .= sprintf( __('You have created <b>%1$s</b> of <b>%2$s</b> that your plan allows, %3$s'), $webinars_user_count, $webinars_limit, $ump_wp_limiter_options['custom_message_text_0'] );
	    	$html .= '<a href="'.$ump_wp_limiter_options['custom_button_url_2'].'" class="btn btn-primary btn-sm float-right">'.$ump_wp_limiter_options['custom_button_text_1'].'</a>';
	    	$html .= '</div>';
	    }else{
	    	$html = '<div class="alert alert-success">';
	    	$html .= sprintf( __('You have created <b>%1$s</b> of <b>%2$s</b> that your plan allows'), $webinars_user_count, $webinars_limit );
	    	$html .= '</div>';
	        $html .= do_shortcode($content);
	    }

	    return $html;

	}

}
