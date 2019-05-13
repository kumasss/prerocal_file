<?php
$options = get_desing_plus_option();

// パスワードフォームのHTMLを書き換える
function tcd_password_form() {
	global $post;
	$options = get_desing_plus_option();
	
	$label = 'pwbox-' . ( empty($post->ID) ? rand() : $post->ID );
	$output = '<form action="' . esc_url( site_url( 'wp-login.php?action=postpass', 'login_post' ) ) . '" class="post-password-form c-pw" method="post">';
	
	// パスワード入力ボックスを追加
  $output .= '<div class="c-pw__box">';

	$output .= '<p class="c-pw__box-desc">' . __( 'This content is password protected. To view it please enter your password below:' ) . '</p>';
	$output .= '<div class="c-pw__box-inner"><label class="c-pw__box-label" for="' . $label . '">' . __( 'Password:', 'tcd-w' ) . '</label><input class="c-pw__box-input" name="post_password" id="' . $label . '" type="password" size="20"><input class="c-pw__btn c-pw__btn--submit" type="submit" name="Submit" value="' . esc_attr_x( 'Enter', 'post password form' ) . '"></div>';

	$output .= '</div></form>';

	return $output;
}
add_filter( 'the_password_form', 'tcd_password_form' );
