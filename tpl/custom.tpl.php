<!--$footer_bg_color = sanitize_hex_color( get_option( $GLOBALS['_settings_page_hook'] . '_footer_bg_color' ) );-->
<!--$footer_fg_color = sanitize_hex_color( get_option( $GLOBALS['_settings_page_hook'] . '_footer_fg_color' ) );-->
<style>
#dwls-results {
	width: <?php echo absint($results_width); ?>;
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
	color: <?php sanitize_hex_color($title_color); ?>;
}
</style>