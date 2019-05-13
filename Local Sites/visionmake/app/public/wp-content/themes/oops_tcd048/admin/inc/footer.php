<?php 
global $footer_blog_num_options, $footer_blog_post_order_options, $footer_blog_slide_time_options, $footer_bar_display_options, $footer_bar_button_options, $footer_bar_icon_options;
$options = get_desing_plus_option(); 
?>
<div id="tab-content8">
	<?php // ブログコンテンツの設定 ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Blog contents settings', 'tcd-w' ); ?></h3>
		<p><?php _e( 'Display a carousel slider of blog posts in the footer area.', 'tcd-w' ); ?></p>
  	<p><label><input id="dp_options[show_footer_blog_top]" name="dp_options[show_footer_blog_top]" type="checkbox" value="1" <?php checked( $options['show_footer_blog_top'], 1 ); ?>><?php _e( 'Show blog contents on top page', 'tcd-w' ); ?></label></p>
  	<p><label><input id="dp_options[show_footer_blog]" name="dp_options[show_footer_blog]" type="checkbox" value="1" <?php checked( $options['show_footer_blog'], 1 ); ?>><?php _e( 'Show blog contents on subpage', 'tcd-w' ); ?></label></p>
  	<h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
  	<input id="dp_options[footer_blog_catchphrase]" class="regular-text" type="text" name="dp_options[footer_blog_catchphrase]" value="<?php echo esc_attr( $options['footer_blog_catchphrase'] ); ?>">
		<h4 class="theme_option_headline2"><?php _e( 'Font size of catchphrase', 'tcd-w' ); ?></h4>
		<p><input id="dp_options[footer_blog_catchphrase_font_size]" class="font_size hankaku" type="text" name="dp_options[footer_blog_catchphrase_font_size]" value="<?php echo esc_attr( $options['footer_blog_catchphrase_font_size'] ); ?>"><span>px</span></p>
  	<h4 class="theme_option_headline2"><?php _e( 'Number of posts', 'tcd-w' ); ?></h4>
  	<select name="dp_options[footer_blog_num]">
			<?php foreach ( $footer_blog_num_options as $option ) : ?>
      <option style="padding-right: 10px;" value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $options['footer_blog_num'] ); ?>><?php echo esc_html( $option['label'] ); ?></option>
			<?php endforeach; ?>
    </select>
    <h4 class="theme_option_headline2"><?php _e( 'Post order', 'tcd-w' ); ?></h4>
    <select name="dp_options[footer_blog_post_order]">
			<?php foreach ( $footer_blog_post_order_options as $option ) : ?>
      <option style="padding-right: 10px;" value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $options['footer_blog_post_order'] ); ?>><?php echo esc_html_e( $option['label'], 'tcd-w' ); ?></option>
			<?php endforeach; ?>
   	</select>
    <h4 class="theme_option_headline2"><?php _e( 'Display setting', 'tcd-w' ); ?></h4>
    <p><label><input id="dp_options[show_footer_blog_date]" name="dp_options[show_footer_blog_date]" type="checkbox" value="1" <?php checked( $options['show_footer_blog_date'], 1 ); ?>><?php _e( 'Display date', 'tcd-w' ); ?></label></p>
    <p><label><input id="dp_options[show_footer_blog_category]" name="dp_options[show_footer_blog_category]" type="checkbox" value="1" <?php checked( $options['show_footer_blog_category'], 1 ); ?>><?php _e( 'Display category', 'tcd-w' ); ?></label></p>
    <h4 class="theme_option_headline2"><?php _e( 'Link to blog archive page', 'tcd-w' ); ?></h4>
    <p><label><input id="dp_options[show_footer_blog_link]" name="dp_options[show_footer_blog_link]" type="checkbox" value="1" <?php checked( $options['show_footer_blog_link'], 1 ); ?>><?php _e( 'Display link for blog archive page', 'tcd-w' ); ?></label></p>
    <p><label><?php _e( 'Link text', 'tcd-w' ); ?><input id="dp_options[footer_blog_link_text]" class="regular-text" type="text" name="dp_options[footer_blog_link_text]" value="<?php echo esc_attr( $options['footer_blog_link_text'] ); ?>"></label></p>
    <h4 class="theme_option_headline2"><?php _e( 'Slide speed', 'tcd-w' ); ?></h4>
    <select name="dp_options[footer_blog_slide_time]">
			<?php foreach ( $footer_blog_slide_time_options as $option ) : ?>
      <option style="padding-right: 10px;" value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $option['value'], $options['footer_blog_slide_time'] ); ?>><?php echo esc_html( $option['label'] ); ?><?php _e( ' miliseconds', 'tcd-w' ); ?></option>
			<?php endforeach; ?>
    </select>
    <input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
	</div>
	<?php // SNSボタンの設定 ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'SNS button setting', 'tcd-w' ); ?></h3>
  	<p><?php _e( 'Enter url of your twitter and facebook page. If it is blank SNS button will not be shown.', 'tcd-w' ); ?></p>
  	<ul>
  		<li><label><?php _e( 'your twitter URL', 'tcd-w' ); ?> </label><input class="regular-text" type="text" name="dp_options[twitter_url]" value="<?php esc_attr_e( $options['twitter_url'] ); ?>"></li>
  		<li><label><?php _e( 'your facebook URL', 'tcd-w' ); ?></label><input id="dp_options[facebook_url]" class="regular-text" type="text" name="dp_options[facebook_url]" value="<?php esc_attr_e( $options['facebook_url'] ); ?>"></li>
  		<li><label style="display:inline-block; min-width:140px;"><?php _e( 'your instagram URL', 'tcd-w' ); ?></label><input id="dp_options[insta_url]" class="regular-text" type="text" name="dp_options[insta_url]" value="<?php esc_attr_e( $options['insta_url'] ); ?>"></li>
		</ul>
 		<hr>
  	<p><label><input id="dp_options[show_rss]" name="dp_options[show_rss]" type="checkbox" value="1" <?php checked( '1', $options['show_rss'] ); ?>><?php _e( 'Display RSS button', 'tcd-w' ); ?></label></p>
  	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
	</div>
	<?php // フッターに表示する会社情報 ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Company information on footer', 'tcd-w' ); ?></h3>
  	<ul>
  		<li>
				<p><?php _e( 'Phone number, Address, and miscs', 'tcd-w' ); ?></p>
				<textarea rows="4" id="dp_options[footer_company_address]" class="large-text" name="dp_options[footer_company_address]"><?php echo esc_textarea( $options['footer_company_address'] ); ?></textarea>
			</li>
  	</ul>
  	<input type="submit" class="button-ml" value="<?php echo _e( 'Save Changes', 'tcd-w' ); ?>">
  </div>
	<?php // 著作権表示の設定 ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Copyright settings', 'tcd-w' ); ?></h3>
		<h4 class="theme_option_headline2"><?php _e( 'Background color', 'tcd-w' ); ?></h4>
		<input type="text" name="dp_options[copyright_bg]" value="<?php echo esc_attr( $options['copyright_bg'] ); ?>" data-default-color="#000000" class="c-color-picker">
  	<input type="submit" class="button-ml" value="<?php echo _e( 'Save Changes', 'tcd-w' ); ?>">
  </div>
	<?php // フッターバーの設定 ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Setting of the footer bar for smart phone', 'tcd-w' ); ?></h3>
		<p><?php _e( 'Please set the footer bar which is displayed with smart phone.', 'tcd-w' ); ?>
		<p><?php _e( 'Note: The footer bar is not displayed when the footer CTA is displayed.', 'tcd-w' ); ?></p>
    <h4 class="theme_option_headline2"><?php _e( 'Display type of the footer bar', 'tcd-w' ); ?></h4>
    <fieldset class="cf select_type2">
     <?php foreach ( $footer_bar_display_options as $option ) : ?>
     <label class="description"><input type="radio" name="dp_options[footer_bar_display]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $options['footer_bar_display'], $option['value'] ); ?>><?php echo esc_html_e( $option['label'], 'tcd-w' ); ?></label>
     <?php endforeach; ?>
    </fieldset>
    <h4 class="theme_option_headline2"><?php _e( 'Settings for the appearance of the footer bar', 'tcd-w' ); ?></h4>
    <p>
     	<?php _e( 'Background color', 'tcd-w' ); ?>
			<input type="text" name="dp_options[footer_bar_bg]" value="<?php echo esc_attr( $options['footer_bar_bg'] ); ?>" data-default-color="#ffffff" class="c-color-picker">
		</p>
    <p>
    	<?php _e( 'Border color', 'tcd-w' ); ?>
			<input type="text" name="dp_options[footer_bar_border]" value="<?php echo esc_attr( $options['footer_bar_border'] ); ?>" data-default-color="#dddddd" class="c-color-picker">
		</p>
    <p>
     	<?php _e( 'Font color', 'tcd-w' ); ?>
			<input type="text" name="dp_options[footer_bar_color]" value="<?php echo esc_attr( $options['footer_bar_color'] ); ?>" data-default-color="#000000" class="c-color-picker">
		</p>
		<p>
     	<?php _e( 'Opacity of background', 'tcd-w' ); ?>
     	<input class="font_size hankaku" type="text" name="dp_options[footer_bar_tp]" value="<?php echo esc_attr( $options['footer_bar_tp'] ); ?>" /><br><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.8)', 'tcd-w' ); ?>
		</p>
    <h4 class="theme_option_headline2"><?php _e('Settings for the contents of the footer bar', 'tcd-w'); ?></h4>
   	<p><?php _e( 'You can display the button with icon in footer bar. (We recommend you to set max 4 buttons.)', 'tcd-w' ); ?><br><?php _e( 'You can select button types below.', 'tcd-w' ); ?></p>
		<table class="table-border">
			<tr>
				<th><?php _e( 'Default', 'tcd-w' ); ?></th>
				<td><?php _e( 'You can set link URL.', 'tcd-w' ); ?></td>
			</tr>
			<tr>
				<th><?php _e( 'Share', 'tcd-w' ); ?></th>
				<td><?php _e( 'Share buttons are displayed if you tap this button.', 'tcd-w' ); ?></td>
			</tr>
			<tr>
				<th><?php _e( 'Telephone', 'tcd-w' ); ?></th>
				<td><?php _e( 'You can call this number.', 'tcd-w' ); ?></td>
			</tr>
		</table>
		<p><?php _e( 'Click "Add item", and set the button for footer bar. You can drag the item to change their order.', 'tcd-w' ); ?></p>
		<div class="repeater-wrapper">
			<div class="repeater sortable" data-delete-confirm="<?php _e( 'Delete?', 'tcd-w' ); ?>">
				<?php 
				if ( $options['footer_bar_btns'] ) :
					foreach ( $options['footer_bar_btns'] as $key => $value ) :  
				?>
				<div class="sub_box repeater-item repeater-item-<?php echo esc_attr( $key ); ?>">
     			<h4 class="theme_option_subbox_headline"><?php echo esc_attr( $value['label'] ); ?></h4>
					<div class="sub_box_content">
    				<p class="footer-bar-target" style="<?php if ( $value['type'] !== 'type1' ) { echo 'display: none;'; } ?>"><label><input name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][target]" type="checkbox" value="1" <?php checked( $value['target'], 1 ); ?>><?php _e( 'Open with new window', 'tcd-w' ); ?></label></p>
    				<table class="table-repeater">
     					<tr class="footer-bar-type">
								<th><label><?php _e( 'Button type', 'tcd-w' ); ?></label></th>
								<td>
									<select name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][type]">
										<?php foreach( $footer_bar_button_options as $option ) : ?>
										<option value="<?php echo esc_attr( $option['value'] ); ?>" <?php selected( $value['type'], $option['value'] ); ?>><?php esc_html_e( $option['label'], 'tcd-w' ); ?></option>
										<?php endforeach; ?>
									</select>
								</td>
							</tr>
     					<tr>
								<th><label for="dp_options[repeater_footer_bar_btn<?php echo esc_attr( $key ); ?>_label]"><?php _e( 'Button label', 'tcd-w' ); ?></label></th>
								<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_label]" class="regular-text repeater-label" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][label]" value="<?php echo esc_attr( $value['label'] ); ?>"></td>
							</tr>
							<tr class="footer-bar-url" style="<?php if ( $value['type'] !== 'type1' ) { echo 'display: none;'; } ?>">
								<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]"><?php _e( 'Link URL', 'tcd-w' ); ?></label></th>
								<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]" class="regular-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][url]" value="<?php echo esc_attr( $value['url'] ); ?>"></td>
							</tr>
     					<tr class="footer-bar-number" style="<?php if ( $value['type'] !== 'type3' ) { echo 'display: none;'; } ?>">
								<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]"><?php _e( 'Phone number', 'tcd-w' ); ?></label></th>
								<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]" class="regular-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][number]" value="<?php echo esc_attr( $value['number'] ); ?>"></td>
							</tr>
     					<tr>
								<th><?php _e( 'Button icon', 'tcd-w' ); ?></th>
								<td>
									<?php foreach( $footer_bar_icon_options as $option ) : ?>
									<p><label><input type="radio" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][icon]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $value['icon'] ); ?>><span class="icon icon-<?php echo esc_attr( $option['value'] ); ?>"></span><?php esc_html_e( $option['label'], 'tcd-w' ); ?></label></p>
									<?php endforeach; ?>
								</td>
							</tr>
						</table>
       			<p class="delete-row right-align"><a href="#" class="button button-secondary button-delete-row"><?php _e( 'Delete item', 'tcd-w' ); ?></a></p>
					</div>
				</div>
				<?php
					endforeach;
				endif;
				?>
				<?php
    		$key = 'addindex';
    		ob_start();
				?>
				<div class="sub_box repeater-item repeater-item-<?php echo $key; ?>">
     			<h4 class="theme_option_subbox_headline"><?php _e( 'New item', 'tcd-w' ); ?></h4>
					<div class="sub_box_content">
    				<p class="footer-bar-target"><label><input name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][target]" type="checkbox" value="1"><?php _e( 'Open with new window', 'tcd-w' ); ?></label></p>
    				<table class="table-repeater">
     					<tr class="footer-bar-type">
								<th><label><?php _e( 'Button type', 'tcd-w' ); ?></label></th>
								<td>
									<select name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][type]">
										<?php foreach( $footer_bar_button_options as $option ) : ?>
										<option value="<?php echo esc_attr( $option['value'] ); ?>"><?php esc_html_e( $option['label'], 'tcd-w' ); ?></option>
										<?php endforeach; ?>
									</select>
								</td>
							</tr>
     					<tr>
								<th><label for="dp_options[repeater_footer_bar_btn<?php echo esc_attr( $key ); ?>_label]"><?php _e( 'Button label', 'tcd-w' ); ?></label></th>
								<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_label]" class="regular-text repeater-label" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][label]" value=""></td>
							</tr>
							<tr class="footer-bar-url">
								<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]"><?php _e( 'Link URL', 'tcd-w' ); ?></label></th>
								<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_url]" class="regular-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][url]" value=""></td>
							</tr>
     					<tr class="footer-bar-number" style="display: none;">
								<th><label for="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]"><?php _e( 'Phone number', 'tcd-w' ); ?></label></th>
								<td><input id="dp_options[footer_bar_btn<?php echo esc_attr( $key ); ?>_number]" class="regular-text" type="text" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][number]" value=""></td>
							</tr>
     					<tr>
								<th><?php _e( 'Button icon', 'tcd-w' ); ?></th>
								<td>
									<?php foreach( $footer_bar_icon_options as $option ) : ?>
									<p><label><input type="radio" name="dp_options[repeater_footer_bar_btns][<?php echo esc_attr( $key ); ?>][icon]" value="<?php echo esc_attr( $option['value'] ); ?>"<?php if ( 'file-text' == $option['value'] ) { echo ' checked="checked"'; } ?>><span class="icon icon-<?php echo esc_attr( $option['value'] ); ?>"></span><?php esc_html_e( $option['label'], 'tcd-w' ); ?></label></p>
									<?php endforeach; ?>
								</td>
							</tr>
						</table>
       			<p class="delete-row right-align"><a href="#" class="button button-secondary button-delete-row"><?php _e( 'Delete item', 'tcd-w' ); ?></a></p>
					</div>
				</div>
				<?php $clone = ob_get_clean(); ?>
			</div>
			<a href="#" class="button button-secondary button-add-row" data-clone="<?php echo esc_attr( $clone ); ?>"><?php _e( 'Add item', 'tcd-w' ); ?></a>
		</div>
		<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>"> 
	</div>
</div><!-- END #tab-content8 -->
