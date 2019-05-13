<?php
/**
 * Archive list (tcd ver)
 */
class Tcdw_Archive_List_Widget extends WP_Widget {

	function __construct() {
		parent::__construct(
			'tcdw_archive_list_widget', // ID
			__( 'Archive list (tcd ver)', 'tcd-w' ), // Name
			array( 
				'classname' => 'tcdw_archive_list_widget',
				'discription' => __( 'Displays designed archive dropdown menu.', 'tcd-w' ) 
			)
		);
	}

	function widget( $args, $instance ) {
		
		extract( $args );
		
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		
		if ( $title ) { 
			echo $before_title . $title . $after_title; 
		}
		?>
		<div class="p-widget-dropdown">
    	<select onChange='document.location.href=this.options[this.selectedIndex].value;'>
      	<option>ARCHIVES</option>
				<?php wp_get_archives( 'type=monthly&format=option&show_post_count=1' ); ?>
     	</select>
    </div>
		<?php
   	echo $after_widget;
	}

	function form( $instance ) {
	
		$title = isset( $instance['title'] ) ? $instance['title'] : '';	
?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'tcd-w' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>'" type="text" value="<?php echo esc_attr( $title ); ?>">
		</p>
<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['title'] = strip_tags( $new_instance['title'] );
		return $instance;
	}

}

function register_tcds_archive_list_widget() {
	register_widget( 'Tcdw_Archive_List_Widget' );
}
add_action( 'widgets_init', 'register_tcds_archive_list_widget' );
