<?php
header("Content-Type: text/html;charset=UTF-8");
header("Expires: Thu, 01 Dec 1994 16:00:00 GMT");
header("Last-Modified: ". gmdate("D, d M Y H:i:s"). " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

#設定ファイルインクルード
require_once('./config.php');
require_once( '../../../../common/config.ini' );  //Cyfons用config

//----------------------------------------------------------------------
//  ログイン処理 (START)
//----------------------------------------------------------------------
session_start();
//----------------------------------------------------------------------
//  ログイン処理 (END)
//----------------------------------------------------------------------

//----------------------------------------------------------------------
//  データ保存用ファイル、画像保存ディレクトリのパーミッションチェック (START)
//----------------------------------------------------------------------
//$messe = permissionCheck($filePath,$commentFilePath,$pulldownFilePath,$closedFilePath,$dataDir,$perm_check01,$perm_check02,$perm_check03,$reservFileDir,$timeListFilePath);
//----------------------------------------------------------------------
//  データ保存用ファイルのパーミッションチェック (END)
//----------------------------------------------------------------------

// 複数メールフォーム対応 2016/3/18
if(!isset($_GET['id'])) {
	$_GET['id'] = 1;
}
if ($_GET['id'] == 1) {
	$inqid = '';
}else{
	$inqid = $_GET['id'];
}
$cmsFilePath = $dataDir.$inqid.$cmsFilePath_last;

//----------------------------------------------------------------------
//  書き込み・編集処理 (START)
//----------------------------------------------------------------------


if (isset($_POST['regist']) && !isset($_POST['delete'])){
	
	$mode = h($_POST['mode']);
	
	$data = '';
	
	//各記事にユニークなIDを付与　uniqid（PHP3以下）が無ければ年月日時分秒
	$id = generateID();
	$data .= $id.',';
	
	//並び順（登録時は空を挿入）
	$data .= ($mode == 'update') ? h($_POST['dspno']).',' : ',';
	
	$listData = '';
	foreach($_POST['data'] as $key => $val){
		
		//textareaの場合は改行ごとに連結
		if($key == 'list'){
			$listArr = explode("\n",$val);
			foreach($listArr as $listArrVal){
				$listData .= $listArrVal.'||';
			}
			$data .= str_replace(array("\n","\r",','),'',rtrim($listData,'||')).',';
			
		}else{
			$data .= str_replace(array("\n","\r",','),'',$val).',';
		}
	}
	
	$data .= "\n";
	

	// ----------  cmsFilePath (form.dat) ----------
	$lines = file($cmsFilePath);
	$fp = fopen($cmsFilePath, "r+b") or die("fopen Error!!");
	// 俳他的ロック
	if (flock($fp, LOCK_EX)) {
		ftruncate($fp,0);
		rewind($fp);
		
		if($mode != 'update'){
			//fwrite($fp, $data);// 書き込み
			foreach($lines as $val){
				fwrite($fp, $val);// 書き込み
			}
			fwrite($fp, $data);// 書き込み  追加したものを最後尾に移動する 2015/4/30
		}
		else{
			
			foreach($lines as $val){
				$linesArray = explode(',',$val);
				
				if($id == $linesArray[0]){
					fwrite($fp, $data);// 書き込み	
				}else{
					fwrite($fp, $val);// 書き込み	
				}
				
			}
		}
	}
	fflush($fp);
	flock($fp, LOCK_UN);
	fclose($fp);




	// formOrder.datの更新 (cmsOrderFilePath)       2015/4/24
	//    form.datとdelete.datの内容を元に作成する
	updateFormOrderDat();




	//再送信防止リダイレクト
	header("Location: ./index.php?mode=form&id=".$_GET['id']);
	exit();
}
//----------------------------------------------------------------------
//  書き込み・編集処理 (END)
//----------------------------------------------------------------------


//----------------------------------------------------------------------
//  並び替え処理 (START)
//----------------------------------------------------------------------

if(isset($_POST['sortSubmit'])){
	orderChange($cmsFilePath);	
	//再送信防止リダイレクト
	header("Location: ./index.php?mode=sort&id=".$_GET['id']);
	exit();
}


//----------------------------------------------------------------------
//  並び替え処理 (END)
//----------------------------------------------------------------------

//----------------------------------------------------------------------
//  削除処理 (START)
//----------------------------------------------------------------------

if(isset($_POST['delete'])){
	delData($cmsFilePath);
	//再送信防止リダイレクト
	header("Location: ./index.php?mode=del&id=".$_GET['id']);
	exit();
}


//----------------------------------------------------------------------
//  削除処理 (END)
//----------------------------------------------------------------------


//----------------------------------------------------------------------
//  設定書き込み・編集処理 (START)
//----------------------------------------------------------------------

if (isset($_POST['configSubmit'])){
	$data = '';
	if(count($_POST['config']) != 6) exit('設定項目数が変更されているため強制終了しました。単純にhtmlのみで項目を増やしても反映されませんので制作者にお問い合わせ下さい。<a href="?">戻る</a>');
	foreach($_POST['config'] as $key => $val){
		//メールアドレスの形式をチェック
		if($key == 'to'){
			$val = trim($val);
			if(!checkMail($val) || empty($val)) exit('メールアドレスの形式に問題があるため強制終了しました。データは更新されていません。ご確認の上再度設定下さい。<a href="?">戻る</a>');
		}
		$data .= dataToBrcodeAndKanma($val,0).',';
	}
	
	$data .= "\n";
	$fp = fopen($configFilePath, "r+b") or die("fopen Error!!");
	if(flock($fp, LOCK_EX)){// 俳他的ロック
		ftruncate($fp,0);
		rewind($fp);
		fwrite($fp, $data);// 書き込み
	}
	
	fflush($fp);
	flock($fp, LOCK_UN);
	fclose($fp);
	
	//再送信防止リダイレクト
	header("Location: ./index.php?mode=config&id=".$_GET['id']);
	exit();
}
//----------------------------------------------------------------------
//  設定書き込み・編集処理 (END)
//----------------------------------------------------------------------

cffsg($warningMesse02,$cfilePath);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Cyfons管理画面</title>


<link href="style.css" rel="stylesheet" type="text/css" media="all" />

<link href="<?php echo URL; ?>/common/css/bootstrap.min.css" type="text/css" rel="stylesheet">
<link href="<?php echo URL; ?>/common/css/common.css" type="text/css" rel="stylesheet">

<script src="<?php echo URL; ?>/common/js/jquery-1.7.2.min.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>/common/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo URL; ?>/common/js/bootstrap-dropdown.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.dropdown-toggle').dropdown();
});
</script>


