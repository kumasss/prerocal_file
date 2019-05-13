<?php
$options = get_desing_plus_option();

// 使用するコンテンツの番号
$cta_index = $options['cta_display'];

// $cta_index が4（ランダム表示）の時、表示するCTAをランダムで決定する
if ( '4' === $cta_index ) {
	
	// ランダム表示に使用するCTA配列を取得する
	$cta_in_random_display = get_cta_in_random_display();	

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

// 使用するコンテンツのタイプ
$cta_type = $options['cta_type' . $cta_index];
?>
<?php 
// スマホ表示の時、スマホ専用画像が登録されていればそれを、されていなければPC用画像を表示する
if ( 'type1' === $cta_type ) : 
?>
<div id="js-cta" class="p-entry__cta p-cta--<?php echo esc_attr( $cta_index ); ?> p-cta--type1 p-cta" style="background-image: url(<?php echo is_mobile() && $options['cta_type1_image_sp' . $cta_index] ? esc_attr( wp_get_attachment_url( $options['cta_type1_image_sp' . $cta_index] ) ) : esc_attr( wp_get_attachment_url( $options['cta_type1_image' . $cta_index] ) ); ?>);">
	<div class="p-cta__inner">
		<div class="p-cta__catch" style="font-size: <?php echo esc_attr( $options['cta_type1_catch_font_size' . $cta_index] ); ?>px; "><?php echo nl2br( $options['cta_type1_catch' . $cta_index] ); ?></div>
		<div class="p-cta__desc" style="font-size: <?php echo esc_attr( $options['cta_type1_desc_font_size' . $cta_index] ); ?>px;"><?php echo wpautop( $options['cta_type1_desc' . $cta_index] ); ?></div>
		<a id="js-cta__btn" class="p-cta__btn" href="<?php echo esc_url( $options['cta_type1_btn_url' . $cta_index] ); ?>"<?php if ( $options['cta_type1_btn_target' . $cta_index] ) { echo ' target="_blank"'; } ?>><?php echo esc_html( $options['cta_type1_btn_label' . $cta_index] ); ?></a>
	</div>
</div>
<?php elseif ( 'type2' === $cta_type ) : ?>
<div id="js-cta" class="p-entry__cta p-cta--<?php echo esc_attr( $cta_index ); ?> p-cta--type2 p-cta <?php if ( 'type2' === $options['cta_type2_layout' . $cta_index] ) { echo ' p-cta--type2-rev'; } ?>">
	<div class="p-cta__img"><img src="<?php echo is_mobile() && $options['cta_type2_image_sp' . $cta_index] ? esc_attr( wp_get_attachment_url( $options['cta_type2_image_sp' . $cta_index] ) ) : esc_attr( wp_get_attachment_url( $options['cta_type2_image' . $cta_index] ) ); ?>" alt=""></div>
	<div class="p-cta__inner">
		<div class="p-cta__catch" style="font-size: <?php echo esc_attr( $options['cta_type2_catch_font_size' . $cta_index] ); ?>px;"><?php echo nl2br( $options['cta_type2_catch' . $cta_index] ); ?></div>
		<div class="p-cta__desc" style="font-size: <?php echo esc_attr( $options['cta_type2_desc_font_size' . $cta_index] ); ?>px;"><?php echo wpautop( $options['cta_type2_desc' . $cta_index] ); ?></div>
		<a id="js-cta__btn" class="p-cta__btn" href="<?php echo esc_url( $options['cta_type2_btn_url' . $cta_index] ); ?>"<?php if ( $options['cta_type2_btn_target' . $cta_index] ) { echo ' target="_blank"'; } ?>><?php echo esc_html( $options['cta_type2_btn_label' . $cta_index] ); ?></a>
	</div>
</div>
<?php	else : ?>
<div id="js-cta" class="p-cta--<?php echo esc_attr( $cta_index ); ?>">
<?php echo apply_filters( 'the_content', $options['cta_editor' . $cta_index] ); ?>
</div>
<?php endif; ?>
