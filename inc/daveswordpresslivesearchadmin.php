<?php

namespace com\davidmichaelross\DavesWordPressLiveSearch;

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Cannot access pages directly.' );
}

define( __NAMESPACE__ . '\option_group', 'daves-wordpress-live-search' );
define( __NAMESPACE__ . '\SETTINGS_PAGE_SLUG', 'daves-wordpress-live-search' );

/**
 * Contains the slug of the settings page once it's registered
 *
 * @var
 */
$_settings_page_hook = '';


/**
 * @param $options
 *
 * @return mixed
 */
function default_id_from_name( $options ) {
	return isset( $options['id'] ) ? $options : array_merge( array( 'id' => $options['name'] ), $options );
}

function admin_enqueue_scripts() {

	wp_enqueue_style( 'wp-color-picker' );

	wp_enqueue_script(
		'daves-wordpress-live-search-color-picker',
		DWLS_TNG_URL . '/js/src/color-picker.js',
		array( 'wp-color-picker' ),
		DWLS_TNG_VERSION,
		true
	);

}

add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\admin_enqueue_scripts' );

function add_settings_page() {
	$GLOBALS['_settings_page_hook'] = add_options_page(
		'Live Search',
		'Live Search',
		'manage_options',
		SETTINGS_PAGE_SLUG,
		__NAMESPACE__ . '\render_page'
	);
}

add_action( 'admin_menu', __NAMESPACE__ . '\add_settings_page' );

