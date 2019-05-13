<?php

add_filter( 'wp_image_editors', 'change_graphic_lib' );
function change_graphic_lib($array) {
return array( 'WP_Image_Editor_GD', 'WP_Image_Editor_Imagick' );
}


// Translation
load_theme_textdomain( 'tcd-w', get_template_directory() . '/languages' );

function oops_setup() {

	// Post thumbnails
	add_theme_support( 'post-thumbnails' );

	// Title tag
	add_theme_support( 'title-tag' );

	// Image sizes
	add_image_size( 'size1', 720, 360, true ); 	
	add_image_size( 'size2', 320, 320, true ); 	
	add_image_size( 'size3', 680, 440, true ); 	
	add_image_size( 'size-card', 120, 120, true ); // カードリンクパーツ用
	
	// Menu
	register_nav_menus( array(
		'global_front' => __( 'Global menu (front page)', 'tcd-w' ),
		'global_sub' => __( 'Global menu (sub page)', 'tcd-w' ),
		'footer' => __( 'Footer menu', 'tcd-w' )
	) );

}
add_action( 'after_setup_theme', 'oops_setup' );

function oops_init() {

	// Emoji
  $options = get_desing_plus_option();
  if ( 0 == $options['use_emoji'] ) {
  	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
    remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
    remove_action( 'wp_print_styles', 'print_emoji_styles' );
    remove_action( 'admin_print_styles', 'print_emoji_styles' );    
    remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
    remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );    
  	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	}

	// Custom post type: News
	$news_labels = array(
		'name' => __( 'News', 'tcd-w' )
	);
	$news_args = array(
		'has_archive' => true,
		'labels' => $news_labels,
		'menu_position' => 5,
		'public' => true,
		'supports' => array( 'editor', 'revisions', 'thumbnail', 'title' )
	);
	register_post_type( 'news', $news_args );

	// Custom post type: Review
	$review_labels = array(
		'name' => __( 'Review', 'tcd-w' )
	);
	$review_args = array(
		'has_archive' => true,
		'labels' => $review_labels,
		'menu_position' => 5,
		'public' => true,
		'supports' => array( 'editor', 'revisions', 'title' )
	);
	register_post_type( 'review', $review_args );
}
add_action( 'init', 'oops_init' );

