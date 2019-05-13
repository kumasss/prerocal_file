<?php
/**
 * 記事ページの広告用ショートコード
 */
function theme_option_single_banner() {

	$options = get_desing_plus_option();
	$html = '';	

	if ( $options['single_ad_code3'] || $options['single_ad_image3'] || $options['single_ad_code4'] || $options['single_ad_image4'] ) {
    	
		$html .= '<div class="p-entry__ad">' . "\n";

    if ( $options['single_ad_code3'] ) {
    	$html .= '<div class="p-entry__ad-item">' . "\n";
      $html .= $options['single_ad_code3'] . "\n";
      $html .= '</div>' . "\n";
    } elseif ( $options['single_ad_image3'] ) {
      $single_image3 = wp_get_attachment_image_src( $options['single_ad_image3'], 'full' );
      $html .= '<div class="p-entry__ad-item">' . "\n";
      $html .= '<a href="' . esc_url( $options['single_ad_url3'] ) . '" target="_blank"><img src="' . esc_attr( $single_image3[0] ) . '" alt=""></a>' . "\n";
      $html .= '</div>' . "\n";
    }

    if ( $options['single_ad_code4'] ) {
    	$html .= '<div class="p-entry__ad-item">' . "\n";
      $html .= $options['single_ad_code4'] . "\n";
      $html .= '</div>' . "\n";
    } elseif ( $options['single_ad_image4'] ) {
      $single_image4 = wp_get_attachment_image_src( $options['single_ad_image4'], 'full' );
      $html .= '<div class="p-entry__ad-item">' . "\n";
      $html .= '<a href="' . esc_url( $options['single_ad_url4'] ) . '" target="_blank"><img src="' . esc_attr( $single_image4[0] ) . '" alt=""></a>' . "\n";
      $html .= '</div>' . "\n";
    }

    $html .= '</div>' . "\n";
    }
    return $html;
}
add_shortcode( 's_ad', 'theme_option_single_banner' );

/**
 * ニュースページの広告用ショートコード
 */
function theme_option_news_banner() {

	$options = get_desing_plus_option();
	$html = '';	

	if ( $options['news_ad_code3'] || $options['news_ad_image3'] || $options['news_ad_code4'] || $options['news_ad_image4'] ) {
    	
		$html .= '<div class="p-entry__ad">' . "\n";

    if ( $options['news_ad_code3'] ) {
    	$html .= '<div class="p-entry__ad-item">' . "\n";
      $html .= $options['news_ad_code3'] . "\n";
      $html .= '</div>' . "\n";
    } elseif ( $options['news_ad_image3'] ) {
      $news_image3 = wp_get_attachment_image_src( $options['news_ad_image3'], 'full' );
      $html .= '<div class="p-entry__ad-item">' . "\n";
      $html .= '<a href="' . esc_url( $options['news_ad_url3'] ) . '" target="_blank"><img src="' . esc_attr( $news_image3[0] ) . '" alt=""></a>' . "\n";
      $html .= '</div>' . "\n";
    }

    if ( $options['news_ad_code4'] ) {
    	$html .= '<div class="p-entry__ad-item">' . "\n";
      $html .= $options['news_ad_code4'] . "\n";
      $html .= '</div>' . "\n";
    } elseif ( $options['news_ad_image4'] ) {
      $news_image4 = wp_get_attachment_image_src( $options['news_ad_image4'], 'full' );
      $html .= '<div class="p-entry__ad-item">' . "\n";
      $html .= '<a href="' . esc_url( $options['news_ad_url4'] ) . '" target="_blank"><img src="' . esc_attr( $news_image4[0] ) . '" alt=""></a>' . "\n";
      $html .= '</div>' . "\n";
    }

    $html .= '</div>' . "\n";
    }
    return $html;
}
add_shortcode( 'n_ad', 'theme_option_news_banner' );