function register_settings() {

	add_settings_section(
		option_group,
		'',
		'__return_empty_string',
		$GLOBALS['_settings_page_hook']
	);

	// Headlines & Messages
	register_setting( option_group, $GLOBALS['_settings_page_hook'] . '_max_results', 'absint' );
	register_setting( option_group, $GLOBALS['_settings_page_hook'] . '_results_direction', __NAMESPACE__ . '\validate_results_direction' );
	register_setting( option_group, $GLOBALS['_settings_page_hook'] . '_minchars', 'absint' );
	register_setting( option_group, $GLOBALS['_settings_page_hook'] . '_display_post_meta', __NAMESPACE__ . '\validate_boolean_string' );
	register_setting( option_group, $GLOBALS['_settings_page_hook'] . '_display_thumbnail', __NAMESPACE__ . '\validate_boolean_string' );
	register_setting( option_group, $GLOBALS['_settings_page_hook'] . '_display_excerpt', __NAMESPACE__ . '\validate_boolean_string' );
	register_setting( option_group, $GLOBALS['_settings_page_hook'] . '_excerpt_length', 'absint' );
	register_setting( option_group, $GLOBALS['_settings_page_hook'] . '_more_results', __NAMESPACE__ . '\validate_boolean_string' );
	register_setting( option_group, $GLOBALS['_settings_page_hook'] . '_results_width', 'absint' );
	register_setting( option_group, $GLOBALS['_settings_page_hook'] . '_title_color', __NAMESPACE__ . '\sanitize_hex_color' );
	register_setting( option_group, $GLOBALS['_settings_page_hook'] . '_fg_color', __NAMESPACE__ . '\sanitize_hex_color' );
	register_setting( option_group, $GLOBALS['_settings_page_hook'] . '_bg_color', __NAMESPACE__ . '\sanitize_hex_color' );
	register_setting( option_group, $GLOBALS['_settings_page_hook'] . '_hover_bg_color', __NAMESPACE__ . '\sanitize_hex_color' );
	register_setting( option_group, $GLOBALS['_settings_page_hook'] . '_divider_color', __NAMESPACE__ . '\sanitize_hex_color' );
	register_setting( option_group, $GLOBALS['_settings_page_hook'] . '_footer_bg_color', __NAMESPACE__ . '\sanitize_hex_color' );
	register_setting( option_group, $GLOBALS['_settings_page_hook'] . '_footer_fg_color', __NAMESPACE__ . '\sanitize_hex_color' );
	register_setting( option_group, $GLOBALS['_settings_page_hook'] . '_shadow', __NAMESPACE__ . '\validate_boolean_string' );

	add_settings_field(
		$GLOBALS['_settings_page_hook'] . '_max_results',
		'Max # results',
		__NAMESPACE__ . '\text_field',
		$GLOBALS['_settings_page_hook'],
		option_group,
		array(
			'name'  => $GLOBALS['_settings_page_hook'] . '_max_results',
			'type'  => 'number',
			'value' => get_option( $GLOBALS['_settings_page_hook'] . '_max_results', 10 ),
		)
	);

	add_settings_field(
		$GLOBALS['_settings_page_hook'] . '_results_direction',
		'Results direction',
		__NAMESPACE__ . '\select_field',
		$GLOBALS['_settings_page_hook'],
		option_group,
		array(
			'name'    => $GLOBALS['_settings_page_hook'] . '_results_direction',
			'options' => array( 'up' => 'Up', 'down' => 'Down' ),
			'value'   => get_option( $GLOBALS['_settings_page_hook'] . '_results_direction', 'down' ),
		)
	);

	add_settings_field(
		$GLOBALS['_settings_page_hook'] . '_minchars',
		'Minimum characters to search',
		__NAMESPACE__ . '\text_field',
		$GLOBALS['_settings_page_hook'],
		option_group,
		array(
			'name'  => $GLOBALS['_settings_page_hook'] . '_minchars',
			'value' => get_option( $GLOBALS['_settings_page_hook'] . '_minchars', '3' ),
			'type'  => 'number',
		)
	);

	add_settings_section(
		option_group,
		'Design',
		'__return_empty_string',
		$GLOBALS['_settings_page_hook']
	);

	add_settings_field(
		$GLOBALS['_settings_page_hook'] . '_display_post_meta',
		'Display post metadata',
		__NAMESPACE__ . '\checkbox_field',
		$GLOBALS['_settings_page_hook'],
		option_group,
		array(
			'name'  => $GLOBALS['_settings_page_hook'] . '_display_post_meta',
			'value' => get_option( $GLOBALS['_settings_page_hook'] . '_display_post_meta', 'true' ),
		)
	);

	add_settings_field(
		$GLOBALS['_settings_page_hook'] . '_display_thumbnail',
		'Display thumbnail',
		__NAMESPACE__ . '\checkbox_field',
		$GLOBALS['_settings_page_hook'],
		option_group,
		array(
			'name'  => $GLOBALS['_settings_page_hook'] . '_display_thumbnail',
			'value' => get_option( $GLOBALS['_settings_page_hook'] . '_display_thumbnail', 'true' ),
		)
	);

	add_settings_field(
		$GLOBALS['_settings_page_hook'] . '_display_excerpt',
		'Display excerpt',
		__NAMESPACE__ . '\checkbox_field',
		$GLOBALS['_settings_page_hook'],
		option_group,
		array(
			'name'  => $GLOBALS['_settings_page_hook'] . '_display_excerpt',
			'value' => get_option( $GLOBALS['_settings_page_hook'] . '_display_excerpt', 'true' ),
		)
	);

	add_settings_field(
		$GLOBALS['_settings_page_hook'] . '_excerpt_length',
		'Excerpt length',
		__NAMESPACE__ . '\text_field',
		$GLOBALS['_settings_page_hook'],
		option_group,
		array(
			'name'  => $GLOBALS['_settings_page_hook'] . '_excerpt_length',
			'value' => get_option( $GLOBALS['_settings_page_hook'] . '_excerpt_length', 30 ),
		)
	);

	add_settings_field(
		$GLOBALS['_settings_page_hook'] . '_more_results',
		'Show "more results" link',
		__NAMESPACE__ . '\checkbox_field',
		$GLOBALS['_settings_page_hook'],
		option_group,
		array(
			'name'  => $GLOBALS['_settings_page_hook'] . '_more_results',
			'value' => get_option( $GLOBALS['_settings_page_hook'] . '_more_results', 'true' ),
		)
	);

	add_settings_field(
		$GLOBALS['_settings_page_hook'] . '_results_width',
		'Results box width',
		__NAMESPACE__ . '\text_field',
		$GLOBALS['_settings_page_hook'],
		option_group,
		array(
			'name'  => $GLOBALS['_settings_page_hook'] . '_results_width',
			'value' => get_option( $GLOBALS['_settings_page_hook'] . '_results_width', '300' ),
			'type'  => 'number',
		)
	);

	add_settings_field(
		$GLOBALS['_settings_page_hook'] . '_title_color',
		'Title color',
		__NAMESPACE__ . '\text_field',
		$GLOBALS['_settings_page_hook'],
		option_group,
		array(
			'name'  => $GLOBALS['_settings_page_hook'] . '_title_color',
			'value' => get_option( $GLOBALS['_settings_page_hook'] . '_title_color', '#aaaadd' ),
			'class' => 'dwls_color_picker',
		)
	);

	add_settings_field(
		$GLOBALS['_settings_page_hook'] . '_fg_color',
		'Text color',
		__NAMESPACE__ . '\text_field',
		$GLOBALS['_settings_page_hook'],
		option_group,
		array(
			'name'  => $GLOBALS['_settings_page_hook'] . '_fg_color',
			'value' => get_option( $GLOBALS['_settings_page_hook'] . '_fg_color', '#aaaadd' ),
			'class' => 'dwls_color_picker',
		)
	);

	add_settings_field(
		$GLOBALS['_settings_page_hook'] . '_bg_color',
		'Background color',
		__NAMESPACE__ . '\text_field',
		$GLOBALS['_settings_page_hook'],
		option_group,
		array(
			'name'  => $GLOBALS['_settings_page_hook'] . '_bg_color',
			'value' => get_option( $GLOBALS['_settings_page_hook'] . '_bg_color', '#111133' ),
			'class' => 'dwls_color_picker',
		)
	);

	add_settings_field(
		$GLOBALS['_settings_page_hook'] . '_hover_bg_color',
		'Hover background color',
		__NAMESPACE__ . '\text_field',
		$GLOBALS['_settings_page_hook'],
		option_group,
		array(
			'name'  => $GLOBALS['_settings_page_hook'] . '_hover_bg_color',
			'value' => get_option( $GLOBALS['_settings_page_hook'] . '_hover_bg_color', '#444477' ),
			'class' => 'dwls_color_picker',
		)
	);

	add_settings_field(
		$GLOBALS['_settings_page_hook'] . '_divider_color',
		'Divider color',
		__NAMESPACE__ . '\text_field',
		$GLOBALS['_settings_page_hook'],
		option_group,
		array(
			'name'  => $GLOBALS['_settings_page_hook'] . '_divider_color',
			'value' => get_option( $GLOBALS['_settings_page_hook'] . '_divider_color', '#111122' ),
			'class' => 'dwls_color_picker',
		)
	);

	add_settings_field(
		$GLOBALS['_settings_page_hook'] . '_footer_bg_color',
		'Footer background color',
		__NAMESPACE__ . '\text_field',
		$GLOBALS['_settings_page_hook'],
		option_group,
		array(
			'name'  => $GLOBALS['_settings_page_hook'] . '_footer_bg_color',
			'value' => get_option( $GLOBALS['_settings_page_hook'] . '_footer_bg_color', '#555577' ),
			'class' => 'dwls_color_picker',
		)
	);

	add_settings_field(
		$GLOBALS['_settings_page_hook'] . '_footer_fg_color',
		'Footer foreground color',
		__NAMESPACE__ . '\text_field',
		$GLOBALS['_settings_page_hook'],
		option_group,
		array(
			'name'  => $GLOBALS['_settings_page_hook'] . '_footer_fg_color',
			'value' => get_option( $GLOBALS['_settings_page_hook'] . '_footer_fg_color', '#ffffff' ),
			'class' => 'dwls_color_picker',
		)
	);

	add_settings_field(
		$GLOBALS['_settings_page_hook'] . '_shadow',
		'Shadow',
		__NAMESPACE__ . '\checkbox_field',
		$GLOBALS['_settings_page_hook'],
		option_group,
		array(
			'name'  => $GLOBALS['_settings_page_hook'] . '_shadow',
			'value' => get_option( $GLOBALS['_settings_page_hook'] . '_shadow', 'false' ),
		)
	);

}