function oops_scripts() {

	$options = get_desing_plus_option();

	if ( is_front_page() ) {

		wp_enqueue_style( 'oops-lightbox', get_template_directory_uri() . '/css/lightbox.min.css' );
		wp_enqueue_script( 'oops-lightbox', get_template_directory_uri() . '/js/lightbox.min.js', array( 'jquery' ), version_num(), true );

		if ( 'type1' == $options['header_content_type'] ) {

			wp_enqueue_script( 'oops-index-slider', get_template_directory_uri() . '/js/index-slider.min.js', array( 'jquery' ), version_num(), true );

		} elseif ( 'type2' == $options['header_content_type'] ) {
			wp_enqueue_style( 'oops-vegas', get_template_directory_uri() . '/css/vegas.min.css' );
			wp_enqueue_script( 'oops-vegas', get_template_directory_uri() . '/js/vegas.min.js', array( 'jquery' ), version_num(), true );

		} else {
			wp_enqueue_style( 'oops-YTPlayer', get_template_directory_uri() . '/css/jquery.mb.YTPlayer.min.css' );
			wp_enqueue_script( 'oops-YTPlayer', get_template_directory_uri() . '/js/jquery.mb.YTPlayer.min.js', array( 'jquery' ), version_num(), true );
		}

		if ( $options['display_news_ticker'] ) {
			wp_enqueue_script( 'oops-simple-ticker', get_template_directory_uri() . '/js/jquery.simpleTicker.js', array( 'jquery' ), version_num(), true );
		}

	} elseif ( is_search() || is_home() || ( is_archive() && ! is_post_type_archive( 'review' ) ) ) {
		wp_enqueue_script( 'oops-imagesloaded', get_template_directory_uri() . '/js/imagesloaded.pkgd.min.js', array( 'jquery' ), version_num(), true );

		if ( ! wp_is_mobile() ) {
			wp_enqueue_script( 'oops-jquery-infinitescroll-min', get_template_directory_uri() . '/js/jquery.infinitescroll.min.js', array( 'jquery' ), version_num(), true );
			wp_enqueue_script( 'oops-infinitescroll', get_template_directory_uri() . '/js/infinitescroll.min.js', array( 'jquery' ), version_num(), true );
		}

	} elseif ( is_singular( 'post' ) ) {
		wp_enqueue_script( 'comment', get_template_directory_uri() . '/js/comment.js', array( 'jquery' ), version_num(), true );
	}

	wp_enqueue_script( 'oops-inview', get_template_directory_uri() . '/js/jquery.inview.min.js', array( 'jquery' ), version_num(), true );
	wp_enqueue_style( 'oops-slick', get_template_directory_uri() . '/css/slick.min.css' );
	wp_enqueue_style( 'oops-slick-theme', get_template_directory_uri() . '/css/slick-theme.min.css' );
	wp_enqueue_style( 'oops-style', get_stylesheet_uri(), false, version_num() );
	wp_enqueue_script( 'oops-parallax', get_template_directory_uri() . '/js/parallax.min.js', array( 'jquery' ), version_num(), true );
	wp_enqueue_script( 'oops-slick', get_template_directory_uri() . '/js/slick.min.js', array( 'jquery' ), version_num(), true );
	wp_enqueue_script( 'oops-auto-height', get_template_directory_uri() . '/js/jQueryAutoHeight.js', array( 'jquery', 'oops-slick' ), version_num(), true );
	wp_enqueue_script( 'oops-script', get_template_directory_uri() . '/js/functions.min.js', array( 'jquery', 'oops-slick', 'oops-auto-height' ), version_num(), true );

	if ( ! is_no_responsive() ) { 
		wp_enqueue_style( 'oops-responsive', get_template_directory_uri() . '/responsive.min.css', array( 'oops-style' ), version_num() ); 
		wp_enqueue_script( 'oops-responsive', get_template_directory_uri() . '/js/responsive.min.js', array( 'jquery', 'oops-script' ), version_num(), true );
		if ( 'type3' !== $options['footer_bar_display'] && '5' === $options['footer_cta_display'] ) {
			wp_enqueue_style( 'oops-footer-bar', get_template_directory_uri() . '/css/footer-bar.min.css', false, version_num() );
			wp_enqueue_script( 'oops-footer-bar', get_template_directory_uri() . '/js/footer-bar.min.js', array( 'jquery' ), version_num(), true );
		}
	}

	// ヘッダースクロール
	if ( wp_is_mobile() && 'type2' == $options['mobile_header_fix'] ) {
		wp_enqueue_script( 'oops-scroll', get_template_directory_uri() . '/js/mobile-index-scroll.min.js', array( 'jquery' ), version_num(), true );
	} elseif ( ! wp_is_mobile() && 'type2' == $options['header_fix'] ) {
		if ( is_front_page() ) {
			wp_enqueue_script( 'oops-scroll', get_template_directory_uri() . '/js/index-scroll.min.js', array( 'jquery' ), version_num(), true );
		} else {
			wp_enqueue_script( 'oops-scroll', get_template_directory_uri() . '/js/scroll.min.js', array( 'jquery' ), version_num(), true );
		}
	}

}
add_action( 'wp_enqueue_scripts', 'oops_scripts' );

