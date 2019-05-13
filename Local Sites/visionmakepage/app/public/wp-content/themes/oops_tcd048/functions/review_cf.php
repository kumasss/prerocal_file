<?php
function review_meta_box() {
	add_meta_box( 
		'review_meta_box', 
		__( 'Settings for review page', 'tcd-w' ), 
		'show_review_meta_box', 
		'review', 
		'normal', 
		'high'
	);
}
add_action( 'add_meta_boxes', 'review_meta_box' );

function show_review_meta_box( $post ) {

	// Display on front page
  $display_on_front = array( 
		'name' => __( 'Display on front page', 'tcd-w' ),
		'desc' => '', 
		'id' => 'display_on_front', 
		'type' => 'checkbox', 
		'std' => '' 
	);
	$display_on_front_meta = $post->display_on_front;

	// Display link button
  $display_review_button = array( 
		'name' => __( 'Display link button to this post in archive page', 'tcd-w' ),
		'desc' => '', 
		'id' => 'display_review_button', 
		'type' => 'checkbox', 
		'std' => '' 
	);
	$display_review_button_meta = $post->display_review_button;

	// Name
  $review_name = array( 
		'name' => __( 'Name', 'tcd-w' ),
		'desc' => '', 
		'id' => 'review_name', 
		'type' => 'input', 
		'std' => '' 
	);
	$review_name_meta = $post->review_name;

	// Job
  $review_job = array( 
		'name' => __( 'Job', 'tcd-w' ),
		'desc' => '', 
		'id' => 'review_job', 
		'type' => 'input', 
		'std' => '' 
	);
	$review_job_meta = $post->review_job;

	// Image
  $review_portrait = array( 
		'name' => __( 'Portrait', 'tcd-w' ),
		'desc' => __( 'Recommended size: width:320px, height:320px', 'tcd-w' ), 
		'id' => 'review_portrait', 
		'type' => 'image', 
		'std' => '' 
	);
	$review_portrait_meta = $post->review_portrait;

	wp_nonce_field( 'save_review_meta_box', 'review_meta_box_nonce' );

	echo '<dl class="ml_custom_fields">' , "\n";

  // Display Settings
 	echo '<dt class="label">' , __( 'Display settings', 'tcd-w' ) , '</dt>', "\n";
  echo '<dd class="content">' , "\n";
	echo '<p><label><input type="checkbox" value="1" name="' , esc_attr( $display_on_front['id'] ) , '" ' , checked( $display_on_front_meta, 1, false ) , '>' , esc_html( $display_on_front['name'] ) , '</label></p>';
	echo '<p><label><input type="checkbox" value="1" name="' , esc_attr( $display_review_button['id'] ) , '" ' , checked( $display_review_button_meta, 1, false ) , '>' , esc_html( $display_review_button['name'] ) , '</label></p>';
  echo "</dd>\n";

	// Name
	echo '<dt class="label"><label for="' , esc_attr( $review_name['id'] ) , '">' , esc_html( $review_name['name'] ) , '</label></dt>' , "\n";
	echo '<dd class="content"><input type="text" name="' , esc_attr( $review_name['id'] ) , '" id="' , esc_attr( $review_name['id'] ) , '" class="widefat" value="' , $review_name_meta ? esc_attr( $review_name_meta ) : esc_attr( $review_name['std'] ), '"></dd>' , "\n";

	// Job
	echo '<dt class="label"><label for="' , esc_attr( $review_job['id'] ) , '">' , esc_html( $review_job['name'] ) , '</label></dt>' , "\n";
	echo '<dd class="content"><input type="text" name="' , esc_attr( $review_job['id'] ) , '" id="' , esc_attr( $review_job['id'] ) , '" class="widefat" value="' , $review_job_meta ? esc_attr( $review_job_meta ) : esc_attr( $review_job['std'] ), '"></dd>' , "\n";

	// Portrait
	echo '<dt class="label"><label for="' , esc_attr( $review_portrait['id'] ) , '">' , esc_html( $review_portrait['name'] ) , '</label></dt>' , "\n";
	echo '<dd class="content">' , "\n";
	echo '<p>' , esc_html( $review_portrait['desc'] ) , '<p>' , "\n";
	echo '<div class="cf cf_media_field hide-if-no-js">';
  echo '<input type="hidden" class="cf_media_id" name="' , esc_attr( $review_portrait['id'] ) , '" id="' , esc_attr( $review_portrait['id'] ) , '" value="' , esc_attr( $review_portrait_meta ), '">' , "\n";
  echo '<div class="preview_field">' , $review_portrait_meta ? wp_get_attachment_image( $review_portrait_meta, 'medium' ) : '' , '</div>' , "\n";
	echo '<div class="button_area">' , "\n";
  echo '<input type="button" class="cfmf-select-img button" value="' , __( 'Select Image', 'tcd-w' ) , '">' , "\n";
  echo '<input type="button" class="cfmf-delete-img button' , ! $review_portrait_meta ? ' hidden' : '' , '" value="' , __( 'Remove Image', 'tcd-w' ) , '">' , "\n";
  echo '</div>' , "\n";
  echo '</div>' , "\n";
	echo '</dd>' , "\n";

  echo '</dl>';
}

function save_review_meta_box( $post_id ) {

	// Check if our nonce is set.
	if ( ! isset( $_POST['review_meta_box_nonce'] ) ) return;

	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['review_meta_box_nonce'], 'save_review_meta_box'  ) ) {
  	return $post_id;
  }

  // check autosave
  if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
    return $post_id;
 	}

  // check permissions
  if ( ! current_user_can( 'edit_post', $post_id ) ) {
  	return $post_id;
  }

  // save or delete
  $cf_keys = array( 
		'display_on_front', 
		'display_review_button', 
		'review_name', 
		'review_job', 
		'review_portrait' 
	);

  foreach ( $cf_keys as $cf_key ) {

  	$old = get_post_meta( $post_id, $cf_key, true );
		$new = isset( $_POST[$cf_key] ) ? $_POST[$cf_key] : '';

    if ( $new && $new != $old ) {
   		update_post_meta( $post_id, $cf_key, $new );
    } elseif ( '' == $new && $old ) {
     	delete_post_meta( $post_id, $cf_key, $old );
    }	
  }
}
add_action( 'save_post', 'save_review_meta_box' );