<script type="text/javascript" src="//code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<script type="text/javascript" src="validate.js"></script>



<script type="text/javascript">
//ポップアップ用JS
function openwin(url) {
 wn = window.open(url, 'win','width=540,height=590,status=no,location=no,scrollbars=yes,directories=no,menubar=no,resizable=no,toolbar=no,left=50,top=50');wn.focus();
}

$(function(){
		   
	$(".message_com").delay(2000).fadeOut("slow");
		   
    $(".acrbtn").click(function () {
      $(".acrDescription").toggle("normal");
    });
	
	changeFormKind();
	
	$('#formKind').change(function(){
		changeFormKind();
	});
});

function changeFormKind(){
	
	$('#mailAddressMesse').hide();
	
	if( $('#formKind').val() == "2" || $('#formKind').val() == "3" || $('#formKind').val() == "4" ){
		$('.form_list').fadeIn();
		$('.form_text,.form_textarea').hide();
	}
	else if($('#formKind').val() == "1"){
		$('.form_text').fadeIn();
		$('.form_list,.form_textarea').hide();
	}
	else if($('#formKind').val() == "6"){
		$('.form_text').fadeIn();
		$('.form_list,.form_textarea').hide();
		$('#mailAddressMesse').html('<span class="alert alert-error">「メールアドレス入力欄」はフォーム内で1つのみ設定可能です</span>').show();
		
	}
	else if($('#formKind').val() == "5"){
		$('.form_textarea').fadeIn();
		$('.form_list,.form_text').hide();
	}
}

//並び替え
$(function(){ 
		$('#previewTable tbody').sortable();
});



