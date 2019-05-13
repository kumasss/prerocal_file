<?php
/**
 * The template for displaying the footer.
 *
 * Contains footer content and the closing of the
 * #main and #page div elements.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
 global $post;
 $theme_options = get_theme_options();
 $footer_target = get_field('footer_target', $post->ID) ?: 'blank';
 $footer_target = '_'.$footer_target;
?>
	</div><!-- #main .wrapper -->

<?php if( get_field('footer_enable', $post->ID) != 'off' ) : ?>
<?php if( get_field('footer_enable', $post->ID) != 'sp' || wp_is_mobile() ) : ?>
<?php if( get_field('footer_code', $post->ID) ) : ?>
<div class="btn-footer <?php echo get_field('footer_position', $post->ID); ?>">
<?php echo get_field('footer_code', $post->ID); ?>
</div>
<?php elseif( get_field('footer_image', $post->ID) ) : ?>
<?php $footer_image = wp_get_attachment_image_src( get_field('footer_image', $post->ID), 'full' ); ?>
<div class="btn-footer <?php echo get_field('footer_position', $post->ID); ?>">
<a href="<?php echo get_field('footer_url', $post->ID); ?>" target="<?php echo $footer_target; ?>"><img src="<?php echo $footer_image[0]; ?>" width="<?php echo $footer_image[1]; ?>" height="<?php echo $footer_image[2]; ?>" alt="<?php echo get_field('footer_text', $post->ID); ?>"></a>
</div>
<?php elseif( get_field('footer_text', $post->ID) ) : ?>
<div class="btn-footer <?php echo get_field('footer_position', $post->ID); ?>">
<p class="<?php echo get_field('footer_class', $post->ID); ?>"><a href="<?php echo get_field('footer_url', $post->ID); ?>" target="<?php echo $footer_target; ?>"><?php echo get_field('footer_text', $post->ID); ?></a></p>
</div>
<?php endif; ?>
<?php endif; ?>
<?php endif; ?>

<footer>
		<div class="site-info">
			 <?php do_action( 'twentytwelve_credits' ); ?> 
		<!--	<a href="<?php echo esc_url( __( 'http://wordpress.org/', 'twentytwelve' ) ); ?>" title="<?php esc_attr_e( 'Semantic Personal Publishing Platform', 'twentytwelve' ); ?>"><?php printf( __( 'Proudly powered by %s', 'twentytwelve' ), 'WordPress' ); ?></a>-->
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php if( is_home() || is_singular('post') || is_archive() || is_search() ) : ?>
	<?php if( $theme_options['footer_content'] > 0 ) : ?>
	<footer id="footer">
	<?php
	  $post = get_post($theme_options['footer_content']);
	  setup_postdata($post);
	?>
	<iframe src="<?php the_permalink(); ?>" width="100%" scrolling="no" frameBorder="0"></iframe>
	<?php wp_reset_postdata(); ?>
	</footer><!-- #footer -->
	<?php endif; ?>

	<?php if( $theme_options['footer_content'] == -1 ) : ?>
	<footer id="footer" class="widget-template clear">
		<?php if ( is_active_sidebar( 'footer-1' ) ) : ?><div class="widget-area"><?php dynamic_sidebar( 'footer-1' ); ?></div><?php endif; ?>
		<?php if ( is_active_sidebar( 'footer-2' ) ) : ?><div class="widget-area"><?php dynamic_sidebar( 'footer-2' ); ?></div><?php endif; ?>
		<?php if ( is_active_sidebar( 'footer-3' ) ) : ?><div class="widget-area"><?php dynamic_sidebar( 'footer-3' ); ?></div><?php endif; ?>
	</footer><!-- #footer -->
	<?php endif; ?>
<?php elseif( is_page() ) : ?>
	<?php if( (get_field('entire_hf_enable', $post->ID) === 'on' || $theme_options['all_enable'] === 'on') && $theme_options['footer_content'] > 0 ) : ?>
	<footer id="footer">
	<?php
	  $post = get_post($theme_options['footer_content']);
	  setup_postdata($post);
	?>
	<iframe src="<?php the_permalink(); ?>" width="100%" scrolling="no" frameBorder="0"></iframe>
	<?php wp_reset_postdata(); ?>
	</footer><!-- #footer -->
	<?php endif; ?>

	<?php if( (get_field('entire_hf_enable', $post->ID) === 'on' || $theme_options['all_enable'] === 'on') && $theme_options['footer_content'] == -1 ) : ?>
	<footer id="footer" class="widget-template clear">
		<?php if ( is_active_sidebar( 'footer-1' ) ) : ?><div class="widget-area"><?php dynamic_sidebar( 'footer-1' ); ?></div><?php endif; ?>
		<?php if ( is_active_sidebar( 'footer-2' ) ) : ?><div class="widget-area"><?php dynamic_sidebar( 'footer-2' ); ?></div><?php endif; ?>
		<?php if ( is_active_sidebar( 'footer-3' ) ) : ?><div class="widget-area"><?php dynamic_sidebar( 'footer-3' ); ?></div><?php endif; ?>
	</footer><!-- #footer -->
	<?php endif; ?>
<?php endif; ?>

<?php if( get_field('countdown_method', $post->ID) === 'one' ) : ?>
<!--ワンタイムオファー
    ================================================== -->

<script type="text/javascript">
 var today = new Date();
 if( GetCookie('onetime<?php echo get_the_ID(); ?>') == null ) {
  var cookieExpire = new Date( today.getFullYear(), today.getMonth() + 6, today.getDate() );
  document.cookie = 'onetime<?php echo get_the_ID(); ?>=1; expires=' + cookieExpire.toUTCString();
 } else {
  location.href = '<?php echo get_field('countdown_url', $post->ID); ?>';
 }

function GetCookie(name){
 var result = null;
 var cookieName = name + '=';
 var cookies = document.cookie;
 var position = cookies.indexOf(cookieName);

 if( position != -1 ) {
  var startIndex = position + cookieName.length;
  var endIndex = cookies.indexOf(';', startIndex);
  if( endIndex == -1 ) { endIndex = cookies.length; }
  result = decodeURIComponent( cookies.substring(startIndex, endIndex) );
 }
 return result;
}
</script>
<?php endif; ?>

<?php if( get_field('countdown_method', $post->ID) === 'access' || get_field('countdown_method', $post->ID) === 'date' ) : ?>
<!--カウントダウン
    ================================================== -->

<script type="text/javascript">
 var today = new Date();
<?php if( get_field('countdown_method', $post->ID) === 'access' ) : ?>
 if( GetCookie('endDate<?php echo get_the_ID(); ?>') == null ) {
<?php if( get_field('cookie_expires', $post->ID) ) :
$expires = floatval(get_field('cookie_expires', $post->ID));
$floor = floor($expires);
$minutes = intval(60 * ($expires - $floor));
?>
  var endDate = new Date( today.getFullYear(), today.getMonth(), today.getDate(), today.getHours() + <?php echo $floor; ?>, today.getMinutes() + <?php echo $minutes; ?> );
  var cookieExpire = new Date( today.getFullYear(), today.getMonth() + 6, today.getDate() );
  document.cookie = 'endDate<?php echo get_the_ID(); ?>=' + endDate + '; expires=' + cookieExpire.toUTCString();
<?php else : ?>
  document.cookie = 'endDate<?php echo get_the_ID(); ?>=' + today;
<?php endif; ?>
 }
<?php endif; ?>
function GetCookie(name){
 var result = null;
 var cookieName = name + '=';
 var cookies = document.cookie;
 var position = cookies.indexOf(cookieName);

 if( position != -1 ) {
  var startIndex = position + cookieName.length;
  var endIndex = cookies.indexOf(';', startIndex);
  if( endIndex == -1 ) { endIndex = cookies.length; }
  result = decodeURIComponent( cookies.substring(startIndex, endIndex) );
 }
 return result;
}
function CountdownTimer(elm,tl,mes){
 this.initialize.apply(this,arguments);
}
function CountdownTimer2(elm,tl,mes){
 this.initialize.apply(this,arguments);
}

CountdownTimer.prototype={
 initialize:function(elm,tl,mes) {
  this.elem = document.getElementById(elm);
  this.tl = tl;
  this.mes = mes;
 },countDown:function(){
  var timer='';
  today=new Date();
  var day=Math.floor((this.tl-today)/(24*60*60*1000));
  var hour=Math.floor(((this.tl-today)%(24*60*60*1000))/(60*60*1000));
  var min=Math.floor(((this.tl-today)%(24*60*60*1000))/(60*1000))%60;
  var sec=Math.floor(((this.tl-today)%(24*60*60*1000))/1000)%60%60;
  var milli=Math.floor(((this.tl-today)%(24*60*60*1000))/10)%100;
  var me=this;

  if( ( this.tl - today ) > 0 ){
   if (day) timer += '<span class="day">'+day+'日</span>';
   if (hour) timer += '<span class="hour">'+hour+'時間</span>';
<?php if( get_field('countdown_format', $post->ID) === 'minute' ) : ?>
   timer += '<span class="min">'+this.addZero(min)+'分</span>';
<?php elseif( get_field('countdown_format', $post->ID) === 'second' ) : ?>
   timer += '<span class="min">'+this.addZero(min)+'分</span><span class="sec">'+this.addZero(sec)+'秒</span>';
<?php else : ?>
   timer += '<span class="min">'+this.addZero(min)+'分</span><span class="sec">'+this.addZero(sec)+'秒</span><span class="milli">'+this.addZero(milli)+'</span>';
<?php endif; ?>
   this.elem.innerHTML = timer;
   tid = setTimeout( function(){me.countDown();},10 );
  }else{
   this.elem.innerHTML = this.mes;
<?php
// ページジャンプ
$post = get_post($post); if( get_field('countdown_url', $post->ID) ) :
?>
   location.href = '<?php the_field('countdown_url', $post->ID); ?>';
<?php endif; ?>
   return;
  }
 },addZero:function(num){ return ('0'+num).slice(-2); }
}
function CDT(){
<?php
// カウントダウン
if( get_field('countdown_method', $post->ID) === 'date' ) :
if( get_field('countdown_date', $post->ID) ) :
	if( get_field('countdown_time', $post->ID) ) {
		$countdown_time = get_field('countdown_time', $post->ID);
	} else {
		$countdown_time = '00:00:00';
	}
?>
 var tl = new Date('<?php the_field('countdown_date', $post->ID); ?> <?php echo $countdown_time; ?>');
<?php else : ?>
 var tl = new Date('2013/12/23 00:00:00');
<?php endif; ?>
<?php elseif( get_field('countdown_method', $post->ID) === 'access' ) : ?>
 var tl = new Date( GetCookie('endDate<?php echo get_the_ID(); ?>') );
<?php endif; ?>
<?php if( get_field('countdown_design', $post->ID) === 'design2' ) : ?>
 $('#CDT').countdown({
   timestamp: tl,
   callback: function(days, hours, minutes, seconds){
    if(days == 0 && hours == 0 && minutes == 0 && seconds == 0) {
     <?php
      // ページジャンプ
      $post = get_post($post); if( get_field('countdown_url', $post->ID) ) :
     ?>
     location.href = '<?php the_field('countdown_url', $post->ID); ?>';
     <?php endif; ?>
    }
   }
 });
<?php else : ?>
 var timer = new CountdownTimer('CDT',tl,'終了しました');
 timer.countDown();
<?php endif; ?>
}

CountdownTimer2.prototype={
 initialize:function(elm,tl,mes) {
  this.elems = document.getElementsByClassName(elm);
  this.tl = tl;
  this.mes = mes;
 },countDown:function(){
  var timer='';
  today=new Date();
  var day=Math.floor((this.tl-today)/(24*60*60*1000));
  var hour=Math.floor(((this.tl-today)%(24*60*60*1000))/(60*60*1000));
  var min=Math.floor(((this.tl-today)%(24*60*60*1000))/(60*1000))%60;
  var sec=Math.floor(((this.tl-today)%(24*60*60*1000))/1000)%60%60;
  var milli=Math.floor(((this.tl-today)%(24*60*60*1000))/10)%100;
  var me=this;

  if( ( this.tl - today ) > 0 ){
   if (day) timer += '<span class="day">'+day+'日</span>';
   if (hour) timer += '<span class="hour">'+hour+'時間</span>';
<?php if( get_field('countdown_format', $post->ID) === 'minute' ) : ?>
   timer += '<span class="min">'+this.addZero(min)+'分</span>';
<?php elseif( get_field('countdown_format', $post->ID) === 'second' ) : ?>
   timer += '<span class="min">'+this.addZero(min)+'分</span><span class="sec">'+this.addZero(sec)+'秒</span>';
<?php else : ?>
   timer += '<span class="min">'+this.addZero(min)+'分</span><span class="sec">'+this.addZero(sec)+'秒</span><span class="milli">'+this.addZero(milli)+'</span>';
<?php endif; ?>
   for( var j=0; j<this.elems.length; j++ ) {
     this.elems[j].innerHTML = timer;
   }
   tid = setTimeout( function(){me.countDown();},10 );
  }else{
   for( var j=0; j<this.elems.length; j++ ) {
     this.elems[j].innerHTML = this.mes;
   }
<?php
// ページジャンプ
$post = get_post($post); if( get_field('countdown_url', $post->ID) ) :
?>
   location.href = '<?php the_field('countdown_url', $post->ID); ?>';
<?php endif; ?>
   return;
  }
 },addZero:function(num){ return ('0'+num).slice(-2); }
}
function CDT2(){
<?php
// カウントダウン
if( get_field('countdown_method', $post->ID) === 'date' ) :
if( get_field('countdown_date', $post->ID) ) :
	if( get_field('countdown_time', $post->ID) ) {
		$countdown_time = get_field('countdown_time', $post->ID);
	} else {
		$countdown_time = '00:00:00';
	}
?>
 var tl = new Date('<?php the_field('countdown_date', $post->ID); ?> <?php echo $countdown_time; ?>');
<?php else : ?>
 var tl = new Date('2013/12/23 00:00:00');
<?php endif; ?>
<?php elseif( get_field('countdown_method', $post->ID) === 'access' ) : ?>
 var tl = new Date( GetCookie('endDate<?php echo get_the_ID(); ?>') );
<?php endif; ?>
<?php if( get_field('countdown_indesign', $post->ID) === 'design2' ) : ?>
 $('.CDT').each(function(){
  $(this).countdown({
   timestamp: tl,
   callback: function(days, hours, minutes, seconds){
    if(days == 0 && hours == 0 && minutes == 0 && seconds == 0) {
     <?php
      // ページジャンプ
      $post = get_post($post); if( get_field('countdown_url', $post->ID) ) :
     ?>
     location.href = '<?php the_field('countdown_url', $post->ID); ?>';
     <?php endif; ?>
    }
   }
  });
 });
<?php elseif( get_field('countdown_indesign', $post->ID) === 'design3' ) : ?>
 var currentDate = new Date();
 $('.CDT').each(function(){
  $(this).ClassyCountdown({
   theme: 'flat-colors',
   end: tl.getTime() / 1000 + 1,
   now: currentDate.getTime() / 1000,
   onEndCallback: function(){
     <?php
      // ページジャンプ
      $post = get_post($post); if( get_field('countdown_url', $post->ID) ) :
     ?>
     location.href = '<?php the_field('countdown_url', $post->ID); ?>';
     <?php endif; ?>
   }
  });
 });
<?php elseif( get_field('countdown_indesign', $post->ID) === 'design4' ) : ?>
 var currentDate = new Date();
 var diff = tl.getTime() / 1000 - currentDate.getTime() / 1000 - 1;
 if(diff < 0) diff = 0;
 $('.CDT').each(function(){
  $(this).FlipClock(diff, {
   clockFace: 'DailyCounter',
   countdown :true,
   callbacks: { stop: function(){
     <?php
      // ページジャンプ
      $post = get_post($post); if( get_field('countdown_url', $post->ID) ) :
     ?>
     location.href = '<?php the_field('countdown_url', $post->ID); ?>';
     <?php endif; ?>
   }}
  });
 });
<?php else : ?>
 var timer2 = new CountdownTimer2('CDT',tl,'終了しました');
 timer2.countDown();
<?php endif; ?>
}

window.onload=function(){
 CDT();
 CDT2();
}
</script>
<?php endif; ?>

<?php wp_footer(); ?>
</body>
</html>