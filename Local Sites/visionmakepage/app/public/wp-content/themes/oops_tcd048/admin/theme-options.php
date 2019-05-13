<?php
// 設定項目と無害化用コールバックを登録
function theme_options_init() {
	register_setting( 
		'design_plus_options', 
		'dp_options', 
		'theme_options_validate'
	);
}
add_action( 'admin_init', 'theme_options_init' );

// 外観メニューにサブメニューを登録
function theme_options_add_page() {
	add_theme_page( 
		__( 'TCD Theme Options', 'tcd-w' ), 
		__( 'TCD Theme Options', 'tcd-w' ), 
		'edit_theme_options',
		'theme_options',
		'theme_options_do_page'
	);
}
add_action( 'admin_menu', 'theme_options_add_page' );

/**
 * オプション初期値
 * @var array
 */
global $dp_default_options;
$dp_default_options = array(

	/**
	 * 基本設定
	 */
	// 色の設定
	'primary_color' => '#121d1f',
	'secondary_color' => '#ff7f00',
	'tertiary_color' => '#e37100',

	// ファビコンの設定
	'favicon' => '',

	// フォントタイプ
	'font_type' => 'type1',

	// 大見出しのフォントタイプ
	'headline_font_type' => 'type2',

	// 絵文字の設定
	'use_emoji' => 1,

	// レスポンシブデザインの設定
	'responsive' => 'yes',

	// ロード画面の設定
	'use_load_icon' => '',
	'load_icon' => 'type1',
	'load_time' => 3,

	// ホバーエフェクトの設定
	'hover_type' => 'type1',
	'hover1_zoom' => 1.2,
	'hover1_rotate' => 1,
	'hover2_direct' => 'type1',
	'hover2_opacity' => 0.5,
	'hover3_opacity' => 0.5,
	'hover3_bgcolor' => '#ffffff',

	// Facebook OGPの設定
	'use_ogp' => 0,
	'fb_admin_id' => '',
	'ogp_image' => '',

	// Twitter Cardsの設定
	'use_twitter_card' => 0,
	'twitter_account_name' => '',

	// ソーシャルボタンの表示設定
	'show_sns_top' => 1,
	'sns_type_top' => 'type1',
	'show_twitter_top' => 1,
	'show_fblike_top' => 1,
	'show_fbshare_top' => 1,
	'show_google_top' => 1,
	'show_hatena_top' => 1,
	'show_pocket_top' => 1,
	'show_feedly_top' => 1,
	'show_rss_top' => 1,
	'show_pinterest_top' => 1,
	'show_sns_btm' => 1,
	'sns_type_btm' => 'type1',
	'show_twitter_btm' => 1,
	'show_fblike_btm' => 1,
	'show_fbshare_btm' => 1,
	'show_google_btm' => 1,
	'show_hatena_btm' => 1,
	'show_pocket_btm' => 1,
	'show_feedly_btm' => 1,
	'show_rss_btm' => 1,
	'show_pinterest_btm' => 1,
	'twitter_info' => '',

	// カスタムCSS	
	'css_code' => '',

	/**
	 * ロゴ
	 */
	// ヘッダーのロゴ
	'logo_font_size' => 26,
	'header_logo_image' => '',
	'header_logo_image_retina' => '',
	
	// ヘッダーのロゴ（スマホ用）
	'logo_font_size_mobile' => 18,
	'header_logo_image_mobile' => '',
	'header_logo_image_mobile_retina' => '',

	// フッターのロゴ
	'logo_font_size_footer' => 26,
	'footer_logo_image' => false,

	/**
	 * トップページ
	 */
	// ヘッダーコンテンツの設定
	'header_content_type' => 'type1',
	'video' => false,
	'video_image' => false,
	'youtube_url' => '',
	'youtube_image' => false,
	'use_video_catch' => '1',
	'video_catch' => '',
	'video_catch_font_size' => '42',
	'video_desc' => '',
	'video_desc_font_size' => '16',
	'video_catch_color' => '#ffffff',
	'video_catch_shadow1' => 0,
	'video_catch_shadow2' => 0,
	'video_catch_shadow3' => 0,
	'video_catch_shadow_color' => '#333333',
	'show_video_catch_button' => '',
	'video_catch_button' => '',
	'video_button_color' => '#ffffff',
	'video_button_color_hover' => '#ffffff',
	'video_button_bg_color' => '#ff7f00',
	'video_button_bg_color_hover' => '#ff7f00',
	'video_button_url' => '',
	'video_button_target' => 1,
	'slider_type1' => 'type1',
	'slider_type2' => 'type2',
	'slider_type3' => 'type3',
	'slider_headline1' => '',
	'slider_headline2' => '',
	'slider_headline3' => '',
	'slider_headline_font_size1' => 40,
	'slider_headline_font_size2' => 40,
	'slider_headline_font_size3' => 40,
	'slider_desc1' => '',
	'slider_desc2' => '',
	'slider_desc3' => '',
	'slider_desc_font_size1' => 16,
	'slider_desc_font_size2' => 16,
	'slider_desc_font_size3' => 16,
	'slider_font_color1' => '#ffffff',
	'slider_font_color2' => '#ffffff',
	'slider_font_color3' => '#ffffff',
	'slider1_shadow1' => 0,
	'slider2_shadow1' => 0,
	'slider3_shadow1' => 0,
	'slider1_shadow2' => 0,
	'slider2_shadow2' => 0,
	'slider3_shadow2' => 0,
	'slider1_shadow3' => 0,
	'slider2_shadow3' => 0,
	'slider3_shadow3' => 0,
	'slider1_shadow_color' => '#888888',
	'slider2_shadow_color' => '#888888',
	'slider3_shadow_color' => '#888888',
	'display_slider_button1' => '',
	'display_slider_button2' => '',
	'display_slider_button3' => '',
	'slider_button_label1' => '',
	'slider_button_label2' => '',
	'slider_button_label3' => '',
	'slider_btn_color1' => '#000000',
	'slider_btn_color2' => '#000000',
	'slider_btn_color3' => '#000000',
	'slider_btn_bg1' => '#ff8000',
	'slider_btn_bg2' => '#ff8000',
	'slider_btn_bg3' => '#ff8000',
	'slider_btn_color_hover1' => '#ffffff',
	'slider_btn_color_hover2' => '#ffffff',
	'slider_btn_color_hover3' => '#ffffff',
	'slider_btn_bg_hover1' => '#e37100',
	'slider_btn_bg_hover2' => '#e37100',
	'slider_btn_bg_hover3' => '#e37100',
	'slider_url1' => '',
	'slider_url2' => '',
	'slider_url3' => '',
	'slider_target1' => '',
	'slider_target2' => '',
	'slider_target3' => '',
	'slider_image1' => '',
	'slider_image2' => '',
	'slider_image3' => '',
	'slider_bg_image1' => '',
	'slider_bg_image2' => '',
	'slider_bg_image3' => '',

	// ニュースティッカー
	'display_news_ticker' => 0,
	'display_news_ticker_date' => 1,
	'news_ticker_num' => 5,
	'display_news_ticker_link' => 1,
	'news_ticker_link_text' => '',

	// コンテンツビルダー
	'contents_builder' => array(),

	/**
	 * ブログ
	 */
	// アーカイブページヘッダーの設定
	'archive_image' => '',
	'archive_overlay' => '#0b3247',
	'archive_overlay_opacity' => 0.6,
	'archive_catchphrase' => '',
	'archive_desc' => '',
	'archive_catchphrase_font_size' => 40,
	'archive_desc_font_size' => 14,
	'archive_color' => 'FFFFFF',
	'archive_shadow1' => 0,
	'archive_shadow2' => 0,
	'archive_shadow3' => 0,
	'archive_shadow_color' => '#888888',

	// 記事詳細の設定
	'blog_overlay' => '#000000',
	'blog_overlay_opacity' => 0.5,
	'blog_color' => 'FFFFFF',
	'blog_shadow1' => 0,
	'blog_shadow2' => 0,
	'blog_shadow3' => 0,
	'blog_shadow_color' => '#888888',
	'title_font_size' => 40,
	'content_font_size' => 14,
	'content_link_color' => '#ff7f00',

	// 表示設定
	'show_date' => 1,
	'show_category' => 1,
	'show_tag' => 1,
	'show_author' => 1,
	'show_thumbnail' => 1,
	'show_next_post' => 1,
	'show_related_post' => 1,
	'show_comment' => 1,
	'show_trackback' => 1,

	// 記事詳細の広告設定1
	'single_ad_code1' => '',
	'single_ad_image1' => false,
	'single_ad_url1' => '',
	'single_ad_code2' => '',
	'single_ad_image2' => false,
	'single_ad_url2' => '',

	// 記事詳細の広告設定2
	'single_ad_code3' => '',
	'single_ad_image3' => false,
	'single_ad_url3' => '',
	'single_ad_code4' => '',
	'single_ad_image4' => false,
	'single_ad_url4' => '',

	// スマートフォン専用の広告
	'single_mobile_ad_code1' => '',
	'single_mobile_ad_image1' => false,
	'single_mobile_ad_url1' => '',

	/**
	 * ニュース
	 */
	// アーカイブページヘッダーの設定
	'news_archive_image' => '',
	'news_archive_overlay' => '#ab360b',
	'news_archive_overlay_opacity' => 0.5,
	'news_archive_catchphrase' => '',
	'news_archive_desc' => '',
	'news_archive_catchphrase_font_size' => 40,
	'news_archive_desc_font_size' => 14,
	'news_archive_color' => '#ffffff',
	'news_archive_shadow1' => 0,
	'news_archive_shadow2' => 0,
	'news_archive_shadow3' => 0,
	'news_archive_shadow_color' => '#888888',

	// 記事詳細の設定
	'news_overlay' => '#000000',
	'news_overlay_opacity' => 0.5,
	'news_color' => '#ffffff',
	'news_shadow1' => 0,
	'news_shadow2' => 0,
	'news_shadow3' => 0,
	'news_shadow_color' => '#888888',
	'news_title_font_size' => 40,
	'news_content_font_size' => 14,

	// 表示設定
	'show_date_news' => 1,
	'show_thumbnail_news' => 1,
	'show_next_post_news' => 1,
	'show_sns_top_news' => 1,
	'show_sns_btm_news' => 1,

	// 最近のニュース一覧の設定
	'recent_news_headline' => '',
	'recent_news_link_text' => '',
	'recent_news_num' => 10,

	// 記事詳細の広告設定1
	'news_ad_code1' => '',
	'news_ad_image1' => false,
	'news_ad_url1' => '',
	'news_ad_code2' => '',
	'news_ad_image2' => false,
	'news_ad_url2' => '',

	// 記事詳細の広告設定2
	'news_ad_code3' => '',
	'news_ad_image3' => false,
	'news_ad_url3' => '',
	'news_ad_code4' => '',
	'news_ad_image4' => false,
	'news_ad_url4' => '',

	// スマートフォン専用の広告
	'news_mobile_ad_code1' => '',
	'news_mobile_ad_image1' => false,
	'news_mobile_ad_url1' => '',

	/**
	 * レビュー
	 */
	// アーカイブページヘッダーの設定
	'review_archive_image' => '',
	'review_archive_overlay' => '#00280a',
	'review_archive_overlay_opacity' => 0.5,
	'review_archive_catchphrase' => '',
	'review_archive_desc' => '',
	'review_archive_catchphrase_font_size' => 40,
	'review_archive_desc_font_size' => 14,
	'review_archive_color' => '#ffffff',
	'review_archive_shadow1' => 0,
	'review_archive_shadow2' => 0,
	'review_archive_shadow3' => 0,
	'review_archive_shadow_color' => '#888888',

	// 記事詳細の設定の設定
	'review_title_font_size' => 30,
	'review_content_font_size' => 14,

	/**
	 * ヘッダー
	 */
	// ヘッダーバーの表示位置
	'header_fix' => 'type1',
	
	// ヘッダーバーの表示位置（スマホ）
	'mobile_header_fix' => 'type1',

	// ヘッダーバーの色の設定
	'top_header_bg' => '121e1f',
	'top_header_opacity' => 0.8,
	'top_header_font_color' => '#ffffff',	
	'sub_header_bg' => '121e1f',
	'sub_header_opacity' => 0.8,
	'sub_header_font_color' => '#ffffff',	

	/**
	 * ブログ
	 */
	// ブログコンテンツの設定
	'show_footer_blog_top' => 1,
	'show_footer_blog' => 1,
	'footer_blog_catchphrase' => '',
	'footer_blog_catchphrase_font_size' => 30,
	'footer_blog_num' => 8,
	'footer_blog_post_order' => 'date1',
	'show_footer_blog_date' => 1,
	'show_footer_blog_category' => 1,
	'show_footer_blog_link' => 1,
	'footer_blog_link_text' => '',
	'footer_blog_slide_time' => 300,
	// SNSボタンの設定
	'twitter_url' => '',
	'facebook_url' => '',
	'insta_url' => '',
	'show_rss' => 1,

	// フッターに表示する会社情報
	'footer_company_address' => '',

	// 著作権表示の設定
	'copyright_bg' => '#000000',

	// スマホ用固定フッターバーの設定
	'footer_bar_display' => 'type3',
	'footer_bar_tp' => 0.8,
	'footer_bar_bg' => '#ffffff',
	'footer_bar_border' => '#dddddd',
	'footer_bar_color' => '#000000',
	'footer_bar_btns' => array(
		array(
			'type' => 'type1',
			'label' => '',
			'url' => '',
			'number' => '',
			'target' => 0,
			'icon' => 'file-text'
		)
	),

	/**
	 * 404 ページ
	 */
	'image_404' => '',
	'overlay_404' => '#0B3247',
	'overlay_opacity_404' => 0.6,
	'catchphrase_404' => '',
	'desc_404' => '',
	'catchphrase_font_size_404' => 40,
	'desc_font_size_404' => 14,
	'color_404' => 'FFFFFF',
	'shadow1_404' => 0,
	'shadow2_404' => 0,
	'shadow3_404' => 0,
	'shadow_color_404' => '#888888',

	/**
	 * マーケティング
	 */

	'cta_display' => 4,
	'cta_display_news' => 0,
	'cta_display_review' => 0,

	'footer_cta_display' => 4,
	'footer_cta_hide_on_front' => 0,

);
for ( $i = 1; $i<= 3; $i++ ) {
	$dp_default_options['cta_type' . $i] = 'type1';
	$dp_default_options['cta_type1_catch' . $i] = '';
	$dp_default_options['cta_type1_catch_font_size' . $i] = 30;
	$dp_default_options['cta_type1_desc' . $i] = '';
	$dp_default_options['cta_type1_desc_font_size' . $i] = 14;
	$dp_default_options['cta_type1_btn_label' . $i] = '';
	$dp_default_options['cta_type1_btn_url' . $i] = '';
	$dp_default_options['cta_type1_btn_target' . $i] = 0;
	$dp_default_options['cta_type1_btn_bg' . $i] = '#ff8000';
	$dp_default_options['cta_type1_btn_bg_hover' . $i] = '#444444';
	$dp_default_options['cta_type1_image' . $i] = '';
	$dp_default_options['cta_type1_image_sp' . $i] = '';
	$dp_default_options['cta_type1_overlay' . $i] = '#000000';
	$dp_default_options['cta_type1_overlay_opacity' . $i] = 0.5;
	$dp_default_options['cta_type2_layout' . $i] = 'type1';
	$dp_default_options['cta_type2_catch' . $i] = '';
	$dp_default_options['cta_type2_catch_font_size' . $i] = 21;
	$dp_default_options['cta_type2_desc' . $i] = '';
	$dp_default_options['cta_type2_desc_font_size' . $i] = 14;
	$dp_default_options['cta_type2_btn_label' . $i] = '';
	$dp_default_options['cta_type2_btn_url' . $i] = '';
	$dp_default_options['cta_type2_btn_target' . $i] = 0;
	$dp_default_options['cta_type2_btn_bg' . $i] = '#ff8000';
	$dp_default_options['cta_type2_btn_bg_hover' . $i] = '#444444';
	$dp_default_options['cta_type2_image' . $i] = '';
	$dp_default_options['cta_type2_image_sp' . $i] = '';
	$dp_default_options['cta_editor' . $i] = '';
	$dp_default_options['cta_random' . $i] = 0;

	$dp_default_options['footer_cta_type' . $i] = 'type1';
	$dp_default_options['footer_cta_catch' . $i] = '';
	$dp_default_options['footer_cta_catch_font_color' . $i] = '#ffffff';
	$dp_default_options['footer_cta_desc' . $i] = '';
	$dp_default_options['footer_cta_desc_font_color' . $i] = '#999999';
	$dp_default_options['footer_cta_btn_label' . $i] = '';
	$dp_default_options['footer_cta_btn_url' . $i] = '';
	$dp_default_options['footer_cta_btn_target' . $i] = 0;
	$dp_default_options['footer_cta_btn_bg' . $i] = '#ff8000';
	$dp_default_options['footer_cta_btn_bg_hover' . $i] = '#444444';
	$dp_default_options['footer_cta_bg' . $i] = '#000000';
	$dp_default_options['footer_cta_bg_opacity' . $i] = 1;
	$dp_default_options['footer_cta_editor' . $i] = '';
	$dp_default_options['footer_cta_random' . $i] = 0;
}