//必須チェック（PHP処理が絡むため外部化基本不可）
$(function(){

	$(".validateForm").validate({
		rules: {
			"data[name]" :{
				required: true
			},
			"data[kind]" :{
				required: true
			}
			
		},
		messages: {
			"data[name]" :{
				required: "項目名を入力してください"
			},
			"data[kind]" :{
				required: "フォームの種類を選択してください"
			}
			
		},
		//メッセージの順序反転処理
		showErrors: function(errorMap, errorList) {
		  for ( var i = this.errorList.length -1; this.errorList[i]; i-- ) {
			var error = this.errorList[i];
			this.settings.highlight && this.settings.highlight.call( this, error.element, this.settings.errorClass );
			this.showLabel( error.element, error.message );
		  }
		  if( this.errorList.length ) {
			this.toShow = this.toShow.add( this.containers );
		  }
		  if (this.settings.success) {
			for ( var i = 0; this.successList[i]; i++ ) {
			  this.showLabel( this.successList[i] );
			}
		  }
		  if (this.settings.unhighlight) {
			for ( var i = 0, elements = this.validElements(); elements[i]; i++ ) {
			  this.settings.unhighlight.call( this, elements[i], this.settings.errorClass );
			}
		  }
		  this.toHide = this.toHide.not( this.toShow );
		  this.hideErrors();
		  this.addWrapper( this.toShow ).show();
		},
		//メッセージ表示箇所変更処理
		errorPlacement: function(error, element) {
		  switch(element.attr('name')) {
			  
			default:
			  error.insertAfter(element);
		  }
		}		
	});
});


//タイトル名の重複チェック  2015/7/11 abe
$(function(){
	$("input[name='data[name]']").blur(function(){

		$('#regist').attr('disabled', 'disabled');
		$('#regist').removeAttr('disabled');

		if($(this).val() == "お問い合わせ件名"){
			$('#regist').attr('disabled', 'disabled');

		} else if($(this).val() == "お名前") {
			$('#regist').attr('disabled', 'disabled');

		} else if($(this).val() == "メールアドレス") {
			$('#regist').attr('disabled', 'disabled');
		}

	});
});



</script>
</head>
<body id="admin">

<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( '../../../../common/element/gnav_builder.php'); ?>
</div>
</div>
</div>
</div>



<div class="container" id="container">
<div id="content">
<div id="message"></div>

<div class="form-actions">
<a class="btn" href="<?php echo URL; ?>/admin/builders/tp_inquirys_menu/">フォーム一覧に戻る</a>
</div>

<div class="titles form">
<?php require_once( '../../../../common/element/tab_form_setting_mailform.php'); ?>
<div class="pulldownList_btn"><a href="../" >キャンセル</a></div>
<?php if(!$copyright){echo $warningMesse; exit;}else{ ?>
<?php if(!empty($messe))echo "<p class=\"alert alert-error\">{$messe}</p>"; ?>
<?php if(@$_GET['mode'] == 'form') echo '<p class="alert alert-success">登録が完了しました</p>'; ?>
<?php if(@$_GET['mode'] == 'sort') echo '<p class="alert alert-success">並び替えが完了しました</p>'; ?>
<?php if(@$_GET['mode'] == 'del') echo '<p class="alert alert-success">削除が完了しました</p>'; ?>
<?php if(@$_GET['mode'] == 'config') echo '<p class="alert alert-success">設定内容を更新しました。</p>'; ?>

<div class="waku">
<p><i style="margin:2px 3px 0 0;" class="icon-ok-sign"></i><span style="font-weight:bold;">プレビュー</span></p>
<p>ドラッグ＆ドロップで並び替えが可能です。反映するには「並び替え実行」ボタンを押して下さい。</p>
<p><span class="require">※</span>は必須入力項目です。なお「お問い合わせ件名」「お名前」及び「メールアドレス」は編集できません。（並び替えは可能です）</p>
<form action="" method="post">
<table class="formTable" id="previewTable">
<tbody>
<?php
// form.datファイルのフォルダが未生成の場合作成する  2016/3/27
createFormDatFolder($dataDir.$inqid);

// 並び替えした結果を取得する
// 複数メールフォーム対応 2016/3/27
//  $lines = getListSorted($cmsInitFilePath, $cmsFilePath);
if ($_GET['id'] == 1) {
  $lines = getListSorted($cmsInitFilePath, $cmsFilePath);
}else{
  $lines = getListSorted($cmsInitFilePath2, $cmsFilePath);
}

	foreach($lines as $val){
		$linesArray = explode(',',$val);
		$htmlTag = '';
		
		//text
		if($linesArray[3] == 1 || $linesArray[3] == 6){
			$htmlTag .= '<input name="'.$linesArray[2].'" type="text" size="'.$linesArray[4].'" />';
		}
		
		//radio
		elseif($linesArray[3] == 3){
			$arr = explode('||',$linesArray[7]);
			foreach($arr as $val){
				$htmlTag .= '<input name="'.$linesArray[2].'" type="radio" value="'.$val.'" /> '.htmlspecialchars($val).'<br />';
			}
		}
		
		//checkbox
		elseif($linesArray[3] == 4){
			$arr = explode('||',$linesArray[7]);
			foreach($arr as $val){
				$htmlTag .= '<input name="'.$linesArray[2].'[]" type="checkbox" value="'.$val.'" /> '.htmlspecialchars($val).'<br />';
			}
		}
		
		//select
		elseif($linesArray[3] == 2){
			$htmlTag .= '<select name="'.$linesArray[2].'">';
			$arr = explode('||',$linesArray[7]);
			foreach($arr as $val){
				$htmlTag .= '<option value="'.$val.'">'.htmlspecialchars($val).'</option>';
			}
			$htmlTag .= '</select>';
		}
		elseif($linesArray[3] == 5){
			$htmlTag .= '<textarea name="'.$linesArray[2].'" cols="'.$linesArray[5].'" rows="'.$linesArray[6].'"></textarea>';
		}
		
		//設定した項目の場合には編集不可とする　※設定ファイルで設定可（デフォルトは名前、メールアドレス、コメント）
		$dispNonFlag = '';
		foreach($compForm as $compFormVal){
			if($linesArray[2] == $compFormVal){
				$dispNonFlag = ' hidden';
				break;
			}
		}
		
?>

  <tr>
    <th><?php echo htmlspecialchars($linesArray[2]);?><?php echo (!empty($linesArray[9])) ? ' <span class="require">※</span>' : '';?></th>
    <td><?php echo $htmlTag;?><br /><?php echo htmlspecialchars($linesArray[8]);?></td>
    <td class="taC"><a href="?mode=edit&itemid=<?php echo $linesArray[0];?>&id=<?php echo $_GET['id'];?>" class="editBtn<?php echo $dispNonFlag;?>">編集</a><input type="hidden" name="sort[]" value="<?php echo $linesArray[0];?>" /></td>
  </tr>


<?php 
	}
}
?>
</tbody>
</table>

