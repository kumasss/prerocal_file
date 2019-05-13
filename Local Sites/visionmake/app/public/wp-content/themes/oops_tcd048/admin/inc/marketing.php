<?php
global $cta_type_options, $cta_type2_layout_options, $cta_display_options, $footer_cta_type_options;
$options = get_desing_plus_option(); 
?>
<div id="tab-content10">
	<?php // 記事下CTA ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'CTA under the post content', 'tcd-w' ); ?></h3>
		<p><?php _e( 'You can set up CTA under the post content.', 'tcd-w' ); ?></p>
		<p><?php _e( 'You can register up to three contents.', 'tcd-w' ); ?></p>
		<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
		<div class="sub_box">
			<h4 class="theme_option_subbox_headline">CTA-<?php echo 1 === $i ? 'A' : ( 2 === $i ? 'B' : 'C' ); ?></h4>
			<div class="sub_box_content">
				<h5 class="theme_option_headline2"><?php _e( 'Type of CTA', 'tcd-w' ); ?></h5>
				<ul class="c-preview-list">	
					<?php foreach( $cta_type_options as $option ) : ?>
					<li class="c-preview-list__item"><label><?php if ( $option['image'] ) { ?><img src="<?php echo esc_attr( $option['image'] ); ?>" class="c-preview-list__item-img" alt=""><?php } ?><input type="radio" class="cta-type" name="dp_options[cta_type<?php echo $i; ?>]" value="<?php echo esc_attr( $option['value'] ); ?>" id="js-cta-<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $options['cta_type' . $i], $option['value'] ); ?>><?php esc_html_e( $option['label'], 'tcd-w' ); ?></label></li>
					<?php endforeach; ?>
				</ul>
				<div class="cta-type1-content cta-content <?php if ( 'type1' !== $options['cta_type' . $i] ) { echo 'u-hidden'; } ?>">
					<h6 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h6>
					<textarea name="dp_options[cta_type1_catch<?php echo $i; ?>]" class="large-text"><?php echo esc_textarea( $options['cta_type1_catch' . $i] ); ?></textarea>
					<p><label><?php _e( 'Font size', 'tcd-w' ); ?> <input type="text" class="tiny-text" name="dp_options[cta_type1_catch_font_size<?php echo $i; ?>]" value="<?php echo esc_attr( $options['cta_type1_catch_font_size' . $i] ); ?>"> px</label></p>
					<h6 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h6>
					<textarea name="dp_options[cta_type1_desc<?php echo $i; ?>]" class="large-text"><?php echo esc_textarea( $options['cta_type1_desc' . $i] ); ?></textarea>
					<p><label><?php _e( 'Font size', 'tcd-w' ); ?> <input type="text" class="tiny-text" name="dp_options[cta_type1_desc_font_size<?php echo $i; ?>]" value="<?php echo esc_attr( $options['cta_type1_desc_font_size' . $i] ); ?>"> px</label></p>
					<h6 class="theme_option_headline2"><?php _e( 'Button settings', 'tcd-w' ); ?></h6>
					<p><label><?php _e( 'Button label', 'tcd-w' ); ?> <input type="text" name="dp_options[cta_type1_btn_label<?php echo $i; ?>]" value="<?php echo esc_attr( $options['cta_type1_btn_label' . $i] ); ?>" class="regular-text"></label></p>
					<p><label><?php _e( 'Link URL', 'tcd-w' ); ?> <input type="text" name="dp_options[cta_type1_btn_url<?php echo $i; ?>]" value="<?php echo esc_attr( $options['cta_type1_btn_url' . $i] ); ?>" class="regular-text"></label></p>
					<p><label><input type="checkbox" name="dp_options[cta_type1_btn_target<?php echo $i; ?>]" value="1" <?php checked( 1, $options['cta_type1_btn_target' . $i] ); ?>> <?php _e( 'Open with new window', 'tcd-w' ); ?></label></p>
					<p><?php _e( 'Background color', 'tcd-w' ); ?> <input type="text" class="c-color-picker" name="dp_options[cta_type1_btn_bg<?php echo $i; ?>]" value="<?php echo esc_attr( $options['cta_type1_btn_bg' . $i] ); ?>" data-default-color="#ff8000"></p>
					<p><?php _e( 'Background color on hover', 'tcd-w' ); ?> <input type="text" class="c-color-picker" name="dp_options[cta_type1_btn_bg_hover<?php echo $i; ?>]" value="<?php echo esc_attr( $options['cta_type1_btn_bg_hover' . $i] ); ?>" data-default-color="#444444"></p>
					<h6 class="theme_option_headline2"><?php _e( 'Image', 'tcd-w' ); ?></h6>
					<p><?php _e( 'Recommend image size. Width:900px, Height:400px', 'tcd-w' ); ?></p>
    			<div class="image_box cf">
    				<div class="cf cf_media_field hide-if-no-js cta_type1_image<?php echo $i; ?>">
    					<input type="hidden" value="<?php echo esc_attr( $options['cta_type1_image' . $i] ); ?>" id="cta_type1_image<?php echo $i; ?>" name="dp_options[cta_type1_image<?php echo $i; ?>]" class="cf_media_id">
    			  	<div class="preview_field"><?php if ( $options['cta_type1_image' . $i] ) { echo wp_get_attachment_image( $options['cta_type1_image' . $i], 'full' ); } ?></div>
    			  	<div class="button_area">
    			   		<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
    			   		<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['cta_type1_image' . $i] ) { echo 'hidden'; } ?>">
    			  	</div>
						</div>
    			</div>
					<h6 class="theme_option_headline2"><?php _e( 'Image for mobile', 'tcd-w' ); ?></h6>
					<p><?php _e( 'Recommend image size. Width:320px, Height:280px', 'tcd-w' ); ?></p>
    			<div class="image_box cf">
    				<div class="cf cf_media_field hide-if-no-js cta_type1_image_sp<?php echo $i; ?>">
    					<input type="hidden" value="<?php echo esc_attr( $options['cta_type1_image_sp' . $i] ); ?>" id="cta_type1_image_sp<?php echo $i; ?>" name="dp_options[cta_type1_image_sp<?php echo $i; ?>]" class="cf_media_id">
    			  	<div class="preview_field"><?php if ( $options['cta_type1_image_sp' . $i] ) { echo wp_get_attachment_image( $options['cta_type1_image_sp' . $i], 'full' ); } ?></div>
    			  	<div class="button_area">
    			   		<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
    			   		<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['cta_type1_image_sp' . $i] ) { echo 'hidden'; } ?>">
    			  	</div>
						</div>
    			</div>
					<h6 class="theme_option_headline2"><?php _e( 'Image settings', 'tcd-w' ); ?></h6>
					<p><?php _e( 'Color of overlay', 'tcd-w' ); ?> <input type="text" class="c-color-picker" name="dp_options[cta_type1_overlay<?php echo $i; ?>]" value="<?php echo esc_attr( $options['cta_type1_overlay' . $i] ); ?>" data-default-color="#000000"></p>
					<p><?php _e( 'Opacity of overlay', 'tcd-w' ); ?> <input type="number" name="dp_options[cta_type1_overlay_opacity<?php echo $i; ?>]" max="1" min="0" step="0.1" value="<?php echo esc_attr( $options['cta_type1_overlay_opacity' . $i] ); ?>"></p>
					<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.7)', 'tcd-w' ); ?></p>
					<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
				</div>
				<div class="cta-type2-content cta-content <?php if ( 'type2' !== $options['cta_type' . $i] ) { echo 'u-hidden'; } ?>">
					<h6 class="theme_option_headline2"><?php _e( 'Layout settings', 'tcd-w' ); ?></h6>
					<?php foreach ( $cta_type2_layout_options as $option ) : ?>
					<p><label><input type="radio" name="dp_options[cta_type2_layout<?php echo $i; ?>]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $options['cta_type2_layout' . $i] ); ?>> <?php esc_html_e( $option['label'], 'tcd-w' ); ?></label></p>
					<?php endforeach; ?>
					<h6 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h6>
					<textarea name="dp_options[cta_type2_catch<?php echo $i; ?>]" class="large-text"><?php echo esc_textarea( $options['cta_type2_catch' . $i] ); ?></textarea>
					<p><label><?php _e( 'Font size', 'tcd-w' ); ?> <input type="text" class="tiny-text" name="dp_options[cta_type2_catch_font_size<?php echo $i; ?>]" value="<?php echo esc_attr( $options['cta_type2_catch_font_size' . $i] ); ?>"> px</label></p>
					<h6 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h6>
					<textarea name="dp_options[cta_type2_desc<?php echo $i; ?>]" class="large-text"><?php echo esc_textarea( $options['cta_type2_desc' . $i] ); ?></textarea>
					<p><label><?php _e( 'Font size', 'tcd-w' ); ?> <input type="text" class="tiny-text" name="dp_options[cta_type2_desc_font_size<?php echo $i; ?>]" value="<?php echo esc_attr( $options['cta_type2_desc_font_size' . $i] ); ?>"> px</label></p>
					<h6 class="theme_option_headline2"><?php _e( 'Button settings', 'tcd-w' ); ?></h6>
					<p><label><?php _e( 'Button label', 'tcd-w' ); ?> <input type="text" name="dp_options[cta_type2_btn_label<?php echo $i; ?>]" value="<?php echo esc_attr( $options['cta_type2_btn_label' . $i] ); ?>" class="regular-text"></label></p>
					<p><label><?php _e( 'Link URL', 'tcd-w' ); ?> <input type="text" name="dp_options[cta_type2_btn_url<?php echo $i; ?>]" value="<?php echo esc_attr( $options['cta_type2_btn_url' . $i] ); ?>" class="regular-text"></label></p>
					<p><label><input type="checkbox" name="dp_options[cta_type2_btn_target<?php echo $i; ?>]" value="1" <?php checked( 1, $options['cta_type2_btn_target' . $i] ); ?>> <?php _e( 'Open with new window', 'tcd-w' ); ?></label></p>
					<p><?php _e( 'Background color', 'tcd-w' ); ?> <input type="text" class="c-color-picker" name="dp_options[cta_type2_btn_bg<?php echo $i; ?>]" value="<?php echo esc_attr( $options['cta_type2_btn_bg' . $i] ); ?>" data-default-color="#ff8000"></p>
					<p><?php _e( 'Background color on hover', 'tcd-w' ); ?> <input type="text" class="c-color-picker" name="dp_options[cta_type2_btn_bg_hover<?php echo $i; ?>]" value="<?php echo esc_attr( $options['cta_type2_btn_bg_hover' . $i] ); ?>" data-default-color="#444444"></p>
					<h6 class="theme_option_headline2"><?php _e( 'Image', 'tcd-w' ); ?></h6>
					<p><?php _e( 'Recommend image size. Width:450px, Height:400px', 'tcd-w' ); ?></p>
    			<div class="image_box cf">
    				<div class="cf cf_media_field hide-if-no-js cta_type2_image<?php echo $i; ?>">
    					<input type="hidden" value="<?php echo esc_attr( $options['cta_type2_image' . $i] ); ?>" id="cta_type2_image<?php echo $i; ?>" name="dp_options[cta_type2_image<?php echo $i; ?>]" class="cf_media_id">
    			  	<div class="preview_field"><?php if ( $options['cta_type2_image' . $i] ) { echo wp_get_attachment_image( $options['cta_type2_image' . $i], 'full' ); } ?></div>
    			  	<div class="button_area">
    			   		<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
    			   		<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['cta_type2_image' . $i] ) { echo 'hidden'; } ?>">
    			  	</div>
						</div>
    			</div>
					<h6 class="theme_option_headline2"><?php _e( 'Image for mobile', 'tcd-w' ); ?></h6>
					<p><?php _e( 'Recommend image size. Width:320px, Height:280px', 'tcd-w' ); ?></p>
    			<div class="image_box cf">
    				<div class="cf cf_media_field hide-if-no-js cta_type2_image_sp<?php echo $i; ?>">
    					<input type="hidden" value="<?php echo esc_attr( $options['cta_type2_image_sp' . $i] ); ?>" id="cta_type2_image_sp<?php echo $i; ?>" name="dp_options[cta_type2_image_sp<?php echo $i; ?>]" class="cf_media_id">
    			  	<div class="preview_field"><?php if ( $options['cta_type2_image_sp' . $i] ) { echo wp_get_attachment_image( $options['cta_type2_image_sp' . $i], 'full' ); } ?></div>
    			  	<div class="button_area">
    			   		<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
    			   		<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['cta_type2_image_sp' . $i] ) { echo 'hidden'; } ?>">
    			  	</div>
						</div>
    			</div>
					<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
				</div>
				<div class="cta-type3-content cta-content <?php if ( 'type3' !== $options['cta_type' . $i] ) { echo 'u-hidden'; } ?>">
					<div class="theme_option_message">
						<p><?php _e( 'If you want to measure the number of clicks in WYSIWYG editor, set the id attribute of the target element to "js-cta__btn".', 'tcd-w' ); ?></p>
					</div>
					<h6 class="theme_option_headline2"><?php _e( 'Wysiwyg editor', 'tcd-w' ); ?></h6>
					<?php wp_editor( $options['cta_editor' . $i], 'cta_editor' . $i, array( 'textarea_name' => 'dp_options[cta_editor' . $i . ']', 'textarea_rows' => 10 ) ); ?>
					<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
				</div>
			</div>
		</div>
		<?php endfor; ?>
		<h4 class="theme_option_headline2"><?php echo __( 'Display settings', 'tcd-w' ); ?></h4>
		<p><?php _e( 'Please select the CTA to display under the post content.', 'tcd-w' ); ?></p>
		<select id="js-cta-display" name="dp_options[cta_display]">
			<?php foreach ( $cta_display_options as $option ) : ?>
			<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $options['cta_display'] ); ?>><?php esc_html_e( $option['label'] ); ?></option>
			<?php endforeach; ?>
		</select>
		<p><label><input type="checkbox" name="dp_options[cta_display_news]" value="1" <?php checked( 1, $options['cta_display_news'] ); ?>> <?php _e( 'Display CTA in news posts', 'tcd-w' ); ?></label></p>
		<p><label><input type="checkbox" name="dp_options[cta_display_review]" value="1" <?php checked( 1, $options['cta_display_review'] ); ?>> <?php _e( 'Display CTA in review posts', 'tcd-w' ); ?></label></p>
		<div id="js-cta-random-display" class="<?php if ( '4' !== $options['cta_display'] ) { echo 'u-hidden'; } ?>">
  		<h4 class="theme_option_headline2"><?php _e( 'Random display', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Please select CTA to use in random display.', 'tcd-w' ); ?></p>
			<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
			<p><label><input type="checkbox" name="dp_options[cta_random<?php echo $i; ?>]" value="1" <?php checked( 1, $options['cta_random' . $i] ); ?>>CTA-<?php echo 1 === $i ? 'A' : ( 2 === $i ? 'B' : 'C' ); ?></label></p>
			<?php endfor; ?>
		</div>
  	<h4 class="theme_option_headline2"><?php _e( 'A/B Testing', 'tcd-w' ); ?></h4>
		<div class="theme_option_message">
			<p><?php _e( 'To measure conversions, copy and paste the following code in the editor of "thanks page".', 'tcd-w' ); ?></p>
			<p><textarea class="large-text" readonly="readonly"><div id="js-cta-conversion"></div></textarea></p>
		</div>
		<table class="c-ab-table">
			<tr class="c-ab-table__row">
				<th>CTA</th>
				<th><?php _e( 'Impressions', 'tcd-w' ); ?></th>
				<th><?php _e( 'Number of clicks', 'tcd-w' ); ?></th>
				<th><?php _e( 'Click-through rate', 'tcd-w' ); ?></th>
				<th><?php _e( 'Conversions', 'tcd-w' ); ?></th>
				<th><?php _e( 'Conversion rate', 'tcd-w' ); ?></th>
				<th><?php _e( 'Reset', 'tcd-w' ); ?></th>
			</tr>
			<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
			<tr class="c-ab-table__row">
				<td>CTA-<?php echo 1 === $i ? 'A' : ( 2 === $i ? 'B' : 'C' ); ?></td>
				<td class="c-ab-table__impression"><?php echo esc_html( get_option( 'tcd_cta_impression' . $i, 0 ) ); ?></td>
				<td class="c-ab-table__click"><?php echo esc_html( get_option( 'tcd_cta_click' . $i, 0 ) ); ?></td>
				<td class="c-ab-table__ctr"><?php echo esc_html( get_option( 'tcd_cta_ctr' . $i, 0 ) ); ?>%</td>
				<td class="c-ab-table__conversion"><?php echo esc_html( get_option( 'tcd_cta_conversion' . $i, 0 ) ); ?></td>
				<td class="c-ab-table__cvr"><?php echo esc_html( get_option( 'tcd_cta_cvr' . $i, 0 ) ); ?>%</td>
				<td><a class="js-cta-reset c-ab-table__reset" href="#" data-cta-index="<?php echo $i; ?>"><?php _e( 'Reset values', 'tcd-w' ); ?></a></td>
			</tr>
			<?php endfor; ?>
		</table>
		<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
	</div>
	<?php // フッターCTA ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Footer CTA', 'tcd-w' ); ?></h3>
		<p><?php _e( 'You can set up Footer CTA which is displayed at the bottom of the footer on scroll.', 'tcd-w' ); ?></p>
		<p><?php _e( 'You can register up to three contents.', 'tcd-w' ); ?></p>
		<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
		<div class="sub_box">
			<h4 class="theme_option_subbox_headline">CTA-<?php echo 1 === $i ? 'A' : ( 2 === $i ? 'B' : 'C' ); ?></h4>
			<div class="sub_box_content">
				<h5 class="theme_option_headline2"><?php _e( 'Type of CTA', 'tcd-w' ); ?></h5>
				<?php foreach( $footer_cta_type_options as $option ) : ?>
				<p><label><input type="radio" class="cta-type" name="dp_options[footer_cta_type<?php echo $i; ?>]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $options['footer_cta_type' . $i] ); ?>> <?php esc_html_e( $option['label'], 'tcd-w' ); ?></label></p>
				<?php endforeach; ?>
				<div class="cta-type1-content cta-content <?php if ( 'type1' !== $options['footer_cta_type' . $i] ) { echo 'u-hidden'; } ?>">
					<h6 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h6>
					<p><?php _e( 'Newlines are converted to <br> tags only in smartphones.', 'tcd-w' ); ?></p>
					<textarea name="dp_options[footer_cta_catch<?php echo $i; ?>]" class="large-text"><?php echo esc_textarea( $options['footer_cta_catch' . $i] ); ?></textarea>
					<p><?php _e( 'Font color', 'tcd-w' ); ?> <input type="text" class="c-color-picker" name="dp_options[footer_cta_catch_font_color<?php echo $i; ?>]" value="<?php echo esc_attr( $options['footer_cta_catch_font_color' . $i] ); ?>" data-default-color="#ffffff"></p>
					<h6 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h6>
					<textarea name="dp_options[footer_cta_desc<?php echo $i; ?>]" class="large-text"><?php echo esc_textarea( $options['footer_cta_desc' . $i] ); ?></textarea>
					<p><?php _e( 'Font color', 'tcd-w' ); ?> <input type="text" class="c-color-picker" name="dp_options[footer_cta_desc_font_color<?php echo $i; ?>]" value="<?php echo esc_attr( $options['footer_cta_desc_font_color' . $i] ); ?>" data-default-color="#999999"></p>
					<h6 class="theme_option_headline2"><?php _e( 'Button settings', 'tcd-w' ); ?></h6>
					<p><label><?php _e( 'Button label', 'tcd-w' ); ?> <input type="text" name="dp_options[footer_cta_btn_label<?php echo $i; ?>]" value="<?php echo esc_attr( $options['footer_cta_btn_label' . $i] ); ?>" class="regular-text"></label></p>
					<p><label><?php _e( 'Link URL', 'tcd-w' ); ?> <input type="text" name="dp_options[footer_cta_btn_url<?php echo $i; ?>]" value="<?php echo esc_attr( $options['footer_cta_btn_url' . $i] ); ?>" class="regular-text"></label></p>
					<p><label><input type="checkbox" name="dp_options[footer_cta_btn_target<?php echo $i; ?>]" value="1" <?php checked( 1, $options['footer_cta_btn_target' . $i] ); ?>> <?php _e( 'Open with new window', 'tcd-w' ); ?></label></p>
					<p><?php _e( 'Background color', 'tcd-w' ); ?> <input type="text" class="c-color-picker" name="dp_options[footer_cta_btn_bg<?php echo $i; ?>]" value="<?php echo esc_attr( $options['footer_cta_btn_bg' . $i] ); ?>" data-default-color="#ff8000"></p>
					<p><?php _e( 'Background color on hover', 'tcd-w' ); ?> <input type="text" class="c-color-picker" name="dp_options[footer_cta_btn_bg_hover<?php echo $i; ?>]" value="<?php echo esc_attr( $options['footer_cta_btn_bg_hover' . $i] ); ?>" data-default-color="#444444"></p>
					<h6 class="theme_option_headline2"><?php _e( 'Background color settings', 'tcd-w' ); ?></h6>
					<p><?php _e( 'Background color', 'tcd-w' ); ?> <input type="text" class="c-color-picker" name="dp_options[footer_cta_bg<?php echo $i; ?>]" value="<?php echo esc_attr( $options['footer_cta_bg' . $i] ); ?>" data-default-color="#000000"></p>
					<p><?php _e( 'Opacity of Background color', 'tcd-w' ); ?> <input type="number" name="dp_options[footer_cta_bg_opacity<?php echo $i; ?>]" max="1" min="0" step="0.1" value="<?php echo esc_attr( $options['footer_cta_bg_opacity' . $i] ); ?>"></p>
					<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.7)', 'tcd-w' ); ?></p>
					<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
				</div>
				<div class="cta-type2-content cta-content <?php if ( 'type2' !== $options['footer_cta_type' . $i] ) { echo 'u-hidden'; } ?>">
					<div class="theme_option_message">
						<p><?php _e( 'If you want to measure the number of clicks in WYSIWYG editor, set the id attribute of the target element to "js-footer-cta__btn".', 'tcd-w' ); ?></p>
					</div>
					<h6 class="theme_option_headline2"><?php _e( 'Wysiwyg editor', 'tcd-w' ); ?></h6>
					<?php wp_editor( $options['footer_cta_editor' . $i], 'footer_cta_editor' . $i, array( 'textarea_name' => 'dp_options[footer_cta_editor' . $i . ']', 'textarea_rows' => 10 ) ); ?>
					<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
				</div>
			</div>
		</div>
		<?php endfor; ?>
		<h4 class="theme_option_headline2"><?php echo __( 'Display settings', 'tcd-w' ); ?></h4>
		<p><?php _e( 'Please select the Footer CTA to display.', 'tcd-w' ); ?></p>
		<p><?php _e( 'Note: when the Footer CTA is displayed, the footer bar is hidden.', 'tcd-w' ); ?></p>
		<select id="js-footer-cta-display" name="dp_options[footer_cta_display]">
			<?php foreach ( $cta_display_options as $option ) : ?>
			<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $options['footer_cta_display'] ); ?>><?php esc_html_e( $option['label'] ); ?></option>
			<?php endforeach; ?>
		</select>
		<p><label><input type="checkbox" name="dp_options[footer_cta_hide_on_front]" value="1" <?php checked( 1, $options['footer_cta_hide_on_front'] ); ?>> <?php _e( 'Hide Footer CTA on front page', 'tcd-w' ); ?></label></p>
		<div id="js-footer-cta-random-display" class="<?php if ( '4' !== $options['footer_cta_display'] ) { echo 'u-hidden'; } ?>">
  		<h4 class="theme_option_headline2"><?php _e( 'Random display', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Please select CTA to use in random display.', 'tcd-w' ); ?></p>
			<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
			<p><label><input type="checkbox" name="dp_options[footer_cta_random<?php echo $i; ?>]" value="1" <?php checked( 1, $options['footer_cta_random' . $i] ); ?>>CTA-<?php echo 1 === $i ? 'A' : ( 2 === $i ? 'B' : 'C' ); ?></label></p>
			<?php endfor; ?>
		</div>
  	<h4 class="theme_option_headline2"><?php _e( 'A/B Testing', 'tcd-w' ); ?></h4>
		<div class="theme_option_message">
			<p><?php _e( 'To measure conversions, copy and paste the following code in the editor of "thanks page".', 'tcd-w' ); ?></p>
			<p><textarea class="large-text" readonly="readonly"><div id="js-footer-cta-conversion"></div></textarea></p>
		</div>
		<table class="c-ab-table">
			<tr class="c-ab-table__row">
				<th>CTA</th>
				<th><?php _e( 'Impressions', 'tcd-w' ); ?></th>
				<th><?php _e( 'Number of clicks', 'tcd-w' ); ?></th>
				<th><?php _e( 'Click-through rate', 'tcd-w' ); ?></th>
				<th><?php _e( 'Conversions', 'tcd-w' ); ?></th>
				<th><?php _e( 'Conversion rate', 'tcd-w' ); ?></th>
				<th><?php _e( 'Reset', 'tcd-w' ); ?></th>
			</tr>
			<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
			<tr class="c-ab-table__row">
				<td>CTA-<?php echo 1 === $i ? 'A' : ( 2 === $i ? 'B' : 'C' ); ?></td>
				<td class="c-ab-table__impression"><?php echo esc_html( get_option( 'tcd_footer_cta_impression' . $i, 0 ) ); ?></td>
				<td class="c-ab-table__click"><?php echo esc_html( get_option( 'tcd_footer_cta_click' . $i, 0 ) ); ?></td>
				<td class="c-ab-table__ctr"><?php echo esc_html( get_option( 'tcd_footer_cta_ctr' . $i, 0 ) ); ?>%</td>
				<td class="c-ab-table__conversion"><?php echo esc_html( get_option( 'tcd_footer_cta_conversion' . $i, 0 ) ); ?></td>
				<td class="c-ab-table__cvr"><?php echo esc_html( get_option( 'tcd_footer_cta_cvr' . $i, 0 ) ); ?>%</td>
				<td><a class="js-footer-cta-reset c-ab-table__reset" href="#" data-footer-cta-index="<?php echo $i; ?>"><?php _e( 'Reset values', 'tcd-w' ); ?></a></td>
			</tr>
			<?php endfor; ?>
		</table>
		<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
	</div>
</div><!-- END #tab-content10 -->
