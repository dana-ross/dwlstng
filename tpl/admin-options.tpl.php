<?php if ( !defined( 'ABSPATH' ) ) {
	die( "Cannot access files directly." );
} ?>

<?php include DWLS_TNG_PATH . '/tpl/admin-header.tpl.php'; ?>

<tr valign="top">
	<th scope="row"><?php _e( "Display Metadata", 'dwls' ); ?></th>

	<td>
		<input type="hidden" name="daves-wordpress-live-search_display_post_meta" value="" />
		<input type="checkbox" name="daves-wordpress-live-search_display_post_meta" id="daves-wordpress-live-search_display_post_meta" value="true" <?php checked( $displayPostMeta ); ?> />
		<label for="daves-wordpress-live-search_display_post_meta"><?php _e( "Display author & date for every search result", 'dwls' ); ?></label>
	</td>
</tr>

<!-- Display post thumbnail -->
<tr valign="top">
	<th scope="row"><?php _e( "Display Post Thumbnail", 'dwls' ); ?></th>

	<td>
		<input type="hidden" name="daves-wordpress-live-search_thumbs" value="" />
		<input type="checkbox" name="daves-wordpress-live-search_thumbs" id="daves-wordpress-live-search_thumbs" value="true" <?php checked( $showThumbs ); ?> />
		<label for="daves-wordpress-live-search_thumbs"><?php _e( "Display thumbnail images for every search result with at least one image", 'dwls' ); ?></label>
	</td>
</tr>

<!-- Display post excerpt -->
<tr valign="top">
	<th scope="row"><?php _e( "Display Post Excerpt", 'dwls' ); ?></th>

	<td>
		<input type="hidden" name="daves-wordpress-live-search_excerpt" value="" />
		<input type="checkbox" name="daves-wordpress-live-search_excerpt" id="daves-wordpress-live-search_excerpt" value="true" <?php checked( $showExcerpt ); ?> />
		<label for="daves-wordpress-live-search_excerpt"><?php printf( __( "Display an excerpt for every search result. If the post doesn't have one, use the first %s characters.", 'dwls' ), "<input type=\"text\" name=\"daves-wordpress-live-search_excerpt_length\" id=\"daves-wordpress-live-search_excerpt_length\" value=\"$excerptLength\" size=\"3\" />" ); ?></label>
	</td>
</tr>

<!-- Display 'more results' -->
<tr valign="top">
	<th scope="row"><?php _e( "Display &quot;View more results&quot; link", 'dwls' ); ?></th>

	<td>
		<input type="hidden" name="daves-wordpress-live-search_more_results" value="" />
		<input type="checkbox" name="daves-wordpress-live-search_more_results" id="daves-wordpress-live-search_more_results" value="true" <?php checked( $showMoreResultsLink ); ?> />
		<label for="daves-wordpress-live-search_more_results"><?php _e( "Display the &quot;View more results&quot; link after the search results.", 'dwls' ); ?></label>
	</td>
</tr>

<tr valign="top">
	<th scope="row"><?php _e( "Maximum Results to Display", 'dwls' ); ?></th>

	<td>
		<input type="text" name="daves-wordpress-live-search_max_results" id="daves-wordpress-live-search_max_results" value="<?php echo intval( $maxResults ); ?>" class="regular-text code" /><span class="setting-description"><?php _e( "Enter &quot;0&quot; to display all matching results", 'dwls' ); ?></span>
	</td>
</tr>

<tr valign="top">
	<th scope="row"><?php _e( "Minimum characters before searching", 'dwls' ); ?></th>

	<td>
		<select name="daves-wordpress-live-search_minchars">
			<option value="1" <?php selected( $minCharsToSearch, 1 ); ?>><?php _e( "Search right away", 'dwls' ); ?></option>
			<option value="2" <?php selected( $minCharsToSearch, 2 ); ?>><?php _e( "Wait for two characters", 'dwls' ); ?></option>
			<option value="3" <?php selected( $minCharsToSearch, 3 ); ?>><?php _e( "Wait for three characters", 'dwls' ); ?></option>
			<option value="4" <?php selected( $minCharsToSearch, 4 ); ?>><?php _e( "Wait for four characters", 'dwls' ); ?></option>
		</select>
	</td>
