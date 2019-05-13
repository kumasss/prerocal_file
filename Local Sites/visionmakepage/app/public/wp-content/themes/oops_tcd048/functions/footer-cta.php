<?php
$options = get_desing_plus_option();

function tcd_footer_cta_scripts() {

	wp_enqueue_script( 'oops-footer-cta', get_template_directory_uri() . '/js/footer-cta.min.js', array( 'jquery' ), version_num(), true );
	wp_enqueue_script( 'oops-admin-footer-cta', get_template_directory_uri() . '/admin/js/footer-cta.min.js', array( 'jquery' ), version_num(), true );
	wp_localize_script( 'oops-admin-footer-cta', 'tcd_footer_cta', array( 'admin_url' => admin_url( 'admin-ajax.php' ), 'ajax_nonce' => wp_create_nonce( 'tcd_footer_cta_nonce' ) ) );


}
if ( '5' !== $options['footer_cta_display'] ) {
	add_action( 'wp_enqueue_scripts', 'tcd_footer_cta_scripts' );
}

function tcd_admin_footer_cta_scripts() {

	wp_enqueue_script( 'oops-footer-cta', get_template_directory_uri() . '/admin/js/footer-cta.min.js', array( 'jquery' ), version_num(), true );
	wp_localize_script( 'oops-footer-cta', 'tcd_footer_cta', array( 'admin_url' => admin_url( 'admin-ajax.php' ), 'ajax_nonce' => wp_create_nonce( 'tcd_footer_cta_nonce' ), 'confirm_text' => __( 'Are you sure to reset these values?', 'tcd-w' ) ) );

}
add_action( 'admin_print_scripts-appearance_page_theme_options', 'tcd_admin_footer_cta_scripts' );

// インプレッション、クリック率、コンバージョン率の管理
function tcd_footer_cta_impression() {

	$options = get_desing_plus_option();

	// verify the nonce
	check_ajax_referer( 'tcd_footer_cta_nonce', 'security' );

	// 表示しているフッターCTAの番号
	$cta_index = $options['footer_cta_display'];

	// ランダム表示の場合、渡されたcta_indexを使用する
	if ( '4' === $cta_index ) {
		$cta_index = strval( intval( $_POST['cta_index'] ) );
	}

	// 表示しているフッターCTAのインプレッションとクリック数、コンバージョンを取得
	$cta_impression = get_option( 'tcd_footer_cta_impression' . $cta_index, 0 );
	$cta_click = get_option( 'tcd_footer_cta_click' . $cta_index, 0 );
	$cta_conversion = get_option( 'tcd_footer_cta_conversion' . $cta_index, 0 );

	// インプレッションのカウントを1増やす
	$cta_impression++;

	// クリック率の計算
	if ( 0 !== $cta_impression ) {
		$cta_ctr = floor( 10000 * $cta_click / $cta_impression ) / 100;
	} else {
		$cta_ctr = 0;
	}

	// コンバージョン率の計算
	if ( 0 !== $cta_impression ) {
		$cta_cvr = floor( 10000 * $cta_conversion / $cta_impression ) / 100;
	} else {
		$cta_cvr = 0;
	}

	// データを更新
	update_option( 'tcd_footer_cta_impression' . $cta_index, $cta_impression );
	update_option( 'tcd_footer_cta_ctr' . $cta_index, $cta_ctr );
	update_option( 'tcd_footer_cta_cvr' . $cta_index, $cta_cvr );

	die();
}
add_action( 'wp_ajax_tcd_footer_cta_impression', 'tcd_footer_cta_impression' );
add_action( 'wp_ajax_nopriv_tcd_footer_cta_impression', 'tcd_footer_cta_impression' );

// クリック数、クリック率、Cookie の管理
function tcd_footer_cta_click() {

	$options = get_desing_plus_option();

	// verify the nonce
	check_ajax_referer( 'tcd_footer_cta_nonce', 'security' );

	// 表示しているフッターCTAの番号
	$cta_index = $options['footer_cta_display'];

	// ランダム表示の場合、渡されたcta_indexを使用する
	if ( '4' === $cta_index ) {
		$cta_index = strval( intval( $_POST['cta_index'] ) );
	}

	// Cookie の上書き
	if ( isset( $_COOKIE['tcd_footer_cta'] ) ) {
		setcookie( 'tcd_footer_cta', '', time() - 3600, '/' );
	}

	// Cookie を30日間に設定
	setcookie( 'tcd_footer_cta', $cta_index, time() + 60*60*24*30, '/' );

	// 表示しているフッターCTAのインプレッションとクリック数を取得
	$cta_impression = get_option( 'tcd_footer_cta_impression' . $cta_index, 0 );
	$cta_click = get_option( 'tcd_footer_cta_click' . $cta_index, 0 );

	// 表示しているフッターCTAのクリック率(Click-through rate)
	$cta_ctr = get_option( 'tcd_footer_cta_ctr' . $cta_index, 0 );

	// クリック数のカウントを1増やす
	$cta_click++;

	// クリック率の計算
	if ( 0 !== $cta_impression ) {
		$cta_ctr = floor( 10000 * $cta_click / $cta_impression ) / 100;
	} else {
		$cta_ctr = 0;
	}

	// データを更新
	update_option( 'tcd_footer_cta_click' . $cta_index, $cta_click );
	update_option( 'tcd_footer_cta_ctr' . $cta_index, $cta_ctr );

	die();
}
add_action( 'wp_ajax_tcd_footer_cta_click', 'tcd_footer_cta_click' );
add_action( 'wp_ajax_nopriv_tcd_footer_cta_click', 'tcd_footer_cta_click' );

