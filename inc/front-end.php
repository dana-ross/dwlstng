<?php

namespace com\davidmichaelross\DavesWordPressLiveSearch;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

define( __NAMESPACE__ . '\FRONT_END_ENDPOINT', 'dwls-ajax' );
define( __NAMESPACE__ . '\FIRST_IMG_META_FIELD', 'dwls_first_image' );

function register_front_end_hooks() {

	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\wp_enqueue_styles' );
	add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\wp_enqueue_scripts' );
	add_action( 'init', __NAMESPACE__ . '\init' );
	add_filter( 'query_vars', __NAMESPACE__ . '\add_query_vars' );
	add_filter( 'parse_request', __NAMESPACE__ . '\parse_request' );
	add_action( 'template_redirect', __NAMESPACE__ . '\template_redirect' );
	add_action( 'save_post', __NAMESPACE__ . '\update_first_image_postmeta', 10, 2 );

}

if ( ! defined( 'DWLS_UNIT_TEST' ) ) {
	register_front_end_hooks();
}

function wp_enqueue_styles() {

	wp_enqueue_style(
		'daves-wordpress-live-search',
		DWLS_TNG_URL . '/css/src/daves-wordpress-live-search.css',
		array(),
		DWLS_TNG_VERSION,
		'screen'
	);

	wp_add_inline_style(
		'daves-wordpress-live-search',
		generate_theme_css()
	);

}

function generate_theme_css() {

	$GLOBALS['_settings_page_hook'] = 'settings_page_daves-wordpress-live-search';

	$results_width   = get_option( $GLOBALS['_settings_page_hook'] . '_results_width', 300 );
	$title_color     = get_option( $GLOBALS['_settings_page_hook'] . '_title_color' );
	$fg_color        = get_option( $GLOBALS['_settings_page_hook'] . '_fg_color' );
	$bg_color        = get_option( $GLOBALS['_settings_page_hook'] . '_bg_color' );
	$hover_bg_color  = get_option( $GLOBALS['_settings_page_hook'] . '_hover_bg_color' );
	$divider_color   = get_option( $GLOBALS['_settings_page_hook'] . '_divider_color' );
	$footer_bg_color = get_option( $GLOBALS['_settings_page_hook'] . '_footer_bg_color' );
	$footer_fg_color = get_option( $GLOBALS['_settings_page_hook'] . '_footer_fg_color' );
	$shadow          = get_option( $GLOBALS['_settings_page_hook'] . '_shadow', false );

	ob_start();
	include DWLS_TNG_PATH . '/tpl/custom.tpl.php';

	return ob_get_clean();

}

function wp_enqueue_scripts() {

	wp_enqueue_script(
		'qsa-polyfill-ie7',
		DWLS_TNG_URL . '/js/src/qsa-polyfill-ie7.js',
		array(),
		'1.0',
		true
	);

	wp_enqueue_script(
		'daves-wordpress-live-search',
		DWLS_TNG_URL . '/js/src/daves-wordpress-live-search.js',
		array( 'underscore', 'qsa-polyfill-ie7' ),
		DWLS_TNG_VERSION,
		true
	);

	$settings = array(
		'endpoint'  => home_url( FRONT_END_ENDPOINT ),
		'templates' => array(
			'search-results' => file_get_contents( DWLS_TNG_PATH . '/tpl/search-results.tpl.ejs' ),
		),
		'settings'  => array(
			'offsets'        => array(
				'x' => intval( get_option( 'daves-wordpress-live-search_xoffset', 0 ) ),
				'y' => intval( get_option( 'daves-wordpress-live-search_yoffset', 0 ) ),
			),
			'min_chars'      => intval( get_option( 'daves-wordpress-live-search_minchars', 3 ) ),
			'max_results'    => intval( get_option( 'daves-wordpress-live-search_max_results', 0 ) ),
			'design'         => array(
				'show_thumbs'       => (bool) get_option( 'daves-wordpress-live-search_thumbs', true ),
				'show_excerpt'      => (bool) get_option( 'daves-wordpress-live-search_excerpt', true ),
				'show_metadata'     => (bool) get_option( 'daves-wordpress-live-search_display_post_meta', true ),
				'more_results_link' => (bool) get_option( 'daves-wordpress-live-search_more_results', true ),
				'results_direction' => stripslashes( get_option( 'daves-wordpress-live-search_results_direction', 'down' ) ),
			),
			'excerpt_length' => intval( get_option( 'daves-wordpress-live-search_excerpt_length', 30 ) ),
		),
	);

	wp_localize_script(
		'daves-wordpress-live-search',
		'DavesWordPressLiveSearch',
		$settings
	);

}