add_action( 'admin_init', __NAMESPACE__ . '\register_settings' );

/**
 * @param array $extras
 *
 * @return array
 */
function default_input_field_attributes( array $extras = array() ) {
	return array_merge( array_flip( array( 'name', 'class', 'value' ) ), $extras );
}

function text_field( $options ) {

	$options = array_merge(
		default_input_field_attributes( array( 'type' => 'text' ) ),
		default_id_from_name( $options )
	);

	echo '<input type="' . esc_attr( $options['type'] ) . '" id="' . esc_attr( $options['id'] ) . '" name="' . esc_attr( $options['name'] ) . '" value="' . esc_attr( $options['value'] ) . '" class="' . esc_attr( $options['class'] ) . '" />';

}

/**
 * @param array $options
 */
function select_field( array $options ) {

	$options = array_merge(
		default_input_field_attributes( array( 'options' => array() ) ),
		default_id_from_name( $options )
	);

	echo '<select id="' . esc_attr( $options['id'] ) . '" name="' . esc_attr( $options['name'] ) . '">' .
	     wp_kses( render_select_options( $options['options'], $options['value'] ), array( 'option' => array( 'value' => array(), 'selected' => array() ) ) ) .
	     '</select>';

}

/**
 * @param array $options Associative array of select options
 *
 * @return string HTML
 * @uses selected renders selected="selected" attribute if values match
 */
