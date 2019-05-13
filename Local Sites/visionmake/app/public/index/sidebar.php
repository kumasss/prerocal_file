<?php
if(!empty($_GET['page'])):$contents_id=$_GET['page'];else:$contents_id=0;endif;
if((!empty($contents_id))||($contents_id!=0)):$side_title_id=$buildersObj->get_side_title_id_tp_sidebars( $contents_id );else:$side_title_id=0;endif;
if(empty($subtitle1))$subtitle1=NULL;
if(empty($subtitle2))$subtitle2=NULL;

$sidebar = '';
if(!empty($freearea_upper)){
	$sidebar .= '<div class="box">';
	$sidebar .= '<aside>';
	$sidebar .= '<div class="content">';
	$sidebar .= $freearea_upper;
	$sidebar .= '</div>';
	$sidebar .= '</aside>';
	$sidebar .= '</div>';
}
$sidebar .= '<div class="box">';
$sidebar .= '<aside>';
$sidebar .= '<div class="content">';
$sidebar .= '<div class="heading"><h2>'.$subtitle1.'</h2></div>';

// start of contents
if(!empty($sidebars_data)){
	$show_midasi = 0;$copy_id = "";$first_div = 0;
	foreach($sidebars_data as $col):
		$public = $buildersObj->check_reg_date( $col['contents_public_date'], $col['contents_no_public_date'] );
		$check_group = $buildersObj->check_group( $col['group_id'] );
		if( $col['contents_public'] && $public ):
			if(!empty($col['contents_title']) && $check_group){
				$sum_public = $buildersObj->ck_midasi_sidebar( $col['side_title_id'] );
				if ( $sum_public > 0 ):
					//見出し
					if ( $copy_id != $col['side_title_id'] ){
						if ( $first_div != 0 ){
							$sidebar .=  '</ul>'."\n";
						}
						if( $col['side_titles_title'] == 'no caption' ){$dis='display:none;';}else{$dis='';}
						if( ($col['toggle_flg']=="1") || ($side_title_id==$col['side_title_id']) ){$togg="toggle1";}else{$togg="toggle2";}
						$sidebar .=	 '<div class="topic2 '.$togg.'" style="'.$dis.'">'.$col['side_titles_title'].'</div>'."\n";
						$sidebar .=  '<ul>'."\n";
						$show_midasi = 1;
						$first_div = 1;
						$copy_id = $col['side_title_id'];
					}
					//タイトル
					if(!empty($col['img_uploaders_id'])){
						$sidebar .= '<li><img src="./'.$col['img_uploaders_store_folder'].'/'.$col['img_uploaders_store_file'].'" alt="'.$col['img_uploaders_title'].'" class="imgeye">';
					}else{
						$sidebar .= '<li>';
					}
					// ?page -> ?url change 2016-08-20
					$col['contents_title'] = $buildersObj->txtReplace( $col['contents_title'], $user);
					$sidebar .=  '<a href="./page.php?url='.$col['url'].'">'.htmlspecialchars_decode($col['contents_title']).'</a></li>'."\n";
				endif;
			}
		endif;
	endforeach;
	$sidebar .= '</ul>'."\n";
}
$sidebar .= '</div>';
$sidebar .= '</aside>';
$sidebar .= '</div>';
// end of contents

if(!empty($freearea_middle)){
	$sidebar .= '<div class="box m-t20">';
	$sidebar .= '<aside>';
	$sidebar .= '<div class="content">';
	$sidebar .= $freearea_middle;
	$sidebar .= '</div>';
	$sidebar .= '</aside>';
	$sidebar .= '</div>';
}

if($settings_data['disp_contact'] or $settings_data['disp_member'] or $settings_data['disp_logout']){
$sidebar .= '<div class="box m-t20">';
$sidebar .= '<aside>';
$sidebar .= '<div class="content">';
$sidebar .= '<div class="heading"><h2>'.$subtitle2.'</h2></div>';
$sidebar .= '<ul>'."\n";
if($settings_data['disp_contact'])
	$sidebar .= '<li class="mail"><a href="'.URL.'/contact.php">問い合わせフォーム</a></li>';
if($settings_data['disp_member'])
	$sidebar .= '<li class="henkou"><a href="'.URL.'/member.php">会員情報変更</a></li>';
if($settings_data['disp_logout'])
	$sidebar .= '<li class="out"><a href="'.URL.'/logout.php">ログアウト</a></li>';
$sidebar .= '</ul>'."\n";
$sidebar .= '</div>';
$sidebar .= '</aside>';
$sidebar .= '</div>';
}

if(!empty($freearea_lower)){
	$sidebar .= '<div class="box m-t20">';
	$sidebar .= '<aside>';
	$sidebar .= '<div class="content">';
	$sidebar .= $freearea_lower;
	$sidebar .= '</div>';
	$sidebar .= '</aside>';
	$sidebar .= '</div>';
}
?>