</tr>


<tr valign="top">
	<th scope="row"><?php _e( "Results Direction", 'dwls' ); ?></th>

	<td>
		<input type="radio" name="daves-wordpress-live-search_results_direction" id="daves-wordpress-live-search_results_direction_down" value="down" <?php checked( empty( $resultsDirection ) );
		checked( $resultsDirection, 'down' ); ?> />
		<label for="daves-wordpress-live-search_results_direction_down"><?php _e( "Down", 'dwls' ); ?></input></label>

		<input type="radio" name="daves-wordpress-live-search_results_direction" id="daves-wordpress-live-search_results_direction_up" value="up" <?php checked( $resultsDirection, 'up' ); ?> />
		<label for="daves-wordpress-live-search_results_direction_up"><?php _e( "Up", 'dwls' ); ?></label><br /><span class="setting-description"><?php _e( "When search results are displayed, in which direction should the results box extend from the search box?", 'dwls' ); ?></span>
	</td>
</tr>

<!-- CSS styles -->
<tr valign="top">
	<td colspan="2"><h3><?php _e( "Styles", 'dwls' ); ?></h3></td>
</tr>

<tr valign="top">
	<th scope="row"></th>
	<td>

		<div id="custom_colors">

			<div id="dwls_design_preview">
				<ul class="search_results dwls_search_results" style="display: block;">
					<input type="hidden" name="query" value="sample">
					<li class="daves-wordpress-live-search_result">
						<a href="#" class="daves-wordpress-live-search_title">Sample Page</a>

						<p class="excerpt clearfix"></p>

						<p>This is an example page. It's different from a blog post because it will stay in one place and will [...]</p>

						<p></p>

						<p class="meta clearfix" id="daves-wordpress-live-search_author">Posted by Admin</p>

						<p id="daves-wordpress-live-search_date" class="meta clearfix">December 5, 2012</p>

						<div class="clearfix"></div>
					</li>
					<div class="clearfix search_footer dwls_search_footer"><a href="#">View more results</a></div>
				</ul>
			</div>
		</div>
	</td>
</tr>

<tr valign="top">
	<th scope="row">
		<label for="daves-wordpress-live-search_results_title"><?php _e( "Title", 'dwls' ); ?></label>
	</th>
	<td>
		<input type="text" name="daves-wordpress-live-search_results_title" id="daves-wordpress-live-search_results_title" value="<?php echo esc_attr($titleColor); ?>" data-default-color="#000" class="dwls_color_picker" pattern="^#[0-9,a-f]{3,6}" />
	</td>
</tr>

<?php settings_fields(DavesWordPressLiveSearchAdmin::SETTINGS_PAGE_SLUG); ?>
<?php do_settings_sections( DavesWordPressLiveSearchAdmin::SETTINGS_PAGE_SLUG); ?>
<tr valign="top">
	<th scope="row">
		<label for="daves-wordpress-live-search_custom_fg"><?php _e( "Excerpt", 'dwls' ); ?></label>
	</th>
	<td>
		<input type="text" name="daves-wordpress-live-search_custom[fg]" id="daves-wordpress-live-search_custom_fg" value="<?php echo $customOptions['fg']; ?>" data-default-color="#000" class="dwls_color_picker" pattern="^#[0-9,a-f]{3,6}" />
	</td>
</tr>

<tr valign="top">
	<th scope="row">
		<label for="daves-wordpress-live-search_custom_bg"><?php _e( "Background", 'dwls' ); ?></label>
	</th>
	<td>
		<input type="text" name="daves-wordpress-live-search_custom[bg]" id="daves-wordpress-live-search_custom_bg" value="<?php echo $customOptions['bg']; ?>" data-default-color="#ddd" class="dwls_color_picker" pattern="^#[0-9,a-f]{3,6}" />
	</td>
</tr>