function oops_admin_scripts() {

	wp_enqueue_script( 'media-upload' );

	// 画像アップロードで使用
	wp_enqueue_script( 'cf-media-field', get_template_directory_uri() . '/admin/js/cf-media-field.js', '', version_num() );

	// メディアアップローダーAPIを利用するための処理
	wp_enqueue_media();

	// ウィジェット「広告（tcd バージョン）」で使用
	wp_enqueue_script( 'oops-widget-script', get_template_directory_uri() . '/admin/js/widget.min.js', array( 'jquery' ), '', version_num() );

	// テーマオプションのタブで使用
	wp_enqueue_script( 'jquery.cookieTab', get_template_directory_uri() . '/admin/js/jquery.cookieTab.js', '', version_num() );

	// テーマオプションの画像で使用
  wp_enqueue_script( 'dp-image-manager', get_template_directory_uri().'/admin/js/image-manager.min.js', '', version_num(), true );
  wp_enqueue_style( 'jquery-ui-draggable' ); // admin/js/image-manager.js で使用

	wp_enqueue_style( 'my_admin_css', get_template_directory_uri() . '/admin/css/my_admin.min.css', '', version_num() );
	wp_enqueue_script( 'my_script', get_template_directory_uri() . '/admin/js/my_script.min.js', '', version_num() );

	// コンテンツビルダー
	wp_enqueue_style( 'oops-cb', get_template_directory_uri() . '/admin/css/cb.min.css', '', version_num() );
	wp_enqueue_script( 'oops-cb', get_template_directory_uri() . '/admin/js/cb.min.js', '', version_num() );
	wp_enqueue_style( 'editor-buttons' ); // editor-buttons.css を常時出力

	// フッターバー
	wp_enqueue_style( 'oops-admin-footer-bar', get_template_directory_uri() . '/admin/css/footer-bar.min.css', '', version_num() );
	wp_enqueue_script( 'oops-admin-footer-bar', get_template_directory_uri() . '/admin/js/footer-bar.min.js', '', version_num() );

	wp_enqueue_style( 'wp-color-picker' );
	wp_enqueue_script( 'wp-color-picker');
?>
<script type="text/javascript">
var cfmf_text = { title:'<?php _e('Please Select Image', 'tcd-w'); ?>', button:'<?php _e('Use this Image', 'tcd-w'); ?>' };
</script>
<?php
}
add_action( 'admin_enqueue_scripts', 'oops_admin_scripts' );

// Editor style
function oops_add_editor_styles() {
    add_editor_style( 'admin/css/editor-style-02.min.css' );
}
add_action( 'admin_init', 'oops_add_editor_styles' );

// Widget area
function oops_widgets_init() {

	// Archive page(left)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget">'."\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>',
		'name' => __( 'Archive page(left)', 'tcd-w' ),
		'id' => 'archive_widget_left'
	) );

	// Archive page(center)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget">'."\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>',
		'name' => __( 'Archive page(center)', 'tcd-w' ),
		'id' => 'archive_widget_center'
	) );

	// Archive page(right)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget">'."\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>',
		'name' => __( 'Archive page(right)', 'tcd-w' ),
		'id' => 'archive_widget_right'
	) );

	// Archive page(mobile)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget">'."\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>',
		'name' => __( 'Archive page(mobile)', 'tcd-w' ),
		'id' => 'archive_widget_mobile'
	) );

	// Post page(left)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget">'."\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>',
		'name' => __( 'Post page(left)', 'tcd-w' ),
		'id' => 'post_widget_left'
	) );

	// Post page(center)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget">'."\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>',
		'name' => __( 'Post page(center)', 'tcd-w' ),
		'id' => 'post_widget_center'
	) );

	// Post page(right)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget">'."\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>',
		'name' => __( 'Post page(right)', 'tcd-w' ),
		'id' => 'post_widget_right'
	) );

	// Post page(mobile)
	register_sidebar( array(
		'before_widget' => '<div class="p-widget">'."\n",
		'after_widget' => "</div>\n",
		'before_title' => '<h2 class="p-widget__title">',
		'after_title' => '</h2>',
		'name' => __( 'Post page(mobile)', 'tcd-w' ),
		'id' => 'post_widget_mobile'
	) );
}
add_action( 'widgets_init', 'oops_widgets_init' );

// Excerpt
function custom_excerpt_length( $length ) {
	return 75;
}
add_filter( 'excerpt_length', 'custom_excerpt_length', 999 );

function new_excerpt_more( $more ) {
	return '...';
}
add_filter( 'excerpt_more', 'new_excerpt_more' );

// Remove wpautop from the excerpt
remove_filter( 'the_excerpt', 'wpautop' );