// コンバージョン、コンバージョン率の管理
function tcd_footer_cta_conversion() {

	$options = get_desing_plus_option();

	// verify the nonce
	check_ajax_referer( 'tcd_footer_cta_nonce', 'security' );

	if ( isset( $_COOKIE['tcd_footer_cta'] ) ) {
	
		// コンバージョンを計測するフッターCTAの番号
		$cta_index = strval( intval( $_COOKIE['tcd_footer_cta'] ) );
		
		// Cookie の削除
		setcookie( 'tcd_footer_cta', '', time() - 3600, '/' );

		// コンバージョンを計測するフッターCTAのインプレッション、コンバージョンを取得
		$cta_impression = get_option( 'tcd_footer_cta_impression' . $cta_index, 0 );
		$cta_conversion = get_option( 'tcd_footer_cta_conversion' . $cta_index, 0 );

		// コンバージョンのカウントを1増やす
		$cta_conversion++;
	}

	// コンバージョン率の計算 (Conversion Rate)
	if ( 0 !== $cta_impression ) {
		$cta_cvr = floor( 10000 * $cta_conversion / $cta_impression ) / 100;
	} else {
		$cta_cvr = 0;
	}

	// データを更新
	update_option( 'tcd_footer_cta_conversion' . $cta_index, $cta_conversion );
	update_option( 'tcd_footer_cta_cvr' . $cta_index, $cta_cvr );

	die();
}
add_action( 'wp_ajax_tcd_footer_cta_conversion', 'tcd_footer_cta_conversion' );
add_action( 'wp_ajax_nopriv_tcd_footer_cta_conversion', 'tcd_footer_cta_conversion' );

function tcd_footer_cta_reset() {

	$options = get_desing_plus_option();

	// verify the nonce
	check_ajax_referer( 'tcd_footer_cta_nonce', 'security' );

	// リセットするフッターCTAの番号
	$cta_index = strval( intval( $_POST['footer_cta_index'] ) );

	// インプレッション、クリック数、クリック率をリセット
	update_option( 'tcd_footer_cta_impression' . $cta_index, 0 );
	update_option( 'tcd_footer_cta_click' . $cta_index, 0 );
	update_option( 'tcd_footer_cta_ctr' . $cta_index, 0 );

	die();
}
add_action( 'wp_ajax_tcd_footer_cta_reset', 'tcd_footer_cta_reset' );
add_action( 'wp_ajax_nopriv_tcd_footer_cta_reset', 'tcd_footer_cta_reset' );

// ランダム表示に使用するCTA配列を取得する
function get_footer_cta_in_random_display() {
	
	$options = get_desing_plus_option();

	$cta_in_random_display = array();

	for ( $i = 1; $i <= 3; $i++) {
		if ( $options['footer_cta_random' . $i] ) {
			$cta_in_random_display[] = $i;
		}
	}

	return $cta_in_random_display;
}

// head 要素にフッターCTAのスタイルを書き出す
// スタイルを適用するクラスの先頭に .p-footer-cta--{$i} を置くことで、CTA-A〜C全てのスタイルを書きだす
function add_footer_cta_styles() {

	$options = get_desing_plus_option();
	if ( '5' === $options['cta_display'] ) return;
?>
<style>
<?php
for ( $i = 1; $i <= 3; $i++ ) :
	if ( 'type1' == $options['footer_cta_type' . $i] ) :
?>
.p-footer-cta--<?php echo $i; ?> .p-footer-cta__inner { background: rgba( <?php echo esc_html( implode( ', ', hex2rgb( $options['footer_cta_bg' . $i] ) ) ); ?>, <?php echo esc_html( $options['footer_cta_bg_opacity' . $i] ); ?>); }
.p-footer-cta--<?php echo $i; ?> .p-footer-cta__btn { background: <?php echo esc_html( $options['footer_cta_btn_bg' . $i] ); ?>; }
.p-footer-cta--<?php echo $i; ?> .p-footer-cta__btn:hover { background: <?php echo esc_html( $options['footer_cta_btn_bg_hover' . $i] ); ?>; }
<?php
	endif;
endfor; 
?>
</style>
<?php
}
add_action( 'wp_head', 'add_footer_cta_styles' );