<div class="taC mt20 mb20"><input type="submit" value="　並び替え実行　" name="sortSubmit" class="btn btn-primary" /></div>

</div>

</form>



<div class="waku">

<p><i style="margin:2px 3px 0 0;" class="icon-ok-sign"></i><span style="font-weight:bold;">フォーム項目の追加/修正</span></p>
<p>項目を更新後、都度送信テストを行うことを強くおすすめします。</p>
<!--<p class="acrbtn">【操作マニュアル・注意事項】</p>
<p class="acrDescription ml10" style="display:none">
※プルダウンから「<?php echo $pulldownListArray[0];?>」、「<?php echo $pulldownListArray[1];?>」を選択し、ページ下の「登録」ボタンを押して下さい。<br />
※「<?php echo $pulldownListArray[0];?>」を選択した場合のみ「<?php echo $reservText;?>」ボタンが表示されます。<br />
※「未選択」を選択したものは非表示になります。
</p>
-->
<?php

//項目名の重複チェック
$lines = file($cmsFilePath);
$arrayOverLap = '';
$addDisable = '';
foreach($lines as $val){
	$arrayOverLapCount = 0;
	$linesArray01 = explode(',',$val);
	foreach($lines as $vv){
		$linesArray02 = explode(',',$vv);
		if($linesArray01[2] == $linesArray02[2]){
			$arrayOverLapCount++;
		}
	}
	$arrayOverLap .= ($arrayOverLapCount > 1) ? '「'.$linesArray01[2].'」' : '';
	
	//ついでにメールアドレス入力欄がすでに選択済かどうか確認する true = disabledに。
	if($linesArray01[3] == 6){
		$addDisable = ' disabled="disabled"';	
	}
}
echo (!empty($arrayOverLap)) ? '<span class="alert alert-error">【 重大な問題発生 】</span><br /><span class="col19">'.$arrayOverLap.'が重複していますので修正して下さい。（フォーム内で同じ項目名は使用できません）</span>' : '';


//編集画面時の表示用
$linesArray = array();
$dspno = '';
if(isset($_GET['itemid'])){
	foreach($lines as $val){
		$linesArray = explode(',',$val);
		if($_GET['itemid'] == $linesArray[0]){
			break;	
		}
	}
	
	$dspno = $linesArray[1];
	echo '<span class="alert alert-error">下記内容を編集後「変更」ボタンを押してください。</span>';
}
?>


