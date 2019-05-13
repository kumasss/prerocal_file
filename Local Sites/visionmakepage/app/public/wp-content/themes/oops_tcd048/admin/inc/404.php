<?php $options = get_desing_plus_option(); ?>
<div id="tab-content9">
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Settings for 404 page', 'tcd-w' ); ?></h3>
		<h4 class="theme_option_headline2"><?php _e( 'Header image', 'tcd-w' ); ?></h4>
		<p><?php _e( 'Recommend image size. Width:1450px, Height:500px', 'tcd-w' ); ?></p>
		<div class="image_box cf">
			<div class="cf cf_media_field hide-if-no-js image_404">
				<input id="image_404" type="hidden" value="<?php echo esc_attr( $options['image_404'] ); ?>" name="dp_options[image_404]" class="cf_media_id">
				<div class="preview_field"><?php if ( $options['image_404'] ) { echo wp_get_attachment_image( $options['image_404'], 'medium' ); } ?></div>
				<div class="button_area">
					<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
					<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['image_404'] ) { echo 'hidden'; } ?>">
				</div>
			</div>
		</div>
		<h4 class="theme_option_headline2"><?php _e( 'Color of overlay', 'tcd-w' ); ?></h4>
		<input type="text" name="dp_options[overlay_404]" value="<?php echo esc_attr( $options['overlay_404'] ); ?>" data-default-color="#0B3247" class="c-color-picker">
		<h4 class="theme_option_headline2"><?php _e( 'Opacity of overlay', 'tcd-w' ); ?></h4>
		<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.7)', 'tcd-w' ); ?></p>
		<input id="dp_options[overlay_opacity_404]" class="hankaku" style="width:45px;" type="text" name="dp_options[overlay_opacity_404]" value="<?php echo esc_attr( $options['overlay_opacity_404'] ); ?>">
		<h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
    <input class="regular-text" type="text" name="dp_options[catchphrase_404]" value="<?php echo esc_attr( $options['catchphrase_404'] ); ?>">
    <h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
    <textarea cols="50" rows="4" name="dp_options[desc_404]"><?php echo esc_textarea( $options['desc_404'] ); ?></textarea>
    <h4 class="theme_option_headline2"><?php _e( 'Font size of catchphrase', 'tcd-w' ); ?></h4>
    <p><input class="font_size hankaku" type="text" name="dp_options[catchphrase_font_size_404]" value="<?php echo esc_attr( $options['catchphrase_font_size_404'] ); ?>"><span>px</span></p>
    <h4 class="theme_option_headline2"><?php _e( 'Font size of description', 'tcd-w' ); ?></h4>
    <p><input class="font_size hankaku" type="text" name="dp_options[desc_font_size_404]" value="<?php echo esc_attr( $options['desc_font_size_404'] ); ?>"><span>px</span></p>
    <h4 class="theme_option_headline2"><?php _e( 'Font color', 'tcd-w' ); ?></h4>
		<input type="text" name="dp_options[color_404]" value="<?php echo esc_attr( $options['color_404'] ); ?>" data-default-color="#ffffff" class="c-color-picker">
    <h4 class="theme_option_headline2"><?php _e( 'Dropshadow', 'tcd-w' ); ?></h4>
    <ul class="headline_option">
			<li><label><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label><input class="font_size hankaku" type="text" name="dp_options[shadow1_404]" value="<?php echo esc_attr( $options['shadow1_404'] ); ?>"><span>px</span></li>
     	<li><label><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label><input class="font_size hankaku" type="text" name="dp_options[shadow2_404]" value="<?php echo esc_attr( $options['shadow2_404'] ); ?>"><span>px</span></li>
     	<li><label><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label><input class="font_size hankaku" type="text" name="dp_options[shadow3_404]" value="<?php echo esc_attr( $options['shadow3_404'] ); ?>"><span>px</span></li>
     	<li><?php _e( 'Dropshadow color', 'tcd-w' ); ?> <input type="text" name="dp_options[shadow_color_404]" value="<?php echo esc_attr( $options['shadow_color_404'] ); ?>" data-default-color="#ffffff" class="c-color-picker"></li>
    </ul>
		<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
	</div>
</div><!-- END #tab-content9 -->
