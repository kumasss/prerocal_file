<?php
$options = get_desing_plus_option(); 

// 使用するコンテンツの番号
$cta_index = $options['footer_cta_display'];

// $cta_index が4（ランダム表示）の時、表示するCTAをランダムで決定する
if ( '4' === $cta_index ) {
	
	// ランダム表示に使用するCTA配列を取得する
	$cta_in_random_display = get_footer_cta_in_random_display();	

	// CTA配列が空の場合、CTAを表示しない
	if ( ! $cta_in_random_display ) {
		
		return;

	// 配列の要素が1つのみの場合、乱数の生成を行わない
	} elseif ( 1 === count( $cta_in_random_display ) ) {

		$cta_index = $cta_in_random_display[0];
	
	// CTA配列から、今回表示するCTAを決定する
	} else {

		$cta_index = rand( 1, count( $cta_in_random_display ) );

	}
}
?>
<div id="js-footer-cta" class="p-footer-cta p-footer-cta--<?php echo esc_attr( $cta_index ); ?>">
	<?php if ( 'type1' === $options['footer_cta_type' . $cta_index] ) : ?>
	<?php if ( is_mobile() ) : ?><a id="js-footer-cta__btn" href="<?php echo esc_url( $options['footer_cta_btn_url' . $cta_index] ); ?>"<?php if ( $options['footer_cta_btn_target' . $cta_index] ) { echo ' target="_blank"'; } ?>><?php endif; ?>
	<div class="p-footer-cta__inner">
		<div>
			<div class="p-footer-cta__catch"><?php echo is_mobile() ? nl2br( $options['footer_cta_catch' . $cta_index] ) : $options['footer_cta_catch' . $cta_index]; ?></div>
			<div class="p-footer-cta__desc"><?php echo $options['footer_cta_desc' . $cta_index]; ?></div>	
		</div>
		<?php if ( ! is_mobile() ) : ?><a id="js-footer-cta__btn" href="<?php echo esc_url( $options['footer_cta_btn_url' . $cta_index] ); ?>" class="p-footer-cta__btn"><?php echo esc_html( $options['footer_cta_btn_label' . $cta_index] ); ?></a><?php endif; ?>
	</div>
	<div id="js-footer-cta__close" class="p-footer-cta__close"></div>
	<?php if ( is_mobile() ) : ?></a><?php endif; ?>
	<?php else : ?>
		<?php echo apply_filters( 'the_content', $options['footer_cta_editor' . $cta_index] ); ?>
	<?php endif; ?>
</div>