/**
 * Design Plus のオプションを返す
 *
 * @global array $dp_default_options
 * @return array 
 */
function get_desing_plus_option() {
	global $dp_default_options;
	return shortcode_atts( $dp_default_options, get_option( 'dp_options', array() ) );
}

// フォントタイプ
global $font_type_options;
$font_type_options = array(
 	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Meiryo', 'tcd-w' )
	),
 	'type2' => array( 
		'value' => 'type2',
		'label' => __( 'YuGothic', 'tcd-w' ) 
	),
 	'type3' => array( 
		'value' => 'type3',
		'label' => __( 'YuMincho', 'tcd-w' ) 
	)
);

// 大見出しのフォントタイプ
global $headline_font_type_options;
$headline_font_type_options = array(
 	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Meiryo', 'tcd-w' )
	),
 	'type2' => array( 
		'value' => 'type2',
		'label' => __( 'YuGothic', 'tcd-w' ) 
	),
 	'type3' => array( 
		'value' => 'type3',
		'label' => __( 'YuMincho', 'tcd-w' ) 
	)
);

// レスポンシブデザインの設定
global $responsive_options;
$responsive_options = array(
	'yes' => array( 
		'value' => 'yes',
		'label' => __( 'Use responsive design', 'tcd-w' )
	),
 	'no' => array( 
		'value' => 'no',
		'label' => __( 'Do not use responsive design', 'tcd-w' )
	)
);

// ローディングアイコンの種類の設定
global $load_icon_options;
$load_icon_options = array(
	'type1' => array( 'value' => 'type1', 'label' => __( 'Circle', 'tcd-w' ) ),
	'type2' => array( 'value' => 'type2', 'label' => __( 'Square', 'tcd-w' ) ),
 	'type3' => array( 'value' => 'type3', 'label' => __( 'Dot', 'tcd-w' ) )
);

// ロード画面の設定
global $load_time_options;
for ( $i = 3; $i <= 10; $i++) {
	$load_time_options[$i] = array( 'value' => $i * 1000, 'label' => $i );
}

// ホバーエフェクトの設定
global $hover_type_options;
$hover_type_options = array(
	'type1' => array( 
		'value' => 'type1',
		'label' => __( 'Zoom', 'tcd-w' ) 
	),
 	'type2' => array( 
		'value' => 'type2',
		'label' => __( 'Slide', 'tcd-w' )
	),
 	'type3' => array( 
		'value' => 'type3',
		'label' => __( 'Fade', 'tcd-w' )
	)
);
global $hover2_direct_options;
$hover2_direct_options = array(
	'type1' => array( 
		'value' => 'type1',
		'label' => __( 'Left to Right', 'tcd-w' )
	),
 	'type2' => array( 
		'value' => 'type2',
		'label' => __( 'Right to Left', 'tcd-w' )
	)
);

// ショーケースのタイプ
global $cb_showcase_type_options;
$cb_showcase_type_options = array(
	'type1' => array( 
		'value' => 'type1', 
		'label' => __( 'Type1', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/showcase1.jpg'
	),
	'type2' => array( 
		'value' => 'type2', 
		'label' => __( 'Type2', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/showcase2.jpg'
	),
	'type3' => array( 
		'value' => 'type3', 
		'label' => __( 'Type3', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/showcase3.jpg'
	),
);

// ヘッダーコンテンツの設定
global $header_content_type_options;
$header_content_type_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Image slider', 'tcd-w' ) 
	),
 	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Video background', 'tcd-w' )
	),
 	'type3' => array(
		'value' => 'type3',
		'label' => __( 'Youtube background', 'tcd-w' )
	)
);

// ヘッダースライダーのアニメーション設定
global $slider_type_options;
$slider_type_options = array(
 	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Fade in', 'tcd-w' )
	),
 	'type2' => array( 
		'value' => 'type2',
		'label' => __( 'Slide1', 'tcd-w' ) 
	),
 	'type3' => array( 
		'value' => 'type3',
		'label' => __( 'Slide2', 'tcd-w' ) 
	)
);

// ヘッダーバーの表示位置
global $header_fix_options;
$header_fix_options = array(
	'type1' => array(
		'value' => 'type1',
		'label' => __( 'Normal header', 'tcd-w' ) 
	),
 	'type2' => array(
		'value' => 'type2',
		'label' => __( 'Fix at top after page scroll', 'tcd-w' )
	),
);

// フッターブログコンテンツの数
global $footer_blo_num_options;
for ( $i = 1; $i <= 3; $i++ ) {
	$footer_blog_num_options[$i * 4] = array( 'value' => $i * 4, 'label' => $i * 4 );
}

// フッターブログコンテンツ表示順
global $footer_blog_post_order_options;
$footer_blog_post_order_options = array(
	'date1' => array(
		'value' => 'date1',
		'label' => __( 'Date (DESC)', 'tcd-w' )
	),
 	'date2' => array(
		'value' => 'date2',
		'label' => __( 'Date (ASC)', 'tcd-w' )
	),
 	'rand' => array(
		'value' => 'rand',
		'label' => __( 'Random', 'tcd-w' )
	)
);

// フッターブログコンテンツスライダーが切り替わるスピード
global $footer_blog_slide_time_options;
for ( $i = 3; $i <= 10; $i++) {
	$footer_blog_slide_time_options[$i * 100] = array( 'value' => $i * 100, 'label' => $i * 100 );
}

// 記事上ボタンタイプ
global $sns_type_top_options;
$sns_type_top_options = array(
	'type1' => array( 
		'value' => 'type1', 
		'label' => __( 'style1', 'tcd-w' )
	),
	'type2' => array( 
		'value' => 'type2', 
		'label' => __( 'style2', 'tcd-w' )
	),
	'type3' => array( 
		'value' => 'type3', 
		'label' => __( 'style3', 'tcd-w' )
	),
	'type4' => array( 
		'value' => 'type4', 
		'label' => __( 'style4', 'tcd-w' )
	),
	'type5' => array( 
		'value' => 'type5', 
		'label' => __( 'style5', 'tcd-w' )
	)
);

// 記事下ボタンタイプ
global $sns_type_btm_options;
$sns_type_btm_options = $sns_type_top_options;

// フッターの固定メニュー 表示タイプ
global $footer_bar_display_options;
$footer_bar_display_options = array(
	'type1' => array( 'value' => 'type1', 'label' => __( 'Fade In', 'tcd-w' ) ),
	'type2' => array( 'value' => 'type2', 'label' => __( 'Slide In', 'tcd-w' ) ),
	'type3' => array( 'value' => 'type3', 'label' => __( 'Hide', 'tcd-w' ) )
);

// フッターバーボタンのタイプ
global $footer_bar_button_options;
$footer_bar_button_options = array(
	'type1' => array( 'value' => 'type1', 'label' => __( 'Default', 'tcd-w' ) ),
 	'type2' => array( 'value' => 'type2', 'label' => __( 'Share', 'tcd-w' ) ),
 	'type3' => array( 'value' => 'type3', 'label' => __( 'Telephone', 'tcd-w' ) )
);

// フッターバーボタンのアイコン
global $footer_bar_icon_options;
$footer_bar_icon_options = array(
	'file-text' => array( 
		'value' => 'file-text', 
		'label' => __( 'Document', 'tcd-w' )
	),
	'share-alt' => array( 
		'value' => 'share-alt', 
		'label' => __( 'Share', 'tcd-w' )
	),
	'phone' => array( 
		'value' => 'phone', 
		'label' => __( 'Telephone', 'tcd-w' )
	),
	'envelope' => array( 
		'value' => 'envelope', 
		'label' => __( 'Envelope', 'tcd-w' )
	),
	'tag' => array( 
		'value' => 'tag', 
		'label' => __( 'Tag', 'tcd-w' )
	),
	'pencil' => array( 
		'value' => 'pencil', 
		'label' => __( 'Pencil', 'tcd-w' )
	)
);

