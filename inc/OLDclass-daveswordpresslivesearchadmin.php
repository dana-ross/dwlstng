<?php

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

class DavesWordPressLiveSearchAdmin {

	const SETTINGS_PAGE_SLUG = 'daves-wordpress-live-search';
	const OPTION_GROUP_DESIGN = 'live_search_design';

	function __construct() {

		add_action( 'admin_init', array( $this, 'admin_init' ) );
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
	}

	/**
	 * Include the Live Search options page in the admin menu
	 *
	 * @return void
	 */
	public static function admin_menu() {

		add_options_page( "Dave's WordPress Live Search Options", __( 'Live Search', 'dwls' ), 'manage_options', self::SETTINGS_PAGE_SLUG, array(
			'DavesWordPressLiveSearchAdmin',
			'plugin_options'
		) );

	}

	public static function admin_enqueue_scripts() {

		wp_enqueue_style( 'wp-color-picker' );

		wp_enqueue_script(
			'daves-wordpress-live-search-color-picker',
			DWLS_TNG_URL . '/js/src/color-picker.js',
			array( 'wp-color-picker' ),
			DWLS_TNG_VERSION,
			true
		);

	}

	public static function admin_init() {

		register_setting( self::OPTION_GROUP_DESIGN, 'daves-wordpress-live-search_results_width', 'absint' );
//
//		add_settings_section( self::OPTION_GROUP_DESIGN, 'Design', 'plugin_section_design', 'plugin' );
//		add_settings_field( 'plugin_text_string', 'Plugin Text Input', 'plugin_setting_string', 'plugin', 'plugin_main' );

		add_settings_section(
			'dwls_design',            // ID used to identify this section and with which to register options
			__( 'Design', 'dwls' ),        // Title to be displayed on the administration page
			array(__CLASS__, 'plugin_section_design'),    // Callback used to render the description of the section
			'general'
		);

		add_settings_field(
			'daves-wordpress-live-search_results_width',
			'Width',
			array(__CLASS__, 'render_settings_text_field'),
			'general',
			null,
			array(
				'name' => 'daves-wordpress-live-search_results_width',
			)
		);

	}

	public static function render_settings_text_field($options) {
		echo '<input type="text" name="'. esc_attr($options['name']).'" id="'.esc_attr($options['name']).'" />';
	}

	public static function plugin_section_design() {
//		echo '<p>' . __( 'Design', 'dwls' ) . '</p>';
	}

	public static function plugin_options() {

		if ( array_key_exists( 'daves-wordpress-live-search_submit', $_POST ) && current_user_can( 'manage_options' ) ) {
			check_admin_referer( 'daves-wordpress-live-search-config' );

			// Read their posted value
			$maxResults          = intval( $_POST['daves-wordpress-live-search_max_results'], 0 );
			$resultsDirection    = ( 'up' === $_POST['daves-wordpress-live-search_results_direction'] ) ? 'up' : 'down';
			$minCharsToSearch    = intval( $_POST['daves-wordpress-live-search_minchars'] );
			$xOffset             = intval( $_POST['daves-wordpress-live-search_xoffset'] );
			$yOffset             = intval( $_POST['daves-wordpress-live-search_yoffset'] );
			$applyContentFilter  = ( isset( $_POST['daves-wordpress-live-search_apply_content_filter'] ) && "true" == $_POST['daves-wordpress-live-search_apply_content_filter'] );
			$displayPostMeta     = ( 'true' === $_POST['daves-wordpress-live-search_display_post_meta'] );
			$showThumbs          = ( 'true' === $_POST['daves-wordpress-live-search_thumbs'] );
			$showExcerpt         = ( 'true' === $_POST['daves-wordpress-live-search_excerpt'] );
			$excerptLength       = $_POST['daves-wordpress-live-search_excerpt_length'];
			$showMoreResultsLink = ( 'true' === $_POST['daves-wordpress-live-search_more_results'] );

			$resultsWidth = absint( $_POST['daves-wordpress-live-search_results_width'] );
			$titleColor   = sanitize_text_field( $_POST['daves-wordpress-live-search_results_title'] );

			// Save the posted value in the database
			update_option( 'daves-wordpress-live-search_max_results', $maxResults );
			update_option( 'daves-wordpress-live-search_results_direction', $resultsDirection );
			update_option( 'daves-wordpress-live-search_minchars', $minCharsToSearch );
			update_option( 'daves-wordpress-live-search_xoffset', intval( $xOffset ) );
			update_option( 'daves-wordpress-live-search_yoffset', intval( $yOffset ) );
			update_option( 'daves-wordpress-live-search_apply_content_filter', $applyContentFilter );
			update_option( 'daves-wordpress-live-search_display_post_meta', (string) $displayPostMeta );
			update_option( 'daves-wordpress-live-search_thumbs', $showThumbs );
			update_option( 'daves-wordpress-live-search_excerpt', $showExcerpt );
			update_option( 'daves-wordpress-live-search_excerpt_length', $excerptLength );
			update_option( 'daves-wordpress-live-search_more_results', $showMoreResultsLink );

			update_option( 'daves-wordpress-live-search_results_width', $resultsWidth );
			update_option( 'daves-wordpress-live-search_results_title', $titleColor );

			$updateMessage = __( 'Options saved.', 'dwls' );
			echo "<div class=\"updated fade\"><p><strong>$updateMessage</strong></p></div>";
		} else {
			$maxResults          = intval( get_option( 'daves-wordpress-live-search_max_results', 5 ) );
			$resultsDirection    = stripslashes( get_option( 'daves-wordpress-live-search_results_direction', 'down' ) );
			$minCharsToSearch    = intval( get_option( 'daves-wordpress-live-search_minchars', 3 ) );
			$xOffset             = intval( get_option( 'daves-wordpress-live-search_xoffset', 0 ) );
			$yOffset             = intval( get_option( 'daves-wordpress-live-search_yoffset', 0 ) );
			$applyContentFilter  = (bool) get_option( 'daves-wordpress-live-search_apply_content_filter', false );
			$displayPostMeta     = (bool) get_option( 'daves-wordpress-live-search_display_post_meta', true );
			$showThumbs          = (bool) get_option( 'daves-wordpress-live-search_thumbs', true );
			$showExcerpt         = (bool) get_option( 'daves-wordpress-live-search_excerpt', true );
			$excerptLength       = intval( get_option( 'daves-wordpress-live-search_excerpt_length', 30 ) );
			$showMoreResultsLink = (bool) get_option( 'daves-wordpress-live-search_more_results', true );

			// Design settings
			$resultsWidth = absint( get_option( 'daves-wordpress-live-search_results_width' ), 500 );

		}

		include DWLS_TNG_PATH . '/tpl/admin-options.tpl.php';

	}

}

$DavesWordPressLiveSearchAdmin = new DavesWordPressLiveSearchAdmin();