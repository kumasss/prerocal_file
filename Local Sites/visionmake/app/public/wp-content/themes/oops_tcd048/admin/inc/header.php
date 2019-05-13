<?php 
global $header_fix_options; 
$options = get_desing_plus_option();
?>
<div id="tab-content7">
	<?php // ヘッダーバーの表示位置 ?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Header position', 'tcd-w' ); ?></h3>
   	<fieldset class="cf select_type2">
			<?php foreach ( $header_fix_options as $option ) : ?>
     	<label class="description"><input type="radio" name="dp_options[header_fix]" value="<?php esc_attr_e( $option['value'] ); ?>" <?php checked( $option['value'], $options['header_fix'] ); ?>><?php _e( $option['label'], 'tcd-w' ); ?></label>
			<?php endforeach; ?>
    </fieldset>
    <input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
	</div>
	<?php // ヘッダーバーの表示位置（スマホ）?>
	<div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Header position for mobile device', 'tcd-w' ); ?></h3>
  	<fieldset class="cf select_type2">
			<?php foreach ( $header_fix_options as $option ) : ?>
			<label class="description"><input type="radio" name="dp_options[mobile_header_fix]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php checked( $option['value'], $options['mobile_header_fix'] ); ?>><?php esc_html_e( $option['label'], 'tcd-w' ); ?></label>
			<?php endforeach; ?>
		</fieldset>
  	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
	</div>
	<?php // ヘッダーバーの色の設定（トップページ）?>
  <div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Color of header (Top page)', 'tcd-w' );  ?></h3>
  	<h4 class="theme_option_headline2"><?php _e( 'Background color setting', 'tcd-w' );  ?></h4>
		<input type="text" name="dp_options[top_header_bg]" value="<?php echo esc_attr( $options['top_header_bg'] ); ?>" data-default-color="#121e1f" class="c-color-picker">
  	<h4 class="theme_option_headline2"><?php _e( 'Opacity of background', 'tcd-w' ); ?></h4>
		<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.7)', 'tcd-w' ); ?></p>
		<input id="dp_options[top_header_opacity]" class="hankaku" style="width: 45px;" type="text" name="dp_options[top_header_opacity]" value="<?php echo esc_attr( $options['top_header_opacity'] ); ?>">
  	<h4 class="theme_option_headline2"><?php _e( 'Text color setting', 'tcd-w' ); ?></h4>
		<input type="text" name="dp_options[top_header_font_color]" value="<?php echo esc_attr( $options['top_header_font_color'] ); ?>" data-default-color="#ffffff" class="c-color-picker">
  	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
  </div>
	<?php // ヘッダーバーの色の設定（トップページスクロール後・下層ページ・スマホ）?>
  <div class="theme_option_field cf">
  	<h3 class="theme_option_headline"><?php _e( 'Color of header (Top page after scrolling and sub page and mobile)', 'tcd-w' );  ?></h3>
  	<h4 class="theme_option_headline2"><?php _e( 'Background color setting', 'tcd-w' );  ?></h4>
		<input type="text" name="dp_options[sub_header_bg]" value="<?php echo esc_attr( $options['sub_header_bg'] ); ?>" data-default-color="#121e1f" class="c-color-picker">
  	<h4 class="theme_option_headline2"><?php _e( 'Opacity of background', 'tcd-w' ); ?></h4>
		<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.7)', 'tcd-w' ); ?></p>
		<p><?php _e( 'Note: "Opacity of background" is not applied to "Normal header" and smartphones.', 'tcd-w' ); ?></p>
		<input id="dp_options[sub_header_opacity]" class="hankaku" style="width: 45px;" type="text" name="dp_options[sub_header_opacity]" value="<?php echo esc_attr( $options['sub_header_opacity'] ); ?>">
  	<h4 class="theme_option_headline2"><?php _e( 'Text color setting', 'tcd-w' ); ?></h4>
		<input type="text" name="dp_options[sub_header_font_color]" value="<?php echo esc_attr( $options['sub_header_font_color'] ); ?>" data-default-color="#ffffff" class="c-color-picker">
  	<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
  </div>
</div><!-- END #tab-content7 -->
