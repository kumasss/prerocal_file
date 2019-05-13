<?php $options = get_desing_plus_option(); ?>
<div id="tab-content2">
	<?php // ヘッダーのロゴ ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Header logo', 'tcd-w' ); ?></h3>
    <div<?php if ( ! empty( $options['header_logo_image'] ) ) { echo ' style="display:none;"'; } ?>>
    	<h4 class="theme_option_headline2"><?php _e( 'Font size for text logo', 'tcd-w' ); ?></h4>
    	<input class="font_size hankaku" type="text" name="dp_options[logo_font_size]" value="<?php esc_attr_e( $options['logo_font_size'] ); ?>"><span>px</span>
    </div>
   	<h4 class="theme_option_headline2"><?php _e( 'Image for logo', 'tcd-w' ); ?></h4>
   	<p><?php _e( 'If the image is not registered, text will be displayed instead.', 'tcd-w' ); ?></p>
    <div class="image_box cf">
    	<div class="cf cf_media_field hide-if-no-js header_logo_image">
    		<input type="hidden" value="<?php echo esc_attr( $options['header_logo_image'] ); ?>" id="header_logo_image" name="dp_options[header_logo_image]" class="cf_media_id">
      	<div class="preview_field"><?php if ( $options['header_logo_image'] ) { echo wp_get_attachment_image( $options['header_logo_image'], 'full' ); } ?></div>
      	<div class="button_area">
       		<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
       		<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['header_logo_image'] ) { echo 'hidden'; } ?>">
      	</div>
			</div>
    </div>
    <p><label><input name="dp_options[header_logo_image_retina]" type="checkbox" value="1" <?php checked( 1, $options['header_logo_image_retina'] ); ?>><?php _e( 'Use retina display logo image', 'tcd-w' ); ?></label></p>
    <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
	</div>
	<?php // ヘッダーのロゴ（モバイル）?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Header logo for mobile device', 'tcd-w' ); ?></h3>
    <div<?php if ( ! empty( $options['header_logo_image_mobile'] ) ) { echo ' style="display:none;"'; } ?>>
    <h4 class="theme_option_headline2"><?php _e( 'Font size for text logo', 'tcd-w' ); ?></h4>
    <input id="dp_options[logo_font_size_mobile]" class="font_size hankaku" type="text" name="dp_options[logo_font_size_mobile]" value="<?php esc_attr_e( $options['logo_font_size_mobile'] ); ?>"><span>px</span>
	</div>
	<h4 class="theme_option_headline2"><?php _e( 'Image for logo', 'tcd-w' ); ?></h4>
  <p><?php _e( 'If the image is not registered, text will be displayed instead.', 'tcd-w' ); ?></p>
  <div class="image_box cf">
  	<div class="cf cf_media_field hide-if-no-js header_logo_image_mobile">
    	<input type="hidden" value="<?php echo esc_attr( $options['header_logo_image_mobile'] ); ?>" id="header_logo_image_mobile" name="dp_options[header_logo_image_mobile]" class="cf_media_id">
     	<div class="preview_field"><?php if ( $options['header_logo_image_mobile'] ) { echo wp_get_attachment_image( $options['header_logo_image_mobile'], 'full' ); } ?></div>
      <div class="button_area">
      	<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
       	<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['header_logo_image_mobile']){ echo 'hidden'; } ?>">
      </div>
		</div>
   </div>
    <p><label><input name="dp_options[header_logo_image_mobile_retina]" type="checkbox" value="1" <?php checked( 1, $options['header_logo_image_mobile_retina'] ); ?>><?php _e( 'Use retina display logo image', 'tcd-w' ); ?></label></p>
   <input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
	</div>
	<?php // フッターのロゴ ?>
	<div class="theme_option_field cf">
		<h3 class="theme_option_headline"><?php _e( 'Footer logo', 'tcd-w' ); ?></h3>
    <div<?php if ( ! empty( $options['footer_logo_image'] ) ) { echo ' style="display:none;"'; } ?>>
			<h4 class="theme_option_headline2"><?php _e( 'Font size for text logo', 'tcd-w' ); ?></h4>
			<input class="font_size hankaku" type="text" name="dp_options[logo_font_size_footer]" value="<?php echo esc_attr( $options['logo_font_size_footer'] ); ?>"><span>px</span>
    </div>
    <h4 class="theme_option_headline2"><?php _e( 'Image for logo', 'tcd-w' ); ?></h4>
    <p><?php _e( 'If the image is not registered, text will be displayed instead.', 'tcd-w' ); ?></p>
    <div class="image_box cf">
    	<div class="cf cf_media_field hide-if-no-js footer_logo_image">
      	<input type="hidden" value="<?php echo esc_attr( $options['footer_logo_image'] ); ?>" id="footer_logo_image" name="dp_options[footer_logo_image]" class="cf_media_id">
      	<div class="preview_field"><?php if ( $options['footer_logo_image'] ) { echo wp_get_attachment_image( $options['footer_logo_image'], 'full' ); } ?></div>
      	<div class="button_area">
       		<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
       		<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['footer_logo_image'] ) { echo 'hidden'; } ?>">
      	</div>
     	</div>
    </div>
   	<input type="submit" class="button-ml" value="<?php echo _e( 'Save Changes', 'tcd-w' ); ?>">
  </div>
</div><!-- END #tab-content2 -->