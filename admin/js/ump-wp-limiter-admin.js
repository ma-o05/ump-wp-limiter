(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */


})( jQuery );

function umpl_wp_limiter_custom_fields(webinars_limit = null){
	var html = '<div class="iump-form-line iump-no-border"><div class="row"><div class="col-xs-4"><div class="input-group"><h4>Limite de webinars</h4><input name="webinars_limit" type="number" value="'+webinars_limit+'" class="ihc-plan-details-price-text"></div></div></div></div>';
	jQuery('.ihc-plan-details-wrapper').append(html);
}