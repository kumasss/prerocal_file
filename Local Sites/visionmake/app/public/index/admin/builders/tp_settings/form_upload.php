<?php
session_start();
define('FILE_ERR',99); 
require_once( '../../../common/builders.php' );
require_once( '../../../common/users.php' );
$usersObj = new users();
if( $usersObj->get_auth_session( $_SESSION, $user ))
{
	if( $usersObj->db_login( $user['email'], $user['password'], $auth=ADMIN_ROLL, $user ))
	{
		session_regenerate_id( TRUE );
	} else {
		$usersObj->session_dell();
	}
} else {
	header( 'Location:'.URL.'/admin/' );
}
if( $_SERVER['REQUEST_METHOD'] == 'POST' )
{
	$usersObj->get_data($_REQUEST, $form_data);
}
$errorMessage = "";
$result = false;
$status = (isset($form_data['status'])) ? $form_data['status']:NULL;
$buildersObj = new builders();
$buildersObj->get_all_setting( $settings_data );
$data['site_name'] = htmlspecialchars_decode( $settings_data['site_name'], ENT_QUOTES );

if($status == "upload")
{
	$upload_key = 'images';
	$img_path1 = 'images';
	$img_path2 = date( "Ymd", time() );
	$img_path = '../../../'.$img_path1.'/'.$img_path2;
	
	if( !is_dir( $img_path ))
	{
		if( @mkdir( $img_path ))
		{
		} else {
			$err['upload'] = 'ディレクトリの作成に失敗しました。';
		}
	}
	$buildersObj->get_all_img_uploaders2( $img_uploaders_data, $position=HEADER );
	$cnt = count($img_uploaders_data);
	if( $cnt > 0 )
	{
		$result = FILE_ERR;
		$html  = '<p style="color:#ff0000">すでにヘッダー画像が登録されています。</p>';
		$html .= '<a class="btn btn-inverse" href="" onclick="window.close();return false;">閉じる</a>';
	} else {
		$result = $buildersObj->upload( $data, $upload_key, $img_path );
		if( $result === TRUE)
		{
			$data['title'] = pathinfo( $data['org_file'], PATHINFO_FILENAME );
			$data['store_folder'] = $img_path1.'/'.$img_path2;
			$data['position'] = HEADER;

			$buildersObj->db_add_img_uploaders2( $data );
		} else {
			$err['upload'] = $result;
			$result = FILE_ERR;
			$html  = '<p style="color:#ff0000">'.$err['upload'].'</p>';
			$html .= '<a class="btn btn-inverse" href="">再アップロード</a>';
		}
	}
}
?>
<?php /***** not login *****/ ?>
<!-- Doctype -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $data['site_name']?>|ヘッダー画像アップロード</title>
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/style.css">
	<link rel="stylesheet" href="<?php echo URL; ?>/css/bootstrap.css">
	<script src="<?php echo URL; ?>/common/js/jquery-1.7.2.min.js" type="text/javascript"></script>
</head>
<!-- Header -->
<body>
<!-- Content -->
<section id="content">
<div class="row block">
<div id="main-content" class="col-full">
<div class="wrap-col">
<article>
<div class="heading">
<h2 style="border-bottom: 2px solid #919191; line-height: 25px; padding: 10px 0;">ヘッダー画像アップロード</h2>
<div class="info"></a></div>
</div>
<div class="content">
<?php if ($result === FILE_ERR){?>
<?php echo $html;?>
<?php }else if ($result){?>
<p style="color: green">ヘッダー画像のアップロードが完了しました。</p>
<a id="btn_close" class="btn btn-inverse" href="">閉じる</a>
<script Language="JavaScript"><!--
$(function(){
	var url = "<?php echo URL ?>";
	url=url+"/common/ajax_set_header_image.php";
	window.opener.$("#HeaderImg").load(url, function(){
	});
	$("#btn_close").click(function(e){
		e.preventDefault();
		e.stopPropagation();
		window.close();
		return false;
	});
});
// --></script>
<?php }else{?>
<p>サイトのヘッダーに表示する画像をアップロードできます。</p>
<div id="img_uploaders_div">
	<form id="img_uploaders_form" accept-charset="utf-8" method="post" enctype="multipart/form-data" class="form-inline">
	<input class="input-file" id="ImgUploaders" type="file" name="images">
	<input type="hidden" name="status" value="upload">
	<input id="img_upload_btn" type="submit" class="btn btn-primary" style="margin-right:5px;" value="アップロード">
	</form>
</div>
<?php }?>
</fieldset>
</form>
</div>
</article>
</div>
</div>
</div>
</section>
</body>
</html>