<tr valign="top">
	<th scope="row">
		<label for="daves-wordpress-live-search_custom_hoverbg"><?php _e( "Hover Background", 'dwls' ); ?></label>
	</th>
	<td>
		<input type="text" name="daves-wordpress-live-search_custom[hoverbg]" id="daves-wordpress-live-search_custom_hoverbg" value="<?php echo $customOptions['hoverbg']; ?>" data-default-color="#fff" class="dwls_color_picker" pattern="^#[0-9,a-f]{3,6}" />
	</td>
</tr>

<tr valign="top">
	<th scope="row">
		<label for="daves-wordpress-live-search_custom_divider"><?php _e( "Divider", 'dwls' ); ?></label>
	</th>
	<td>
		<input type="text" name="daves-wordpress-live-search_custom[divider]" id="daves-wordpress-live-search_custom_divider" value="<?php echo $customOptions['divider']; ?>" data-default-color="#aaa" class="dwls_color_picker" pattern="^#[0-9,a-f]{3,6}" />
	</td>
</tr>

<tr valign="top">
	<th scope="row">
		<label for="daves-wordpress-live-search_custom_footbg"><?php _e( "Footer Background", 'dwls' ); ?></label>
	</th>
	<td>
		<input type="text" name="daves-wordpress-live-search_custom[footbg]" id="daves-wordpress-live-search_custom_footbg" value="<?php echo $customOptions['footbg']; ?>" data-default-color="#888" class="dwls_color_picker" pattern="^#[0-9,a-f]{3,6}" />
	</td>
</tr>

<tr valign="top">
	<th scope="row">
		<label for="daves-wordpress-live-search_custom_footfg"><?php _e( "Footer Text", 'dwls' ); ?></label>
	</th>
	<td>
		<input type="text" name="daves-wordpress-live-search_custom[footfg]" id="daves-wordpress-live-search_custom_footfg" value="<?php echo $customOptions['footfg']; ?>" data-default-color="#fff" class="dwls_color_picker" pattern="^#[0-9,a-f]{3,6}" />
	</td>
</tr>

<tr valign="top">
	<th scope="row">
		<label for="daves-wordpress-live-search_custom_shadow"><?php _e( "Shadow", 'dwls' ); ?></label>
	</th>
	<td>
		<input type="checkbox" name="daves-wordpress-live-search_custom[shadow]" id="daves-wordpress-live-search_custom_shadow" value="true" class="dwls_design_toggle" <?php checked( !empty( $customOptions['shadow'] ) ); ?> />
	</td>
</tr>

<!-- Advanced -->
<tr valign="top">
	<td colspan="2"><h3><?php _e( "Advanced", 'dwls' ); ?></h3></td>
</tr>

<!-- X Offset -->
<tr valign="top">
	<th scope="row"><?php _e( "Search Results box X offset", 'dwls' ); ?></th>

	<td>
		<div>
			<span class="setting-description"><?php _e( "Use this setting to move the search results box left or right to align exactly with your theme's search field. Value is in pixels. Negative values move the box to the left, positive values move it to the right.", 'dwls' ); ?></span>
		</div>

		<input type="text" name="daves-wordpress-live-search_xoffset" id="daves-wordpress-live-search_xoffset" value="<?php echo $xOffset; ?>"
	</td>
</tr>

<!-- Y Offset -->
<tr valign="top">
	<th scope="row"><?php _e( "Search Results box Y offset", 'dwls' ); ?></th>

	<td>
		<div>
			<span class="setting-description"><?php _e( "Use this setting to move the search results box up or down to align exactly with your theme's search field. Value is in pixels. Negative values move the box up, positive values move it down.", 'dwls' ); ?></span>
		</div>

		<input type="text" name="daves-wordpress-live-search_yoffset" id="daves-wordpress-live-search_yoffset" value="<?php echo $yOffset; ?>"
	</td>
</tr>

<!-- Submit buttons -->
<tr valign="top">
	<td colspan="2">
		<div style="border-top: 1px solid #333;margin-top: 15px;padding: 5px;">
			<?php submit_button( NULL, 'primary', 'daves-wordpress-live-search_submit', false, array( 'id' => 'daves-wordpress-live-search_submit' ) ); ?>
		</div>
	</td>
</tr>

</tbody></table>

</form>

<?php include DWLS_TNG_PATH . '/tpl/admin-footer.tpl.php'; ?>
</div>