function init() {

	add_rewrite_rule( rewrite_endpoint(), rewrite_query_string(), 'top' );

}

function rewrite_endpoint() {
	return FRONT_END_ENDPOINT . '/([^/]*)';
}

function rewrite_query_string() {
	return 'index.php?' . FRONT_END_ENDPOINT . '=$matches[1]';
}

function add_query_vars( $vars ) {

	$vars[] = FRONT_END_ENDPOINT;

	return $vars;

}

function parse_request( $wp_query ) {

	if ( ! isset( $wp_query->query_vars[ FRONT_END_ENDPOINT ] ) ) {
		return $wp_query;
	}

	$wp_query->query_vars['s'] = $wp_query->query_vars[ FRONT_END_ENDPOINT ];

	return $wp_query;

}

function template_redirect() {

	global $wp_query;

	if ( ! isset( $wp_query->query_vars[ FRONT_END_ENDPOINT ] ) ) {
		return;
	}

	try {
		wp_send_json_success( do_search() );
	} catch ( \Exception $e ) {
		wp_send_json_error( $e->getMessage() );
	}

}

function do_search() {

	global $wp_query;

	$found_posts = $wp_query->get_posts();

	$post_data = array();
	foreach ( $found_posts as $post ) {

		$post_data[] = array(
			'ID'        => $post->ID,
			'title'     => $post->post_title,
			'excerpt'   => wp_trim_words( $post->post_content, 55, false ),
			'permalink' => get_permalink( $post->ID ),
			'date'      => $post->post_date,
			'post_type' => $post->post_type,
			'thumbnail' => get_post_thumbnail( $post ),
		);

	}

	return $post_data;

}


function get_post_thumbnail( $post ) {

	if ( function_exists( 'get_post_thumbnail_id' ) ) {

		// Support for WP 2.9 post thumbnails
		$postImageID     = get_post_thumbnail_id( $post->ID );
		$postImageData   = wp_get_attachment_image_src( $postImageID, apply_filters( 'post_image_size', 'thumbnail' ) );
		$hasThumbnailSet = ( $postImageData !== false );

	} else {

		// No support for post thumbnails
		$hasThumbnailSet = false;

	}

	if ( $hasThumbnailSet && isset( $postImageData[0] ) ) {

		$attachment_thumbnail = $postImageData[0];

	} else {

		$firstImageMeta = get_post_meta( $post->ID, FIRST_IMG_META_FIELD, true );
		if ( $firstImageMeta ) {
			$attachment_thumbnail = $firstImageMeta;
		} else {
			// If no post thumbnail, grab the first image from the post_date
			$attachment_thumbnail = update_first_image_postmeta( $post->ID, $post );
		}
	}

	return $attachment_thumbnail;

}

function update_first_image_postmeta( $post_id, $post ) {

	$parent_post = wp_is_post_revision( $post_id );
	if ( false !== $parent_post ) {
		$post_id = $parent_post;
		$post    = get_post( $parent_post, OBJECT );
	}

	$applyContentFilter = get_option( 'daves-wordpress-live-search_apply_content_filter', false );
	$content            = $post->post_content;
	if ( $applyContentFilter ) {
		$content = apply_filters( 'the_content', $content );
	}
	$content              = str_replace( ']]>', ']]&gt;', $content );
	$attachment_thumbnail = first_img( $content );
	update_post_meta( $post_id, FIRST_IMG_META_FIELD, $attachment_thumbnail );

	return $attachment_thumbnail;

}

function first_img( $post_content ) {

	$matches = array();
	preg_match_all( '/<img [^>]*src=["|\']([^"|\']+)/i', $post_content, $matches );

	if ( isset( $matches[1][0] ) ) {
		$first_img = $matches[1][0];
	}

	if ( empty( $first_img ) ) {
		return '';
	}

	return $first_img;

}

function daves_wordpress_live_search_activate() {
	init();
	flush_rewrite_rules();
}

function daves_wordpress_live_search_deactivate() {
	flush_rewrite_rules();
}

if ( ! defined( 'DWLS_UNIT_TEST' ) ) {
	register_activation_hook( __FILE__, __NAMESPACE__ . '\daves_wordpress_live_search_activate' );
	register_deactivation_hook( __FILE__, __NAMESPACE__ . '\daves_wordpress_live_search_deactivate' );
}
