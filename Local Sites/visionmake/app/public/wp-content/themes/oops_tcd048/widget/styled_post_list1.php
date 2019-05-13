<?php
/**
 * Styled post list (tcd ver)
 */
class Styled_Post_List1_widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'styled_post_list1_widget', // ID
			__( 'Styled post list (tcd ver)', 'tcd-w' ), // Name
			array(
				'classname' => 'styled_post_list1_widget',
				'description' => __( 'Displays styled post list.', 'tcd-w' )
			)
		);
	}

	function widget( $args, $instance ) {

		extract( $args );

		$title = apply_filters( 'widget_title', $instance['title'] );
   	$post_type = $instance['post_type'];
		$post_num = $instance['post_num'];
   	$show_date = $instance['show_date'];
   	$post_order = $instance['post_order'];

   	if ( 'date2' == $post_order ) {
			$order = 'ASC'; 
		} else { 
			$order = 'DESC'; 
		}
   	if ( $post_order == 'date1' || $post_order == 'date2' ) { 
			$post_order = 'date'; 
		}

   	echo $before_widget;
   	
		if ( $title ) { 
			echo $before_title . $title . $after_title; 
		}

   	if ( 'recent_post' == $post_type ) {
    	$args = array(
				'post_type' => 'post', 
				'posts_per_page' => $post_num, 
				'ignore_sticky_posts' => 1, 
				'orderby' => $post_order, 
				'order' => $order
			);
   	} else {
     	$args = array(
				'post_type' => 'post', 
				'posts_per_page' => $post_num, 
				'ignore_sticky_posts' => 1, 
				'orderby' => $post_order, 
				'order' => $order, 
				'meta_key' => $post_type, 
				'meta_value' => 'on'
			);
   	}
   	$post_list= new WP_Query( $args );
		?>
		<ul class="p-widget-list">
		<?php
   	if ( $post_list->have_posts() ) :
    	while ( $post_list->have_posts() ) : 
				$post_list->the_post();
		?>
			<li class="p-widget-list__item">
				<a href="<?php the_permalink() ?>">
    			<?php if ( $show_date ) : ?>
						<time class="p-widget-list__item-date" datetime="<?php the_time( 'Y-m-d' ); ?>"><?php the_time( 'Y.m.d' ); ?></time>
					<?php endif; ?>
					<?php echo wp_trim_words( get_the_title(), 28, '...' ); ?>
				</a>
 			</li>
		<?php 
			endwhile;
			wp_reset_postdata();
		else :
		?>
			<li class="no_post"><?php _e( 'There is no registered post.', 'tcd-w' ); ?></li>
		<?php endif; ?>
		</ul>
		<?php
   	echo $after_widget;		
	} 

	function form( $instance ) {
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$post_num = ! empty( $instance['post_num'] ) ? $instance['post_num'] : 5;
		$post_order = ! empty( $instance['post_order'] ) ? $instance['post_order'] : 'date1';
		$post_type = ! empty( $instance['post_type'] ) ? $instance['post_type'] : 'recent_post';
		$show_date = ! empty( $instance['show_date'] ) ? $instance['show_date'] : 0;
	?>
	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tcd-w' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>'" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_type' ); ?>"><?php _e( 'Post type:', 'tcd-w' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'post_type'); ?>" name="<?php echo $this->get_field_name( 'post_type' ); ?>" class="widefat">
				<option value="recent_post" <?php selected( $post_type, 'recent_post' ); ?>><?php _e( 'Recent post', 'tcd-w' ); ?></option>
				<option value="recommend_post" <?php selected( $post_type, 'recommend_post' ); ?>><?php _e( 'Recommend post', 'tcd-w' ); ?></option>
				<option value="recommend_post2" <?php selected( $post_type, 'recommend_post2' ); ?>><?php _e( 'Recommend post2', 'tcd-w' ); ?></option>
				<option value="recommend_post3" <?php selected( $post_type, 'recommend_post3' ); ?>><?php _e( 'Recommend post3', 'tcd-w' ); ?></option>
			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_num' ); ?>"><?php _e( 'Number of post:', 'tcd-w' ); ?></label>
			<select id="<?php echo $this->get_field_id( 'post_num' ); ?>" name="<?php echo $this->get_field_name( 'post_num' ); ?>" class="widefat">
				<?php
				for ( $i = 1; $i <= 10; $i++ ) {
					echo '<option value="' . $i . '" ' . selected( $post_num, $i ) . '>' . $i . '</option>' . "\n"; 
				}
				?>
 			</select>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'post_order' ); ?>"><?php _e( 'Post order:', 'tcd-w' ); ?></label>
 			<select id="<?php echo $this->get_field_id( 'post_order' ); ?>" name="<?php echo $this->get_field_name( 'post_order' ); ?>" class="widefat">
				<option value="date1" <?php selected( $post_order, 'date1' ); ?>><?php _e( 'Date (DESC)', 'tcd-w' ); ?></option>
  				<option value="date2" <?php selected( $post_order, 'date2' ); ?>><?php _e( 'Date (ASC)', 'tcd-w' ); ?></option>
  				<option value="rand" <?php selected( $post_order, 'rand' ); ?>><?php _e( 'Random', 'tcd-w' ); ?></option>
			</select>
		</p>
		<p>
			<input id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>" type="checkbox" value="1" <?php checked( $show_date, 1 ); ?>>
 			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display date', 'tcd-w' ); ?></label>
		</p>
		<?php
 	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['post_num'] = strip_tags( $new_instance['post_num'] );
		$instance['post_order'] = strip_tags( $new_instance['post_order'] );
  	$instance['post_type'] = strip_tags( $new_instance['post_type'] );
		$instance['show_date'] = strip_tags( $new_instance['show_date'] );
		return $instance;
	}
}

add_action( 'widgets_init', function() {
	register_widget( 'Styled_Post_List1_Widget' );
});
