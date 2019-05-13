<?php $options = get_desing_plus_option(); ?>
<?php if ( 'type1' == $options['header_content_type'] ) : // 画像スライダー ?>
	<div id="js-index-slider" class="p-index-slider">
		<?php 
		for ( $i = 1; $i <= 3; $i++ ) : 
			// 背景画像のないスライドはHTML生成しない
			if ( ! $options['slider_bg_image' . $i] ) { continue; }
			$slider_shadow1 = $options['slider' . $i . '_shadow1'] ? $options['slider' . $i . '_shadow1'] : 0;
			$slider_shadow2 = $options['slider' . $i . '_shadow2'] ? $options['slider' . $i . '_shadow2'] : 0;
			$slider_shadow3 = $options['slider' . $i . '_shadow3'] ? $options['slider' . $i . '_shadow3'] : 0;
			$slider_shadow4 = $options['slider' . $i . '_shadow_color'];
			$slider_headline_font_size = $options['slider_headline_font_size' . $i] ? $options['slider_headline_font_size' . $i] : 40;
			$slider_desc_font_size = $options['slider_desc_font_size' . $i] ? $options['slider_desc_font_size' . $i] : 16;
		?>	
		<div class="p-index-slider__item p-index-slider__item--<?php echo esc_attr( $options['slider_type' . $i] ); ?>" style="background-image: url(<?php echo esc_attr( wp_get_attachment_url( $options['slider_bg_image' . $i ] ) ); ?>)">
			<div class="p-index-slider__item-inner l-inner">
				<div class="p-index-slider__item-content">
					<div class="p-index-slider__item-catch" style="color: <?php echo esc_attr( $options['slider_font_color' . $i] ); ?>; font-size: <?php echo esc_attr( $slider_headline_font_size ); ?>px; text-shadow: <?php echo esc_attr( $slider_shadow1 ); ?>px <?php echo esc_attr( $slider_shadow2 ); ?>px <?php echo esc_attr( $slider_shadow3 ); ?>px <?php echo esc_attr( $slider_shadow4 ); ?>;"><?php echo nl2br( esc_html( $options['slider_headline' . $i] ) ); ?></div>
				<div class="p-index-slider__item-desc" style="color: <?php echo esc_attr( $options['slider_font_color' . $i] ); ?>; font-size: <?php echo esc_attr( $slider_desc_font_size ); ?>px;  text-shadow: <?php echo esc_attr( $slider_shadow1 ); ?>px <?php echo esc_attr( $slider_shadow2 ); ?>px <?php echo esc_attr( $slider_shadow3 ); ?>px <?php echo esc_attr( $slider_shadow4 ); ?>;"><p><?php echo nl2br( esc_html( $options['slider_desc' . $i] ) ); ?></p></div>
					<?php if ( $options['display_slider_button' . $i] ) : ?>
					<a class="p-index-slider__item-button p-button" href="<?php echo esc_url( $options['slider_url' . $i] ); ?>"<?php if ( $options['slider_target' . $i] ) { echo ' target="_blank"'; } ?>><?php echo esc_html( $options['slider_button_label' . $i] ); ?></a>
					<?php endif; ?>
				</div>				
				<?php if ( $options['slider_image' . $i] ) : ?>
				<?php if ( $options['slider_url' . $i] ) : ?>
				<a class="p-index-slider__item-image" href="<?php echo esc_url( $options['slider_url' . $i] ); ?>"<?php if ( $options['slider_target' . $i] ) { echo ' target="_blank"'; } ?>><img src="<?php echo esc_attr( wp_get_attachment_url( $options['slider_image' . $i] ) ); ?>" alt=""></a>
				<?php else : ?>
				<div class="p-index-slider__item-image"><img src="<?php echo esc_attr( wp_get_attachment_url( $options['slider_image' . $i] ) ); ?>" alt=""></div>
				<?php endif; endif; ?>
			</div>
		</div>
		<?php endfor; ?>
	</div>
