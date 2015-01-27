<?php

namespace com\davidmichaelross\DavesWordPressLiveSearch;

if ( ! defined( 'ABSPATH' ) ) {
	die( "Please don't try to access this file directly." );
}

?>

<style>
	#dwls-results {
		width: <?php echo absint($results_width); ?>px;
	}

	#dwls-results li {
		color: <?php echo \com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color($fg_color); ?>;
		background-color: <?php echo \com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color($bg_color); ?>;
		border-bottom: <?php echo \com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color($divider_color); ?>;
		<?php if('true' === \com\davidmichaelross\DavesWordPressLiveSearch\validate_boolean_string($shadow)) : ?>
		<?php endif; ?>
	}

	#dwls-results .dwls-result:hover {
		background-color: <?php echo \com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color($hover_bg_color); ?>;
	}

	#dwls-results .dwls_title {
		color: <?php echo sanitize_hex_color($title_color); ?>;
	}

	#dwls-results li.footer {
		color: <?php echo \com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color($footer_fg_color); ?>;
		background-color: <?php echo \com\davidmichaelross\DavesWordPressLiveSearch\sanitize_hex_color($footer_bg_color); ?>;
	}
</style>