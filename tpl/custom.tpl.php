<?php

namespace com\davidmichaelross\DavesWordPressLiveSearch;

if ( ! defined( 'ABSPATH' ) ) {
	die( "Please don't try to access this file directly." );
}

?>

#dwls-results {
	width: <?php echo absint($results_width); ?>px;
}

#dwls-results .dwls-result {
	padding: .25em .5em;
	color: <?php echo \com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color($fg_color); ?>;
	background-color: <?php echo \com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color($bg_color); ?>;
	border-top: 1px solid <?php echo \com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color($divider_color); ?>;
	<?php if('true' === \com\davidmichaelross\DavesWordPressLiveSearch\validate_boolean_string($shadow)) : ?>
	<?php endif; ?>
}

#dwls-results .dwls-result:first-child {
	border-top: none;
}

#dwls-results .dwls-result a {
	color: <?php echo \com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color($fg_color); ?>;
	background-color: <?php echo \com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color($bg_color); ?>;
}

#dwls-results .dwls-result:hover {
	background-color: <?php echo \com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color($hover_bg_color); ?>;
}

#dwls-results li .dwls_title {
	color: <?php echo sanitize_hex_color($title_color); ?>;
}

#dwls-footer {
	padding: .25em .5em;
	color: <?php echo \com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color($footer_fg_color); ?>;
	background-color: <?php echo \com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color($footer_bg_color); ?>;
}

#dwls-footer a {
	color: <?php echo \com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color($footer_fg_color); ?>;
	background-color: <?php echo \com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color($footer_bg_color); ?>;
}