<?php elseif ( 'type2' == $options['header_content_type'] ) : // 動画を背景に表示する ?>
	<?php 
	if ( ! wp_is_mobile() ) : // if is pc
		$video = $options['video'];
		if ( ! empty( $video ) ) : 
	?>
	<div id="js-header-video" class="p-header-video c-header-video">
		<?php
		    if($options['use_video_catch'] == 1 || $options['show_video_catch_button'] == 1) {
		      $catch = esc_html($options['video_catch']);
		      $font_size = $options['video_catch_font_size'];
		      $desc = esc_html($options['video_desc']);
		      $desc_font_size = $options['video_desc_font_size'];
		      $font_color = $options['video_catch_color'];
		      $shadow1 = $options['video_catch_shadow1'];
		      $shadow2 = $options['video_catch_shadow2'];
		      $shadow3 = $options['video_catch_shadow3'];
		      $shadow4 = $options['video_catch_shadow_color'];
		?>
		<div class="caption">
		<?php if($options['use_video_catch'] == 1){ ?><p class="title" style="font-size:<?php echo esc_html($font_size); ?>px; text-shadow:<?php echo esc_html($shadow1); ?>px <?php echo esc_html($shadow2); ?>px <?php echo esc_html($shadow3); ?>px <?php echo esc_html($shadow4); ?>; color:<?php echo esc_html($font_color); ?>;"><?php echo nl2br($catch); ?></p><?php }; ?>
		<p class="title desc" style="font-size:<?php echo esc_html($desc_font_size); ?>px; text-shadow:<?php echo esc_html($shadow1); ?>px <?php echo esc_html($shadow2); ?>px <?php echo esc_html($shadow3); ?>px <?php echo esc_html($shadow4); ?>; color:<?php echo esc_html($font_color); ?>;"><?php echo nl2br($desc); ?></p>
		<?php
		     if($options['show_video_catch_button'] == 1) {
		       $url = $options['video_button_url'];
		       $target = $options['video_button_target'];
		       $button_text = $options['video_catch_button'];
		?>
		<a class="button p-button" href="<?php echo esc_url($url); ?>"<?php if($target == 1) { echo ' target="_blank"'; }; ?>><?php echo esc_html($button_text); ?></a>
		<?php }; // END button ?>
		</div><!-- END .caption -->
		<?php }; // END catch ?>
		<div class="c-header-video__overlay"></div>
	</div>
	<?php 
		endif; 
	else : // if is mobile device
		$video_image = wp_get_attachment_image_src( $options['video_image'], 'full' );
	?>
	<div class="p-header-video c-header-video" style="background-image: url(<?php echo $video_image[0]; ?>);">
	    <?php
	         if($options['use_video_catch'] == 1 || $options['show_video_catch_button'] == 1) {
	           $catch = esc_html($options['video_catch']);
	           $font_size = $options['video_catch_font_size'];
	           $desc = esc_html($options['video_desc']);
	           $desc_font_size = $options['video_desc_font_size'];
	           $font_color = $options['video_catch_color'];
	           $shadow1 = $options['video_catch_shadow1'];
	           $shadow2 = $options['video_catch_shadow2'];
	           $shadow3 = $options['video_catch_shadow3'];
	           $shadow4 = $options['video_catch_shadow_color'];
	    ?>
	    <div class="caption">
	     <?php if($options['use_video_catch'] == 1){ ?><p class="title" style="font-size:<?php echo esc_html($font_size); ?>px; text-shadow:<?php echo esc_html($shadow1); ?>px <?php echo esc_html($shadow2); ?>px <?php echo esc_html($shadow3); ?>px <?php echo esc_html($shadow4); ?>; color:<?php echo esc_html($font_color); ?>;"><?php echo nl2br($catch); ?></p><?php }; ?>
	     <p class="title desc" style="font-size:<?php echo esc_html($desc_font_size); ?>px; text-shadow:<?php echo esc_html($shadow1); ?>px <?php echo esc_html($shadow2); ?>px <?php echo esc_html($shadow3); ?>px <?php echo esc_html($shadow4); ?>; color:<?php echo esc_html($font_color); ?>;"><?php echo nl2br($desc); ?></p>
	     <?php
	          if($options['show_video_catch_button'] == 1) {
	            $url = $options['video_button_url'];
	            $target = $options['video_button_target'];
	            $button_text = $options['video_catch_button'];
	     ?>
	     <a class="button p-button" href="<?php echo esc_url($url); ?>"<?php if($target == 1) { echo ' target="_blank"'; }; ?>><?php echo esc_html($button_text); ?></a>
	     <?php }; // END button ?>
	    </div><!-- END .caption -->
	    <?php }; // END catch ?>
	    <div class="c-header-video__overlay"></div>
	</div>
	<?php endif; ?>
<?php else : // Youtubeの動画を背景に表示する ?>
	<?php
	if ( ! wp_is_mobile() ) : // if is pc
		$youtube_url = $options['youtube_url'];
		if ( ! empty( $youtube_url ) ) :
