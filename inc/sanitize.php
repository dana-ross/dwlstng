<?php

namespace com\davidmichaelross\DavesWordPressLiveSearch;

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
