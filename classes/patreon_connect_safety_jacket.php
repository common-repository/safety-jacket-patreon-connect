<?php

/*
Plugin Name: Patreon Connect: Safety Jacket
Plugin URI:https://uiux.me/patreon-connect-safety-jacket
Description: A safety jacket for Patreon Connect
Version: 1.0
Author: UIUX <me@uiux.me>
Author URI: https://uiux.me
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

class Patreon_Connect_Safety_Jacket {


	function __construct() {
		add_action('init', array($this,'triggerFailsafe'));
	}

	function triggerFailsafe() {

		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

		if(!class_exists('Patreon_Wordpress') || is_plugin_active( 'patreon-wordpress/patreon.php' ) == false ) {
			add_filter('the_content', array($this, 'protectPostContent'), PHP_INT_MAX);
			add_shortcode( 'patreon_content', array($this, 'renderProtectedContent') );
			add_shortcode( 'patreon_register_button', array($this, 'renderTextLink') );
			if(get_option('patreon-safety-jacket-walled-garden', false)) {
				add_action( 'wp', array($this, 'patreonWalledGarden') );
			}
		}

	}

	function protectPostContent($the_content) {

		global $post;

		if(isset($post->ID)) {

			$patreon_level = get_post_meta($post->ID, 'patreon-level', true);

			if(is_numeric($patreon_level) && $patreon_level > 0) {
				$the_content = $this->renderProtectedContent();
			}

		}

		return $the_content;

	}

	function renderTextLink() {
		$creator_page_url = get_option('patreon-safety-jacket-creator-page-url', false);
		if($creator_page_url == false) {
			return '';
		}

		return '<a href="'.$creator_page_url.'" target="_blank">Support me on Patreon</a>';

	}

	function renderProtectedContent() {

		$html = '';

		$creator_id = get_option('patreon-safety-jacket-creator-id', false);

		if($creator_id == false) {
			$html = '';
		} else {
			$html = '<a href="https://www.patreon.com/bePatron?u='.$creator_id.'" data-patreon-widget-type="become-patron-button">Become a Patron!</a><script async src="https://c6.patreon.com/becomePatronButton.bundle.js"></script>';
		}

		if(get_option('patreon-safety-jacket-custom-banner', false)) {
			$html = get_option('patreon-safety-jacket-custom-banner-content', '');
		}

		return $html;

	}

	function patreonWalledGarden() {

		$walled_garden_page = get_option('patreon-safety-jacket-walled-garden-page', false);

		if($walled_garden_page == false || is_numeric($walled_garden_page) == false) {

			wp_redirect(home_url());
			exit;

		} else {

			if(is_user_logged_in() && is_admin() == false && current_user_can('manage_options') == false) {

				if(is_page($walled_garden_page) == false) {
					$url = get_permalink($walled_garden_page);
					wp_redirect($url);
					exit;
				}

			}

		}

	}


}


?>