function render_select_options( array $options, $selected_value = null ) {

	$html = '';

	return ( array_walk(
		$options,
		function ( $label, $value ) use ( &$html, $selected_value ) {
			$html .= '<option value="' . esc_attr( $value ) . '" ' . selected( $selected_value, $value, false ) . '>' . esc_html( $label ) . '</option>';
		}
	) ) ? $html : '';

}


/**
 * @param array $options
 *
 * @uses checked
 */
function checkbox_field( array $options ) {

	$options = array_merge(
		default_input_field_attributes(),
		default_id_from_name( $options )
	);

	echo '<input type="hidden" name="' . esc_attr( $options['name'] ) . '" id="' . esc_attr( $options['id'] ) . '" value="false" />' .
	     '<input type="checkbox" name="' . esc_attr( $options['name'] ) . '" id="' . esc_attr( $options['id'] ) . '" class="' . esc_attr( $options['class'] ) . '" value="true" ' . checked( 'true', $options['value'], false ) . '/>';

}


function render_page() {
	global $_settings_page_hook;
	include DWLS_TNG_PATH . '/tpl/admin-form.tpl.php';
}

function validate_results_direction( $value ) {
	return ( 'up' === $value ) ? 'up' : 'down';
}

function validate_boolean_string( $value ) {
	return ( 'true' === $value ) ? 'true' : 'false';
}

/**
 * Sanitize a three or six digit hex color code with leading '#'.
 * @see sanitize_hex_color_no_hash() in WP core for santizing values without a '#'
 *
 * @param string $color hex value with leading '#'
 *
 * @return string color or ''
 */
function sanitize_hex_color( $color = '' ) {

	if ( '' === $color || ! is_string( $color ) ) {
		return '';
	}

	return preg_match( '/^#([0-9a-fA-F]{3}){1,2}$/', $color ) ? $color : '';

}