<form action="" method="post" class="validateForm">
<table class="formTable">

  <tr>
    <th>項目名（日本語）</th>
    <td><input name="data[name]" id="dataname" type="text" size="30" value="<?php echo (!empty($linesArray[2])) ? $linesArray[2] : '';?>" />　例 ご住所<br />
      <span class="small">このテキストがそのまま確認画面と送信メールの項目名として設定されます。<br />記号、機種依存文字、半角スペース、半角カンマは使用できません。<br />「お問い合わせ件名」「お名前」及び「メールアドレス」は指定できません。</span></td>
  </tr>
  <tr>
    <th>フォームの種類</th>
    <td>
    <select name="data[kind]" id="formKind">
    <option value="">選択して下さい</option>
    <option value="1"<?php if(!empty($linesArray[3]) && $linesArray[3] == 1) echo ' selected="selected"';?>>テキスト入力</option>
    <option value="2"<?php if(!empty($linesArray[3]) && $linesArray[3] == 2) echo ' selected="selected"';?>>プルダウン</option>
    <option value="3"<?php if(!empty($linesArray[3]) && $linesArray[3] == 3) echo ' selected="selected"';?>>ラジオボタン</option>
    <option value="4"<?php if(!empty($linesArray[3]) && $linesArray[3] == 4) echo ' selected="selected"';?>>チェックボックス</option>
    <option value="5"<?php if(!empty($linesArray[3]) && $linesArray[3] == 5) echo ' selected="selected"';?>>テキストエリア（複数行のテキスト入力）</option>
    <!--<option value="6"<?php if(!empty($linesArray[3]) && $linesArray[3] == 6) echo ' selected="selected"';?>>メールアドレス入力欄</option>-->
    </select>
    
    <div id="mailAddressMesse"></div></td>
  </tr>
  
  <input type="hidden" name="data[size]" value="30" />
  
  <tr class="form_textarea" style="display:none;">
    <th>高さ</th>
    <td><input type="hidden" name="data[cols]" value="30" /><input type="text" name="data[rows]" size="5" value="<?php echo (!empty($linesArray[6])) ? $linesArray[6] : '5';?>" />　
    </td>
  </tr>
  
  <tr class="form_list" style="display:none;">
    <th>プルダウン、ラジオボタン、チェックボックスの場合の項目</th>
    <td>選択項目を1行ごとにご指定下さい。<br />
    <textarea name="data[list]" rows="5" cols="70"><?php echo (!empty($linesArray[7])) ? str_replace('||',"\n",htmlspecialchars($linesArray[7])) : '';?></textarea>
    </td>
  </tr>
  
  
  <tr>
    <th>補足、コメント</th>
    <td><input name="data[comment]" type="text" size="40" value="<?php echo (!empty($linesArray[8])) ? htmlspecialchars($linesArray[8]) : '';?>" /><br />
※例　半角数字を入力下さい。</td>
  </tr>
  <tr>
    <th>必須設定</th>
    <td><input name="data[require]" type="hidden" value="0" /><input name="data[require]" type="checkbox" value="1"<?php if(!empty($linesArray[9]) && $linesArray[9] == 1) echo ' checked="checked"';?> /> 必須にする</td>
  </tr>
  
  
  <?php if(isset($_GET['itemid'])){ ?>
  <tr>
    <th>削除</th>
    <td><input name="delete" type="checkbox" value="1" /> 削除する <span class="small">※チェックを入れるとこの項目を削除します。</span></td>
  </tr>
  <?php } ?>
</table>
<?php echo (isset($_GET['itemid'])) ? '<input type="hidden" name="itemid" value="'.h($_GET['itemid']).'" /><input type="hidden" name="mode" value="update" /><input type="hidden" name="dspno" value="'.$dspno.'" />' : '<input type="hidden" name="mode" value="new" />';?>

<div class="taC mt20 mb20"><input type="submit" value="　<?php echo (isset($_GET['itemid'])) ? '変更' : '登録';?>　" name="regist" class="btn btn-primary" id="regist" />
<?php echo (isset($_GET['itemid'])) ? '&nbsp;&nbsp;<a class="btn" href="?">キャンセル</a>' : '';?>
</div>
<!-- <input type="hidden" name="id" value="<?php echo $_GET['id'];?>" /> 2016/3/21 -->
</form>
</div>
</div>



</div>
</div>
</div>



</body>
</html>