// Customize archive title
function oops_archive_title( $title ) {
	global $author, $post;
	if ( is_author() ) {
		$title = get_the_author_meta( 'display_name', $author );
	} elseif ( is_category() || is_tag() ) {
		$title = single_term_title( '', false );
	} elseif ( is_day() ) {
		$title = get_the_time( __( 'F jS, Y', 'tcd-w' ), $post );
	} elseif ( is_month() ) {
		$title = get_the_time( __( 'F, Y', 'tcd-w' ), $post );
	} elseif ( is_year() ) {
		$title = get_the_time( __( 'Y', 'tcd-w' ), $post );
	} elseif ( is_search() ) {
		$title = __( 'Search result', 'tcd-w' );
	}
	return $title;
}
add_filter( 'get_the_archive_title', 'oops_archive_title', 10 );

// ビジュアルエディタに表(テーブル)の機能を追加
function mce_external_plugins_table( $plugins ) {
	$plugins['table'] = '//cdn.tinymce.com/4/plugins/table/plugin.min.js';
  return $plugins;
}
add_filter( 'mce_external_plugins', 'mce_external_plugins_table' );

// tinymceのtableボタンにclass属性プルダウンメニューを追加
function mce_buttons_table( $buttons ) {
	$buttons[] = 'table';
  return $buttons;
}
add_filter( 'mce_buttons', 'mce_buttons_table' );

function bootstrap_classes_tinymce( $settings ) {
  $styles = array(
    array( 'title' => __( 'Default style', 'tcd-w'), 'value' => '' ),
    array( 'title' => __( 'No border', 'tcd-w'), 'value' => 'table_no_border' ),
    array( 'title' => __( 'Display only horizontal border', 'tcd-w' ), 'value' => 'table_border_horizontal' )
  );
  $settings['table_class_list'] = json_encode( $styles );
  return $settings;
}
add_filter( 'tiny_mce_before_init', 'bootstrap_classes_tinymce' );

// ビジュアルエディタにページ分割ボタンを追加 -----------------------------------------------
function add_nextpage_buttons($buttons){
	array_push($buttons, "wp_page");
	return $buttons;
}
add_filter("mce_buttons", "add_nextpage_buttons");


/**
 * クローン用のリッチエディター化処理をしないようにする
 * クローン後のリッチエディター化はjsで行う
 */
function cb_builder_tiny_mce_before_init( $mceInit, $editor_id ) { 
  if ( strpos( $editor_id, 'cb_cloneindex' ) !== false ) { 
    $mceInit['wp_skip_init'] = true;
  }
  return $mceInit;
}
add_filter( 'tiny_mce_before_init', 'cb_builder_tiny_mce_before_init', 10, 2 );

/**
 *  Translate Hex to RGB
 */
function hex2rgb( $hex ) {

	$hex = str_replace( '#', '', $hex );

  if ( strlen( $hex ) == 3 ) {
		$r = hexdec( substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) );
    $g = hexdec( substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) );
    $b = hexdec( substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) );
  } else {
  	$r = hexdec( substr( $hex, 0, 2 ) );
    $g = hexdec( substr( $hex, 2, 2 ) );
    $b = hexdec( substr( $hex, 4, 2 ) );
   }
   $rgb = array( $r, $g, $b );

   return $rgb;
}

/**
 *  ユーザーエージェントを判定するための関数
 */
function is_mobile() {
  
	// タブレットも含める場合は wp_is_mobile()
 	$match = 0;
	$ua = array(
  	'iPhone', // iPhone
   	'iPod', // iPod touch
		'Android.*Mobile', // 1.5+ Android *** Only mobile
		'Windows.*Phone', // *** Windows Phone
		'dream', // Pre 1.5 Android
		'CUPCAKE', // 1.5+ Android
		'BlackBerry', // BlackBerry
		'BB10', // BlackBerry10
		'webOS', // Palm Pre Experimental
		'incognito', // Other iPhone browser
		'webmate' // Other iPhone browser
	);

 	$pattern = '/' . implode( '|', $ua ) . '/i';
 	$match   = preg_match( $pattern, $_SERVER['HTTP_USER_AGENT'] );

 	if ( $match === 1 ) {
   		return TRUE;
 	} else {
   		return FALSE;
 	}
}

/**
 * レスポンシブOFF機能を判定するための関数
 */
