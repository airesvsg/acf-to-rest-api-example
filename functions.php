<?php

// Registered field groups will not appear in the list of editable field groups.
require_once get_template_directory() . '/acf-fields.php';

add_action( 'wp_enqueue_scripts', function() {
	$assets_dir = get_template_directory_uri() . '/assets/';

	wp_enqueue_style( 'bootstrap', $assets_dir . 'css/bootstrap.min.css' );
	wp_enqueue_style( 'bootstrap-datepicker3', $assets_dir . 'css/bootstrap-datepicker3.min.css', array( 'bootstrap' ) );
	wp_enqueue_style( 'bootstrap-colorpicker', $assets_dir . 'css/bootstrap-colorpicker.min.css', array( 'bootstrap' ) );
	wp_enqueue_style( 'style', get_stylesheet_uri() );	

	wp_enqueue_script( 'script', $assets_dir . 'js/script.js', array( 'jquery' ), false, true );
	wp_localize_script( 'script', 'WP_API_Settings', array( 'root' => esc_url_raw( rest_url() ), 'nonce' => wp_create_nonce( 'wp_rest' ) ) );

	wp_enqueue_script( 'bootstrap', $assets_dir . 'js/bootstrap.min.js', array( 'script' ), false, true );
	wp_enqueue_script( 'bootstrap-datepicker', $assets_dir . 'js/bootstrap-datepicker.min.js', array( 'bootstrap' ), false, true );
	wp_enqueue_script( 'bootstrap-colorpicker', $assets_dir . 'js/bootstrap-colorpicker.min.js', array( 'bootstrap' ), false, true );
	wp_enqueue_script( 'google-maps', 'https://maps.googleapis.com/maps/api/js?v=3.11&sensor=false&libraries=places' );
} );

function _checked( $haystack, $current, $echo = true ) {
	if ( is_array( $haystack ) ) {
		if ( in_array( $current, $haystack ) ) {
			$current = $haystack = true;
		} else {
			$current = ! ( $haystack = true );
		}
	}

	return checked( $haystack, $current, $echo );
}