?>
	<div id="js-header-youtube" class="p-header-youtube c-header-youtube">
		<?php
		    if($options['use_video_catch'] == 1 || $options['show_video_catch_button'] == 1) {
		      $catch = esc_html($options['video_catch']);
		      $font_size = $options['video_catch_font_size'];
		      $desc = esc_html($options['video_desc']);
		      $desc_font_size = $options['video_desc_font_size'];
		      $font_color = $options['video_catch_color'];
		      $shadow1 = $options['video_catch_shadow1'];
		      $shadow2 = $options['video_catch_shadow2'];
		      $shadow3 = $options['video_catch_shadow3'];
		      $shadow4 = $options['video_catch_shadow_color'];
		?>
		<div class="caption">
		<?php if($options['use_video_catch'] == 1){ ?><p class="title" style="font-size:<?php echo esc_html($font_size); ?>px; text-shadow:<?php echo esc_html($shadow1); ?>px <?php echo esc_html($shadow2); ?>px <?php echo esc_html($shadow3); ?>px <?php echo esc_html($shadow4); ?>; color:<?php echo esc_html($font_color); ?>;"><?php echo nl2br($catch); ?></p><?php }; ?>
		<p class="title desc" style="font-size:<?php echo esc_html($desc_font_size); ?>px; text-shadow:<?php echo esc_html($shadow1); ?>px <?php echo esc_html($shadow2); ?>px <?php echo esc_html($shadow3); ?>px <?php echo esc_html($shadow4); ?>; color:<?php echo esc_html($font_color); ?>;"><?php echo nl2br($desc); ?></p>
		<?php
		     if($options['show_video_catch_button'] == 1) {
		       $url = $options['video_button_url'];
		       $target = $options['video_button_target'];
		       $button_text = $options['video_catch_button'];
		?>
		<a class="button p-button" href="<?php echo esc_url($url); ?>"<?php if($target == 1) { echo ' target="_blank"'; }; ?>><?php echo esc_html($button_text); ?></a>
		<?php }; // END button ?>
		</div><!-- END .caption -->
		<?php }; // END catch ?>
		<div class="c-header-youtube__overlay"></div>
	</div>
	<div id="js-youtube-video-player" class="player" data-property="{videoURL:'<?php echo esc_url( $youtube_url ); ?>',containment:'#js-header-youtube',startAt:0,mute:true,autoPlay:true,loop:true,opacity:1}"></div>
<?php
		endif;
	else : // if is mobile device
		$youtube_image = wp_get_attachment_image_src( $options['youtube_image'], 'full' );
?>
	<div class="p-header-youtube c-header-youtube" style="background-image: url(<?php echo $youtube_image[0]; ?>);">
	    <?php
	         if($options['use_video_catch'] == 1 || $options['show_video_catch_button'] == 1) {
	           $catch = esc_html($options['video_catch']);
	           $font_size = $options['video_catch_font_size'];
	           $desc = esc_html($options['video_desc']);
	           $desc_font_size = $options['video_desc_font_size'];
	           $font_color = $options['video_catch_color'];
	           $shadow1 = $options['video_catch_shadow1'];
	           $shadow2 = $options['video_catch_shadow2'];
	           $shadow3 = $options['video_catch_shadow3'];
	           $shadow4 = $options['video_catch_shadow_color'];
	    ?>
	    <div class="caption">
	     <?php if($options['use_video_catch'] == 1){ ?><p class="title" style="font-size:<?php echo esc_html($font_size); ?>px; text-shadow:<?php echo esc_html($shadow1); ?>px <?php echo esc_html($shadow2); ?>px <?php echo esc_html($shadow3); ?>px <?php echo esc_html($shadow4); ?>; color:<?php echo esc_html($font_color); ?>;"><?php echo nl2br($catch); ?></p><?php }; ?>
	     <p class="title desc" style="font-size:<?php echo esc_html($desc_font_size); ?>px; text-shadow:<?php echo esc_html($shadow1); ?>px <?php echo esc_html($shadow2); ?>px <?php echo esc_html($shadow3); ?>px <?php echo esc_html($shadow4); ?>; color:<?php echo esc_html($font_color); ?>;"><?php echo nl2br($desc); ?></p>
	     <?php
	          if($options['show_video_catch_button'] == 1) {
	            $url = $options['video_button_url'];
	            $target = $options['video_button_target'];
	            $button_text = $options['video_catch_button'];
	     ?>
	     <a class="button p-button" href="<?php echo esc_url($url); ?>"<?php if($target == 1) { echo ' target="_blank"'; }; ?>><?php echo esc_html($button_text); ?></a>
	     <?php }; // END button ?>
	    </div><!-- END .caption -->
	    <?php }; // END catch ?>
	    <div class="c-header-youtube__overlay"></div>
	</div>
	<?php endif; ?>
<?php endif; ?>