function is_no_responsive() {
	$options = get_desing_plus_option();
	return $options['responsive'] == 'no' ? true : false;
}

/**
 * スクリプトのバージョン管理
 */
function version_num() {
	if ( function_exists( 'wp_get_theme' ) ) {
		$theme_data = wp_get_theme();
 	} else {
   		$theme_data = get_theme_data( TEMPLATEPATH . '/style.css' );
 	}
	$current_version = $theme_data['Version'];
 	return $current_version;
}

/**
 * カードリンクパーツ
 */
function get_the_custom_excerpt( $content, $length ) {
	$length = ( $length ? $length : 70 ); // デフォルトの長さを指定する
  $content =  preg_replace( '/<!--more-->.+/is', '', $content ); // moreタグ以降削除
 	$content =  strip_shortcodes( $content ); // ショートコード削除
  $content =  strip_tags( $content ); // タグの除去
  $content =  str_replace( '&nbsp;', '', $content ); // 特殊文字の削除（今回はスペースのみ）
  $content =  mb_substr( $content, 0, $length ); // 文字列を指定した長さで切り取る
  return $content.'...';
}
 
/**
 * カードリンクショートコード
 */
function clink_scode( $atts ) {
	extract( shortcode_atts( array( 'url' => '', 'title' => '', 'excerpt' => '' ), $atts ) );
  $id = url_to_postid( $url ); // URLから投稿IDを取得
  $post = get_post( $id ); // IDから投稿情報の取得
  $date = mysql2date( 'Y.m.d', $post->post_date ); // 投稿日の取得
  $img_width = 120; // 画像サイズの幅指定
  $img_height = 120; // 画像サイズの高さ指定
  $no_image = get_template_directory_uri() . '/img/common/no-image-280x280.gif';

  // 抜粋を取得
  if ( empty( $excerpt ) ) {
  	if ( $post->post_excerpt ) {
    	$excerpt = get_the_custom_excerpt( $post->post_excerpt, 145 );
  	} else {
      $excerpt = get_the_custom_excerpt( $post->post_content , 145 );
  	}
  }
  // タイトルを取得
  if ( empty( $title ) ) {
  	$title = esc_html( get_the_title( $id ) );
  }
 	// アイキャッチ画像を取得 
  if ( has_post_thumbnail( $id ) ) {
  	$img = wp_get_attachment_image_src( get_post_thumbnail_id( $id ), 'size-card' );
    $img_tag = '<img src="' . $img[0] . '" alt="' . $title . '" width="' . $img[1] . '" height="' . $img[2] . '">';
  } else { 
		$img_tag ='<img src="' . $no_image . '" alt="" width="' . $img_width . '" height="' . $img_height . '">';
  }
  $clink = '<div class="cardlink"><a href="' . esc_url( $url ) . '"><div class="cardlink_thumbnail">' . $img_tag . '</div></a><div class="cardlink_content"><span class="cardlink_timestamp">' . esc_html( $date ) . '</span><div class="cardlink_title"><a href="' . esc_url( $url ) . '">' . esc_html( $title ) . '</a></div><div class="cardlink_excerpt">' . esc_html( $excerpt ) . '</div></div><div class="cardlink_footer"></div></div>';
  
	return $clink;
}  
add_shortcode( 'clink', 'clink_scode' );

/**
* ロゴ画像を保存しているディレクトリ名を返す 
* @return string
*/
function dp_logo_basedir() {
	$dir = wp_upload_dir();
	return $dir['basedir'] . DIRECTORY_SEPARATOR . 'tcd-w';
}

/**
* ロゴ画像を保存しているディレクトリのURLを返す
* @return string
*/
function dp_logo_baseurl() {
	$dir = wp_upload_dir();
	return $dir['baseurl'] . '/tcd-w';
}

/**
 * アップロードされたロゴか否か
 * @param string $url
 * @return boolean 
 */
function dp_is_uploaded_img( $url ) {
	return false !== strpos( $url, dp_logo_baseurl() );
}	

/**
 * ロゴ画像を削除する
 * @return void
 */
