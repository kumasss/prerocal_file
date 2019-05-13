<?php $options = get_desing_plus_option(); ?>
<div id="tab-content4">
	<?php // アーカイブページヘッダーの設定 ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Setting for archive page header', 'tcd-w' ); ?></h3>
		<h4 class="theme_option_headline2"><?php _e( 'Header image', 'tcd-w' ); ?></h4>
    <p><?php _e( 'Recommend image size. Width:1450px, Height:500px', 'tcd-w' ); ?></p>
    <div class="image_box cf">
    	<div class="cf cf_media_field hide-if-no-js archive_image">
    		<input type="hidden" value="<?php echo esc_attr( $options['archive_image'] ); ?>" id="archive_image" name="dp_options[archive_image]" class="cf_media_id">
    		<div class="preview_field"><?php if ( $options['archive_image'] ) { echo wp_get_attachment_image($options['archive_image'], 'medium' ); } ?></div>
    		<div class="button_area">
    			<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
    			<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['archive_image'] ) { echo 'hidden'; } ?>">
    		</div>
    	</div>
    </div>
		<h4 class="theme_option_headline2"><?php _e( 'Color of overlay', 'tcd-w' ); ?></h4>
		<input type="text" name="dp_options[archive_overlay]" value="<?php echo esc_attr( $options['archive_overlay'] ); ?>" data-default-color="#0b3247" class="c-color-picker">
		<h4 class="theme_option_headline2"><?php _e( 'Opacity of overlay', 'tcd-w' ); ?></h4>
		<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.7)', 'tcd-w' ); ?></p>
		<input id="dp_options[archive_overlay_opacity]" class="hankaku" style="width:45px;" type="text" name="dp_options[archive_overlay_opacity]" value="<?php echo esc_attr( $options['archive_overlay_opacity'] ); ?>">
    <h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
    <input id="dp_options[archive_catchphrase]" class="regular-text" type="text" name="dp_options[archive_catchphrase]" value="<?php echo esc_attr( $options['archive_catchphrase'] ); ?>">
    <h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
    <textarea cols="50" rows="4" id="dp_options[archive_desc]" name="dp_options[archive_desc]"><?php echo esc_textarea( $options['archive_desc'] ); ?></textarea>
    <h4 class="theme_option_headline2"><?php _e( 'Font size of catchphrase', 'tcd-w' ); ?></h4>
    <p><input id="dp_options[archive_catchphrase_font_size]" class="font_size hankaku" type="text" name="dp_options[archive_catchphrase_font_size]" value="<?php echo esc_attr( $options['archive_catchphrase_font_size'] ); ?>"><span>px</span></p>
    <h4 class="theme_option_headline2"><?php _e( 'Font size of description', 'tcd-w' ); ?></h4>
    <p><input id="dp_options[archive_desc_font_size]" class="font_size hankaku" type="text" name="dp_options[archive_desc_font_size]" value="<?php echo esc_attr( $options['archive_desc_font_size'] ); ?>"><span>px</span></p>
    <h4 class="theme_option_headline2"><?php _e( 'Font color', 'tcd-w' ); ?></h4>
		<input type="text" name="dp_options[archive_color]" value="<?php echo esc_attr( $options['archive_color'] ); ?>" data-default-color="#ffffff" class="c-color-picker">
    <h4 class="theme_option_headline2"><?php _e( 'Dropshadow', 'tcd-w' ); ?></h4>
    <ul class="headline_option">
			<li><label><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label><input id="dp_options[archive_shadow1]" class="font_size hankaku" type="text" name="dp_options[archive_shadow1]" value="<?php echo esc_attr( $options['archive_shadow1'] ); ?>"><span>px</span></li>
     	<li><label><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label><input id="dp_options[archive_shadow2]" class="font_size hankaku" type="text" name="dp_options[archive_shadow2]" value="<?php echo esc_attr( $options['archive_shadow2'] ); ?>"><span>px</span></li>
     	<li><label><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label><input id="dp_options[archive_shadow3]" class="font_size hankaku" type="text" name="dp_options[archive_shadow3]" value="<?php echo esc_attr( $options['archive_shadow3'] ); ?>"><span>px</span></li>
     	<li><?php _e( 'Dropshadow color', 'tcd-w' ); ?> <input type="text" name="dp_options[archive_shadow_color]" value="<?php echo esc_attr( $options['archive_shadow_color'] ); ?>" data-default-color="#888888" class="c-color-picker"></li>
    </ul>
    <input type="submit" class="button-ml" value="<?php echo _e( 'Save Changes', 'tcd-w' ); ?>">
	</div>
	<?php // 記事詳細ページの設定 ?>
  <div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Single Page Settings', 'tcd-w' ); ?></h3>
		<p><?php _e( 'In a single page, a thumbnail you set is displayed in the header area. If a thumbnail is not set, the header image of the archive page is used.', 'tcd-w' ); ?></p>
		<h4 class="theme_option_headline2"><?php _e( 'Color of overlay', 'tcd-w' ); ?></h4>
		<input type="text" name="dp_options[blog_overlay]" value="<?php echo esc_attr( $options['blog_overlay'] ); ?>" data-default-color="#000000" class="c-color-picker">
		<h4 class="theme_option_headline2"><?php _e( 'Opacity of overlay', 'tcd-w' ); ?></h4>
		<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.7)', 'tcd-w' ); ?></p>
		<input id="dp_options[blog_overlay_opacity]" class="hankaku" style="width:45px;" type="text" name="dp_options[blog_overlay_opacity]" value="<?php echo esc_attr( $options['blog_overlay_opacity'] ); ?>">
  	<h4 class="theme_option_headline2"><?php _e( 'Font color', 'tcd-w' ); ?></h4>
		<input type="text" name="dp_options[blog_color]" value="<?php echo esc_attr( $options['blog_color'] ); ?>" data-default-color="#ffffff" class="c-color-picker">
  	<h4 class="theme_option_headline2"><?php _e( 'Dropshadow', 'tcd-w' ); ?></h4>
  	<ul class="headline_option">
			<li><label><?php _e( 'Dropshadow position (left)', 'tcd-w' ); ?></label><input id="dp_options[blog_shadow1]" class="font_size hankaku" type="text" name="dp_options[blog_shadow1]" value="<?php echo esc_attr( $options['blog_shadow1'] ); ?>"><span>px</span></li>
  		<li><label><?php _e( 'Dropshadow position (top)', 'tcd-w' ); ?></label><input id="dp_options[blog_shadow2]" class="font_size hankaku" type="text" name="dp_options[blog_shadow2]" value="<?php echo esc_attr( $options['blog_shadow2'] ); ?>"><span>px</span></li>
  		<li><label><?php _e( 'Dropshadow size', 'tcd-w' ); ?></label><input id="dp_options[blog_shadow3]" class="font_size hankaku" type="text" name="dp_options[blog_shadow3]" value="<?php echo esc_attr( $options['blog_shadow3'] ); ?>"><span>px</span></li>
  		<li><?php _e( 'Dropshadow color', 'tcd-w' ); ?> <input type="text" name="dp_options[blog_shadow_color]" value="<?php echo esc_attr( $options['blog_shadow_color'] ); ?>" data-default-color="#888888" class="c-color-picker"></li>
  	</ul>
  	<h4 class="theme_option_headline2"><?php _e( 'Font size of post title', 'tcd-w' ); ?></h4>
  	<input id="dp_options[title_font_size]" class="font_size hankaku" type="text" name="dp_options[title_font_size]" value="<?php echo esc_attr( $options['title_font_size'] ); ?>"><span>px</span>
  	<h4 class="theme_option_headline2"><?php _e( 'Font size of post contents', 'tcd-w' ); ?></h4>
  	<input id="dp_options[content_font_size]" class="font_size hankaku" type="text" name="dp_options[content_font_size]" value="<?php echo esc_attr( $options['content_font_size'] ); ?>"><span>px</span>
  	<h4 class="theme_option_headline2"><?php _e( 'Link color of post contents', 'tcd-w' ); ?></h4>
		<input type="text" name="dp_options[content_link_color]" value="<?php echo esc_attr( $options['content_link_color'] ); ?>" data-default-color="#ff7f00" class="c-color-picker">
  	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
	</div>
	<?php // 表示設定 ?>
  <div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Display setting', 'tcd-w' ); ?></h3>
    <ul>
    	<li><label><input id="dp_options[show_date]" name="dp_options[show_date]" type="checkbox" value="1" <?php checked( '1', $options['show_date'] ); ?>><?php _e( 'Display date', 'tcd-w' ); ?></label></li>
    	<li><label><input id="dp_options[show_category]" name="dp_options[show_category]" type="checkbox" value="1" <?php checked( '1', $options['show_category'] ); ?>><?php _e( 'Display category', 'tcd-w' ); ?></label></li>
    	<li><label><input id="dp_options[show_tag]" name="dp_options[show_tag]" type="checkbox" value="1" <?php checked( '1', $options['show_tag'] ); ?>><?php _e( 'Display tags', 'tcd-w' ); ?></label></li>
    	<li><label><input id="dp_options[show_author]" name="dp_options[show_author]" type="checkbox" value="1" <?php checked( '1', $options['show_author'] ); ?>><?php _e( 'Display author', 'tcd-w' ); ?></label></li>
    	<li><input id="dp_options[show_thumbnail]" name="dp_options[show_thumbnail]" type="checkbox" value="1" <?php checked( '1', $options['show_thumbnail'] ); ?>><?php _e( 'Display thumbnail', 'tcd-w' ); ?></label></li>
    	<li><label><input id="dp_options[show_sns_top]" name="dp_options[show_sns_top]" type="checkbox" value="1" <?php checked( '1', $options['show_sns_top'] ); ?>><?php _e( 'Buttons to the article top', 'tcd-w' ); ?></label></li>
    	<li><label><input id="dp_options[show_sns_btm]" name="dp_options[show_sns_btm]" type="checkbox" value="1" <?php checked( '1', $options['show_sns_btm'] ); ?>><?php _e( 'Buttons to the article bottom', 'tcd-w' ); ?></label></li>
    	<li><label><input id="dp_options[show_next_post]" name="dp_options[show_next_post]" type="checkbox" value="1" <?php checked( '1', $options['show_next_post'] ); ?>><?php _e( 'Display next previous post link', 'tcd-w' ); ?></label></li>
    	<li><label><input id="dp_options[show_related_post]" name="dp_options[show_related_post]" type="checkbox" value="1" <?php checked( '1', $options['show_related_post'] ); ?>><?php _e( 'Display related post', 'tcd-w' ); ?></label></li>
    	<li><label><input id="dp_options[show_comment]" name="dp_options[show_comment]" type="checkbox" value="1" <?php checked( '1', $options['show_comment'] ); ?>><?php _e( 'Display comment', 'tcd-w' ); ?></label></li>
    	<li><label><input id="dp_options[show_trackback]" name="dp_options[show_trackback]" type="checkbox" value="1" <?php checked( '1', $options['show_trackback'] ); ?>><?php _e( 'Display trackbacks', 'tcd-w' ); ?></label></li>
    </ul>
    <input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
	</div>
	<?php // 広告の登録1 ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Single page banner setup', 'tcd-w' ); ?>1</h3>
  	<p><?php _e( 'This banner will be displayed under contents.', 'tcd-w' ); ?></p>
  	<div class="sub_box cf"> 
  		<h3 class="theme_option_subbox_headline"><?php _e( 'Left banner', 'tcd-w' ); ?></h3>
			<div class="sub_box_content">
  			<div class="theme_option_content">
  				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
  				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
  				<textarea id="dp_options[single_ad_code1]" class="large-text" cols="50" rows="10" name="dp_options[single_ad_code1]"><?php echo esc_textarea( $options['single_ad_code1'] ); ?></textarea>
  			</div>
  			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' ); ?></p>
  			<div class="theme_option_content">
  				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); _e( 'Recommend size. Width:300px Height:250px', 'tcd-w' ); ?></h4>
  				<div class="image_box cf">
  					<div class="cf cf_media_field hide-if-no-js single_ad_image1">
  						<input type="hidden" value="<?php echo esc_attr( $options['single_ad_image1'] ); ?>" id="single_ad_image" name="dp_options[single_ad_image1]" class="cf_media_id">
  						<div class="preview_field"><?php if ( $options['single_ad_image1'] ) { echo wp_get_attachment_image( $options['single_ad_image1'], 'medium' ); } ?></div>
  						<div class="button_area">
  							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
  							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['single_ad_image1'] ) { echo 'hidden'; } ?>">
  						</div>
  					</div>
  				</div>
  			</div>
  			<div class="theme_option_content">
  				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
  				<input id="dp_options[single_ad_url1]" class="regular-text" type="text" name="dp_options[single_ad_url1]" value="<?php echo esc_attr( $options['single_ad_url1'] ); ?>">
  				<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
  			</div>
			</div>
  	</div><!-- END .sub_box -->
  	<div class="sub_box cf"> 
  		<h3 class="theme_option_subbox_headline"><?php _e( 'Right banner', 'tcd-w' ); ?></h3>
			<div class="sub_box_content">
  			<div class="theme_option_content">
  				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
  				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
  				<textarea id="dp_options[single_ad_code2]" class="large-text" cols="50" rows="10" name="dp_options[single_ad_code2]"><?php echo esc_textarea( $options['single_ad_code2'] ); ?></textarea>
  			</div>
  			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' );  ?></p>
  			<div class="theme_option_content">
  				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); _e( 'Recommend size. Width:300px Height:250px', 'tcd-w' ); ?></h4>
  				<div class="image_box cf">
  					<div class="cf cf_media_field hide-if-no-js single_ad_image2">
  						<input type="hidden" value="<?php echo esc_attr( $options['single_ad_image2'] ); ?>" id="single_ad_image2" name="dp_options[single_ad_image2]" class="cf_media_id">
  						<div class="preview_field"><?php if ( $options['single_ad_image2'] ) { echo wp_get_attachment_image($options['single_ad_image2'], 'medium' ); } ?></div>
  						<div class="button_area">
  							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
  							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['single_ad_image2'] ) { echo 'hidden'; } ?>">
  						</div>
  					</div>
  				</div>
  			</div>
  			<div class="theme_option_content">
  				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' );  ?></h4>
  				<input id="dp_options[single_ad_url2]" class="regular-text" type="text" name="dp_options[single_ad_url2]" value="<?php echo esc_attr( $options['single_ad_url2'] ); ?>">
  				<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
  			</div>
  		</div><!-- END .sub_box -->
		</div>
  </div><!-- END .theme_option_field -->
	<?php // 記事詳細の広告設定2 ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Single page banner setup', 'tcd-w' ); ?>2</h3>
  	<p><?php _e( 'Please copy and paste the short code inside the content to show this banner.', 'tcd-w' ); ?></p>
  	<p><?php _e( 'Short code', 'tcd-w' );  ?> : <input type="text" readonly="readonly" value="[s_ad]"></p>
  	<div class="sub_box cf"> 
  		<h3 class="theme_option_subbox_headline"><?php _e( 'Left banner', 'tcd-w' ); ?></h3>
			<div class="sub_box_content">
  			<div class="theme_option_content">
  				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
  				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
  				<textarea id="dp_options[single_ad_code3]" class="large-text" cols="50" rows="10" name="dp_options[single_ad_code3]"><?php echo esc_textarea( $options['single_ad_code3'] ); ?></textarea>
  			</div>
  			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' ); ?></p>
  			<div class="theme_option_content">
  				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); _e( 'Recommend size. Width:300px Height:250px', 'tcd-w' ); ?></h4>
  				<div class="image_box cf">
  					<div class="cf cf_media_field hide-if-no-js single_ad_image3">
  						<input type="hidden" value="<?php echo esc_attr( $options['single_ad_image3'] ); ?>" id="single_ad_image3" name="dp_options[single_ad_image3]" class="cf_media_id">
  						<div class="preview_field"><?php if ( $options['single_ad_image3'] ) { echo wp_get_attachment_image( $options['single_ad_image3'], 'medium' ); } ?></div>
  						<div class="button_area">
  							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
  							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $options['single_ad_image3'] ) { echo 'hidden'; } ?>">
  						</div>
  					</div>
  				</div>
  			</div>
  			<div class="theme_option_content">
  				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
  				<input id="dp_options[single_ad_url3]" class="regular-text" type="text" name="dp_options[single_ad_url3]" value="<?php echo esc_attr( $options['single_ad_url3'] ); ?>">
  				<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
  			</div>
			</div>
  	</div><!-- END .sub_box -->
  	<div class="sub_box cf"> 
  		<h3 class="theme_option_subbox_headline"><?php _e( 'Right banner', 'tcd-w' ); ?></h3>
			<div class="sub_box_content">
  			<div class="theme_option_content">
  				<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
  				<p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
  				<textarea id="dp_options[single_ad_code4]" class="large-text" cols="50" rows="10" name="dp_options[single_ad_code4]"><?php echo esc_textarea( $options['single_ad_code4'] ); ?></textarea>
  			</div>
  			<p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' ); ?></p>
  			<div class="theme_option_content">
  				<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); _e( 'Recommend size. Width:300px Height:250px', 'tcd-w' ); ?></h4>
  				<div class="image_box cf">
  					<div class="cf cf_media_field hide-if-no-js single_ad_image4">
  						<input type="hidden" value="<?php echo esc_attr( $options['single_ad_image4'] ); ?>" id="single_ad_image4" name="dp_options[single_ad_image4]" class="cf_media_id">
  						<div class="preview_field"><?php if ( $options['single_ad_image4'] ) { echo wp_get_attachment_image( $options['single_ad_image4'], 'medium' ); } ?></div>
  						<div class="button_area">
  							<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
  							<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if( ! $options['single_ad_image4'] ) { echo 'hidden'; } ?>">
  						</div>
  					</div>
  				</div>
  			</div>
  			<div class="theme_option_content">
  				<h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
  				<input id="dp_options[single_ad_url4]" class="regular-text" type="text" name="dp_options[single_ad_url4]" value="<?php echo esc_attr( $options['single_ad_url4'] ); ?>">
  				<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
  			</div>
  		</div>
  	</div><!-- END .sub_box -->
  </div><!-- END .theme_option_field -->
 	<?php // スマホ専用広告の登録 ?>
	<div class="theme_option_field cf">
		<h3 class="theme_option_headline"><?php _e( 'Mobile device banner setup', 'tcd-w' ); ?></h3>
		<p><?php _e( 'This banner will be displayed on mobile device.', 'tcd-w' ); ?></p>
 	 	<div class="theme_option_content">
 	 		<h4 class="theme_option_headline2"><?php _e( 'Banner code', 'tcd-w' ); ?></h4>
 	    <p><?php _e( 'If you are using google adsense, enter all code below.', 'tcd-w' ); ?></p>
 	    <textarea id="dp_options[single_mobile_ad_code1]" class="large-text" cols="50" rows="10" name="dp_options[single_mobile_ad_code1]"><?php echo esc_textarea( $options['single_mobile_ad_code1'] ); ?></textarea>
 	  </div>
 	  <p><?php _e( 'If you are not using google adsense, you can register your banner image and affiliate code individually.', 'tcd-w' );  ?></p>
 	  <div class="theme_option_content">
 	  	<h4 class="theme_option_headline2"><?php _e( 'Register banner image.', 'tcd-w' ); ?></h4>
 	  	<div class="image_box cf">
 	    	<div class="cf cf_media_field hide-if-no-js single_mobile_ad_image1">
 	      	<input type="hidden" value="<?php echo esc_attr( $options['single_mobile_ad_image1'] ); ?>" id="single_mobile_ad_image" name="dp_options[single_mobile_ad_image1]" class="cf_media_id">
 	      	<div class="preview_field"><?php if($options['single_mobile_ad_image1']){ echo wp_get_attachment_image($options['single_mobile_ad_image1'], 'medium' ); }; ?></div>
 	      	<div class="buttton_area">
 	       		<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
 	       		<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if(!$options['single_mobile_ad_image1']){ echo 'hidden'; }; ?>">
 	     		</div>
 	    	</div>
			</div>
 	  </div>
 	 	<div class="theme_option_content">
 	    <h4 class="theme_option_headline2"><?php _e( 'Register affiliate code', 'tcd-w' ); ?></h4>
 	    <input id="dp_options[single_mobile_ad_url1]" class="regular-text" type="text" name="dp_options[single_mobile_ad_url1]" value="<?php echo esc_attr( $options['single_mobile_ad_url1'] ); ?>">
 	  	<input type="submit" class="button-ml" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>">
		</div>
	</div><!-- END .theme_option_field -->
</div><!-- END #tab-content4 -->
