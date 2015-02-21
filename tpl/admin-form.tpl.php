<?php
namespace com\davidmichaelross\DavesWordPressLiveSearch;

?>
<h2>Dave's WordPress Live Search</h2>
<form action="options.php" method="post" class="daves-wordpress-live-search-settings-form" style="max-width: 550px;">
	<?php
	settings_fields( option_group );
	do_settings_sections( $_settings_page_hook );

	submit_button( 'Submit' );
	?>
</form>