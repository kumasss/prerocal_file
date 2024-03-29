<?php
/**
 * Show custom fields in quick edit
 */
function custom_quick_edit( $column_name, $post_type ) {

	// クイック編集項目と $column_name と同じではないため一致していないため一度だけ出力させる
	static $print_nonce = true;
	if ( $print_nonce ) :
  	$print_nonce = false;

		// seo
  	if ( in_array( $post_type, array( 'post', 'page', 'news' ) ) ) :
			wp_nonce_field( 'seo.php', 'seo_meta_box_nonce' );
?>
<fieldset class="inline-edit-col-left clear">
	<div class="inline-edit-col column-meta-seo">
		<div class="inline-edit-group">
			<label class="inline-edit-tcd-w_meta_title">
      	<span class="title"><?php _e( 'Meta title', 'tcd-w' ); ?></span>
        <span class="input-text-wrap"><input type="text" name="tcd-w_meta_title" value=""></span>
      </label>
      <label class="inline-edit-tcd-w_meta_description">
        <span class="title"><?php _e( 'Meta description', 'tcd-w' ); ?></span>
        <span class="input-text-wrap"><textarea name="tcd-w_meta_description" rows="2" cols="30"></textarea></span>
    	</label>
  	</div>
</fieldset>
<?php
		endif;
  	if ( 'post' == $post_type ) :
			wp_nonce_field( 'recommend.php', 'recommend_post_meta_box_nonce' );
?>
<fieldset class="inline-edit-col-right">
	<div class="inline-edit-col column-recommend">
		<div class="inline-edit-group">
    	<label><input type="checkbox" name="recommend_post" value="on"><?php _e( 'Show this post for recommend post.', 'tcd-w' ); ?></label>
     	<label><input type="checkbox" name="recommend_post2" value="on"><?php _e( 'Show this post for recommend post2.', 'tcd-w' ); ?></label>
     	<label><input type="checkbox" name="recommend_post3" value="on"><?php _e( 'Show this post for recommend post3.', 'tcd-w' ); ?></label>
    	</div>
  	</div>
</fieldset>
<?php
		endif;
  	if ( 'review' == $post_type ) :
			wp_nonce_field( 'save_review_meta_box', 'review_meta_box_nonce' );
?>
<fieldset class="inline-edit-col-right">
	<div class="inline-edit-col">
		<div class="inline-edit-group">
    	<label><input type="checkbox" name="display_on_front" value="on"><?php _e( 'Display on front page', 'tcd-w' ); ?></label>
    	</div>
  	</div>
</fieldset>
<?php
		endif;
  endif;
}
add_action( 'quick_edit_custom_box', 'custom_quick_edit', 10, 2 );

// クイック編集用 js
function custom_quick_edit_js() {
?>
<script type="text/javascript">
jQuery(document).ready(function($){
	var $wp_inline_edit = inlineEditPost.edit;
  	inlineEditPost.edit = function(id) {
    	$wp_inline_edit.apply(this, arguments);
    	var $post_id = 0;
    	if (typeof(id) == 'object') {
    		$post_id = parseInt(this.getId(id));
    	}
    	if ($post_id > 0) {

    		var $edit_row = $('#edit-' + $post_id);
      	var $post_row = $('#post-' + $post_id);
      	
				$post_row.find('.custom_quick_edit_values > div > div').each(function(){
        	var key = $(this).attr('class');
       		var value = $(this).text();
        	var $input = $edit_row.find('[name="' + key + '"]');
       		if ($input.is('textarea')) {
          	$input.html(value);
        	} else if ($input.attr('type') == 'checkbox') {
          	if (value) {
            	$input.attr('checked', 'checked');
         		} else {
            	$input.removeAttr('checked');
          	}
        	} else {
          	$input.val(value);
        	}
      	});
    	}
  	};
<?php /* 行アクションの最後に不要な「 | 」が表示されるため削除 */  ?>
	var prev_pipe_delete = function () {
  	$('.row-actions .custom_quick_edit_values:not(.prev_pipe_deleted)').each(function(){
    	var $prev = $(this).prev();
     	$prev.html($prev.html().replace(/ \| $/, ''));
      $(this).addClass('prev_pipe_deleted');
    });
  };
  $('.wp-list-table').on('click', 'a.editinline', function(){
  	setInterval(prev_pipe_delete, 5000);
  });
  prev_pipe_delete();
});
</script>
<style>
.widefat th.column-post_id, .widefat td.column-post_id { padding-left:0; padding-right:0; width:2.75em; }
th.sortable.column-post_id a, th.sorted.column-post_id a { padding-left:0; padding-right:0; }
</style>
<?php
}
add_action( 'admin_footer-edit.php', 'custom_quick_edit_js' );

// クイック編集用でフォームに差し込む値
// get_inline_data にはフィルターがないため post_row_actions で処理
function custom_quick_edit_values( $actions, $post ) {
	$meta_keys = array();

	// seo
  if ( in_array( $post->post_type, array( 'post', 'page', 'news', 'review' ) ) ) {
		$meta_keys = array_merge( $meta_keys, array( 'tcd-w_meta_title', 'tcd-w_meta_description' ) );
	}

	// recommend
  if ( $post->post_type == 'post' ) {
		$meta_keys = array_merge( $meta_keys,  array( 'recommend_post', 'recommend_post2', 'recommend_post3' ) );
	}

	// review
  if ( $post->post_type == 'review' ) {
		$meta_keys = array_merge( $meta_keys,  array( 'display_on_front' ) );
	}

	if ( $meta_keys ) {
		$output = '';
		foreach( $meta_keys as $meta_key ) {
			$output .= '<div class="' . esc_attr( $meta_key ) . '">' . esc_html( get_post_meta( $post->ID, $meta_key, true ) ) . '</div>';
		}
		if ( $output ) {
			$actions['custom_quick_edit_values'] = '<div class="hidden">' . $output . '</div>';
		}
	}
	return $actions;
}
add_action( 'post_row_actions', 'custom_quick_edit_values', 99, 2 );
add_action( 'page_row_actions', 'custom_quick_edit_values', 99, 2 );