// 記事下CTAのタイプ
global $cta_type_options;
$cta_type_options = array(
	'type1' => array( 
		'value' => 'type1', 
		'label' => __( 'Type1', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/cta1.jpg'
	),
	'type2' => array( 
		'value' => 'type2', 
		'label' => __( 'Type2', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/cta2.jpg'
	),
	'type3' => array( 
		'value' => 'type3', 
		'label' => __( 'Wysiwyg editor', 'tcd-w' ),
		'image' => get_template_directory_uri() . '/admin/img/cta3.jpg'
	),
);

// 記事下CTAタイプ2のレイアウト
global $cta_type2_layout_options;
$cta_type2_layout_options = array(
	'type1' => array( 
		'value' => 'type1', 
		'label' => __( 'Type1 (left: text, right: image)', 'tcd-w' ),
	),
	'type2' => array( 
		'value' => 'type2', 
		'label' => __( 'Type2 (left: image, right: text)', 'tcd-w' ),
	)
);

// 表示するCTAのセレクトボックス（記事下・フッター兼用）
global $cta_display_options;
$cta_display_options = array(
	1 => array( 
		'value' => 1, 
		'label' => 'CTA-A'
	),
	2 => array( 
		'value' => 2, 
		'label' => 'CTA-B'
	),
	3 => array( 
		'value' => 3, 
		'label' => 'CTA-C'
	),
	4 => array(
		'value' => 4,
		'label' => __( 'Random display', 'tcd-w' )
	),
	5 => array(
		'value' => 5,
		'label' => __( 'Hidden', 'tcd-w' )
	)
);

global $footer_cta_type_options;
$footer_cta_type_options = array(
	'type1' => array( 
		'value' => 'type1', 
		'label' => __( 'Template', 'tcd-w' ),
	),
	'type2' => array( 
		'value' => 'type2', 
		'label' => __( 'Wysiwyg editor', 'tcd-w' ),
	)
);

// テーマオプション画面の作成
function theme_options_do_page() {

	global $dp_upload_error;
	$options = get_desing_plus_option(); 

	$tab_labels = array(
		__( 'Basic', 'tcd-w' ), // 基本設定
		__( 'Logo', 'tcd-w' ), // ロゴの設定
		__( 'Index', 'tcd-w' ), // トップページ
		__( 'Blog', 'tcd-w' ), // ブログ
		__( 'News', 'tcd-w' ), // ニュース
		__( 'Review', 'tcd-w' ), // レビュー
		__( 'Header', 'tcd-w' ), // ヘッダー
		__( 'Footer', 'tcd-w' ),  // フッター
		__( '404 page', 'tcd-w' ),  // 404 ページ
		__( 'Marketing', 'tcd-w' ),  // マーケティング
	);

	if ( ! isset( $_REQUEST['settings-updated'] ) ) {
		$_REQUEST['settings-updated'] = false;
	}
?>
<div class="wrap">
	<h2><?php _e( 'TCD Theme Options', 'tcd-w' ); ?></h2> 
<?php
// 更新時のメッセージ
if ( false !== $_REQUEST['settings-updated'] ) :
?>
	<div class="updated fade">
		<p><strong><?php _e( 'Updated', 'tcd-w' ); ?></strong></p>
	</div>
<?php 
endif; 

	// ファイルアップロード時のメッセージ
	if ( ! empty( $dp_upload_error['message'] ) ):
  	if ( $dp_upload_error['error'] ) :
?>
	<div id="error" class="error">
		<p><?php echo esc_html( $dp_upload_error['message'] ); ?></p>
	</div>
<?php 
		else : 
?>
	<div id="message" class="updated fade">
		<p><?php echo esc_html( $dp_upload_error['message'] ); ?></p>
	</div>
<?php 
		endif; 
	endif;
?>
	<div id="my_theme_option" class="cf">
		<div id="my_theme_left">
   		<ul id="theme_tab" class="cf">
				<?php for ( $i = 0; $i < count( $tab_labels ); $i++ ) : ?>
    		<li><a href="#tab-content<?php echo esc_attr( $i + 1 ); ?>"><?php echo esc_html( $tab_labels[$i] ); ?></a></li>
				<?php endfor; ?>
   		</ul>
  	</div>
  	<div id="my_theme_right">
			<form method="post" action="options.php" enctype="multipart/form-data">
				<?php settings_fields( 'design_plus_options' ); ?>
				<div id="tab-panel">
					<?php get_template_part( 'admin/inc/basic' ); // 基本設定 ?>
					<?php get_template_part( 'admin/inc/logo' ); // ロゴの設定 ?>
					<?php get_template_part( 'admin/inc/top' ); // トップページ ?>
					<?php get_template_part( 'admin/inc/blog' ); // ブログ ?>
					<?php get_template_part( 'admin/inc/news' ); // ニュース ?>
					<?php get_template_part( 'admin/inc/review' ); // レビュー ?>
					<?php get_template_part( 'admin/inc/header' ); // ヘッダー ?>
					<?php get_template_part( 'admin/inc/footer' ); // フッター ?>
					<?php get_template_part( 'admin/inc/404' ); // 404ページ ?>
					<?php get_template_part( 'admin/inc/marketing' ); // マーケティング ?>
				</div><!-- END #tab-panel -->
			</form>
		</div><!-- END #my_theme_right -->
	</div><!-- END #my_theme_option -->
</div><!-- END #wrap -->
<?php
}

/**
 * チェック
 */
function theme_options_validate( $input ) {
	global $font_type_options, $headline_font_type_options, $responsive_options, $load_icon_options, $load_time_options, $hover_type_options, $hover2_direct_options, $sns_type_top_options, $sns_type_btm_options, $header_content_type_options, $slider_type_options, $cb_showcase_type_options, $header_fix_options, $footer_blog_num_options, $footer_blog_post_order_options, $footer_blog_slide_time_options, $footer_bar_display_options, $footer_bar_icon_options, $footer_bar_button_options, $cta_type_options, $cta_type2_layout_options, $cta_display_options, $footer_cta_type_options;

	// 色の設定
 	$input['primary_color'] = wp_filter_nohtml_kses( $input['primary_color'] );
 	$input['secondary_color'] = wp_filter_nohtml_kses( $input['secondary_color'] );
 	$input['tertiary_color'] = wp_filter_nohtml_kses( $input['tertiary_color'] );

	// ファビコン
 	$input['favicon'] = wp_filter_nohtml_kses( $input['favicon'] );

	// フォントの種類
 	if ( ! isset( $input['font_type'] ) ) $input['font_type'] = null;
 	if ( ! array_key_exists( $input['font_type'], $font_type_options ) ) $input['font_type'] = null;

	// 大見出しのフォントタイプ
 	if ( ! isset( $input['headline_font_type'] ) ) $input['headline_font_type'] = null;
 	if ( ! array_key_exists( $input['headline_font_type'], $headline_font_type_options ) ) $input['headline_font_type'] = null;

 	// 絵文字の設定
 	if ( ! isset( $input['use_emoji'] ) ) $input['use_emoji'] = null;
  	$input['use_emoji'] = ( $input['use_emoji'] == 1 ? 1 : 0 );

 	// レスポンシブの設定
 	if ( ! isset( $input['responsive'] ) ) $input['responsive'] = null;
 	if ( ! array_key_exists( $input['responsive'], $responsive_options ) ) $input['responsive'] = null;

 	// ロード画面の設定
	$load_time_flag = false;
 	if ( ! isset( $input['use_load_icon'] ) ) $input['use_load_icon'] = null;
  $input['use_load_icon'] = ( $input['use_load_icon'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['load_icon'] ) ) $input['load_icon'] = null;
 	if ( ! array_key_exists( $input['load_icon'], $load_icon_options ) ) $input['load_icon'] = null;
 	if ( ! isset( $input['load_time'] ) ) $input['load_time'] = null;
	foreach ( $load_time_options as $load_time_option ) {
		if ( $input['load_time'] === $load_time_option['value'] ) {
			$load_time_flag = true;
		}
	}
	if ( ! $load_time_flag ) $input['load_time'] = null;

	// ホバーエフェクトの設定
	$hover_type_flag = false;
 	if ( ! isset( $input['hover_type'] ) ) $input['hover_type'] = null;
	foreach ( $hover_type_options as $hover_type_option ) {
		if ( $input['hover_type'] === $hover_type_option['value'] ) {
			$hover_type_flag = true;
		}
	}
	if ( ! $hover_type_flag ) $input['hover_type'] = false;
 	$input['hover1_zoom'] = wp_filter_nohtml_kses( $input['hover1_zoom'] );
 	if ( ! isset( $input['hover1_rotate'] ) ) $input['hover1_rotate'] = null;
  $input['hover1_rotate'] = ( $input['hover1_rotate'] == 1 ? 1 : 0 );
 	$input['hover1_zoom'] = wp_filter_nohtml_kses( $input['hover1_zoom'] );
 	if ( ! isset( $input['hover2_direct'] ) ) $input['hover2_direct'] = null;
 	if ( ! array_key_exists( $input['hover2_direct'], $hover2_direct_options ) ) $input['hover2_direct'] = null;
 	$input['hover2_opacity'] = wp_filter_nohtml_kses( $input['hover2_opacity'] );
 	$input['hover3_opacity'] = wp_filter_nohtml_kses( $input['hover3_opacity'] );
 	$input['hover3_bgcolor'] = wp_filter_nohtml_kses( $input['hover3_bgcolor'] );
	
	// Facebook OGPの設定
 	if ( ! isset( $input['use_ogp'] ) ) $input['use_ogp'] = null;
  $input['use_ogp'] = ( $input['use_ogp'] == 1 ? 1 : 0 );
 	$input['fb_admin_id'] = wp_filter_nohtml_kses( $input['fb_admin_id'] );
	$input['ogp_image'] = wp_filter_nohtml_kses( $input['ogp_image'] );

	// Twitter Cardsの設定
	if ( ! isset( $input['use_twitter_card'] ) ) $input['use_twitter_card'] = null;
  $input['use_twitter_card'] = ( $input['use_twitter_card'] == 1 ? 1 : 0 );
 	$input['twitter_account_name'] = wp_filter_nohtml_kses( $input['twitter_account_name'] );

 	// ソーシャルボタンの表示設定
 	if ( ! isset( $input['sns_type_top'] ) ) $input['sns_type_top'] = null;
 	if ( ! array_key_exists( $input['sns_type_top'], $sns_type_top_options ) ) $input['sns_type_top'] = null;
 	if ( ! isset( $input['show_sns_top'] ) ) $input['show_sns_top'] = null;
  $input['show_sns_top'] = ( $input['show_sns_top'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_twitter_top'] ) ) $input['show_twitter_top'] = null;
  $input['show_twitter_top'] = ( $input['show_twitter_top'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_fblike_top'] ) ) $input['show_fblike_top'] = null;
  $input['show_fblike_top'] = ( $input['show_fblike_top'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_fbshare_top'] ) ) $input['show_fbshare_top'] = null;
  $input['show_fbshare_top'] = ( $input['show_fbshare_top'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_google_top'] ) ) $input['show_google_top'] = null;
  $input['show_google_top'] = ( $input['show_google_top'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_hatena_top'] ) ) $input['show_hatena_top'] = null;
  $input['show_hatena_top'] = ( $input['show_hatena_top'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_pocket_top'] ) ) $input['show_pocket_top'] = null;
  $input['show_pocket_top'] = ( $input['show_pocket_top'] == 1 ? 1 : 0 );
	if ( ! isset( $input['show_feedly_top'] ) ) $input['show_feedly_top'] = null;
  $input['show_feedly_top'] = ( $input['show_feedly_top'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_rss_top'] ) ) $input['show_rss_top'] = null;
  $input['show_rss_top'] = ( $input['show_rss_top'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_pinterest_top'] ) ) $input['show_pinterest_top'] = null;
  $input['show_pinterest_top'] = ( $input['show_pinterest_top'] == 1 ? 1 : 0 );

 	if ( ! isset( $input['sns_type_btm'] ) ) $input['sns_type_btm'] = null;
 	if ( ! array_key_exists( $input['sns_type_btm'], $sns_type_btm_options ) ) $input['sns_type_btm'] = null;
 	if ( ! isset( $input['show_sns_btm'] ) ) $input['show_sns_btm'] = null;
  $input['show_sns_btm'] = ( $input['show_sns_btm'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_twitter_btm'] ) ) $input['show_twitter_btm'] = null;
  $input['show_twitter_btm'] = ( $input['show_twitter_btm'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_fblike_btm'] ) ) $input['show_fblike_btm'] = null;
  $input['show_fblike_btm'] = ( $input['show_fblike_btm'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_fbshare_btm'] ) ) $input['show_fbshare_btm'] = null;
  $input['show_fbshare_btm'] = ( $input['show_fbshare_btm'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_google_btm'] ) ) $input['show_google_btm'] = null;
  $input['show_google_btm'] = ( $input['show_google_btm'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_hatena_btm'] ) ) $input['show_hatena_btm'] = null;
  $input['show_hatena_btm'] = ( $input['show_hatena_btm'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_pocket_btm'] ) ) $input['show_pocket_btm'] = null;
  $input['show_pocket_btm'] = ( $input['show_pocket_btm'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_feedly_btm'] ) ) $input['show_feedly_btm'] = null;
  $input['show_feedly_btm'] = ( $input['show_feedly_btm'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_rss_btm'] ) ) $input['show_rss_btm'] = null;
  $input['show_rss_btm'] = ( $input['show_rss_btm'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_pinterest_btm'] ) ) $input['show_pinterest_btm'] = null;
  $input['show_pinterest_btm'] = ( $input['show_pinterest_btm'] == 1 ? 1 : 0 );

 	// オリジナルスタイルの設定
 	$input['css_code'] = $input['css_code'];

 	// ヘッダーのロゴ
 	$input['logo_font_size'] = wp_filter_nohtml_kses( $input['logo_font_size'] );
 	$input['header_logo_image'] = wp_filter_nohtml_kses( $input['header_logo_image'] );
 	if ( ! isset( $input['header_logo_image_retina'] ) ) $input['header_logo_image_retina'] = null;
  $input['header_logo_image_retina'] = ( $input['header_logo_image_retina'] == 1 ? 1 : 0 );

	// ヘッダーのロゴ（スマホ用）
 	$input['logo_font_size_mobile'] = wp_filter_nohtml_kses( $input['logo_font_size_mobile'] );
 	$input['header_logo_image_mobile'] = wp_filter_nohtml_kses( $input['header_logo_image_mobile'] );
 	if ( ! isset( $input['header_logo_image_mobile_retina'] ) ) $input['header_logo_image_mobile_retina'] = null;
  $input['header_logo_image_mobile_retina'] = ( $input['header_logo_image_mobile_retina'] == 1 ? 1 : 0 );

	// フッターのロゴ
 	$input['logo_font_size_footer'] = wp_filter_nohtml_kses( $input['logo_font_size_footer'] );
 	$input['footer_logo_image'] = wp_filter_nohtml_kses( $input['footer_logo_image'] );

	/**
	 * トップページ
	 */
	// ヘッダーコンテンツの設定
 	if ( ! isset( $input['header_content_type'] ) ) $input['header_content_type'] = null;
 	if ( ! array_key_exists( $input['header_content_type'], $header_content_type_options ) ) $input['header_content_type'] = null;
	for ( $i = 1; $i <= 3; $i++ ) {
 		if ( ! isset( $input['slider_type' . $i] ) ) $input['slider_type' . $i] = null;
 		if ( ! array_key_exists( $input['slider_type' . $i], $slider_type_options ) ) $input['slider_type' . $i] = null;
		$input['slider_headline_font_size' . $i] = wp_filter_nohtml_kses( $input['slider_headline_font_size' . $i] );
		$input['slider_desc' . $i] = wp_filter_nohtml_kses( $input['slider_desc' . $i] );
		$input['slider_desc_font_size' . $i] = wp_filter_nohtml_kses( $input['slider_desc_font_size' . $i] );
		$input['slider_font_color' . $i] = wp_filter_nohtml_kses( $input['slider_font_color' . $i] );
		$input['slider' . $i . '_shadow1'] = wp_filter_nohtml_kses( $input['slider' . $i . '_shadow1'] );
		$input['slider' . $i . '_shadow2'] = wp_filter_nohtml_kses( $input['slider' . $i . '_shadow2'] );
		$input['slider' . $i . '_shadow3'] = wp_filter_nohtml_kses( $input['slider' . $i . '_shadow3'] );
		$input['slider' . $i . '_shadow_color'] = wp_filter_nohtml_kses( $input['slider' . $i . '_shadow_color'] );
		if ( ! isset( $input['display_slider_button' . $i] ) ) $input['display_slider_button' . $i] = null;
  	$input['display_slider_button' . $i] = ( $input['display_slider_button' . $i] == 1 ? 1 : 0 );
		$input['slider_button_label' . $i] = wp_filter_nohtml_kses( $input['slider_button_label' . $i] );
		$input['slider_url' . $i] = wp_filter_nohtml_kses( $input['slider_url' . $i] );
		if ( ! isset( $input['slider_target' . $i] ) ) $input['slider_target' . $i] = null;
  	$input['slider_target' . $i] = ( $input['slider_target' . $i] == 1 ? 1 : 0 );
		$input['slider_btn_color' . $i] = wp_filter_nohtml_kses( $input['slider_btn_color' . $i] );
		$input['slider_btn_bg' . $i] = wp_filter_nohtml_kses( $input['slider_btn_bg' . $i] );
		$input['slider_btn_color_hover' . $i] = wp_filter_nohtml_kses( $input['slider_btn_color_hover' . $i] );
		$input['slider_btn_bg_hover' . $i] = wp_filter_nohtml_kses( $input['slider_btn_bg_hover' . $i] );
		$input['slider_image' . $i] = wp_filter_nohtml_kses( $input['slider_image' . $i] );
		$input['slider_bg_image' . $i] = wp_filter_nohtml_kses( $input['slider_bg_image' . $i] );
	}
	$input['video'] = wp_filter_nohtml_kses( $input['video'] );
 	$input['video_image'] = wp_filter_nohtml_kses( $input['video_image'] );
 	$input['youtube_url'] = wp_filter_nohtml_kses( $input['youtube_url'] );
 	$input['youtube_image'] = wp_filter_nohtml_kses( $input['youtube_image'] );

	// トップページの動画用キャッチフレーズ
	if ( ! isset( $input['use_video_catch'] ) )
		$input['use_video_catch'] = null;
		$input['use_video_catch'] = ( $input['use_video_catch'] == 1 ? 1 : 0 );
	$input['video_catch'] = wp_filter_nohtml_kses( $input['video_catch'] );
	$input['video_catch_font_size'] = wp_filter_nohtml_kses( $input['video_catch_font_size'] );
	$input['video_desc'] = wp_filter_nohtml_kses( $input['video_desc'] );
	$input['video_desc_font_size'] = wp_filter_nohtml_kses( $input['video_desc_font_size'] );
	$input['video_catch_color'] = wp_filter_nohtml_kses( $input['video_catch_color'] );
	$input['video_catch_shadow1'] = wp_filter_nohtml_kses( $input['video_catch_shadow1'] );
	$input['video_catch_shadow2'] = wp_filter_nohtml_kses( $input['video_catch_shadow2'] );
	$input['video_catch_shadow3'] = wp_filter_nohtml_kses( $input['video_catch_shadow3'] );
	$input['video_catch_shadow_color'] = wp_filter_nohtml_kses( $input['video_catch_shadow_color'] );
	if ( ! isset( $input['show_video_catch_button'] ) )
		$input['show_video_catch_button'] = null;
		$input['show_video_catch_button'] = ( $input['show_video_catch_button'] == 1 ? 1 : 0 );
	$input['video_catch_button'] = wp_filter_nohtml_kses( $input['video_catch_button'] );
	$input['video_button_color'] = wp_filter_nohtml_kses( $input['video_button_color'] );
	$input['video_button_color_hover'] = wp_filter_nohtml_kses( $input['video_button_color_hover'] );
	$input['video_button_bg_color'] = wp_filter_nohtml_kses( $input['video_button_bg_color'] );
	$input['video_button_bg_color_hover'] = wp_filter_nohtml_kses( $input['video_button_bg_color_hover'] );
	$input['video_button_url'] = wp_filter_nohtml_kses( $input['video_button_url'] );
	if ( ! isset( $input['video_button_target'] ) )
		$input['video_button_target'] = null;
		$input['video_button_target'] = ( $input['video_button_target'] == 1 ? 1 : 0 );

	if ( isset( $_FILES['video_file'] ) ) {
	// 画像のアップロードに問題はないか
		if ( $_FILES['video_file']['error'] === 0 ) {
			$name = sanitize_file_name( $_FILES['video_file']['name'] );
			 // ファイル形式をチェック
			 if ( ! preg_match( '/\.(png|jpe?g|gif|mp4)$/i', $name ) ) {
				add_settings_error( 'design_plus_options', 'dp_uploader', sprintf( __( 'You uploaded %s but allowed file format is PNG, GIF, JPG and MP4.', 'tcd-w' ), $name ), 'error' );
			 } else {
				//ディレクトリの存在をチェック
				if ( ( ( file_exists ( dp_logo_basedir() ) && is_dir( dp_logo_basedir() ) && is_writable( dp_logo_basedir() ) ) || @mkdir( dp_logo_basedir() )
					) && move_uploaded_file( $_FILES['video_file']['tmp_name'], dp_logo_basedir() . DIRECTORY_SEPARATOR . $name ) ) {
					$input['video'] = dp_logo_baseurl() . '/' . $name;
				} else {
					add_settings_error( 'default', 'dp_uploader', sprintf( __( 'Directory %s is not writable. Please check permission.', 'tcd-w' ), dp_logo_basedir() ), 'error' );
				}
			 }
		 } elseif ( $_FILES['video_file']['error'] !== UPLOAD_ERR_NO_FILE ) {
			add_settings_error( 'default', 'dp_uploader', _dp_get_upload_err_msg( $_FILES['video_file']['error'] ), 'error' );
		 }
	}

	// ニュースティッカー
 	if ( ! isset( $input['display_news_ticker'] ) ) $input['display_news_ticker'] = null;
  $input['display_news_ticker'] = ( $input['display_news_ticker'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['display_news_ticker_date'] ) ) $input['display_news_ticker_date'] = null;
  $input['display_news_ticker_date'] = ( $input['display_news_ticker_date'] == 1 ? 1 : 0 );
 	$input['news_ticker_num'] = wp_filter_nohtml_kses( $input['news_ticker_num'] );
 	if ( ! isset( $input['display_news_ticker_link'] ) ) $input['display_news_ticker_link'] = null;
  $input['display_news_ticker_link'] = ( $input['display_news_ticker_link'] == 1 ? 1 : 0 );
 	$input['news_ticker_link_text'] = wp_filter_nohtml_kses( $input['news_ticker_link_text'] );

	/**
	 * ブログ
	 */
 	// アーカイブページヘッダーの設定
 	$input['archive_image'] = wp_filter_nohtml_kses( $input['archive_image'] );
 	$input['archive_overlay'] = wp_filter_nohtml_kses( $input['archive_overlay'] );
 	$input['archive_overlay_opacity'] = wp_filter_nohtml_kses( $input['archive_overlay_opacity'] );
 	$input['archive_catchphrase'] = wp_filter_nohtml_kses( $input['archive_catchphrase'] );
 	$input['archive_desc'] = wp_filter_nohtml_kses( $input['archive_desc'] );
 	$input['archive_catchphrase_font_size'] = wp_filter_nohtml_kses( $input['archive_catchphrase_font_size'] );
 	$input['archive_desc_font_size'] = wp_filter_nohtml_kses( $input['archive_desc_font_size'] );
 	$input['archive_color'] = wp_filter_nohtml_kses( $input['archive_color'] );
 	$input['archive_shadow1'] = wp_filter_nohtml_kses( $input['archive_shadow1'] );
 	$input['archive_shadow2'] = wp_filter_nohtml_kses( $input['archive_shadow2'] );
 	$input['archive_shadow3'] = wp_filter_nohtml_kses( $input['archive_shadow3'] );
 	$input['archive_shadow_color'] = wp_filter_nohtml_kses( $input['archive_shadow_color'] );

	// 記事ページの設定
 	$input['blog_overlay'] = wp_filter_nohtml_kses( $input['blog_overlay'] );
 	$input['blog_overlay_opacity'] = wp_filter_nohtml_kses( $input['blog_overlay_opacity'] );
 	$input['blog_color'] = wp_filter_nohtml_kses( $input['blog_color'] );
 	$input['blog_shadow1'] = wp_filter_nohtml_kses( $input['blog_shadow1'] );
 	$input['blog_shadow2'] = wp_filter_nohtml_kses( $input['blog_shadow2'] );
 	$input['blog_shadow3'] = wp_filter_nohtml_kses( $input['blog_shadow3'] );
 	$input['blog_shadow_color'] = wp_filter_nohtml_kses( $input['blog_shadow_color'] );
 	$input['title_font_size'] = wp_filter_nohtml_kses( $input['title_font_size'] );
 	$input['content_font_size'] = wp_filter_nohtml_kses( $input['content_font_size'] );
 	$input['content_link_color'] = wp_filter_nohtml_kses( $input['content_link_color'] );

 	// 表示設定
 	if ( ! isset( $input['show_date'] ) ) $input['show_date'] = null;
  $input['show_date'] = ( $input['show_date'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_category'] ) ) $input['show_category'] = null;
  $input['show_category'] = ( $input['show_category'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_tag'] ) ) $input['show_tag'] = null;
  $input['show_tag'] = ( $input['show_tag'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_author'] ) ) $input['show_author'] = null;
  $input['show_author'] = ( $input['show_author'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_thumbnail'] ) ) $input['show_thumbnail'] = null;
  $input['show_thumbnail'] = ( $input['show_thumbnail'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_next_post'] ) ) $input['show_next_post'] = null;
  $input['show_next_post'] = ( $input['show_next_post'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_related_post'] ) ) $input['show_related_post'] = null;
  $input['show_related_post'] = ( $input['show_related_post'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_comment'] ) ) $input['show_comment'] = null;
  $input['show_comment'] = ( $input['show_comment'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_trackback'] ) ) $input['show_trackback'] = null;
  $input['show_trackback'] = ( $input['show_trackback'] == 1 ? 1 : 0 );

	// 記事ページの広告設定1, 2
	for ( $i = 1; $i <= 4; $i++ ) {
 		$input['single_ad_code' . $i] = $input['single_ad_code' . $i];
 		$input['single_ad_image' . $i] = wp_filter_nohtml_kses( $input['single_ad_image' . $i] );
 		$input['single_ad_url' . $i] = wp_filter_nohtml_kses( $input['single_ad_url' . $i] );
	}
	// スマートフォン専用の広告
	$input['single_mobile_ad_code1'] = $input['single_mobile_ad_code1'];
 	$input['single_mobile_ad_image1'] = wp_filter_nohtml_kses( $input['single_mobile_ad_image1'] );
 	$input['single_mobile_ad_url1'] = wp_filter_nohtml_kses( $input['single_mobile_ad_url1'] );

 	// ニュースアーカイブページヘッダーの設定
 	$input['news_archive_image'] = wp_filter_nohtml_kses( $input['news_archive_image'] );
 	$input['news_archive_overlay'] = wp_filter_nohtml_kses( $input['news_archive_overlay'] );
 	$input['news_archive_overlay_opacity'] = wp_filter_nohtml_kses( $input['news_archive_overlay_opacity'] );
 	$input['news_archive_catchphrase'] = wp_filter_nohtml_kses( $input['news_archive_catchphrase'] );
 	$input['news_archive_desc'] = wp_filter_nohtml_kses( $input['news_archive_desc'] );
 	$input['news_archive_catchphrase_font_size'] = wp_filter_nohtml_kses( $input['news_archive_catchphrase_font_size'] );
 	$input['news_archive_desc_font_size'] = wp_filter_nohtml_kses( $input['news_archive_desc_font_size'] );
 	$input['news_archive_color'] = wp_filter_nohtml_kses( $input['news_archive_color'] );
 	$input['news_archive_shadow1'] = wp_filter_nohtml_kses( $input['news_archive_shadow1'] );
 	$input['news_archive_shadow2'] = wp_filter_nohtml_kses( $input['news_archive_shadow2'] );
 	$input['news_archive_shadow3'] = wp_filter_nohtml_kses( $input['news_archive_shadow3'] );
 	$input['news_archive_shadow_color'] = wp_filter_nohtml_kses( $input['news_archive_shadow_color'] );

	// ニュース記事ページの設定
 	$input['news_overlay'] = wp_filter_nohtml_kses( $input['news_overlay'] );
 	$input['news_overlay_opacity'] = wp_filter_nohtml_kses( $input['news_overlay_opacity'] );
 	$input['news_color'] = wp_filter_nohtml_kses( $input['news_color'] );
 	$input['news_shadow1'] = wp_filter_nohtml_kses( $input['news_shadow1'] );
 	$input['news_shadow2'] = wp_filter_nohtml_kses( $input['news_shadow2'] );
 	$input['news_shadow3'] = wp_filter_nohtml_kses( $input['news_shadow3'] );
 	$input['news_shadow_color'] = wp_filter_nohtml_kses( $input['news_shadow_color'] );
 	$input['news_title_font_size'] = wp_filter_nohtml_kses( $input['news_title_font_size'] );
 	$input['news_content_font_size'] = wp_filter_nohtml_kses( $input['news_content_font_size'] );

	// ニュース表示設定
 	if ( ! isset( $input['show_date_news'] ) ) $input['show_date_news'] = null;
 	$input['show_date_news'] = ( $input['show_date_news'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_thumbnail_news'] ) ) $input['show_thumbnail_news'] = null;
 	$input['show_thumbnail_news'] = ( $input['show_thumbnail_news'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_sns_top_news'] ) ) $input['show_sns_top_news'] = null;
  $input['show_sns_top_news'] = ( $input['show_sns_top_news'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_sns_btm_news'] ) ) $input['show_sns_btm_news'] = null;
  $input['show_sns_btm_news'] = ( $input['show_sns_btm_news'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_next_post_news'] ) ) $input['show_next_post_news'] = null;
  $input['show_next_post_news'] = ( $input['show_next_post_news'] == 1 ? 1 : 0 );

	// ニュース最近のニュース一覧の設定
 	$input['recent_news_headline'] = wp_filter_nohtml_kses( $input['recent_news_headline'] );
 	$input['recent_news_link_text'] = wp_filter_nohtml_kses( $input['recent_news_link_text'] );
 	$input['recent_news_num'] = wp_filter_nohtml_kses( $input['recent_news_num'] );

	// 記事ページの広告設定1, 2
	for ( $i = 1; $i <= 4; $i++ ) {
 		$input['news_ad_code' . $i] = $input['news_ad_code' . $i];
 		$input['news_ad_image' . $i] = wp_filter_nohtml_kses( $input['news_ad_image' . $i] );
 		$input['news_ad_url' . $i] = wp_filter_nohtml_kses( $input['news_ad_url' . $i] );
	}
	// スマートフォン専用の広告
	$input['news_mobile_ad_code1'] = $input['news_mobile_ad_code1'];
 	$input['news_mobile_ad_image1'] = wp_filter_nohtml_kses( $input['news_mobile_ad_image1'] );
 	$input['news_mobile_ad_url1'] = wp_filter_nohtml_kses( $input['news_mobile_ad_url1'] );

 	// レビューアーカイブページヘッダーの設定
 	$input['review_archive_image'] = wp_filter_nohtml_kses( $input['review_archive_image'] );
 	$input['review_archive_overlay'] = wp_filter_nohtml_kses( $input['review_archive_overlay'] );
 	$input['review_archive_overlay_opacity'] = wp_filter_nohtml_kses( $input['review_archive_overlay_opacity'] );
 	$input['review_archive_catchphrase'] = wp_filter_nohtml_kses( $input['review_archive_catchphrase'] );
 	$input['review_archive_desc'] = wp_filter_nohtml_kses( $input['review_archive_desc'] );
 	$input['review_archive_catchphrase_font_size'] = wp_filter_nohtml_kses( $input['review_archive_catchphrase_font_size'] );
 	$input['review_archive_desc_font_size'] = wp_filter_nohtml_kses( $input['review_archive_desc_font_size'] );
 	$input['review_archive_color'] = wp_filter_nohtml_kses( $input['review_archive_color'] );
 	$input['review_archive_shadow1'] = wp_filter_nohtml_kses( $input['review_archive_shadow1'] );
 	$input['review_archive_shadow2'] = wp_filter_nohtml_kses( $input['review_archive_shadow2'] );
 	$input['review_archive_shadow3'] = wp_filter_nohtml_kses( $input['review_archive_shadow3'] );
 	$input['review_archive_shadow_color'] = wp_filter_nohtml_kses( $input['review_archive_shadow_color'] );

	// レビュー記事詳細の設定
 	$input['review_title_font_size'] = wp_filter_nohtml_kses( $input['review_title_font_size'] );
 	$input['review_content_font_size'] = wp_filter_nohtml_kses( $input['review_content_font_size'] );

	// ヘッダーバーの表示位置
 	if ( ! isset( $input['header_fix'] ) ) $input['header_fix'] = null;
 	if ( ! array_key_exists( $input['header_fix'], $header_fix_options ) ) $input['header_fix'] = null;

	// ヘッダーバーの表示位置（スマホ）
 	if ( ! isset( $input['mobile_header_fix'] ) ) $input['mobile_header_fix'] = null;
 	if ( ! array_key_exists( $input['mobile_header_fix'], $header_fix_options ) ) $input['mobile_header_fix'] = null;

	// ヘッダーバーの色の設定
	$input['top_header_bg'] = wp_filter_nohtml_kses( $input['top_header_bg'] );
	$input['top_header_opacity'] = wp_filter_nohtml_kses( $input['top_header_opacity'] );
	$input['top_header_font_color'] = wp_filter_nohtml_kses( $input['top_header_font_color'] );
	$input['sub_header_bg'] = wp_filter_nohtml_kses( $input['sub_header_bg'] );
	$input['sub_header_opacity'] = wp_filter_nohtml_kses( $input['sub_header_opacity'] );
	$input['sub_header_font_color'] = wp_filter_nohtml_kses( $input['sub_header_font_color'] );

	// フッターブログコンテンツの設定
 	if ( ! isset( $input['show_footer_blog_top'] ) ) $input['show_footer_blog_top'] = null;
  $input['show_footer_blog_top'] = ( $input['show_footer_blog_top'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_footer_blog'] ) ) $input['show_footer_blog'] = null;
  $input['show_footer_blog'] = ( $input['show_footer_blog'] == 1 ? 1 : 0 );
 	$input['footer_blog_catchphrase'] = wp_filter_nohtml_kses( $input['footer_blog_catchphrase'] );
 	$input['footer_blog_catchphrase_font_size'] = wp_filter_nohtml_kses( $input['footer_blog_catchphrase_font_size'] );
 	if ( ! isset( $input['footer_blog_num'] ) ) $input['footer_blog_num'] = null;
 	if ( ! array_key_exists( $input['footer_blog_num'], $footer_blog_num_options ) ) $input['footer_blog_num'] = null;
 	if ( ! isset( $input['footer_blog_post_order'] ) ) $input['footer_blog_post_order'] = null;
 	if ( ! array_key_exists( $input['footer_blog_post_order'], $footer_blog_post_order_options ) ) $input['footer_blog_post_order'] = null;
 	if ( ! isset( $input['show_footer_blog_date'] ) ) $input['show_footer_blog_date'] = null;
  $input['show_footer_blog_date'] = ( $input['show_footer_blog_date'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_footer_blog_category'] ) ) $input['show_footer_blog_category'] = null;
  $input['show_footer_blog_category'] = ( $input['show_footer_blog_category'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['show_footer_blog_link'] ) ) $input['show_footer_blog_link'] = null;
  $input['show_footer_blog_link'] = ( $input['show_footer_blog_link'] == 1 ? 1 : 0 );
 	$input['footer_blog_link_text'] = wp_filter_nohtml_kses( $input['footer_blog_link_text'] );
 	if ( ! isset( $input['footer_blog_slide_time'] ) ) $input['footer_blog_slide_time'] = null;
 	if ( ! array_key_exists( $input['footer_blog_slide_time'], $footer_blog_slide_time_options ) ) $input['footer_blog_slide_time'] = null;

	// SNSボタンの設定
	$input['twitter_url'] = wp_filter_nohtml_kses( $input['twitter_url'] );
 	$input['facebook_url'] = wp_filter_nohtml_kses( $input['facebook_url'] );
 	$input['insta_url'] = wp_filter_nohtml_kses( $input['insta_url'] );
 	if ( ! isset( $input['show_rss'] ) ) $input['show_rss'] = null;
  $input['show_rss'] = ( $input['show_rss'] == 1 ? 1 : 0 );
		
	// フッターに表示する会社情報
	$input['footer_company_address'] = wp_filter_nohtml_kses( $input['footer_company_address'] );

	// 著作権表示の設定
 	$input['copyright_bg'] = wp_filter_nohtml_kses( $input['copyright_bg'] );

	// スマホ用固定フッターバーの設定
 	if ( ! array_key_exists( $input['footer_bar_display'], $footer_bar_display_options ) ) $input['footer_bar_display'] = 'type3';
 	$input['footer_bar_bg'] = wp_filter_nohtml_kses( $input['footer_bar_bg'] );
 	$input['footer_bar_border'] = wp_filter_nohtml_kses( $input['footer_bar_border'] );
 	$input['footer_bar_color'] = wp_filter_nohtml_kses( $input['footer_bar_color'] );
 	$input['footer_bar_tp'] = wp_filter_nohtml_kses( $input['footer_bar_tp'] );
 	$footer_bar_btns = array();
	if ( isset( $input['repeater_footer_bar_btns'] ) ) {
		foreach ( $input['repeater_footer_bar_btns'] as $key => $value ) {
  	 		$footer_bar_btns[] = array(
				'type' => ( isset( $input['repeater_footer_bar_btns'][$key]['type'] ) && array_key_exists( $input['repeater_footer_bar_btns'][$key]['type'], $footer_bar_button_options ) ) ? $input['repeater_footer_bar_btns'][$key]['type'] : 'type1',
				'label' => isset( $input['repeater_footer_bar_btns'][$key]['label'] ) ? wp_filter_nohtml_kses( $input['repeater_footer_bar_btns'][$key]['label'] ) : '',
				'url' => isset( $input['repeater_footer_bar_btns'][$key]['url'] ) ? wp_filter_nohtml_kses( $input['repeater_footer_bar_btns'][$key]['url'] ) : '',
				'number' => isset( $input['repeater_footer_bar_btns'][$key]['number'] ) ? wp_filter_nohtml_kses( $input['repeater_footer_bar_btns'][$key]['number'] ) : '',
  	  			'target' => ! empty( $input['repeater_footer_bar_btns'][$key]['target'] ) ? 1 : 0,
  	  			'icon' => ( isset( $input['repeater_footer_bar_btns'][$key]['icon'] ) && array_key_exists( $input['repeater_footer_bar_btns'][$key]['icon'], $footer_bar_icon_options ) ) ? $input['repeater_footer_bar_btns'][$key]['icon'] : 'file-text'
			);
			
		}
	}
 	$input['footer_bar_btns'] = $footer_bar_btns;

	// 404 ページ
 	$input['image_404'] = wp_filter_nohtml_kses( $input['image_404'] );
 	$input['overlay_404'] = wp_filter_nohtml_kses( $input['overlay_404'] );
 	$input['overlay_opacity_404'] = wp_filter_nohtml_kses( $input['overlay_opacity_404'] );
 	$input['catchphrase_404'] = wp_filter_nohtml_kses( $input['catchphrase_404'] );
 	$input['desc_404'] = wp_filter_nohtml_kses( $input['desc_404'] );
 	$input['catchphrase_font_size_404'] = wp_filter_nohtml_kses( $input['catchphrase_font_size_404'] );
 	$input['desc_font_size_404'] = wp_filter_nohtml_kses( $input['desc_font_size_404'] );
 	$input['color_404'] = wp_filter_nohtml_kses( $input['color_404'] );
 	$input['shadow1_404'] = wp_filter_nohtml_kses( $input['shadow1_404'] );
 	$input['shadow2_404'] = wp_filter_nohtml_kses( $input['shadow2_404'] );
 	$input['shadow3_404'] = wp_filter_nohtml_kses( $input['shadow3_404'] );
 	$input['shadow_color_404'] = wp_filter_nohtml_kses( $input['shadow_color_404'] );

	// マーケティング
	for ( $i = 1; $i <= 3; $i++ ) {
 		if ( ! isset( $input['cta_type' . $i] ) ) $input['cta_type' . $i] = null;
 		if ( ! array_key_exists( $input['cta_type' . $i], $cta_type_options ) ) $input['cta_type' . $i] = null;

		$input['cta_type1_catch' . $i] = $input['cta_type1_catch' . $i]; // HTML対応
		$input['cta_type1_desc' . $i] = $input['cta_type1_desc' . $i]; // HTML対応
		$input['cta_type1_catch_font_size' . $i] = wp_filter_nohtml_kses( $input['cta_type1_catch_font_size' . $i] );
		$input['cta_type1_desc_font_size' . $i] = wp_filter_nohtml_kses( $input['cta_type1_desc_font_size' . $i] );
		$input['cta_type1_btn_label' . $i] = wp_filter_nohtml_kses( $input['cta_type1_btn_label' . $i] );
		$input['cta_type1_btn_url' . $i] = wp_filter_nohtml_kses( $input['cta_type1_btn_url' . $i] );
 		if ( ! isset( $input['cta_type1_btn_target' . $i] ) ) $input['cta_type1_btn_target' . $i] = null;
  	$input['cta_type1_btn_target' . $i] = ( $input['cta_type1_btn_target' . $i] == 1 ? 1 : 0 );
		$input['cta_type1_btn_bg' . $i] = wp_filter_nohtml_kses( $input['cta_type1_btn_bg' . $i] );
		$input['cta_type1_btn_bg_hover' . $i] = wp_filter_nohtml_kses( $input['cta_type1_btn_bg_hover' . $i] );
		$input['cta_type1_image' . $i] = wp_filter_nohtml_kses( $input['cta_type1_image' . $i] );
		$input['cta_type1_image_sp' . $i] = wp_filter_nohtml_kses( $input['cta_type1_image_sp' . $i] );
		$input['cta_type1_overlay' . $i] = wp_filter_nohtml_kses( $input['cta_type1_overlay' . $i] );
		$input['cta_type1_overlay_opacity' . $i] = wp_filter_nohtml_kses( $input['cta_type1_overlay_opacity' . $i] );

 		if ( ! isset( $input['cta_type2_layout' . $i] ) ) $input['cta_type2_layout' . $i] = null;
 		if ( ! array_key_exists( $input['cta_type2_layout' . $i], $cta_type2_layout_options ) ) $input['cta_type2_layout' . $i] = null;
		$input['cta_type2_catch' . $i] = $input['cta_type2_catch' . $i]; // HTML対応
		$input['cta_type2_desc' . $i] = $input['cta_type2_desc' . $i]; // HTML対応
		$input['cta_type2_catch_font_size' . $i] = wp_filter_nohtml_kses( $input['cta_type2_catch_font_size' . $i] );
		$input['cta_type2_desc_font_size' . $i] = wp_filter_nohtml_kses( $input['cta_type2_desc_font_size' . $i] );
		$input['cta_type2_btn_label' . $i] = wp_filter_nohtml_kses( $input['cta_type2_btn_label' . $i] );
		$input['cta_type2_btn_url' . $i] = wp_filter_nohtml_kses( $input['cta_type2_btn_url' . $i] );
 		if ( ! isset( $input['cta_type2_btn_target' . $i] ) ) $input['cta_type2_btn_target' . $i] = null;
  	$input['cta_type2_btn_target' . $i] = ( $input['cta_type2_btn_target' . $i] == 1 ? 1 : 0 );
		$input['cta_type2_btn_bg' . $i] = wp_filter_nohtml_kses( $input['cta_type2_btn_bg' . $i] );
		$input['cta_type2_btn_bg_hover' . $i] = wp_filter_nohtml_kses( $input['cta_type2_btn_bg_hover' . $i] );
		$input['cta_type2_image' . $i] = wp_filter_nohtml_kses( $input['cta_type2_image' . $i] );
		$input['cta_type2_image_sp' . $i] = wp_filter_nohtml_kses( $input['cta_type2_image_sp' . $i] );

		$input['cta_editor' . $i] = $input['cta_editor' . $i]; // HTML対応

 		if ( ! isset( $input['cta_random' . $i] ) ) $input['cta_random' . $i] = null;
  	$input['cta_random' . $i] = ( $input['cta_random' . $i] == 1 ? 1 : 0 );
	}

 	if ( ! isset( $input['cta_display'] ) ) $input['cta_display'] = null;
 	if ( ! array_key_exists( $input['cta_display'], $cta_display_options ) ) $input['cta_display'] = null;
 	if ( ! isset( $input['cta_display_news'] ) ) $input['cta_display_news'] = null;
  $input['cta_display_news'] = ( $input['cta_display_news'] == 1 ? 1 : 0 );
 	if ( ! isset( $input['cta_display_review'] ) ) $input['cta_display_review'] = null;
  $input['cta_display_review'] = ( $input['cta_display_review'] == 1 ? 1 : 0 );

	for ( $i = 1; $i <= 3; $i++ ) {

 		if ( ! isset( $input['footer_cta_type' . $i] ) ) $input['footer_cta_type' . $i] = null;
 		if ( ! array_key_exists( $input['footer_cta_type' . $i], $footer_cta_type_options ) ) $input['footer_cta_type' . $i] = null;
		$input['footer_cta_catch' . $i] = $input['footer_cta_catch' . $i]; // HTML対応
		$input['footer_cta_catch_font_color' . $i] = wp_filter_nohtml_kses( $input['footer_cta_catch_font_color' . $i] );
		$input['footer_cta_desc' . $i] = $input['footer_cta_desc' . $i]; // HTML対応
		$input['footer_cta_desc_font_color' . $i] = wp_filter_nohtml_kses( $input['footer_cta_desc_font_color' . $i] );
		$input['footer_cta_btn_label' . $i] = wp_filter_nohtml_kses( $input['footer_cta_btn_label' . $i] );
		$input['footer_cta_btn_url' . $i] = wp_filter_nohtml_kses( $input['footer_cta_btn_url' . $i] );
 		if ( ! isset( $input['footer_cta_btn_target' . $i] ) ) $input['footer_cta_btn_target' . $i] = null;
  	$input['footer_cta_btn_target' . $i] = ( $input['footer_cta_btn_target' . $i] == 1 ? 1 : 0 );
		$input['footer_cta_btn_bg' . $i] = wp_filter_nohtml_kses( $input['footer_cta_btn_bg' . $i] );
		$input['footer_cta_btn_bg_hover' . $i] = wp_filter_nohtml_kses( $input['footer_cta_btn_bg_hover' . $i] );
		$input['footer_cta_bg' . $i] = wp_filter_nohtml_kses( $input['footer_cta_bg' . $i] );
		$input['footer_cta_editor' . $i] = $input['footer_cta_editor' . $i]; // HTML対応
 		if ( ! isset( $input['footer_cta_random' . $i] ) ) $input['footer_cta_random' . $i] = null;
  	$input['footer_cta_random' . $i] = ( $input['footer_cta_random' . $i] == 1 ? 1 : 0 );
	
	}

 	if ( ! isset( $input['footer_cta_display'] ) ) $input['footer_cta_display'] = null;
 	if ( ! array_key_exists( $input['footer_cta_display'], $cta_display_options ) ) $input['footer_cta_display'] = null;

 	if ( ! isset( $input['footer_cta_hide_on_front'] ) ) $input['footer_cta_hide_on_front'] = null;
  $input['footer_cta_hide_on_front'] = ( $input['footer_cta_hide_on_front'] == 1 ? 1 : 0 );


	/**
	 * コンテンツビルダー
	 */
 	if ( ! empty( $input['contents_builder'] ) ) {
  	$input_cb = $input['contents_builder'];
  	$input['contents_builder'] = array();

  	foreach( $input_cb as $key => $value ) {

   		// クローン用はスルー
			if ( in_array( $key, array( 'cb_cloneindex', 'cb_cloneindex2' ) ) ) continue;

			// キャッチフレーズと説明文 ------------------------------
   		if ( 'catch_and_desc' == $value['cb_content_select'] ) {

 				if ( ! isset( $value['cb_catch_and_desc_display'] ) ) $value['cb_catch_and_desc_display'] = null;
  			$value['cb_catch_and_desc_display'] = ( $value['cb_catch_and_desc_display'] == 1 ? 1 : 0 );
     		$value['cb_catch_and_desc_headline'] = wp_filter_nohtml_kses( $value['cb_catch_and_desc_headline'] );
     		$value['cb_catch_and_desc_headline_font_size'] = wp_filter_nohtml_kses( $value['cb_catch_and_desc_headline_font_size'] );
     		$value['cb_catch_and_desc_desc'] = wp_filter_nohtml_kses( $value['cb_catch_and_desc_desc'] );
     		$value['cb_catch_and_desc_desc_font_size'] = wp_filter_nohtml_kses( $value['cb_catch_and_desc_desc_font_size'] );

   			// 3つのボックスコンテンツ ------------------------------
   			} elseif ( 'three_boxes' == $value['cb_content_select'] ) {

 					if ( ! isset( $value['cb_three_boxes_display'] ) ) $value['cb_three_boxes_display'] = null;
  				$value['cb_three_boxes_display'] = ( $value['cb_three_boxes_display'] == 1 ? 1 : 0 );

					for ( $i = 1; $i <= 3; $i++ ) {
 						$value['cb_three_boxes_headline' . $i] = wp_filter_nohtml_kses( $value['cb_three_boxes_headline' . $i] );
 						$value['cb_three_boxes_headline_font_size' . $i] = wp_filter_nohtml_kses( $value['cb_three_boxes_headline_font_size' . $i] );
 						$value['cb_three_boxes_desc' . $i] = wp_filter_nohtml_kses( $value['cb_three_boxes_desc' . $i] );
 						$value['cb_three_boxes_desc_font_size' . $i] = wp_filter_nohtml_kses( $value['cb_three_boxes_desc_font_size' . $i] );
 						$value['cb_three_boxes_image' . $i] = wp_filter_nohtml_kses( $value['cb_three_boxes_image' . $i] );
 						$value['cb_three_boxes_url' . $i] = wp_filter_nohtml_kses( $value['cb_three_boxes_url' . $i] );
 						if ( ! isset( $value['cb_three_boxes_target' . $i] ) ) $value['cb_three_boxes_target' . $i] = null;
  					$value['cb_three_boxes_target' . $i] = ( $value['cb_three_boxes_target' . $i] == 1 ? 1 : 0 );
					}

   			// ショーケース ------------------------------
   			} elseif ( 'showcase' == $value['cb_content_select'] ) {

 					if ( ! isset( $value['cb_showcase_display'] ) ) $value['cb_showcase_display'] = null;
  				$value['cb_showcase_display'] = ( $value['cb_showcase_display'] == 1 ? 1 : 0 );
     			if ( ! isset( $value['cb_showcase_type'] ) ) $value['cb_showcase_type'] = null;
     			if ( ! array_key_exists( $value['cb_showcase_type'], $cb_showcase_type_options ) ) $value['cb_showcase_type'] = null;
     			$value['cb_showcase_headline'] = wp_filter_nohtml_kses( $value['cb_showcase_headline'] );
     			$value['cb_showcase_headline_font_size'] = wp_filter_nohtml_kses( $value['cb_showcase_headline_font_size'] );
     			$value['cb_showcase_desc'] = wp_filter_nohtml_kses( $value['cb_showcase_desc'] );
     			$value['cb_showcase_desc_font_size'] = wp_filter_nohtml_kses( $value['cb_showcase_desc_font_size'] );
 					if ( ! isset( $value['cb_showcase_display_button'] ) ) $value['cb_showcase_display_button'] = null;
  				$value['cb_showcase_display_button'] = ( $value['cb_showcase_display_button'] == 1 ? 1 : 0 );
     			$value['cb_showcase_label'] = wp_filter_nohtml_kses( $value['cb_showcase_label'] );
     			$value['cb_showcase_url'] = wp_filter_nohtml_kses( $value['cb_showcase_url'] );
 					if ( ! isset( $value['cb_showcase_target'] ) ) $value['cb_showcase_target'] = null;
  				$value['cb_showcase_target'] = ( $value['cb_showcase_target'] == 1 ? 1 : 0 );
     			$value['cb_showcase_btn_color'] = wp_filter_nohtml_kses( $value['cb_showcase_btn_color'] );
     			$value['cb_showcase_btn_bg'] = wp_filter_nohtml_kses( $value['cb_showcase_btn_bg'] );
     			$value['cb_showcase_btn_color_hover'] = wp_filter_nohtml_kses( $value['cb_showcase_btn_color_hover'] );
     			$value['cb_showcase_btn_bg_hover'] = wp_filter_nohtml_kses( $value['cb_showcase_btn_bg_hover'] );
     			$value['cb_showcase_image'] = wp_filter_nohtml_kses( $value['cb_showcase_image'] );
     			$value['cb_showcase_bg_image'] = wp_filter_nohtml_kses( $value['cb_showcase_bg_image'] );
     			$value['cb_showcase_overlay'] = wp_filter_nohtml_kses( $value['cb_showcase_overlay'] );
     			$value['cb_showcase_opacity'] = wp_filter_nohtml_kses( $value['cb_showcase_opacity'] );

   			// ギャラリーコンテンツ ------------------------------
   			} elseif ( 'gallery_content' == $value['cb_content_select'] ) {

 					if ( ! isset( $value['cb_gallery_content_display'] ) ) $value['cb_gallery_content_display'] = null;
  				$value['cb_gallery_content_display'] = ( $value['cb_gallery_content_display'] == 1 ? 1 : 0 );
     			$value['cb_gallery_content_headline'] = wp_filter_nohtml_kses( $value['cb_gallery_content_headline'] );
     			$value['cb_gallery_content_headline_font_size'] = wp_filter_nohtml_kses( $value['cb_gallery_content_headline_font_size'] );
     			$value['cb_gallery_content_summary'] = wp_filter_nohtml_kses( $value['cb_gallery_content_summary'] );
     			$value['cb_gallery_content_summary_font_size'] = wp_filter_nohtml_kses( $value['cb_gallery_content_summary_font_size'] );

 					if ( ! isset( $value['cb_gallery_content_display_slider'] ) ) $value['cb_gallery_content_display_slider'] = null;
  				$value['cb_gallery_content_display_slider'] = ( $value['cb_gallery_content_display_slider'] == 1 ? 1 : 0 );


					$cb_gallery_content_items = array();
					if ( isset( $value['cb_gallery_content_items']['caption'] ) ) {
   					foreach( array_keys( $value['cb_gallery_content_items']['caption']) as $key ) {
   						$cb_gallery_content_items[] = array(
   					  	'image' => isset( $value['cb_gallery_content_items']['image'][$key] ) ? wp_filter_nohtml_kses( $value['cb_gallery_content_items']['image'][$key] ) : '',
   					    'caption' => isset( $value['cb_gallery_content_items']['caption'][$key] ) ? wp_filter_nohtml_kses( $value['cb_gallery_content_items']['caption'][$key] ) : '',
   					   );
   					 }
					
					}
					$value['cb_gallery_content_items'] = $cb_gallery_content_items;
     			$value['cb_gallery_content_desc1'] = wp_filter_nohtml_kses( $value['cb_gallery_content_desc1'] );
     			$value['cb_gallery_content_desc_font_size1'] = wp_filter_nohtml_kses( $value['cb_gallery_content_desc_font_size1'] );
     			$value['cb_gallery_content_desc2'] = wp_filter_nohtml_kses( $value['cb_gallery_content_desc2'] );
     			$value['cb_gallery_content_desc_font_size2'] = wp_filter_nohtml_kses( $value['cb_gallery_content_desc_font_size2'] );

   			// 円形画像とテキスト ------------------------------
   			} elseif ( 'circular_images_and_texts' == $value['cb_content_select'] ) {

 					if ( ! isset( $value['cb_circular_images_and_texts_display'] ) ) $value['cb_circular_images_and_texts_display'] = null;
  				$value['cb_circular_images_and_texts_display'] = ( $value['cb_circular_images_and_texts_display'] == 1 ? 1 : 0 );
					$cb_circular_images_and_texts_items = array();
					if ( isset( $value['cb_circular_images_and_texts_items']['headline'] ) ) {
   					foreach( array_keys( $value['cb_circular_images_and_texts_items']['headline']) as $key ) {
   						$cb_circular_images_and_texts_items[] = array(
   					  	'image' => isset( $value['cb_circular_images_and_texts_items']['image'][$key] ) ? wp_filter_nohtml_kses( $value['cb_circular_images_and_texts_items']['image'][$key] ) : '',
   					  	'headline' => isset( $value['cb_circular_images_and_texts_items']['headline'][$key] ) ? wp_filter_nohtml_kses( $value['cb_circular_images_and_texts_items']['headline'][$key] ) : '',
   					  	'desc' => isset( $value['cb_circular_images_and_texts_items']['desc'][$key] ) ? wp_filter_nohtml_kses( $value['cb_circular_images_and_texts_items']['desc'][$key] ) : '',
   					   );
   					 }
					}
					$value['cb_circular_images_and_texts_items'] = $cb_circular_images_and_texts_items;

   			// レビュースライダー ------------------------------
   			} elseif ( 'review_slider' == $value['cb_content_select'] ) {

 					if ( ! isset( $value['cb_review_slider_display'] ) ) $value['cb_review_slider_display'] = null;
  				$value['cb_review_slider_display'] = ( $value['cb_review_slider_display'] == 1 ? 1 : 0 );
     			$value['cb_review_slider_headline'] = wp_filter_nohtml_kses( $value['cb_review_slider_headline'] );
     			$value['cb_review_slider_headline_font_size'] = wp_filter_nohtml_kses( $value['cb_review_slider_headline_font_size'] );
 					if ( ! isset( $value['cb_review_slider_display_slider'] ) ) $value['cb_review_slider_display_slider'] = null;
  				$value['cb_review_slider_display_slider'] = ( $value['cb_review_slider_display_slider'] == 1 ? 1 : 0 );
 					if ( ! isset( $value['cb_review_slider_display_link'] ) ) $value['cb_review_slider_display_link'] = null;
  				$value['cb_review_slider_display_link'] = ( $value['cb_review_slider_display_link'] == 1 ? 1 : 0 );
     			$value['cb_review_slider_link_text'] = wp_filter_nohtml_kses( $value['cb_review_slider_link_text'] );

   			// フリースペース ------------------------------
   			} elseif ( 'wysiwyg' == $value['cb_content_select'] ) {

 					if ( ! isset( $value['cb_wysiwyg_display'] ) ) $value['cb_wysiwyg_display'] = null;
  				$value['cb_wysiwyg_display'] = ( $value['cb_wysiwyg_display'] == 1 ? 1 : 0 );

   			}

   			$input['contents_builder'][] = $value;

  		}
	 } // コンテンツビルダーループここまで

 	return $input;
}

/**
 * コンテンツビルダー用 コンテンツ選択プルダウン
 */
function the_cb_content_select( $cb_index = 'cb_cloneindex', $selected = null ) {
	$cb_content_select = array(
		'catch_and_desc' => __( 'Catchphrase and description', 'tcd-w' ),
		'three_boxes' => __( 'Three boxes', 'tcd-w' ),
		'showcase' => __( 'Showcase', 'tcd-w' ),
		'gallery_content' => __( 'Gallery content', 'tcd-w' ),
		'circular_images_and_texts' => __( 'Circular images and texts', 'tcd-w' ),
		'review_slider' => __( 'Review slider', 'tcd-w' ),
		'wysiwyg' => __( 'WYSIWYG Editor', 'tcd-w' )
	);

	if ( $selected && isset( $cb_content_select[$selected] ) ) {
		$add_class = ' hidden';
	} else {
		$add_class = '';
	}

	$out = '<select name="dp_options[contents_builder][' . esc_attr( $cb_index ) . '][cb_content_select]" class="cb_content_select' . $add_class . '">';
	$out .= '<option value="" style="padding-right: 10px;">' . __( 'Choose the content', 'tcd-w' ) . '</option>';

	foreach( $cb_content_select as $key => $value ) {
		$attr = '';
		if ( $key == $selected ) {
			$attr = ' selected="selected"';
		}
		$out .= '<option value="' . esc_attr( $key ) . '"' . $attr . ' style="padding-right: 10px;">' . esc_html( $value ) . '</option>';
	}

	$out .= '</select>';

	echo $out; 
}

/**
 * コンテンツビルダー用 コンテンツ設定 ■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■■
 */
function the_cb_content_setting( $cb_index = 'cb_cloneindex', $cb_content_select = null, $value = array() ) {
	global $cb_showcase_type_options;
?>
	<div class="cb_content_wrap cf <?php echo esc_attr( $cb_content_select ); ?>">
	<?php
	// キャッチフレーズと説明文 ----------------------------------------------------------------------------------------
	if ( 'catch_and_desc' ==  $cb_content_select ) {

		if ( ! isset( $value['cb_catch_and_desc_display'] ) ) {
			$value['cb_catch_and_desc_display'] = null;
		}
		if ( ! isset( $value['cb_catch_and_desc_headline'] ) ) {
			$value['cb_catch_and_desc_headline'] = '';
		}
		if ( ! isset( $value['cb_catch_and_desc_headline_font_size'] ) ) {
			$value['cb_catch_and_desc_headline_font_size'] = 40;
		}
		if ( ! isset( $value['cb_catch_and_desc_desc'] ) ) {
			$value['cb_catch_and_desc_desc'] = '';
		}
		if ( ! isset( $value['cb_catch_and_desc_desc_font_size'] ) ) {
			$value['cb_catch_and_desc_desc_font_size'] = 16;
		}
?>
    <h3 class="cb_content_headline"><span><?php _e( 'Catchphrase and description', 'tcd-w' ); ?></span><a href="#"><?php _e( 'Open', 'tcd-w' ); ?></a></h3>
    <div class="cb_content">
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_catch_and_desc_display]" type="checkbox" value="1" <?php checked( 1, $value['cb_catch_and_desc_display'] ); ?>><?php _e( 'Display this content at top page', 'tcd-w' ); ?></label></p>
			<?php if ( preg_match( '/^cb_\d+$/', $cb_index ) ) : ?>
			<div class="theme_option_message">
				<p><?php _e( 'To make it a link to jump to this content, set URL of Custom Link in Menus to the following.', 'tcd-w' ); ?></p>
				<p><?php _e( 'ID:', 'tcd-w' ); ?> <input type="text" readonly="readonly" value="#<?php echo $cb_index; ?>"></p>
			</div>
			<?php endif; ?>
  		<h4 class="theme_option_headline2"><?php _e( 'Headline', 'tcd-w' ); ?></h4>
  		<textarea rows="2" class="large-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_catch_and_desc_headline]"><?php echo esc_textarea( $value['cb_catch_and_desc_headline'] ); ?></textarea>
  		<p><?php _e( 'Font size', 'tcd-w' ); ?><input class="font_size hankaku" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_catch_and_desc_headline_font_size]" value="<?php echo esc_attr( $value['cb_catch_and_desc_headline_font_size'] ); ?>"><span>px</span></p>
  		<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
  		<textarea rows="2" class="large-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_catch_and_desc_desc]"><?php echo esc_textarea( $value['cb_catch_and_desc_desc'] ); ?></textarea>
  		<p><?php _e( 'Font size', 'tcd-w' ); ?><input class="font_size hankaku" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_catch_and_desc_desc_font_size]" value="<?php echo esc_attr( $value['cb_catch_and_desc_desc_font_size'] ); ?>"><span>px</span></p>
<?php
	// 3つのボックスコンテンツ　----------------------------------------------------------------------------------------
	} elseif ( 'three_boxes' == $cb_content_select ) {

		if ( ! isset( $value['cb_three_boxes_display'] ) ) {
			$value['cb_three_boxes_display'] = null;
		}
		for ( $i = 1; $i <= 3; $i++ ) {
			if ( ! isset( $value['cb_three_boxes_headline' . $i] ) ) {
				$value['cb_three_boxes_headline' . $i] = '';
			}
			if ( ! isset( $value['cb_three_boxes_headline_font_size' . $i] ) ) {
				$value['cb_three_boxes_headline_font_size' . $i] = 18;
			}
			if ( ! isset( $value['cb_three_boxes_desc' . $i] ) ) {
				$value['cb_three_boxes_desc' . $i] = '';
			}
			if ( ! isset( $value['cb_three_boxes_desc_font_size' . $i] ) ) {
				$value['cb_three_boxes_desc_font_size' . $i] = 14;
			}
			if ( ! isset( $value['cb_three_boxes_image' . $i] ) ) {
				$value['cb_three_boxes_image' . $i] = '';
			}
			if ( ! isset( $value['cb_three_boxes_url' . $i] ) ) {
				$value['cb_three_boxes_url' . $i] = '';
			}
			if ( ! isset( $value['cb_three_boxes_target' . $i] ) ) {
				$value['cb_three_boxes_target' . $i] = null;
			}
		}
?>
    <h3 class="cb_content_headline"><span><?php _e( 'Three boxes', 'tcd-w' ); ?></span><a href="#"><?php _e( 'Open', 'tcd-w' ); ?></a></h3>
    <div class="cb_content">
			<p><?php _e( 'Display three content boxes horizontally.', 'tcd-w' ); ?></p>
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_three_boxes_display]" type="checkbox" value="1" <?php checked( 1, $value['cb_three_boxes_display'] ); ?>><?php _e( 'Display this content at top page', 'tcd-w' ); ?></label></p>
			<?php if ( preg_match( '/^cb_\d+$/', $cb_index ) ) : ?>
			<div class="theme_option_message">
				<p><?php _e( 'To make it a link to jump to this content, set URL of Custom Link in Menus to the following.', 'tcd-w' ); ?></p>
				<p><?php _e( 'ID:', 'tcd-w' ); ?> <input type="text" readonly="readonly" value="#<?php echo $cb_index; ?>"></p>
			</div>
			<?php endif; ?>
			<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
  		<div class="sub_box cf">
  			<h3 class="theme_option_subbox_headline"><?php printf( __( 'Box%s setting', 'tcd-w' ), $i ); ?></h3>
				<div class="sub_box_content">
  		 		<h4 class="theme_option_headline2"><?php _e( 'Headline', 'tcd-w' ); ?></h4>
  		 		<textarea rows="2" class="large-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_three_boxes_headline<?php echo $i; ?>]"><?php echo esc_textarea( $value['cb_three_boxes_headline' . $i] ); ?></textarea>
  				<p><?php _e( 'Font size', 'tcd-w' ); ?><input class="font_size hankaku" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_three_boxes_headline_font_size<?php echo $i; ?>]" value="<?php echo esc_attr( $value['cb_three_boxes_headline_font_size' . $i] ); ?>"><span>px</span></p>
  		 		<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
  		 		<textarea rows="2" class="large-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_three_boxes_desc<?php echo $i; ?>]"><?php echo esc_textarea( $value['cb_three_boxes_desc' . $i] ); ?></textarea>
  				<p><?php _e( 'Font size', 'tcd-w' ); ?><input class="font_size hankaku" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_three_boxes_desc_font_size<?php echo $i; ?>]" value="<?php echo esc_attr( $value['cb_three_boxes_desc_font_size' . $i] ); ?>"><span>px</span></p>
					<h4 class="theme_option_headline2"><?php _e( 'Image', 'tcd-w' ); ?></h4>
  		  	<p><?php _e( 'Recommend image size. Width:680px, Height:440px', 'tcd-w' ); ?></p>
  		  	<div class="image_box cf">
  		   		<div class="cf cf_media_field hide-if-no-js">
  		    		<input type="hidden" value="<?php echo esc_attr( $value['cb_three_boxes_image' . $i] ); ?>" id="cb_three_boxes-image<?php echo $cb_index; ?>-<?php echo $i; ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_three_boxes_image<?php echo $i; ?>]" class="cf_media_id">
  		    		<div class="preview_field"><?php if ( $value['cb_three_boxes_image' . $i] ) { echo wp_get_attachment_image( $value['cb_three_boxes_image' . $i], 'medium' ); } ?></div>
  		    		<div class="button_area">
  		     			<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
  		     			<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $value['cb_three_boxes_image' . $i] ) { echo 'hidden'; } ?>">
  		    		</div>
  		   		</div>
  		  	</div>
  		 		<h4 class="theme_option_headline2"><?php _e( 'Link URL', 'tcd-w' ); ?></h4>
  		 		<input class="regular-text" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_three_boxes_url<?php echo $i; ?>]" value="<?php echo esc_attr( $value['cb_three_boxes_url' . $i] ); ?>">
					<p><label><input type="checkbox" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_three_boxes_target<?php echo $i; ?>]" value="1" <?php checked( 1, $value['cb_three_boxes_target' . $i] ); ?>><?php _e( 'Open a URL in a new window', 'tcd-w' ); ?></label></p>
  		 		<input type="submit" class="button-ml" value="<?php _e( 'Save Changes', 'tcd-w' ); ?>">
				</div><!-- END .sub_box_content -->
  		</div><!-- END .sub_box -->
			<?php endfor; ?>
<?php
	// ショーケース　----------------------------------------------------------------------------------------
	} elseif ( 'showcase' == $cb_content_select ) {

		if ( ! isset( $value['cb_showcase_display'] ) ) {
			$value['cb_showcase_display'] = null;
		}
		if ( ! isset( $value['cb_showcase_type'] ) ) {
			$value['cb_showcase_type'] = 'type1';
		}
		if ( ! isset( $value['cb_showcase_headline'] ) ) {
			$value['cb_showcase_headline'] = '';
		}
		if ( ! isset( $value['cb_showcase_headline_font_size'] ) ) {
			$value['cb_showcase_headline_font_size'] = 40;
		}
		if ( ! isset( $value['cb_showcase_desc'] ) ) {
			$value['cb_showcase_desc'] = '';
		}
		if ( ! isset( $value['cb_showcase_desc_font_size'] ) ) {
			$value['cb_showcase_desc_font_size'] = 16;
		}
		if ( ! isset( $value['cb_showcase_display_button'] ) ) {
			$value['cb_showcase_display_button'] = null;
		}
		if ( ! isset( $value['cb_showcase_label'] ) ) {
			$value['cb_showcase_label'] = '';
		}
		if ( ! isset( $value['cb_showcase_url'] ) ) {
			$value['cb_showcase_url'] = '';
		}
		if ( ! isset( $value['cb_showcase_target'] ) ) {
			$value['cb_showcase_target'] = '';
		}
		if ( ! isset( $value['cb_showcase_btn_color'] ) ) {
			$value['cb_showcase_btn_color'] = '#000000';
		}
		if ( ! isset( $value['cb_showcase_btn_bg'] ) ) {
			$value['cb_showcase_btn_bg'] = '#ff8000';
		}
		if ( ! isset( $value['cb_showcase_btn_color_hover'] ) ) {
			$value['cb_showcase_btn_color_hover'] = '#ffffff';
		}
		if ( ! isset( $value['cb_showcase_btn_bg_hover'] ) ) {
			$value['cb_showcase_btn_bg_hover'] = '#e37100';
		}
		if ( ! isset( $value['cb_showcase_image'] ) ) {
			$value['cb_showcase_image'] = '';
		}
		if ( ! isset( $value['cb_showcase_bg_image'] ) ) {
			$value['cb_showcase_bg_image'] = '';
		}
		if ( ! isset( $value['cb_showcase_overlay'] ) ) {
			$value['cb_showcase_overlay'] = '#000000';
		}
		if ( ! isset( $value['cb_showcase_opacity'] ) ) {
			$value['cb_showcase_opacity'] = '';
		}
?>
    <h3 class="cb_content_headline"><span><?php _e( 'Showcase', 'tcd-w' ); ?></span><a href="#"><?php _e( 'Open', 'tcd-w' ); ?></a></h3>
    <div class="cb_content">
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_display]" type="checkbox" value="1" <?php checked( 1, $value['cb_showcase_display'] ); ?>><?php _e( 'Display this content at top page', 'tcd-w' ); ?></label></p>
			<?php if ( preg_match( '/^cb_\d+$/', $cb_index ) ) : ?>
			<div class="theme_option_message">
				<p><?php _e( 'To make it a link to jump to this content, set URL of Custom Link in Menus to the following.', 'tcd-w' ); ?></p>
				<p><?php _e( 'ID:', 'tcd-w' ); ?> <input type="text" readonly="readonly" value="#<?php echo $cb_index; ?>"></p>
			</div>
			<?php endif; ?>
      <h4 class="theme_option_headline2"><?php _e( 'Showcase type', 'tcd-w' ); ?></h4>
      <ul class="showcase-list">
      	<?php foreach ( $cb_showcase_type_options as $option ) : ?>
      	<li><label><img class="showcase-image" src="<?php echo esc_attr( $option['image'] ); ?>" alt=""><input type="radio" class="cb-showcase-<?php echo esc_attr( $option['value'] ); ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_type]" value="<?php echo esc_attr( $option['value'] ); ?>" <?php echo checked( $option['value'], $value['cb_showcase_type'] ); ?>><?php echo _e( $option['label'], 'tcd-w' ); ?></label></li>
      	<?php endforeach; ?>
      </ul>
  		<h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
  		<textarea rows="2" class="large-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_headline]"><?php echo esc_textarea( $value['cb_showcase_headline'] ); ?></textarea>
  		<p><?php _e( 'Font size', 'tcd-w' ); ?><input class="font_size hankaku" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_headline_font_size]" value="<?php echo esc_attr( $value['cb_showcase_headline_font_size'] ); ?>"><span>px</span></p>
  		<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
  		<textarea rows="4" class="large-text" cols="50" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_desc]"><?php echo esc_textarea( $value['cb_showcase_desc'] ); ?></textarea>
  		<p><?php _e( 'Font size', 'tcd-w' ); ?><input class="font_size hankaku" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_desc_font_size]" value="<?php echo esc_attr( $value['cb_showcase_desc_font_size'] ); ?>"><span>px</span></p>
  		<h4 class="theme_option_headline2"><?php _e( 'Button', 'tcd-w' ); ?></h4>
  		<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_display_button]" type="checkbox" value="1" <?php checked( 1, $value['cb_showcase_display_button'] ); ?>><?php _e( 'Display button', 'tcd-w' ); ?></label></p>
  		<p><label><?php _e( 'Link text', 'tcd-w' ); ?> <input class="regular-text" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_label]" value="<?php echo esc_attr( $value['cb_showcase_label'] ); ?>"></label></p>
  		<p><label><?php _e( 'Link URL', 'tcd-w' ); ?> <input class="regular-text" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_url]" value="<?php echo esc_attr( $value['cb_showcase_url'] ); ?>"></label></p>
			<p><label><input type="checkbox" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_target]" value="1" <?php checked( 1, $value['cb_showcase_target'] ); ?>><?php _e( 'Open a URL in a new window', 'tcd-w' ); ?></label></p>
  		<p><?php _e( 'Font color', 'tcd-w' ); ?> <input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_btn_color]" value="<?php echo esc_attr( $value['cb_showcase_btn_color'] ); ?>" data-default-color="#000000" class="<?php echo preg_match( '/^cb_\d+$/', $cb_index ) ? 'c-color-picker' : 'cb-color-picker'; ?>"></p>
  		<p><?php _e( 'Background color', 'tcd-w' ); ?> <input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_btn_bg]" value="<?php echo esc_attr( $value['cb_showcase_btn_bg'] ); ?>" data-default-color="#ff8800" class="<?php echo preg_match( '/^cb_\d+$/', $cb_index ) ? 'c-color-picker' : 'cb-color-picker'; ?>"></p>
  		<p><?php _e( 'Font color on hover', 'tcd-w' ); ?> <input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_btn_color_hover]" value="<?php echo esc_attr( $value['cb_showcase_btn_color_hover'] ); ?>" data-default-color="#ffffff" class="<?php echo preg_match( '/^cb_\d+$/', $cb_index ) ? 'c-color-picker' : 'cb-color-picker'; ?>"></p>
  		<p><?php _e( 'Background color on hover', 'tcd-w' ); ?> <input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_btn_bg_hover]" value="<?php echo esc_attr( $value['cb_showcase_btn_bg_hover'] ); ?>" data-default-color="#e37100" class="<?php echo preg_match( '/^cb_\d+$/', $cb_index ) ? 'c-color-picker' : 'cb-color-picker'; ?>"></p>
			<div class="cb-showcase-image"<?php if ( 'type3' == $value['cb_showcase_type'] ) { echo ' style="display: none;"'; } ?>>
				<h4 class="theme_option_headline2"><?php _e( 'Image', 'tcd-w' ); ?></h4>
    		<p><?php _e( 'Recommend image size. Width:565px, Max height:580px', 'tcd-w' ); ?></p>
    		<p><?php _e( 'Please register a PNG image with a transparent background.', 'tcd-w' ); ?></p>
    		<div class="image_box cf">
    			<div class="cf cf_media_field hide-if-no-js">
    				<input type="hidden" value="<?php echo esc_attr( $value['cb_showcase_image'] ); ?>" id="cb_showcase_image-<?php echo $cb_index; ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_image]" class="cf_media_id">
    				<div class="preview_field"><?php if ( $value['cb_showcase_image'] ) { echo wp_get_attachment_image( $value['cb_showcase_image'], 'medium' ); } ?></div>
    				<div class="button_area">
    		 			<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
    		 			<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $value['cb_showcase_image'] ) { echo 'hidden'; } ?>">
    				</div>
    			</div>
    		</div>
			</div>
			<h4 class="theme_option_headline2"><?php _e( 'Background image', 'tcd-w' ); ?></h4>
  		<p><?php _e( 'Recommended size: width:1460px, height:1160px', 'tcd-w' ); ?></p>
    	<div class="image_box cf">
    		<div class="cf cf_media_field hide-if-no-js">
    			<input type="hidden" value="<?php echo esc_attr( $value['cb_showcase_bg_image'] ); ?>" id="cb_showcase_bg_image-<?php echo $cb_index; ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_bg_image]" class="cf_media_id">
    			<div class="preview_field"><?php if ( $value['cb_showcase_bg_image'] ) { echo wp_get_attachment_image( $value['cb_showcase_bg_image'], 'medium' ); } ?></div>
    			<div class="button_area">
    	 			<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
    	 			<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $value['cb_showcase_bg_image'] ) { echo 'hidden'; } ?>">
    			</div>
    		</div>
    	</div>
			<h4 class="theme_option_headline2"><?php _e( 'Color of overlay', 'tcd-w' ); ?></h4>
			<input type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_overlay]" value="<?php echo esc_attr( $value['cb_showcase_overlay'] ); ?>" data-default-color="#000000" class="<?php echo preg_match( '/^cb_\d+$/', $cb_index ) ? 'c-color-picker' : 'cb-color-picker'; ?>">
			<h4 class="theme_option_headline2"><?php _e( 'Opacity of overlay', 'tcd-w' ); ?></h4>
			<p><?php _e( 'Please enter the number 0 - 1.0. (e.g. 0.7)', 'tcd-w' ); ?></p>
			<input class="hankaku tiny-text" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_showcase_opacity]" value="<?php echo esc_attr( $value['cb_showcase_opacity'] ); ?>">
<?php
	// ギャラリーコンテンツ ----------------------------------------------------------------------------------------
	} elseif ( 'gallery_content' == $cb_content_select ) {

		if ( ! isset( $value['cb_gallery_content_display'] ) ) {
			$value['cb_gallery_content_display'] = null;
		}
		if ( ! isset( $value['cb_gallery_content_headline'] ) ) {
			$value['cb_gallery_content_headline'] = '';
		}
		if ( ! isset( $value['cb_gallery_content_headline_font_size'] ) ) {
			$value['cb_gallery_content_headline_font_size'] = 40;
		}
		if ( ! isset( $value['cb_gallery_content_summary'] ) ) {
			$value['cb_gallery_content_summary'] = '';
		}
		if ( ! isset( $value['cb_gallery_content_summary_font_size'] ) ) {
			$value['cb_gallery_content_summary_font_size'] = 14;
		}
		if ( ! isset( $value['cb_gallery_content_display_slider'] ) ) {
			$value['cb_gallery_content_display_slider'] = null;
		}
		if ( ! isset( $value['cb_gallery_content_items'] ) ) {
			$value['cb_gallery_content_items'] = array(
				array(
					'caption' => '',
					'image' => '',
				)
			);
		}
		if ( ! isset( $value['cb_gallery_content_desc1'] ) ) {
			$value['cb_gallery_content_desc1'] = '';
		}
		if ( ! isset( $value['cb_gallery_content_desc_font_size1'] ) ) {
			$value['cb_gallery_content_desc_font_size1'] = 14;
		}
		if ( ! isset( $value['cb_gallery_content_desc2'] ) ) {
			$value['cb_gallery_content_desc2'] = '';
		}
		if ( ! isset( $value['cb_gallery_content_desc_font_size2'] ) ) {
			$value['cb_gallery_content_desc_font_size2'] = 14;
		}
?>
    <h3 class="cb_content_headline"><span><?php _e( 'Gallery content', 'tcd-w' ); ?></span><a href="#"><?php _e( 'Open', 'tcd-w' ); ?></a></h3>
    <div class="cb_content">
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_gallery_content_display]" type="checkbox" value="1" <?php checked( 1, $value['cb_gallery_content_display'] ); ?>><?php _e( 'Display this content at top page', 'tcd-w' ); ?></label></p>
			<?php if ( preg_match( '/^cb_\d+$/', $cb_index ) ) : ?>
			<div class="theme_option_message">
				<p><?php _e( 'To make it a link to jump to this content, set URL of Custom Link in Menus to the following.', 'tcd-w' ); ?></p>
				<p><?php _e( 'ID:', 'tcd-w' ); ?> <input type="text" readonly="readonly" value="#<?php echo $cb_index; ?>"></p>
			</div>
			<?php endif; ?>
  		<h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
  		<textarea rows="2" class="large-text" cols="50" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_gallery_content_headline]"><?php echo esc_textarea( $value['cb_gallery_content_headline'] ); ?></textarea>
  		<p><?php _e( 'Font size', 'tcd-w' ); ?> <input class="font_size hankaku" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_gallery_content_headline_font_size]" value="<?php echo esc_attr( $value['cb_gallery_content_headline_font_size'] ); ?>"><span>px</span></p>
  		<h4 class="theme_option_headline2"><?php _e( 'Description', 'tcd-w' ); ?></h4>
  		<textarea rows="4" class="large-text" cols="50" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_gallery_content_summary]"><?php echo esc_textarea( $value['cb_gallery_content_summary'] ); ?></textarea>
  		<p><?php _e( 'Font size', 'tcd-w' ); ?> <input class="font_size hankaku" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_gallery_content_summary_font_size]" value="<?php echo esc_attr( $value['cb_gallery_content_summary_font_size'] ); ?>"><span>px</span></p>
  		<h4 class="theme_option_headline2"><?php _e( 'Carousel slider', 'tcd-w' ); ?></h4>
			<p><?php _e( 'The gallery content will be displayed in the form of a slider if you register more than six items.', 'tcd-w' ); ?></p>
    	<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_gallery_content_display_slider]" type="checkbox" value="1" <?php checked( 1, $value['cb_gallery_content_display_slider'] ); ?>> <?php _e( 'Display carousel slider', 'tcd-w' ); ?></label></p>
    	<div class="topt_repeater_wrapper">
    		<div class="topt_repeater" data-delete-confirm="<?php _e( 'Delete?', 'tcd-w' ); ?>">
<?php 
if ( $value['cb_gallery_content_items'] ) : 
	foreach ( $value['cb_gallery_content_items'] as $rpt_key => $rpt_value ) :
?>
      		<div class="topt_repeater-row sub_box">
       			<table class="topt_table">
        			<tr class="tr_cf_media_field">
      					<p><?php _e( 'Recommend image size. Width:320px or more, Height:320px or more', 'tcd-w' ); ?></p>
        				<th><label><?php _e( 'Image', 'tcd-w' ); ?></label></th>
        				<td>
        	 				<div class="cf cf_media_field hide-if-no-js">
        	  				<input type="hidden" value="<?php echo esc_attr( $rpt_value['image'] ); ?>" id="cb_gallery_content_items-image-<?php echo $cb_index; ?>-<?php echo esc_attr( $rpt_key ); ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_gallery_content_items][image][]" class="cf_media_id">
										<div class="preview_field"><?php if ( $rpt_value['image'] ) { echo wp_get_attachment_image( $rpt_value['image'], 'medium' ); } ?></div>
        	  				<div class="button_area">
        	  					<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
        	  					<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $rpt_value['image'] ) { echo 'hidden'; } ?>">
        	  				</div>
        	 				</div>
        				</td>
        			</tr>
        			<tr>
        				<th><label for="cb_gallery_content_items-caption-<?php echo $cb_index; ?>-<?php echo esc_attr( $rpt_key ); ?>"><?php _e( 'Caption', 'tcd-w' ); ?></label></th>
								<td><input id="cb_gallery_content_items-caption-<?php echo $cb_index; ?>-<?php echo esc_attr( $rpt_key ); ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_gallery_content_items][caption][]" class="regular-text" value="<?php echo esc_attr( $rpt_value['caption'] ); ?>"></td>
							</tr>
						</table>
       			<p class="delete-row right-align"><a href="#" class="button button-secondary button-delete-row"><?php _e( 'Delete item', 'tcd-w' ); ?></a></p>
					</div><!-- /.topt_repeater-row -->
<?php
	endforeach;
endif;
$key = 'addindex';
ob_start(); 
?>
      		<div id="topt_repeater-<?php echo esc_attr( $key ); ?>" class="topt_repeater-row sub_box">
       			<table class="topt_table">
        			<tr class="tr_cf_media_field">
        				<th><label><?php _e( 'Image', 'tcd-w' ); ?></label></th>
        				<td>
        	 				<div class="cf cf_media_field hide-if-no-js">
        	  				<input type="hidden" value="" id="cb_gallery_content_items-image-<?php echo $cb_index; ?>-<?php echo esc_attr( $key ); ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_gallery_content_items][image][]" class="cf_media_id">
        	  				<div class="preview_field"></div>
        	  				<div class="button_area">
        	   					<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
        	   					<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button hidden">
        	  				</div>
        	 				</div>
        				</td>
        			</tr>
        			<tr>
        				<th><label for="cb_gallery_content_items-caption<?php echo $cb_index; ?>-<?php echo esc_attr( $key ); ?>"><?php _e( 'Caption', 'tcd-w' ); ?></label></th>
        				<td><input type="text" id="cb_gallery_content_items-caption<?php echo $cb_index; ?>-<?php echo esc_attr( $key ); ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_gallery_content_items][caption][]" class="regular-text" value=""></td>
							</tr>
						</table>
       			<p class="delete-row right-align"><a href="#" class="button button-secondary button-delete-row"><?php _e( 'Delete item', 'tcd-w' ); ?></a></p>
     			</div>
<?php 
$clone = ob_get_clean(); 
?>
				</div>
  	   	<a href="#" class="button button-secondary button-add-row" data-clone="<?php echo esc_attr( $clone ); ?>"><?php _e( 'Add item', 'tcd-w' ); ?></a>
			</div>
  		<h4 class="theme_option_headline2"><?php _e( 'Description under carousel slider(left)', 'tcd-w' ); ?></h4>
  		<textarea rows="4" class="large-text" cols="50" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_gallery_content_desc1]"><?php echo esc_textarea( $value['cb_gallery_content_desc1'] ); ?></textarea>
  		<p><?php _e( 'Font size', 'tcd-w' ); ?> <input class="font_size hankaku" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_gallery_content_desc_font_size1]" value="<?php echo esc_attr( $value['cb_gallery_content_desc_font_size1'] ); ?>"><span>px</span></p>
  		<h4 class="theme_option_headline2"><?php _e( 'Description under carousel slider(right)', 'tcd-w' ); ?></h4>
  		<textarea rows="4" class="large-text" cols="50" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_gallery_content_desc2]"><?php echo esc_textarea( $value['cb_gallery_content_desc2'] ); ?></textarea>
  		<p><?php _e( 'Font size', 'tcd-w' ); ?> <input class="font_size hankaku" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_gallery_content_desc_font_size2]" value="<?php echo esc_attr( $value['cb_gallery_content_desc_font_size2'] ); ?>"><span>px</span></p>
<?php
	// 円形画像とテキスト ----------------------------------------------------------------------------------------
	} elseif ( 'circular_images_and_texts' == $cb_content_select ) {

		if ( ! isset( $value['cb_circular_images_and_texts_display'] ) ) {
			$value['cb_circular_images_and_texts_display'] = null;
		}
		if ( ! isset( $value['cb_circular_images_and_texts_items'] ) ) {
			$value['cb_circular_images_and_texts_items'] = array(
				array(
					'image' => '',
					'headline' => '',
					'desc' => '',
				)
			);
		}
?>
    <h3 class="cb_content_headline"><span><?php _e( 'Circular images and texts', 'tcd-w' ); ?></span><a href="#"><?php _e( 'Open', 'tcd-w' ); ?></a></h3>
    <div class="cb_content">
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_circular_images_and_texts_display]" type="checkbox" value="1" <?php checked( 1, $value['cb_circular_images_and_texts_display'] ); ?>><?php _e( 'Display this content at top page', 'tcd-w' ); ?></label></p>
			<?php if ( preg_match( '/^cb_\d+$/', $cb_index ) ) : ?>
			<div class="theme_option_message">
				<p><?php _e( 'To make it a link to jump to this content, set URL of Custom Link in Menus to the following.', 'tcd-w' ); ?></p>
				<p><?php _e( 'ID:', 'tcd-w' ); ?> <input type="text" readonly="readonly" value="#<?php echo $cb_index; ?>"></p>
			</div>
			<?php endif; ?>
    	<div class="topt_repeater_wrapper">
    		<div class="topt_repeater" data-delete-confirm="<?php _e( 'Delete?', 'tcd-w' ); ?>">
<?php 
if ( $value['cb_circular_images_and_texts_items'] ) : 
	foreach ( $value['cb_circular_images_and_texts_items'] as $rpt_key => $rpt_value ) :
?>
    	  	<div class="topt_repeater-row sub_box">
    	   		<table class="topt_table">
    	    		<tr class="tr_cf_media_field">
    	  				<p><?php _e( 'Recommended size: width:320px, height:320px', 'tcd-w' ); ?></p>
								<p><?php _e( 'Note: the image is cropped in a circle shape', 'tcd-w' ); ?></p>
    	    			<th><label><?php _e( 'Image', 'tcd-w' ); ?></label></th>
    	    			<td>
        	 				<div class="cf cf_media_field hide-if-no-js">
        	  				<input type="hidden" value="<?php echo esc_attr( $rpt_value['image'] ); ?>" id="cb_circular_images_and_texts_items-image-<?php echo $cb_index; ?>-<?php echo esc_attr( $rpt_key ); ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_circular_images_and_texts_items][image][]" class="cf_media_id">
										<div class="preview_field"><?php if ( $rpt_value['image'] ) { echo wp_get_attachment_image( $rpt_value['image'], 'medium' ); } ?></div>
        	  				<div class="button_area">
        	  					<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
        	  					<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button <?php if ( ! $rpt_value['image'] ) { echo 'hidden'; } ?>">
        	  				</div>
        	 				</div>
    	    			</td>
    	    		</tr>
        			<tr>
        				<th><label for="cb_circular_images_and_texts_items-headline-<?php echo $cb_index; ?>-<?php echo esc_attr( $rpt_key ); ?>"><?php _e( 'Headline', 'tcd-w' ); ?></label></th>
								<td><textarea id="cb_circular_images_and_texts_items-headline-<?php echo $cb_index; ?>-<?php echo esc_attr( $rpt_key ); ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_circular_images_and_texts_items][headline][]" class="large-text" rows="2"><?php echo esc_textarea( $rpt_value['headline'] ); ?></textarea></td>
							</tr>
        			<tr>
        				<th><label for="cb_circular_images_and_texts_items-desc-<?php echo $cb_index; ?>-<?php echo esc_attr( $rpt_key ); ?>"><?php _e( 'Description', 'tcd-w' ); ?></label></th>
								<td><textarea id="cb_circular_images_and_texts_items-desc-<?php echo $cb_index; ?>-<?php echo esc_attr( $rpt_key ); ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_circular_images_and_texts_items][desc][]" class="large-text" rows="4"><?php echo esc_textarea( $rpt_value['desc'] ); ?></textarea></td>
							</tr>
						</table>
    	   		<p class="delete-row right-align"><a href="#" class="button button-secondary button-delete-row"><?php _e( 'Delete item', 'tcd-w' ); ?></a></p>
					</div><!-- /.topt_repeater-row -->
<?php
	endforeach;
endif;
$key = 'addindex';
ob_start(); 
?>
      		<div id="topt_repeater-<?php echo esc_attr( $key ); ?>" class="topt_repeater-row sub_box">
       			<table class="topt_table">
        			<tr class="tr_cf_media_field">
        				<th><label><?php _e( 'Image', 'tcd-w' ); ?></label></th>
        				<td>
        	 				<div class="cf cf_media_field hide-if-no-js">
        	  				<input type="hidden" value="" id="cb_circular_images_and_texts_items-image-<?php echo $cb_index; ?>-<?php echo esc_attr( $key ); ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_circular_images_and_texts_items][image][]" class="cf_media_id">
        	  				<div class="preview_field"></div>
        	  				<div class="button_area">
        	   					<input type="button" value="<?php _e( 'Select Image', 'tcd-w' ); ?>" class="cfmf-select-img button">
        	   					<input type="button" value="<?php _e( 'Remove Image', 'tcd-w' ); ?>" class="cfmf-delete-img button hidden">
        	  				</div>
        	 				</div>
        				</td>
        			</tr>
        			<tr>
        				<th><label for="cb_circular_images_and_texts_items-headline<?php echo $cb_index; ?>-<?php echo esc_attr( $key ); ?>"><?php _e( 'Headline', 'tcd-w' ); ?></label></th>
        				<td><textarea id="cb_circular_images_and_texts_items-headline<?php echo $cb_index; ?>-<?php echo esc_attr( $key ); ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_circular_images_and_texts_items][headline][]" class="large-text" rows="2"></textarea></td>
							</tr>
        			<tr>
        				<th><label for="cb_circular_images_and_texts_items-desc<?php echo $cb_index; ?>-<?php echo esc_attr( $key ); ?>"><?php _e( 'Description', 'tcd-w' ); ?></label></th>
        				<td><textarea id="cb_circular_images_and_texts_items-desc<?php echo $cb_index; ?>-<?php echo esc_attr( $key ); ?>" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_circular_images_and_texts_items][desc][]" class="large-text" rows="4"></textarea></td>
							</tr>
						</table>
       			<p class="delete-row right-align"><a href="#" class="button button-secondary button-delete-row"><?php _e( 'Delete item', 'tcd-w' ); ?></a></p>
     			</div>
<?php 
$clone = ob_get_clean(); 
?>
				</div>
     		<a href="#" class="button button-secondary button-add-row" data-clone="<?php echo esc_attr( $clone ); ?>"><?php _e( 'Add item', 'tcd-w' ); ?></a>
			</div>
<?php
	// レビュースライダー ----------------------------------------------------------------------------------------
	} elseif ( 'review_slider' == $cb_content_select ) {

		if ( ! isset( $value['cb_review_slider_display'] ) ) {
			$value['cb_review_slider_display'] = null;
		}
		if ( ! isset( $value['cb_review_slider_headline'] ) ) {
			$value['cb_review_slider_headline'] = '';
		}
		if ( ! isset( $value['cb_review_slider_headline_font_size'] ) ) {
			$value['cb_review_slider_headline_font_size'] = 40;
		}
		if ( ! isset( $value['cb_review_slider_display_slider'] ) ) {
			$value['cb_review_slider_display_slider'] = null;
		}
		if ( ! isset( $value['cb_review_slider_display_link'] ) ) {
			$value['cb_review_slider_display_link'] = null;
		}
		if ( ! isset( $value['cb_review_slider_link_text'] ) ) {
			$value['cb_review_slider_link_text'] = '';
		}
?>
    <h3 class="cb_content_headline"><span><?php _e( 'Review slider', 'tcd-w' ); ?></span><a href="#"><?php _e( 'Open', 'tcd-w' ); ?></a></h3>
    <div class="cb_content">
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_review_slider_display]" type="checkbox" value="1" <?php checked( 1, $value['cb_review_slider_display'] ); ?>><?php _e( 'Display this content at top page', 'tcd-w' ); ?></label></p>
			<?php if ( preg_match( '/^cb_\d+$/', $cb_index ) ) : ?>
			<div class="theme_option_message">
				<p><?php _e( 'To make it a link to jump to this content, set URL of Custom Link in Menus to the following.', 'tcd-w' ); ?></p>
				<p><?php _e( 'ID:', 'tcd-w' ); ?> <input type="text" readonly="readonly" value="#<?php echo $cb_index; ?>"></p>
			</div>
			<?php endif; ?>
  		<h4 class="theme_option_headline2"><?php _e( 'Catchphrase', 'tcd-w' ); ?></h4>
  		<textarea rows="2" class="large-text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_review_slider_headline]"><?php echo esc_textarea( $value['cb_review_slider_headline'] ); ?></textarea>
  		<p><?php _e( 'Font size', 'tcd-w' ); ?><input class="font_size hankaku" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_review_slider_headline_font_size]" value="<?php echo esc_attr( $value['cb_review_slider_headline_font_size'] ); ?>"><span>px</span></p>
  		<h4 class="theme_option_headline2"><?php _e( 'Review slider', 'tcd-w' ); ?></h4>
  		<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_review_slider_display_slider]" type="checkbox" value="1" <?php checked( 1, $value['cb_review_slider_display_slider'] ); ?>><?php _e( 'Display review slider', 'tcd-w' ); ?></label></p>
			<p><?php _e( 'Slide the article of custom post type "review".', 'tcd-w' ); ?></p>
  		<h4 class="theme_option_headline2"><?php _e( 'Archive link', 'tcd-w' ); ?></h4>
  		<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_review_slider_display_link]" type="checkbox" value="1" <?php checked( 1, $value['cb_review_slider_display_link'] ); ?>><?php _e( 'Display archive link', 'tcd-w' ); ?></label></p>
  		<p><label><?php _e( 'Link text', 'tcd-w' ); ?> <input class="regular-text" type="text" name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_review_slider_link_text]" value="<?php echo esc_attr( $value['cb_review_slider_link_text'] ); ?>"></label></p>
	<?php
	// フリーススペース ----------------------------------------------------------------------------------------
	} elseif ( 'wysiwyg' == $cb_content_select ) {

		if ( ! isset( $value['cb_wysiwyg_display'] ) ) {
			$value['cb_wysiwyg_display'] = null;
		}
		if ( ! isset( $value['cb_wysiwyg_editor'] ) ) {
			$value['cb_wysiwyg_editor'] = '';
		}
?>
    <h3 class="cb_content_headline"><span><?php _e( 'WYSIWYG editor', 'tcd-w' ); ?></span><a href="#"><?php _e( 'Open', 'tcd-w' ); ?></a></h3>
    <div class="cb_content">
			<p><label><input name="dp_options[contents_builder][<?php echo $cb_index; ?>][cb_wysiwyg_display]" type="checkbox" value="1" <?php checked( 1, $value['cb_wysiwyg_display'] ); ?>><?php _e( 'Display this content at top page', 'tcd-w' ); ?></label></p>
			<?php if ( preg_match( '/^cb_\d+$/', $cb_index ) ) : ?>
			<div class="theme_option_message">
				<p><?php _e( 'To make it a link to jump to this content, set URL of Custom Link in Menus to the following.', 'tcd-w' ); ?></p>
				<p><?php _e( 'ID:', 'tcd-w' ); ?> <input type="text" readonly="readonly" value="#<?php echo $cb_index; ?>"></p>
			</div>
			<?php endif; ?>
			<?php wp_editor( $value['cb_wysiwyg_editor'], 'cb_wysiwyg_editor-' . $cb_index, array( 'textarea_name' => 'dp_options[contents_builder][' . $cb_index . '][cb_wysiwyg_editor]', 'textarea_rows' => 10, 'editor_class' => 'change_content_headline' ) ); ?>
<?php
	} else {
?>
    <h3 class="cb_content_headline"><?php echo esc_html( $cb_content_select ); ?><a href="#"><?php _e('Open', 'tcd-w'); ?></a></h3>
    <div class="cb_content">
<?php
      }
?>
     <ul class="cb_content_button cf">
      <li><input type="submit" class="button-ml ajax_button" value="<?php echo __( 'Save Changes', 'tcd-w' ); ?>"></li>
      <li><a href="#" class="button-ml close-content"><?php echo __( 'Close', 'tcd-w' ); ?></a></li>
     </ul>

    </div><!-- END .cb_content -->
   </div><!-- END .cb_content_wrap -->
<?php
}