function _dp_delete_image(){
	if(isset($_REQUEST['page'], $_REQUEST['_wpnonce']) && !isset($_REQUEST['settings-updated']) && $_REQUEST['page'] == 'theme_options'){
		if(wp_verify_nonce($_REQUEST['_wpnonce'], 'dp_delete_image_'.get_current_user_id())){
			$dir = dp_logo_basedir();
			foreach(scandir($dir) as $file){
				if(preg_match("/logo(-resized)?\.(png|gif|jpe?g)/i", $file)){
					if(!@unlink($dir.DIRECTORY_SEPARATOR.$file)){
						add_action('admin_notices', '_dp_delete_message_error');
						return;
					}
				}
			}
			add_action('admin_notices', '_dp_delete_message_sucess');
		}

		$options = get_desing_plus_option();

			if(wp_verify_nonce($_REQUEST['_wpnonce'], 'dp_delete_video')){
				$file = basename($options['video']);
				if(file_exists(dp_logo_basedir().DIRECTORY_SEPARATOR.$file) && @unlink(dp_logo_basedir().DIRECTORY_SEPARATOR.$file)){
					$options['video'] = '';
					update_option('dp_options', $options);
					add_action('admin_notices', '_dp_delete_message_sucess');
				}else{
					add_action('admin_notices', '_dp_delete_message_error');
				}
			}

			if(wp_verify_nonce($_REQUEST['_wpnonce'], 'dp_delete_favicon')){
      	$file = basename($options['favicon']);
      	if(file_exists(dp_logo_basedir().DIRECTORY_SEPARATOR.$file) && @unlink(dp_logo_basedir().DIRECTORY_SEPARATOR.$file)){
        	$options['favicon'] = '';
        	update_option('dp_options', $options);
        	add_action('admin_notices', '_dp_delete_message_sucess');
      	}else{
        	add_action('admin_notices', '_dp_delete_message_error');
      }
    }

	}
	
}
add_action('admin_init', '_dp_delete_image');

/**
 * ロゴ画像の削除失敗メッセージ 
 */
function _dp_delete_message_error(){
	echo '<div id="message" class="error"><p>'.sprintf(__('Failed to delete file. Please check permisson of %s. All files must be writable.', 'tcd-w'), dp_logo_basedir()).'</p></div>';
}

/**
 * ロゴ画像の削除成功メッセージ 
 */
function _dp_delete_message_sucess(){
	echo '<div id="message" class="updated fade"><p>'.__('File are successfully deleted.', 'tcd-w').'</p></div>';
}

/**
 * アップロードエラーのメッセージを表示する
 * @param int $error_code
 * @return string 
 */
function _dp_get_upload_err_msg( $error_code ) {
	switch ( $error_code ) {
		case UPLOAD_ERR_INI_SIZE:
			return __( 'Uploaded file size is larger than limit set in php.ini.', 'tcd-w' );
			break;
		case UPLOAD_ERR_FORM_SIZE:
			return __( 'Uploaded file size is larget than post file size.', 'tcd-w' );
			break;
		case UPLOAD_ERR_PARTIAL:
			return  __(	'The file has been uploaded only partially. Connection error may have occured', 'tcd-w' );
			break;
		case UPLOAD_ERR_NO_FILE:
			return  __(	'Uploaded file size is too large.', 'tcd-w' );
			break;
		case UPLOAD_ERR_NO_TMP_DIR:
			return  __(	'No temporary directory exists. Please check PHP Setting is valid.', 'tcd-w' );
			break;
		case UPLOAD_ERR_CANT_WRITE:
			return  __(	'Failed to write to disk. OS file setting or something is wrong.', 'tcd-w' );
			break;
		case UPLOAD_ERR_EXTENSION:
			return  __(	'PHP extension module stops uploading. Check PHP setting.', 'tcd-w' );
			break;
		default:
			return  __(	'Upload failed. Sorry, but reasons cannot be detected.', 'tcd-w' );
			break;
	}
}

/**
 * カスタムコメント
 */
