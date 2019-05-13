<!--ホバーウィンドウ
    ================================================== -->

<?php
/* ホバーウィンドウの表示 */
//$loop = new WP_Query( array( 'post_type' => 'hover', 'posts_per_page' => 1 ) );
//while ( $loop->have_posts() ) : $loop->the_post();
$post_object = get_field('hoverwindow_text');
if( $post_object ): 
$post = $post_object;
setup_postdata( $post );
?>


<div id="filter" onClick="hideWin();"></div>
<div id="subwin" >



<!-- <h2><a href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2> -->


<div class="custom-post-content">
    <?php the_content('続きを読む&raquo;'); ?>
</div>


<p align="right"><a href="#" onClick="hideWin();">サブウィンドウを閉じる</a></p>



</div>

<?php endif; wp_reset_postdata(); ?>


<script type="text/javascript">
function dispWin(){
document.getElementById('filter').style.display = 'block';
document.getElementById('subwin').style.display = 'block';
};

function hideWin(){
document.getElementById('filter').style.display = 'none';
document.getElementById('subwin').style.display = 'none';
};
</script>

<!--ホバーウィンドウここまで
    ================================================== -->