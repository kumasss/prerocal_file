<?php
/**
 * カスタムカラムを追加する（ID、アイキャッチ画像）
 */
function manage_columns( $columns ) {

	// IDカラムとアイキャッチ画像カラムを加えた、新しいカラム配列を作成
	$new_columns = array();

	foreach ( $columns as $column_name => $column_display_name ) {
		// title カラムの前に post_id カラムを追加
		if ( isset( $columns['title'] ) && $column_name == 'title' ) {
			$new_columns['post_id'] = 'ID';
		}
		$new_columns[$column_name] = $column_display_name;
	}

	// アイキャッチ画像を追加
	$new_columns['new_post_thumb'] = __( 'Featured Image', 'tcd-w' );

	return $new_columns;
}
add_filter( 'manage_post_posts_columns', 'manage_columns', 5 ); // 投稿
add_filter( 'manage_news_posts_columns', 'manage_columns', 5 ); // ニュース
add_filter( 'manage_page_posts_columns', 'manage_columns', 5 ); // 固定ページ

/**
 * カスタムカラムを追加する（おすすめ記事）
 */
function manage_post_posts_columns( $columns ) {
	$columns['recommend_post'] = __( 'Recommend post', 'tcd-w' );
	return $columns;
}
add_filter( 'manage_post_posts_columns', 'manage_post_posts_columns' ); // 投稿のみ

/**
 * カスタムカラムを追加する（ID、トップページに表示する）
 */
function manage_review_posts_columns( $columns ) {

	// IDカラムとアイキャッチ画像カラムを加えた、新しいカラム配列を作成
	$new_columns = array();

	foreach ( $columns as $column_name => $column_display_name ) {
		// title カラムの前に post_id カラムを追加
		if ( isset( $columns['title'] ) && $column_name == 'title' ) {
			$new_columns['post_id'] = 'ID';
		}
		$new_columns[$column_name] = $column_display_name;
	}

	// トップページに表示する
	$new_columns['display_on_front'] = __( 'Display on front page', 'tcd-w' );
	return $new_columns;
}
add_filter( 'manage_review_posts_columns', 'manage_review_posts_columns' ); // レビューのみ

/**
 * カスタムカラムに内容を出力する（ID、アイキャッチ画像、おすすめ記事）
 */
function add_column( $column_name, $post_id ) {

	switch ( $column_name ) {
		
		// ID
		case 'post_id' :
			echo $post_id;
			break;

		// アイキャッチ画像
		case 'new_post_thumb' :
    	$post_thumbnail_id = get_post_thumbnail_id( $post_id );
      if ( $post_thumbnail_id ) {
        $post_thumbnail_img = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail' );
        echo '<img width="70" src="' . $post_thumbnail_img[0] . '">';
      }
			break;

		// おすすめ記事
	 	case 'recommend_post' :
			if ( get_post_meta( $post_id, 'recommend_post', true ) ) { _e( 'Recommend post1<br />', 'tcd-w' ); }
		  if ( get_post_meta( $post_id, 'recommend_post2', true ) ) { _e( 'Recommend post2', 'tcd-w' ); }
		  if ( get_post_meta( $post_id, 'recommend_post3', true ) ) { _e( 'Recommend post3', 'tcd-w' ); }
      break;

		// トップページに表示する
	 	case 'display_on_front' :
		  if ( get_post_meta( $post_id, 'display_on_front', true ) ) { _e( 'Display on front page', 'tcd-w' ); }
      break;
	}
}
add_action( 'manage_posts_custom_column', 'add_column', 10, 2 ); // 投稿、ニュース、レビュー
add_action( 'manage_pages_custom_column', 'add_column', 10, 2 ); // 固定ページ

/**
 * ID カラムをソート可能にする
 */
function custom_quick_edit_sortable_columns( $sortable_columns ) {
	$sortable_columns['post_id'] = 'ID';
	return $sortable_columns;
}
add_filter( 'manage_edit-post_sortable_columns', 'custom_quick_edit_sortable_columns' ); // 投稿
add_filter( 'manage_edit-news_sortable_columns', 'custom_quick_edit_sortable_columns' ); // ニュース
add_filter( 'manage_edit-review_sortable_columns', 'custom_quick_edit_sortable_columns' ); // レビュー
add_filter( 'manage_edit-page_sortable_columns', 'custom_quick_edit_sortable_columns' ); // 固定ページ
