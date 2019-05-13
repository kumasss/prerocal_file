<?php $options = get_desing_plus_option(); ?>
<div id="tab-content6">
	<?php // アーカイブページヘッダーの設定 ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Header settings', 'tcd-w' ); ?></h3>
		<p><?php _e( 'These settings will be applied to archive page and single page.', 'tcd-w' ); ?></p>
		<h4 class="theme_option_headline2"><?php _e( 'Header image', 'tcd-w' ); ?></h4>
  	<p><?php _e( 'Recommend image size. Width:1450px, Height:500px', 'tcd-w' ); ?></p>
  	<div class="image_box cf">
  		<div class="cf cf_media_field hide-if-no-js review_archive_image">
  			<input type="hidden" value="<?php echo esc_attr( $options['review_archive_image'] ); ?>" id="review_archive_image" name="dp_options[review_archive_image]" class="cf_media_id">
  			<div class="preview_field"><?php if ( $options['review_archive_image'] ) { echo wp_get_attachment_image( $options['review_archive_image'], 'medium' ); } ?></div>
  			<div class="button_area">
  				<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
  				<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['review_archive_image'] ) { echo 'hidden'; } ?>">
  			</div>
  		</div>
  	</div>
		<h4 class="theme_option_headline2"><?php _e( 'Color of overlay', 'tcd-w' ); ?></h4>
		<input type="text" name="dp_options[review_archive_overlay]" value="<?php echo esc_attr( $options['review_archive_overlay'] ); ?>" data-default-color="#00280a" class="c-color-picker">
		<h4 class="theme_option_headline2"><?php _e( 'Opacity of overlay', 'tcd-w' ); ?></h4>
		<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.7)', 'tcd-w' ); ?></p>
		<input id="dp_options[review_archive_overlay_opacity]" class="hankaku" style="width:45px;" type="text" name="dp_options[review_archive_overlay_opacity]" value="<?php echo esc_attr( $options['review_archive_overlay_opacity'] ); ?>">
  	<h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
  	<input id="dp_options[review_archive_catchphrase]" class="regular-text" type="text" name="dp_options[review_archive_catchphrase]" value="<?php echo esc_attr( $options['review_archive_catchphrase'] ); ?>">
  	<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
  	<textarea cols="50" rows="4" id="dp_options[review_archive_desc]" name="dp_options[review_archive_desc]"><?php echo esc_textarea( $options['review_archive_desc'] ); ?></textarea>
  	<h4 class="theme_option_headline2"><?php _e( 'Font size of catchphrase', 'tcd-w' ); ?></h4>
  	<p><input id="dp_options[review_archive_catchphrase_font_size]" class="font_size hankaku" type="text" name="dp_options[review_archive_catchphrase_font_size]" value="<?php echo esc_attr( $options['review_archive_catchphrase_font_size'] ); ?>"><span>px</span></p>
  	<h4 class="theme_option_headline2"><?php _e( 'Font size of description', 'tcd-w' ); ?></h4>
  	<p><input id="dp_options[review_archive_desc_font_size]" class="font_size hankaku" type="text" name="dp_options[review_archive_desc_font_size]" value="<?php echo esc_attr( $options['review_archive_desc_font_size'] ); ?>"><span>px</span></p>
  	<h4 class="theme_option_headline2"><?php _e( 'Font color', 'tcd-w' ); ?></h4>
		<input type="text" name="dp_options[review_archive_color]" value="<?php echo esc_attr( $options['review_archive_color'] ); ?>" data-default-color="#ffffff" class="c-color-picker">
  	<h4 class="theme_option_headline2"><?php _e( 'Dropshadow', 'tcd-w' ); ?></h4>
  	<ul class="headline_option">
		<li><label><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label><input id="dp_options[review_archive_shadow1]" class="font_size hankaku" type="text" name="dp_options[review_archive_shadow1]" value="<?php echo esc_attr( $options['review_archive_shadow1'] ); ?>"><span>px</span></li>
  		<li><label><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label><input id="dp_options[review_archive_shadow2]" class="font_size hankaku" type="text" name="dp_options[review_archive_shadow2]" value="<?php echo esc_attr( $options['review_archive_shadow2'] ); ?>"><span>px</span></li>
  		<li><label><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label><input id="dp_options[review_archive_shadow3]" class="font_size hankaku" type="text" name="dp_options[review_archive_shadow3]" value="<?php echo esc_attr( $options['review_archive_shadow3'] ); ?>"><span>px</span></li>
  		<li><?php _e( 'Dropshadow color', 'tcd-w' ); ?> <input type="text" name="dp_options[review_archive_shadow_color]" value="<?php echo esc_attr( $options['review_archive_shadow_color'] ); ?>" data-default-color="#888888" class="c-color-picker"></li>
  		</ul>
  	<input type="submit" class="button-ml" value="<?php echo _e( 'Save Changes', 'tcd-w' ); ?>">
  </div>
	<?php // 記事ページの設定 ?>
  <div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Single Page Settings', 'tcd-w' ); ?></h3>
  	<h4 class="theme_option_headline2"><?php _e( 'Font size of post title', 'tcd-w' ); ?></h4>
  	<input id="dp_options[review_title_font_size]" class="font_size hankaku" type="text" name="dp_options[review_title_font_size]" value="<?php echo esc_attr( $options['review_title_font_size'] ); ?>"><span>px</span>
  	<h4 class="theme_option_headline2"><?php _e( 'Font size of post contents', 'tcd-w' ); ?></h4>
  	<input id="dp_options[review_content_font_size]" class="font_size hankaku" type="text" name="dp_options[review_content_font_size]" value="<?php echo esc_attr( $options['review_content_font_size'] ); ?>"><span>px</span>
  	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
  </div>
</div><!-- END #tab-content6 -->