function custom_comments( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	global $commentcount;
	if ( ! $commentcount ) {
		$commentcount = 0;
	}
?>
<li id="comment-<?php comment_ID(); ?>" class="c-comment__list-item comment">
	<div class="c-comment__item-header u-clearfix">
		<div class="c-comment__item-meta u-clearfix">
<?php 
	if ( function_exists( 'get_avatar' ) && get_option( 'show_avatars' ) ) { 
		echo get_avatar( $comment, 35, '', false, array( 'class' => 'c-comment__item-avatar' ) ); 
	} 
	if ( get_comment_author_url() ) {
		echo '<a id="commentauthor-' . get_comment_ID() . '" class="c-comment__item-author" rel="nofollow">' . get_comment_author() . '</a>' . "\n";
	} else {
		echo '<span id="commentauthor-' . get_comment_ID() . '" class="c-comment__item-author">' . get_comment_author() . '</span>' . "\n";
	}
?>
			<time class="c-comment__item-date" datetime="<?php comment_time( 'Y-m-d' ); ?>"><?php comment_time( __( 'F jS, Y', 'tcd-w' ) ); ?></time>
		</div>
		<ul class="c-comment__item-act">
<?php 
	if ( 1 == get_option( 'thread_comments' ) ) :
?>
			<li><?php comment_reply_link( array_merge( $args, array( 'add_below' => 'comment-content', 'depth' => $depth, 'max_depth' => $args['max_depth'], 'reply_text' => __( 'REPLY', 'tcd-w' ) . '' ) ) ); ?></li>
<?php
	else :
?>
    	<li><a href="javascript:void(0);" onclick="MGJS_CMT.reply('commentauthor-<?php comment_ID() ?>', 'comment-<?php comment_ID() ?>', 'js-comment__textarea');"><?php _e( 'REPLY', 'tcd-w' ); ?></a></li>
<?php
	endif;
?>
    	<li><a href="javascript:void(0);" onclick="MGJS_CMT.quote('commentauthor-<?php comment_ID() ?>', 'comment-<?php comment_ID() ?>', 'comment-content-<?php comment_ID() ?>', 'js-comment__textarea');"><?php _e( 'QUOTE', 'tcd-w' ); ?></a></li>
    	<?php edit_comment_link( __( 'EDIT', 'tcd-w' ), '<li>', '</li>'); ?>
		</ul>
	</div>
	<div id="comment-content-<?php comment_ID() ?>" class="c-comment__item-body">
<?php
	if ( 0 == $comment->comment_approved ) {
		echo '<span class="c-comment__item-note">' . __( 'Your comment is awaiting moderation.', 'tcd-w' ) . '</span>' . "\n"; 
	} else {
		comment_text();
	}
?>
	</div>
<?php
}

// Theme options
require get_template_directory() . '/admin/theme-options.php';

// Add custom columns
require get_template_directory() . '/functions/admin_column.php';

// Calls to action
require get_template_directory() . '/functions/cta.php';
require get_template_directory() . '/functions/footer-cta.php';

// Custom CSS
require get_template_directory() . '/functions/custom_css.php';

// Add quicktags to the visual editor
require get_template_directory() . '/functions/custom_editor.php';

// hook wp_head
require get_template_directory() . '/functions/head.php';

// OGP
require get_template_directory() . '/functions/ogp.php';

// Recommend post
require get_template_directory() . '/functions/recommend.php';

// Review
require get_template_directory() . '/functions/review_cf.php';

// Page builder
require get_template_directory() . '/pagebuilder/pagebuilder.php';

// Page custom fields
require get_template_directory() . '/functions/page_cf.php';

// Password protected pages
require get_template_directory() . '/functions/password_form.php';

// Show custom fields in quick edit
require get_template_directory() . '/functions/quick_edit.php';

// Meta title and description
require get_template_directory() . '/functions/seo.php';

// Shortcode
require get_template_directory() . '/functions/short_code.php';

// Update notifier
require get_template_directory() . '/functions/update_notifier.php';
 
// Widgets
require get_template_directory() . '/widget/ad.php';
require get_template_directory() . '/widget/archive_list.php';
require get_template_directory() . '/widget/category_list.php';
require get_template_directory() . '/widget/google_search.php';
require get_template_directory() . '/widget/styled_post_list1.php';
