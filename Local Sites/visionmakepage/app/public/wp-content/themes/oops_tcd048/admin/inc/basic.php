<?php 
global $font_type_options, $headline_font_type_options, $responsive_options, $load_icon_options, $load_time_options, $hover_type_options, $hover2_direct_options, $sns_type_top_options, $sns_type_btm_options;
$options = get_desing_plus_option(); 
?>
<div id="tab-content1">
	<?php // 色の設定 ?>
	<div id="color_pattern">
		<div class="theme_option_field cf">
			<h3 class="theme_option_headline"><?php _e( 'Color setting', 'tcd-w' ); ?></h3>
			<h4 class="theme_option_headline2"><?php _e( 'Primary color setting', 'tcd-w' ); ?></h4>
			<input type="text" name="dp_options[primary_color]" value="<?php echo esc_attr( $options['primary_color'] ); ?>" data-default-color="#121d1f" class="c-color-picker">	
			<h4 class="theme_option_headline2"><?php _e( 'Secondary color setting', 'tcd-w' ); ?></h4>
			<input type="text" name="dp_options[secondary_color]" value="<?php echo esc_attr( $options['secondary_color'] ); ?>" data-default-color="#ff7f00" class="c-color-picker">	
			<h4 class="theme_option_headline2"><?php _e( 'Tertiary color setting', 'tcd-w' ); ?></h4>
			<input type="text" name="dp_options[tertiary_color]" value="<?php echo esc_attr( $options['tertiary_color'] ); ?>" data-default-color="#e37100" class="c-color-picker">	
			<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
		</div>
	</div>
	<?php // ファビコンの設定 ?>
	<div class="theme_option_field cf">
		<h3 class="theme_option_headline"><?php _e( 'Favicon setup', 'tcd-w' ); ?></h3>
		<p><?php _e( 'Setting for the favicon displayed at browser address bar or tab.', 'tcd-w' ); ?></p>
		<p><?php _e( 'Favicon file', 'tcd-w' ); ?><?php _e( ' (Recommended size: width:16px, height:16px)', 'tcd-w' ); ?></p>
		<p><?php _e( 'You can use .ico, .png or .gif file, and we recommed you to use .ico file.', 'tcd-w' ); ?></p>
    <div class="image_box cf">
    	<div class="cf cf_media_field hide-if-no-js favicon">
    		<input type="hidden" value="<?php echo esc_attr( $options['favicon'] ); ?>" id="favicon" name="dp_options[favicon]" class="cf_media_id">
    		<div class="preview_field"><?php if ( $options['favicon'] ) { echo wp_get_attachment_image($options['favicon'], 'medium' ); } ?></div>
    		<div class="button_area">
    			<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
    			<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['favicon'] ) { echo 'hidden'; } ?>">
    		</div>
    	</div>
    </div>
    <input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
	</div>						
	<?php // フォントタイプ ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Font type', 'tcd-w' ); ?></h3>
		<p><?php _e( 'Please set the font type of all text except for headline.', 'tcd-w' ); ?></p>
  	<fieldset class="cf select_type2">
			<?php foreach ( $font_type_options as $option ) : ?>
			<label class="description"><input type="radio" name="dp_options[font_type]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $options['font_type'] ); ?>><?php esc_html_e( $option['label'], 'tcd-w' ); ?></label>
			<?php endforeach; ?>
		</fieldset>
		<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
	</div>
	<?php // 大見出しのフォントタイプ ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Font type of headline', 'tcd-w' ); ?></h3>
  	<fieldset class="cf select_type2">
			<?php foreach ( $headline_font_type_options as $option ) : ?>
			<label class="description"><input type="radio" name="dp_options[headline_font_type]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php checked( $option['value'], $options['headline_font_type'] ); ?>><?php esc_html_e( $option['label'], 'tcd-w' ); ?></label>
			<?php endforeach; ?>
    </fieldset>
		<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
	</div>
	<?php // 絵文字の設定 ?>
  <div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Emoji setup', 'tcd-w' ); ?></h3>
  	<p><?php _e( 'We recommend to checkoff this option if you dont use any Emoji in your post content.', 'tcd-w' );  ?></p>
  	<p><label><input id="dp_options[use_emoji]" name="dp_options[use_emoji]" type="checkbox" value="1" <?php checked( 1, $options['use_emoji'] ); ?>><?php _e( 'Use emoji', 'tcd-w' ); ?></label></p>
		<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
  </div>
	<?php // レスポンシブ設定 ?>
  <div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Responsive design setting', 'tcd-w' ); ?></h3>
  	<fieldset class="cf select_type2">
			<?php foreach ( $responsive_options as $option ) : ?>
			<label class="description"><input type="radio" name="dp_options[responsive]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php checked( $option['value'], $options['responsive'] ); ?>><?php _e( $option['label'], 'tcd-w' ); ?></label>
			<?php endforeach; ?>
    </fieldset>
   	<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
	</div>
	<?php // ロード画面の設定 ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Loading screen setting', 'tcd-w' ); ?></h3>
  	<p><label><input id="dp_options[use_load_icon]" name="dp_options[use_load_icon]" type="checkbox" value="1" <?php checked( 1, $options['use_load_icon'] ); ?>><?php _e( 'Use load icon.', 'tcd-w' ); ?></label></p>
		<h4 class="theme_option_headline2"><?php _e( 'Type of loader', 'tcd-w' ); ?></h4>
    <select id="load_icon_type" name="dp_options[load_icon]">
    	<?php foreach ( $load_icon_options as $option ) : ?>
      <option style="padding-right: 10px;" value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $options['load_icon'] ); ?>><?php esc_html_e( $option['label'], 'tcd-w' ); ?></option>
      <?php endforeach; ?>
    </select>
    <h4 class="theme_option_headline2"><?php _e( 'Maximum display time', 'tcd-w' ); ?></h4>
  	<p><?php _e( 'Please set the maximum display time of the loading screen.<br />Even if all the content is not loaded, loading screen will disappear automatically after a lapse of time you have set at follwing.', 'tcd-w' ); ?></p>
  	<select name="dp_options[load_time]">
			<?php foreach ( $load_time_options as $option ) : ?>
      <option style="padding-right: 10px;" value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $options['load_time'] ); ?>><?php echo esc_html( $option['label'] ); ?><?php _e( ' seconds', 'tcd-w' ); ?></option>
			<?php endforeach; ?>
		</select>
    <input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
	</div>
	<?php // ホバーエフェクトの設定 ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Hover effect settings', 'tcd-w' ); ?></h3>
  	<h4 class="theme_option_headline2"><?php _e( 'Hover effect type', 'tcd-w' ); ?></h4>
  	<p><?php _e( 'Please set the hover effect for thumbnail images.', 'tcd-w' ); ?></p>
  	<fieldset class="cf select_type2">
			<?php foreach ( $hover_type_options as $option ) : ?>     
			<input type="radio" id="tab-<?php echo $option['value']; ?>" name="dp_options[hover_type]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $options['hover_type'] ); ?>><label for="tab-<?php echo $option['value']; ?>" class="description" style="display: inline;"><?php esc_html_e( $option['label'], 'tcd-w' ); ?></label><br>
			<?php endforeach; ?>
			<div class="tab-box">
				<div id="tabView1">
		  		<h4 class="theme_option_headline2"><?php _e( 'Settings for Zoom effect', 'tcd-w' ); ?></h4>
		  		<p><?php _e( 'Please set the rate of magnification.', 'tcd-w' ); ?></p>
		  		<input id="dp_options[hover1_zoom]" class="hankaku" style="width:45px;" type="text" name="dp_options[hover1_zoom]" value="<?php echo esc_attr( $options['hover1_zoom'] ); ?>">
					<p><label><input type="checkbox" name="dp_options[hover1_rotate]" value="1" <?php checked( 1, $options['hover1_rotate'] ); ?>><?php _e( 'Rotate images on hover', 'tcd-w' ); ?></label></p>
		  		<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
	    	</div>
    		<div id="tabView2">
		  		<h4 class="theme_option_headline2"><?php _e( 'Settings for Slide effect', 'tcd-w' ); ?></h4>
		  		<p><?php _e( 'Please set the direction of slide.', 'tcd-w' ); ?></p>
		  		<fieldset class="cf select_type2">
						<?php foreach ( $hover2_direct_options as $option ) : ?>
		    	 	<label class="description" style="display:inline-block;margin-right:15px;"><input type="radio" name="dp_options[hover2_direct]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $options['hover2_direct'] ); ?>><?php esc_html_e( $option['label'], 'tcd-w' ); ?></label>
						<?php endforeach; ?>
		    	</fieldset>
					<p><?php _e( 'Please set the opacity. (0 - 1.0, e.g. 0.7)', 'tcd-w' ); ?></p>
		    	<input id="dp_options[hover2_opacity]" class="hankaku" style="width:45px;" type="text" name="dp_options[hover2_opacity]" value="<?php echo esc_attr( $options['hover2_opacity'] ); ?>">
		    	<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
	    	</div>
    		<div id="tabView3">
		    	<h4 class="theme_option_headline2"><?php _e( 'Settings for Fade effect', 'tcd-w' ); ?></h4>
		    	<p><?php _e( 'Please set the opacity. (0 - 1.0, e.g. 0.7)', 'tcd-w' ); ?></p>
		    	<input id="dp_options[hover3_opacity]" class="hankaku" style="width:45px;" type="text" name="dp_options[hover3_opacity]" value="<?php echo esc_attr( $options['hover3_opacity'] ); ?>">
		    	<p><?php _e( 'Please set the background color.', 'tcd-w' ); ?></p>
					<input type="text" name="dp_options[hover3_bgcolor]" value="<?php echo esc_attr( $options['hover3_bgcolor'] ); ?>" data-default-color="#ffffff" class="c-color-picker">	
		  		<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
	    	</div>
    	</div>
    </fieldset>
  </div>
	<?php // Use OGP tag ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Facebook OGP setting', 'tcd-w' ); ?></h3>
  	<div class="theme_option_input">
  		<p><label><input id="dp_options[use_ogp]" name="dp_options[use_ogp]" type="checkbox" value="1" <?php checked( '1', $options['use_ogp'] ); ?>><?php _e( 'Use OGP', 'tcd-w' );  ?></label></p>
  		<p><?php _e( 'Your fb:admins ID', 'tcd-w' );  ?> <input id="dp_options[fb_admin_id]" class="regular-text" type="text" name="dp_options[fb_admin_id]" value="<?php esc_attr_e( $options['fb_admin_id'] ); ?>"></p>
  		<p><?php _e( '<a href="http://design-plus1.com/tcd-w/2016/07/facebook-3.html" target="_blank">Information about Facebook OGP and fb:admins ID</a>', 'tcd-w' ); ?></p>
  	</div>
		<h4 class="theme_option_headline2"><?php _e( 'OGP image', 'tcd-w' ); ?></h4>
		<p><?php _e( 'This image is displayed for OGP if the page does not have a thumbnail.', 'tcd-w' ); ?></p>
		<p><?php _e( 'Recommend image size. Width:1200px, Height:630px', 'tcd-w' ); ?></p>
		<div class="image_box cf">
			<div class="cf cf_media_field hide-if-no-js">
				<input type="hidden" value="<?php echo esc_attr( $options['ogp_image'] ); ?>" id="ogp_image" name="dp_options[ogp_image]" class="cf_media_id">
				<div class="preview_field"><?php if ( $options['ogp_image'] ) { echo wp_get_attachment_image( $options['ogp_image'], 'medium'); } ?></div>
				<div class="button_area">
					<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
					<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['ogp_image'] ) { echo 'hidden'; } ?>">
				</div>
			</div>
		</div>
  	<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
  </div>
	<?php // Use twitter card ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Twitter Cards setting', 'tcd-w' );  ?></h3>
  	<div class="theme_option_input">
  		<p><label><input id="dp_options[use_twitter_card]" name="dp_options[use_twitter_card]" type="checkbox" value="1" <?php checked( '1', $options['use_twitter_card'] ); ?>> <?php _e( 'Use Twitter Cards', 'tcd-w' );  ?></label></p>
		<p><?php _e( 'Your Twitter account name (exclude @ mark)', 'tcd-w' ); ?><input id="dp_options[twitter_account_name]" class="regular-text" type="text" name="dp_options[twitter_account_name]" value="<?php esc_attr_e( $options['twitter_account_name'] ); ?>"></p>
  		<p><a href="http://design-plus1.com/tcd-w/2016/11/twitter-cards.html" target="_blank"><?php _e( 'Information about Twitter Cards.', 'tcd-w' ); ?></a></p>
  	</div>
  	<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
  </div>
	<?php // ソーシャルボタンの表示設定 ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Social button Setup', 'tcd-w' ); ?></h3>
  	<div class="theme_option_input">
  		<h4 class="theme_option_headline2"><?php _e( 'Type of button on article top', 'tcd-w' ); ?></h4>
  		<fieldset class="cf">
  			<ul class="cf">
					<?php foreach ( $sns_type_top_options as $option ) : ?>
     			<li><label><input type="radio" name="dp_options[sns_type_top]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $options['sns_type_top'] ); ?>><?php esc_html_e( $option['label'], 'tcd-w' ); ?></label></li>
					<?php endforeach; ?>
    		</ul>
			</fieldset>
    	<h4 class="theme_option_headline2"><?php _e( 'Select the social button to show on article top', 'tcd-w' ); ?></h4>
      <ul>
      	<li><label><input id="dp_options[show_twitter_top]" name="dp_options[show_twitter_top]" type="checkbox" value="1" <?php checked( '1', $options['show_twitter_top'] ); ?>><?php _e( 'Display twitter button', 'tcd-w' ); ?></label></li>
      	<li><label><input id="dp_options[show_fblike_top]" name="dp_options[show_fblike_top]" type="checkbox" value="1" <?php checked( '1', $options['show_fblike_top'] ); ?> /><?php _e( 'Display facebook like button -Button type 5 (Default button) only', 'tcd-w' ); ?></label></li>
      	<li><label><input id="dp_options[show_fbshare_top]" name="dp_options[show_fbshare_top]" type="checkbox" value="1" <?php checked( '1', $options['show_fbshare_top'] ); ?> /><?php _e( 'Display facebook share button', 'tcd-w' ); ?></label></li>
      	<li><label><input id="dp_options[show_google_top]" name="dp_options[show_google_top]" type="checkbox" value="1" <?php checked( '1', $options['show_google_top'] ); ?> /><?php _e( 'Display google+ button', 'tcd-w' ); ?></label></li>
      	<li><label><input id="dp_options[show_hatena_top]" name="dp_options[show_hatena_top]" type="checkbox" value="1" <?php checked( '1', $options['show_hatena_top'] ); ?> /><?php _e( 'Display hatena button', 'tcd-w' ); ?></label></li>
      	<li><label><input id="dp_options[show_pocket_top]" name="dp_options[show_pocket_top]" type="checkbox" value="1" <?php checked( '1', $options['show_pocket_top'] ); ?>><?php _e( 'Display pocket button', 'tcd-w' ); ?></label></li>
      	<li><label><input id="dp_options[show_feedly_top]" name="dp_options[show_feedly_top]" type="checkbox" value="1" <?php checked( '1', $options['show_feedly_top'] ); ?>><?php _e( 'Display feedly button', 'tcd-w' ); ?></label></li>
      	<li><label><input id="dp_options[show_rss_top]" name="dp_options[show_rss_top]" type="checkbox" value="1" <?php checked( '1', $options['show_rss_top'] ); ?>><?php _e( 'Display rss button', 'tcd-w' ); ?></label></li>
      	<li><label><input id="dp_options[show_pinterest_top]" name="dp_options[show_pinterest_top]" type="checkbox" value="1" <?php checked( '1', $options['show_pinterest_top'] ); ?> /><?php _e( 'Display pinterest button', 'tcd-w' ); ?></label></li>
      </ul>
    	<h4 class="theme_option_headline2"><?php _e( 'Type of button on article bottom', 'tcd-w' ); ?></h4>
    	<fieldset class="cf">
    		<ul class="cf">
					<?php foreach ( $sns_type_btm_options as $option ) : ?>
     			<li><label><input type="radio" name="dp_options[sns_type_btm]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php checked( $option['value'], $options['sns_type_btm'] ); ?>><?php esc_html_e( $option['label'], 'tcd-w' ); ?></label></li>
					<?php endforeach; ?>
				</ul>
    	</fieldset>
			<h4 class="theme_option_headline2"><?php _e( 'Select the social button to show on article bottom', 'tcd-w' ); ?></h4>
      <ul>
      	<li><label><input id="dp_options[show_twitter_btm]" name="dp_options[show_twitter_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_twitter_btm'] ); ?>><?php _e( 'Display twitter button', 'tcd-w' ); ?></label></li>
      	<li><label><input id="dp_options[show_fblike_btm]" name="dp_options[show_fblike_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_fblike_btm'] ); ?>><?php _e( 'Display facebook like button-Button type 5 (Default button) only', 'tcd-w' ); ?></label></li>
      	<li><label><input id="dp_options[show_fbshare_btm]" name="dp_options[show_fbshare_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_fbshare_btm'] ); ?>><?php _e( 'Display facebook share button', 'tcd-w' ); ?></label></li>
      	<li><label><input id="dp_options[show_google_btm]" name="dp_options[show_google_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_google_btm'] ); ?> /><?php _e( 'Display google+ button', 'tcd-w' ); ?></label></li>
				<li><label><input id="dp_options[show_hatena_btm]" name="dp_options[show_hatena_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_hatena_btm'] ); ?>><?php _e( 'Display hatena button', 'tcd-w' ); ?></label></li>
      	<li><label><input id="dp_options[show_pocket_btm]" name="dp_options[show_pocket_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_pocket_btm'] ); ?>><?php _e( 'Display pocket button', 'tcd-w' ); ?></label></li>
        <li><label><input id="dp_options[show_feedly_btm]" name="dp_options[show_feedly_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_feedly_btm'] ); ?>><?php _e( 'Display feedly button', 'tcd-w' ); ?></label></li>
        <li><label><input id="dp_options[show_rss_btm]" name="dp_options[show_rss_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_rss_btm'] ); ?>><?php _e( 'Display rss button', 'tcd-w' ); ?></label></li>
        <li><label><input id="dp_options[show_pinterest_btm]" name="dp_options[show_pinterest_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_pinterest_btm'] ); ?>><?php _e( 'Display pinterest button', 'tcd-w' ); ?></label></li>
      </ul>
    	<h4 class="theme_option_headline2"><?php _e( 'Setting for the twitter button', 'tcd-w' ); ?></h4>
      	<label style="margin-top:20px;"><?php _e( 'Set of twitter account. (ex.designplus)', 'tcd-w' ); ?></label>
      	<input style="display:block; margin:.6em 0 1em;" id="dp_options[twitter_info]" class="regular-text" type="text" name="dp_options[twitter_info]" value="<?php esc_attr_e( $options['twitter_info'] ); ?>">
     	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
    </div>
	</div>
	<?php // カスタムCSS ?>
	<div class="theme_option_field cf">
		<h3 class="theme_option_headline"><?php _e( 'Free input area for user definition CSS.', 'tcd-w' );  ?></h3>
  	<p><?php _e( 'Code example:<br /><strong>.example { font-size:12px; }</strong>', 'tcd-w' );  ?></p>
  	<textarea id="dp_options[css_code]" class="large-text" cols="50" rows="10" name="dp_options[css_code]"><?php echo esc_textarea( $options['css_code'] ); ?></textarea>
  	<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
	</div>
</div><!-- END #tab-content1 -->
