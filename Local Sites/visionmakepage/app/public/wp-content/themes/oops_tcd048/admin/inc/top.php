<?php
global $header_content_type_options, $slider_type_options;
$options = get_desing_plus_option();
?>
<div id="tab-content3">
	<?php // ヘッダーコンテンツの設定 ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Header content setting', 'tcd-w' ); ?></h3>
    <h4 class="theme_option_headline2"><?php _e( 'Header content type', 'tcd-w' ); ?></h4>
    <fieldset class="cf select_type2">
			<?php foreach ( $header_content_type_options as $option ) : ?>
			<p><label><input id="header_content_button_<?php echo esc_attr( $option['value'] ); ?>" type="radio" name="dp_options[header_content_type]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $options['header_content_type'], $option['value'] ); ?>><?php esc_html_e( $option['label'], 'tcd-w' ); ?></label></p>
			<?php endforeach; ?>
    </fieldset>
    <div id="header_content_slider" style="<?php echo $options['header_content_type'] == 'type1' ? 'display:block;' : 'display:none;'; ?>">
			<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
			<div class="sub_box cf"> 
     		<h3 class="theme_option_subbox_headline"><?php printf( __( 'Slider%s setting', 'tcd-w' ), $i ); ?></h3>
     		<div class="sub_box_content">
    			<h4 class="theme_option_headline2"><?php _e( 'Slider animation type', 'tcd-w' ); ?></h4>
    			<fieldset class="cf select_type2">
						<?php foreach ( $slider_type_options as $option ) : ?>
						<label><input type="radio" name="dp_options[slider_type<?php echo $i; ?>]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $options['slider_type' . $i], $option['value'] ); ?>><?php esc_html_e( $option['label'], 'tcd-w' ); ?></label>
						<?php endforeach; ?>
    			</fieldset>
    			<h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
    			<textarea rows="2" class="large-text" name="dp_options[slider_headline<?php echo $i; ?>]"><?php echo esc_textarea( $options['slider_headline' . $i] ); ?></textarea>
    			<p><?php _e( 'Font size', 'tcd-w' ); ?><input class="font_size hankaku" type="text" name="dp_options[slider_headline_font_size<?php echo $i; ?>]" value="<?php echo esc_attr( $options['slider_headline_font_size' . $i] ); ?>"><span>px</span></p>
    			<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
    			<textarea rows="4" class="large-text" name="dp_options[slider_desc<?php echo $i; ?>]"><?php echo esc_textarea( $options['slider_desc' . $i] ); ?></textarea>
    			<p><?php _e( 'Font size', 'tcd-w' );  ?><input class="font_size hankaku" type="text" name="dp_options[slider_desc_font_size<?php echo $i; ?>]" value="<?php echo esc_attr( $options['slider_desc_font_size' . $i] ); ?>"><span>px</span></p>
					<h4 class="theme_option_headline2"><?php _e( 'Font color', 'tcd-w' ); ?></h4>
					<input type="text" name="dp_options[slider_font_color<?php echo $i; ?>]" value="<?php echo esc_attr( $options['slider_font_color' . $i] ); ?>" data-default-color="#ffffff" class="c-color-picker">
    			<h4 class="theme_option_headline2"><?php _e( 'Dropshadow', 'tcd-w' ); ?></h4>
    			<ul class="headline_option">
						<li><label><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label><input id="dp_options[slider<?php echo $i; ?>_shadow1]" class="font_size hankaku" type="text" name="dp_options[slider<?php echo $i; ?>_shadow1]" value="<?php echo esc_attr( $options['slider' . $i . '_shadow1'] ); ?>"><span>px</span></li>
     				<li><label><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label><input id="dp_options[slider<?php echo $i; ?>_shadow2]" class="font_size hankaku" type="text" name="dp_options[slider<?php echo $i; ?>_shadow2]" value="<?php echo esc_attr( $options['slider' . $i . '_shadow2'] ); ?>"><span>px</span></li>
     				<li><label><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label><input id="dp_options[slider<?php echo $i; ?>_shadow3]" class="font_size hankaku" type="text" name="dp_options[slider<?php echo $i; ?>_shadow3]" value="<?php echo esc_attr( $options['slider' . $i . '_shadow3'] ); ?>"><span>px</span></li>
     				<li><?php _e( 'Dropshadow color', 'tcd-w' ); ?> <input type="text" name="dp_options[slider<?php echo $i; ?>_shadow_color]" value="<?php echo esc_attr( $options['slider' . $i . '_shadow_color'] ); ?>" data-default-color="#888888" class="c-color-picker"></li>
    			</ul>
    			<h4 class="theme_option_headline2"><?php _e( 'Button', 'tcd-w' ); ?></h4>
    			<p><label><input name="dp_options[display_slider_button<?php echo $i; ?>]" type="checkbox" value="1" <?php checked( 1, $options['display_slider_button' . $i] ); ?>><?php _e( 'Display button', 'tcd-w' ); ?></label></p>
    			<p><label><?php _e( 'Button label', 'tcd-w' ); ?> <input type="text" name="dp_options[slider_button_label<?php echo $i; ?>]" value="<?php echo esc_attr( $options['slider_button_label' . $i] ); ?>"></label></p>
          <p><?php _e( 'Font color', 'tcd-w' ); ?> <input type="text" class="c-color-picker" name="dp_options[slider_btn_color<?php echo $i; ?>]" value="<?php echo esc_attr( $options['slider_btn_color' . $i] ); ?>" data-default-color="#000000"></p> 
          <p><?php _e( 'Background color', 'tcd-w' ); ?> <input type="text" class="c-color-picker" name="dp_options[slider_btn_bg<?php echo $i; ?>]" value="<?php echo esc_attr( $options['slider_btn_bg' . $i] ); ?>" data-default-color="#ff8000"></p> 
          <p><?php _e( 'Font color on hover', 'tcd-w' ); ?> <input type="text" class="c-color-picker" name="dp_options[slider_btn_color_hover<?php echo $i; ?>]" value="<?php echo esc_attr( $options['slider_btn_color_hover' . $i] ); ?>" data-default-color="#ffffff"></p> 
          <p><?php _e( 'Background color on hover', 'tcd-w' ); ?> <input type="text" class="c-color-picker" name="dp_options[slider_btn_bg_hover<?php echo $i; ?>]" value="<?php echo esc_attr( $options['slider_btn_bg_hover' . $i] ); ?>" data-default-color="#e37100"></p> 
      		<h4 class="theme_option_headline2"><?php _e( 'Link URL', 'tcd-w' ); ?></h4>
      		<input class="regular-text" type="text" name="dp_options[slider_url<?php echo esc_attr( $i ); ?>]" value="<?php echo esc_attr( $options['slider_url' . $i] ); ?>">
      		<p><label><input id="dp_options[slider_target<?php echo esc_attr( $i ); ?>]" name="dp_options[slider_target<?php echo esc_attr( $i ); ?>]" type="checkbox" value="1" <?php checked( 1, $options['slider_target' . $i] ); ?>><?php _e( 'Open link in new window', 'tcd-w' ); ?></label></p>
					<h4 class="theme_option_headline2"><?php _e( 'Image', 'tcd-w' ); ?></h4>
      		<p><?php _e( 'Recommend image size. Width:560px, Max height:445px', 'tcd-w' ); ?></p>
      		<div class="image_box cf">
       			<div class="cf cf_media_field hide-if-no-js slider_image<?php echo esc_attr( $i ); ?>">
        			<input type="hidden" value="<?php echo esc_attr( $options['slider_image' . $i] ); ?>" id="slider_image<?php echo esc_attr( $i ); ?>" name="dp_options[slider_image<?php echo esc_attr( $i ); ?>]" class="cf_media_id">
        			<div class="preview_field"><?php if ( $options['slider_image' . $i] ) { echo wp_get_attachment_image( $options['slider_image' . $i], 'medium' ); } ?></div>
        			<div class="button_area">
         				<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
         				<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['slider_image' . $i] ) { echo 'hidden'; } ?>">
        			</div>
       			</div>
      		</div>
					<h4 class="theme_option_headline2"><?php _e( 'Background image', 'tcd-w' ); ?></h4>
      		<p><?php _e( 'Recommend image size. Width:1450px or more, Height:780px or more', 'tcd-w' ); ?></p>
      		<div class="image_box cf">
       			<div class="cf cf_media_field hide-if-no-js slider_bg_image<?php echo esc_attr( $i ); ?>">
        			<input type="hidden" value="<?php echo esc_attr( $options['slider_bg_image' . $i] ); ?>" id="slider_bg_image<?php echo esc_attr( $i ); ?>" name="dp_options[slider_bg_image<?php echo esc_attr( $i ); ?>]" class="cf_media_id">
        			<div class="preview_field"><?php if ( $options['slider_bg_image' . $i] ) { echo wp_get_attachment_image( $options['slider_bg_image' . $i], 'medium' ); } ?></div>
        			<div class="button_area">
         				<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
         				<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['slider_bg_image' . $i] ) { echo 'hidden'; } ?>">
        			</div>
       			</div>
      		</div>
      		<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
       	</div>
      </div>
			<?php endfor; ?>
		</div><!-- END #header_content_slider -->
		<div id="header_content_video" style="<?php if ( $options['header_content_type'] == 'type2' ) { echo 'display:block;'; } else { echo 'display:none;'; } ?>">
   		<div class="sub_box cf"> 
   			<h3 class="theme_option_subbox_headline"><?php _e( 'Video setting', 'tcd-w' ); ?></h3>
				<div class="sub_box_content">
   				<p><?php _e( 'Please upload MP4 format file.', 'tcd-w' );  ?></p>
   				<div class="image_box cf">
   					<div class="upload_banner_button_area">
   						<div class="hide">
								<input type="text" size="36" name="dp_options[video]" value="<?php echo esc_attr( $options['video'] ); ?>">
							</div>
   						<input type="file" name="video_file" id="video_file">
   						<input type="submit" class="button-ml" value="<?php echo _e( 'Upload video file', 'tcd-w' ); ?>">
   					</div>
						<?php if ( $options['video'] ) : ?>
   					<div class="uploaded_banner_image">
   						<p><?php esc_attr_e( $options['video'] ); ?></p>
   					</div>
						<?php if ( dp_is_uploaded_img( $options['video'] ) ) : ?>
   					<div class="delete_uploaded_banner_image">
   						<a href="<?php echo wp_nonce_url( admin_url( 'themes.php?page=theme_options' ), 'dp_delete_video' ); ?>" class="button" onclick="if(!confirm('<?php _e( 'Are you sure to delete this file?', 'tcd-w' ); ?>')) return false;"><?php _e( 'Delete', 'tcd-w' ); ?></a>
   					</div>
						<?php endif; ?>
						<?php endif; ?>
   				</div>
   			</div>
   		</div>
   		<div class="sub_box cf"> 
   			<h3 class="theme_option_subbox_headline"><?php _e( 'Substitute image', 'tcd-w' ); ?></h3>
				<div class="sub_box_content"> 
   				<p><?php _e( 'This image will be displayed instead of video in smartphone.<br /> Also this image will be displayed in the browser which MP4 video is not supported.', 'tcd-w' ); ?></p>
     			<p><?php _e( 'Recommend image size. Width:1450px or more, Height:780px or more', 'tcd-w' ); ?></p>
   				<div class="image_box cf">
   					<div class="cf cf_media_field hide-if-no-js video_image">
   						<input type="hidden" value="<?php echo esc_attr( $options['video_image'] ); ?>" id="video_image" name="dp_options[video_image]" class="cf_media_id">
   					  <div class="preview_field"><?php if ( $options['video_image'] ) { echo wp_get_attachment_image( $options['video_image'], 'medium' ); } ?></div>
   					  <div class="button_area">
								<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
   					   	<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['video_image'] ) { echo 'hidden'; } ?>">
   					  </div>
						</div>
   				</div>
   				<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
   			</div>
			</div>
		</div><!-- END #header_content_video -->
		<div id="header_content_youtube" style="<?php if ( $options['header_content_type'] == 'type3' ) { echo 'display:block;'; } else { echo 'display:none;'; } ?>">
    	<div class="sub_box cf"> 
     		<h3 class="theme_option_subbox_headline"><?php _e( 'Youtube setting', 'tcd-w' ); ?></h3>
				<div class="sub_box_content"> 
     			<p><?php _e( 'Please enter Youtube URL.', 'tcd-w' ); ?></p>
     			<input id="dp_options[youtube_url]" class="regular-text" type="text" name="dp_options[youtube_url]" value="<?php esc_attr_e( $options['youtube_url'] ); ?>">
     			<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
    		</div>
    	</div>
    	<div class="sub_box cf"> 
    		<h3 class="theme_option_subbox_headline"><?php _e( 'Substitute image', 'tcd-w' ); ?></h3>
				<div class="sub_box_content"> 
    			<p><?php _e( 'This image will be displayed instead of Youtube video in smartphone.', 'tcd-w' ); ?></p>
   				<p><?php _e( 'Recommend image size. Width:1450px or more, Height:780px or more', 'tcd-w' ); ?></p>
    			<div class="image_box cf">
    				<div class="cf cf_media_field hide-if-no-js youtube_image">
    					<input type="hidden" value="<?php echo esc_attr( $options['youtube_image'] ); ?>" id="youtube_image" name="dp_options[youtube_image]" class="cf_media_id">
    					<div class="preview_field"><?php if ( $options['youtube_image'] ) { echo wp_get_attachment_image( $options['youtube_image'], 'medium' ); } ?></div>
    					<div class="button_area">
    						<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
    						<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['youtube_image'] ) { echo 'hidden'; } ?>">
    					</div>
    				</div>
    			</div>
    			<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
				</div>
    	</div>
    </div><!-- END #header_content_youtube -->
    
    <?php // 動画用キャッチフレーズ -------------------------------------------------------------------------------------------- ?>
    <div id="header_content_video_catch" style="<?php if( $options['header_content_type'] == 'type1') { echo 'display:none;'; } else { echo 'display:block;'; }; ?>">
     <div class="sub_box cf"> 
      <h3 class="theme_option_subbox_headline"><?php _e('Catchphrase', 'tcd-w');  ?></h3>
      <div class="sub_box_content">
       <p><?php _e('Catchphrase will be displayed on video.', 'tcd-w');  ?></p>
       <p><label><input name="dp_options[use_video_catch]" type="checkbox" value="1" <?php checked( '1', $options['use_video_catch'] ); ?> /> <?php _e('Display catchphrase.', 'tcd-w');  ?></label></p>
       <h4 class="theme_option_headline2"><?php _e('Catchphrase', 'tcd-w');  ?></h4>
       <textarea id="dp_options[video_catch]" class="large-text" cols="50" rows="2" name="dp_options[video_catch]"><?php echo esc_textarea( $options['video_catch'] ); ?></textarea>
       <h4 class="theme_option_headline2"><?php _e('Font size of catchphrase', 'tcd-w');  ?></h4>
       <p><input id="dp_options[video_catch_font_size]" class="font_size hankaku" type="text" name="dp_options[video_catch_font_size]" value="<?php esc_attr_e( $options['video_catch_font_size'] ); ?>" /><span>px</span></p>
       <h4 class="theme_option_headline2"><?php _e('Description', 'tcd-w');  ?></h4>
       <textarea id="dp_options[video_desc]" class="large-text" cols="50" rows="2" name="dp_options[video_desc]"><?php echo esc_textarea( $options['video_desc'] ); ?></textarea>
       <h4 class="theme_option_headline2"><?php _e('Font size of description', 'tcd-w'); ?></h4>
       <p><input id="dp_options[video_desc_font_size]" class="font_size hankaku" type="text" name="dp_options[video_desc_font_size]" value="<?php esc_attr_e( $options['video_desc_font_size'] ); ?>" /><span>px</span></p>
       <h4 class="theme_option_headline2"><?php _e('Font color', 'tcd-w');  ?></h4>
       <input type="text" name="dp_options[video_catch_color]" value="<?php echo esc_attr( $options['video_catch_color'] ); ?>" data-default-color="#ffffff" class="c-color-picker">
       <h4 class="theme_option_headline2"><?php _e('Dropshadow', 'tcd-w');  ?></h4>
       <ul class="headline_option">
        <li><label><?php _e('Dropshadow position (left)', 'tcd-w');  ?></label><input id="dp_options[video_catch_shadow1]" class="font_size hankaku" type="text" name="dp_options[video_catch_shadow1]" value="<?php esc_attr_e( $options['video_catch_shadow1'] ); ?>" /><span>px</span></li>
        <li><label><?php _e('Dropshadow position (top)', 'tcd-w');  ?></label><input id="dp_options[video_catch_shadow2]" class="font_size hankaku" type="text" name="dp_options[video_catch_shadow2]" value="<?php esc_attr_e( $options['video_catch_shadow2'] ); ?>" /><span>px</span></li>
        <li><label><?php _e('Dropshadow size', 'tcd-w');  ?></label><input id="dp_options[video_catch_shadow3]" class="font_size hankaku" type="text" name="dp_options[video_catch_shadow3]" value="<?php esc_attr_e( $options['video_catch_shadow3'] ); ?>" /><span>px</span></li>
        <li><label><?php _e('Dropshadow color', 'tcd-w');  ?></label><input type="text" name="dp_options[video_catch_shadow_color]" value="<?php echo esc_attr( $options['video_catch_shadow_color'] ); ?>" data-default-color="#333333" class="c-color-picker"></li>
       </ul>
       <?php // ボタン ---------- ?>
       <h4 class="theme_option_headline2"><?php _e('Button setting', 'tcd-w');  ?></h4>
       <p class="show_video_catch_button"><label><input id="dp_options[show_video_catch_button]" name="dp_options[show_video_catch_button]" type="checkbox" value="1" <?php checked( '1', $options['show_video_catch_button'] ); ?> /> <?php _e('Display button.', 'tcd-w');  ?></label></p>
       <div class="video_catch_button_setting" style="<?php if( $options['show_video_catch_button'] == 1 ) { echo 'display:block;'; } else { echo 'display:none;'; }; ?>">
        <h4 class="theme_option_headline2"><?php _e('Label of button', 'tcd-w');  ?></h4>
        <input id="dp_options[video_catch_button]" class="regular-text" type="text" name="dp_options[video_catch_button]" value="<?php esc_attr_e( $options['video_catch_button'] ); ?>" />
        <h4 class="theme_option_headline2"><?php _e('Button color setting', 'tcd-w');  ?></h4>
        <ul class="headline_option">
         <li><label><?php _e('Font color', 'tcd-w');  ?></label><input type="text" name="dp_options[video_button_color]" value="<?php echo esc_attr( $options['video_button_color'] ); ?>" data-default-color="#ffffff" class="c-color-picker"></li>
         <li><label><?php _e('Background color', 'tcd-w');  ?></label><input type="text" name="dp_options[video_button_bg_color]" value="<?php echo esc_attr( $options['video_button_bg_color'] ); ?>" data-default-color="#ff7f00" class="c-color-picker"></li>
         <li><label><?php _e('Font hover color', 'tcd-w');  ?></label><input type="text" name="dp_options[video_button_color_hover]" value="<?php echo esc_attr( $options['video_button_color_hover'] ); ?>" data-default-color="#ffffff" class="c-color-picker"></li>
         <li><label><?php _e('Background hover color', 'tcd-w');  ?></label><input type="text" name="dp_options[video_button_bg_color_hover]" value="<?php echo esc_attr( $options['video_button_bg_color_hover'] ); ?>" data-default-color="#ff7f00" class="c-color-picker"></li>
        </ul>
        <?php // リンク ---------- ?>
        <h4 class="theme_option_headline2"><?php _e('Button link URL', 'tcd-w');  ?></h4>
        <input id="dp_options[video_button_url]" class="regular-text" type="text" name="dp_options[video_button_url]" value="<?php esc_attr_e( $options['video_button_url'] ); ?>" />
        <p><label><input id="dp_options[video_button_target]" name="dp_options[video_button_target]" type="checkbox" value="1" <?php checked( '1', $options['video_button_target'] ); ?> /> <?php _e('Open link in new window', 'tcd-w');  ?></label></p>
       </div>
     	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
      </div><!-- END .sub_box_content -->
     </div><!-- END .sub_box -->
    </div><!-- END #header_content_video_catch -->
  	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
	</div>
	<?php // ニュースティッカー ?>
	<div class="theme_option_field cf">
		<h3 class="theme_option_headline"><?php _e( 'News ticker settings', 'tcd-w' ); ?></h3>
		<p><?php _e( 'Displayed at the bottom of the header content of the front page.', 'tcd-w' ); ?></p>
    <p><label><input name="dp_options[display_news_ticker]" type="checkbox" value="1" <?php checked( 1, $options['display_news_ticker'] ); ?>><?php _e( 'Display this content on top page', 'tcd-w' ); ?></label></p>
    <p><label><input name="dp_options[display_news_ticker_date]" type="checkbox" value="1" <?php checked( 1, $options['display_news_ticker_date'] ); ?>><?php _e( 'Display dates', 'tcd-w' ); ?></label></p>
    <h4 class="theme_option_headline2"><?php _e( 'Number of news to display', 'tcd-w' ); ?></h4>
    <input class="tiny-text" type="text" name="dp_options[news_ticker_num]" value="<?php echo esc_attr( $options['news_ticker_num'] ); ?>">
    <h4 class="theme_option_headline2"><?php _e( 'Link to news archive page', 'tcd-w' ); ?></h4>
    <p><label><?php _e( 'Link text', 'tcd-w' ); ?> <input name="dp_options[news_ticker_link_text]" type="text" class="regular-text" value="<?php echo esc_attr( $options['news_ticker_link_text'] ); ?>"></label></p>
    <p><label><input name="dp_options[display_news_ticker_link]" type="checkbox" value="1" <?php checked( 1, $options['display_news_ticker_link'] ); ?>><?php _e( 'Display archive link', 'tcd-w' ); ?></label></p>
    <input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
	</div>
	<?php // コンテンツビルダー ?>
  <div class="theme_option_field cf index_cb_data">
  	<h3 class="theme_option_headline"><?php _e( 'Contents Builder', 'tcd-w' ); ?></h3>
    <div class="theme_option_message"><?php echo __( '<p>You can build contents freely with this function.</p><p>FIRST STEP: Click Add content button.<br />SECOND STEP: Select content from dropdown menu to show on each column.</p><p>You can change row by dragging MOVE button and you can delete row by clicking DELETE button.</p>', 'tcd-w' ); ?></div>
    <div id="contents_builder_wrap">
    	<div id="contents_builder" data-delete-confirm="<?php _e( 'Are you sure you want to delete this content?', 'tcd-w' ); ?>">
      <?php
      if ( ! empty( $options['contents_builder'] ) ) :
      	foreach( $options['contents_builder'] as $key => $content ) :
        	$cb_index = 'cb_' . $key;
      ?>
      <div class="cb_row one_column">
      	<ul class="cb_button cf">
        	<li><span class="cb_move"><?php echo __( 'Move', 'tcd-w' ); ?></span></li>
        	<li><span class="cb_delete"><?php echo __( 'Delete', 'tcd-w' ); ?></span></li>
       	</ul>
       	<div class="cb_column_area cf">
        	<div class="cb_column">
         		<input type="hidden" class="cb_index" value="<?php echo $cb_index; ?>">
         		<input type="hidden" name="dp_options[contents_builder][<?php echo $cb_index; ?>][column]" value="one_column">
         		<?php the_cb_content_select( $cb_index, $content['cb_content_select'] ); ?>
         		<?php if ( ! empty( $content['cb_content_select'] ) ) the_cb_content_setting( $cb_index, $content['cb_content_select'], $content ); ?>
        </div>
       </div><!-- END .cb_column_area -->
      </div><!-- END .cb_row -->
      <?php
      	endforeach;
      endif;
      ?>
     </div><!-- END #contents_builder -->
     <div id="cb_add_row_buttton_area">
      <input type="button" value="<?php echo __( 'Add content', 'tcd-w' ); ?>" class="button-secondary add_row-one_column">
     </div>
     <p><input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>" /></p>
    </div><!-- END #contents_builder_wrap -->
   </div><!-- END .theme_option_field -->
   <?php // コンテンツビルダー追加用 非表示 ?>
   <div id="contents_builder-clone" class="hidden">
    <div class="cb_row one_column">
     <ul class="cb_button cf">
      <li><span class="cb_move"><?php echo __( 'Move', 'tcd-w' ); ?></span></li>
      <li><span class="cb_delete"><?php echo __( 'Delete', 'tcd-w' ); ?></span></li>
     </ul>
     <div class="cb_column_area cf">
      <div class="cb_column">
       <input type="hidden" class="cb_index" value="cb_cloneindex">
       <input type="hidden" name="dp_options[contents_builder][cb_cloneindex][column]" value="one_column">
       <?php the_cb_content_select( 'cb_cloneindex' ); ?>
      </div>
     </div><!-- END .cb_column_area -->
    </div><!-- END .cb_row -->
    <?php
    // キャッチフレーズと説明文
    the_cb_content_setting( 'cb_cloneindex', 'catch_and_desc' );

    // 3つのボックスコンテンツ
    the_cb_content_setting( 'cb_cloneindex', 'three_boxes' );

    // ショーケース
    the_cb_content_setting( 'cb_cloneindex', 'showcase' );

    // ギャラリーコンテンツ
    the_cb_content_setting( 'cb_cloneindex', 'gallery_content' );

    // 円形画像とテキスト
    the_cb_content_setting( 'cb_cloneindex', 'circular_images_and_texts' );

    // レビュースライダー
    the_cb_content_setting( 'cb_cloneindex', 'review_slider' );

    // フリースペース
    the_cb_content_setting( 'cb_cloneindex', 'wysiwyg' );
    ?>
	</div><!-- END #contents_builder-clone.hidden -->
  <?php // コンテンツビルダーここまで ---------------------------------------------------------------- ?>	
</div><!-- END #tab-content3 -->
