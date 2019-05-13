<?php 
$options = get_desing_plus_option(); 

if ( is_singular( 'post' ) ) {
	if ( is_mobile() ) {
		if ( $options['single_mobile_ad_code1'] || $options['single_mobile_ad_image1'] ) {
			echo '<div class="p-entry__ad">' . "\n";
			if ( $options['single_mobile_ad_code1'] ) {
				echo '<div class="p-entry__ad-item">' . $options['single_mobile_ad_code1'] . '</div>';
			} elseif ( $options['single_mobile_ad_image1'] ) {
				$single_mobile_image1 = wp_get_attachment_image_src( $options['single_mobile_ad_image1'], 'full' ); 
				echo '<div class="p-entry__ad-item"><a href="' . esc_url( $options['single_mobile_ad_url1'] ) . '"><img src="' . esc_attr( $single_mobile_image1[0] ) . '" alt=""></a></div>';
			}
			echo '</div>' . "\n";
		}
	} else {
		if ( $options['single_ad_code1'] || $options['single_ad_image1'] || $options['single_ad_code2'] || $options['single_ad_image2'] ) {
			echo '<div class="p-entry__ad">' . "\n";
			if ( $options['single_ad_code1'] ) {
				echo '<div class="p-entry__ad-item">' . $options['single_ad_code1'] . '</div>';
			} elseif ( $options['single_ad_image1'] ) {
				$single_image1 = wp_get_attachment_image_src( $options['single_ad_image1'], 'full' ); 
				echo '<div class="p-entry__ad-item"><a href="' . esc_url( $options['single_ad_url1'] ) . '"><img src="' . esc_attr( $single_image1[0] ) . '" alt=""></a></div>';
			}
			if ( $options['single_ad_code2'] ) {
				echo '<div class="p-entry__ad-item">' . $options['single_ad_code2'] . '</div>';
			} elseif ( $options['single_ad_image2'] ) {
				$single_image2 = wp_get_attachment_image_src( $options['single_ad_image2'], 'full' ); 
				echo '<div class="p-entry__ad-item"><a href="' . esc_url( $options['single_ad_url2'] ) . '"><img src="' . esc_attr( $single_image2[0] ) . '" alt=""></a></div>';
			}
			echo '</div>' . "\n";
		}
	}
} elseif ( is_singular( 'news' ) ) {
	if ( is_mobile() ) {
		if ( $options['news_mobile_ad_code1'] || $options['news_mobile_ad_image1'] ) {
			echo '<div class="p-entry__ad">' . "\n";
			if ( $options['news_mobile_ad_code1'] ) {
				echo '<div class="p-entry__ad-item">' . $options['news_mobile_ad_code1'] . '</div>';
			} elseif ( $options['news_mobile_ad_image1'] ) {
				$news_mobile_image1 = wp_get_attachment_image_src( $options['news_mobile_ad_image1'], 'full' ); 
				echo '<div class="p-entry__ad-item"><a href="' . esc_url( $options['news_mobile_ad_url1'] ) . '"><img src="' . esc_attr( $news_mobile_image1[0] ) . '" alt=""></a></div>';
			}
			echo '</div>' . "\n";
		}
	} else {
		if ( $options['news_ad_code1'] || $options['news_ad_image1'] || $options['news_ad_code2'] || $options['news_ad_image2'] ) {
			echo '<div class="p-entry__ad">' . "\n";
			if ( $options['news_ad_code1'] ) {
				echo '<div class="p-entry__ad-item">' . $options['news_ad_code1'] . '</div>';
			} elseif ( $options['news_ad_image1'] ) {
				$news_image1 = wp_get_attachment_image_src( $options['news_ad_image1'], 'full' ); 
				echo '<div class="p-entry__ad-item"><a href="' . esc_url( $options['news_ad_url1'] ) . '"><img src="' . esc_attr( $news_image1[0] ) . '" alt=""></a></div>';
			}
			if ( $options['news_ad_code2'] ) {
				echo '<div class="p-entry__ad-item">' . $options['news_ad_code2'] . '</div>';
			} elseif ( $options['news_ad_image2'] ) {
				$news_image2 = wp_get_attachment_image_src( $options['news_ad_image2'], 'full' ); 
				echo '<div class="p-entry__ad-item"><a href="' . esc_url( $options['news_ad_url2'] ) . '"><img src="' . esc_attr( $news_image2[0] ) . '" alt=""></a></div>';
			}
			echo '</div>' . "\n";
		}
	}
}
?>
