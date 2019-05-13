<?php
if ( is_home() ) :
	if ( is_mobile() ) :
		if ( is_active_sidebar( 'archive_widget_mobile' ) ) :
	?>
		<section class="p-widget-area">
			<div class="p-widget-area__inner l-inner u-clearfix">
				<div class="p-widget-area__column">
					<?php dynamic_sidebar( 'archive_widget_mobile' ); ?>
	    	</div>
			</div>
		</section>
	<?php
		endif;
	else :
		if ( is_active_sidebar( 'archive_widget_left' ) || is_active_sidebar( 'archive_widget_center' ) || is_active_sidebar( 'archive_widget_right' ) ) :
	?>
		<section class="p-widget-area">
			<div class="p-widget-area__inner l-inner u-clearfix">
				<div class="p-widget-area__column">
					<?php dynamic_sidebar( 'archive_widget_left' ); ?>
	    	</div>
				<div class="p-widget-area__column">
					<?php dynamic_sidebar( 'archive_widget_center' ); ?>
	      </div>
				<div class="p-widget-area__column">
					<?php dynamic_sidebar( 'archive_widget_right' ); ?>
	    	</div>
			</div>
		</section>
	<?php
		endif;
	endif;
elseif ( is_single() ) :
	if ( is_mobile() ) :
		if ( is_active_sidebar( 'post_widget_mobile' ) ) :
	?>
		<section class="p-widget-area">
			<div class="p-widget-area__inner l-inner u-clearfix">
				<div class="p-widget-area__column">
					<?php dynamic_sidebar( 'post_widget_mobile' ); ?>
	    	</div>
			</div>
		</section>
	<?php
		endif;
	else :
		if ( is_active_sidebar( 'post_widget_left' ) || is_active_sidebar( 'post_widget_center' ) || is_active_sidebar( 'post_widget_right' ) ) :
	?>
		<section class="p-widget-area">
			<div class="p-widget-area__inner l-inner u-clearfix">
				<div class="p-widget-area__column">
					<?php dynamic_sidebar( 'post_widget_left' ); ?>
	    	</div>
				<div class="p-widget-area__column">
					<?php dynamic_sidebar( 'post_widget_center' ); ?>
	      </div>
				<div class="p-widget-area__column">
					<?php dynamic_sidebar( 'post_widget_right' ); ?>
	    	</div>
			</div>
		</section>
	<?php
		endif;
	endif;
endif;
?>
