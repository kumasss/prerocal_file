<?php require_once( './edit_item/config.php'); ?>
<?php 
//----------------------------------------------------------------------
//  絞り込み検索処理 (START)
//----------------------------------------------------------------------
//初期状態は過去１か月とする  2015/5/4
//$stratYmd = (!empty($_POST['start_ymd'])) ? $_POST['start_ymd'] : date('Y/m/d');
//$endYmd = (!empty($_POST['end_ymd'])) ? $_POST['end_ymd'] : $stratYmd;
$stratYmd = (!empty($_POST['start_ymd'])) ? $_POST['start_ymd'] : date('Y/m/d',strtotime("-1 month"));
$endYmd = (!empty($_POST['end_ymd'])) ? $_POST['end_ymd'] :  date('Y/m/d');

// 複数メールフォーム対応 2016/3/18
if ($_GET['id'] == 1) {
	$inqid = '';
}else{
	$inqid = $_GET['id'];
}
$csv_file_path = $dataDir.$inqid.$csv_file_path_last;
$cmsOrderFilePath = $dataDir.$inqid.$cmsOrderFilePath_last;



//日付が存在する日付かどうかチェック
$getStratYmdArr = explode('/',$stratYmd);
$getEndYmdArr = explode('/',$endYmd);
if(!checkdate($getStratYmdArr[1],$getStratYmdArr[2],$getStratYmdArr[0]) || !checkdate($getEndYmdArr[1],$getEndYmdArr[2],$getEndYmdArr[0])){
	$messe = '日付が存在しない値です。カレンダーから選択した書式を変更しないでください。';	
	$stratYmd = date('Y/m/d');
	$endYmd = $stratYmd;
} elseif(strtotime($stratYmd) > strtotime($endYmd)) {
	    $messe = '終了日は開始日以降の日付を設定してください。';
}


$lines = by_tmpfile($csv_file_path);
//表示順を逆にする  2015/5/4
$lines = array_reverse($lines);

$res = array();

$labelcnt = 0;

foreach($lines as $val){
	if(strtotime($stratYmd) <= strtotime($val[0]) && strtotime($endYmd) >= strtotime($val[0])){
		$res[] = $val;
	}
}

//----------------------------------------------------------------------
//  絞り込み検索処理 (END)
//----------------------------------------------------------------------


//----------------------------------------------------------------------
//  ユーザーID+メールアドレスの処理関数(STARTD)  2017/6/17
//----------------------------------------------------------------------
/* ユーザーIDとメールアドレスに分解する*/
function get_id_mail($idmail, &$out_id, &$out_mail)
{
  $out_id = "";
  $out_mail = "";
  $i = 0;
  $wkAr = explode('|', $idmail);

//  var_dump($wkAr);

  if (count($wkAr) > 1) {
    $out_id = $wkAr[0];
    $out_mail = $wkAr[1];
  }else{
     if (count($wkAr) == 1) {
       $out_id = "";
       $out_mail = $wkAr[0];
     }
  }
}
//----------------------------------------------------------------------
//  ユーザーID+メールアドレスの処理関数(END)
//----------------------------------------------------------------------


//----------------------------------------------------------------------
//  CSVダウンロード処理 (START)
//----------------------------------------------------------------------
if(isset($_POST['kikan_download']) && count($res) > 0){
	$csv = '';
	//フォーム項目を取得
	$getFormData = dataListSort_ForCSV(file($cmsOrderFilePath));
	
	//CSVのヘッダ
	//$csv .= csv_string('お問い合わせ日').',';
	$csv .= csv_string('メール受信日').',';  //2016/4/4

	$labelcnt = count($getFormData) + 1;  //管理ラベル数の取得　　  +1は「お問い合わせ日」の分

	foreach($getFormData as $getFormDataVal){
		$getFormDataValArr = explode(',',$getFormDataVal);
		//メールアドレスの場合はユーザーIDを分離  2017/6/17
		//$csv .= csv_string($getFormDataValArr[2]).',';
		if ($getFormDataValArr[2] == 'メールアドレス') {
			$csv .= csv_string('ユーザーID').','.csv_string('メールアドレス').',';
		}else{
			$csv .= csv_string($getFormDataValArr[2]).',';
		}
	}
	$csv .= "\n";//I改行コード挿入


//--- Cyfons ・・・ .csv先頭の「お問い合わせ日」が検索対象！


	$hitIndex = 2;
	if ($_GET['id'] == 1) {
		/* 基本フォームの場合はインデックスが1つ多い */
		$hitIndex = 3;
    }

	foreach($res as $val){

		$labelYukoCnt = 0;
        $wkID = "";
        $wkMail = "";

		foreach($val as $kk => $vv)
		{
			if(strpos($vv,'0') === 0 && $csv_data_esc ==1) 
			{
				$csv .= '=';
			}
            //メールアドレスの場合は、ユーザーIDと分離する
			//$csv .= csv_string($vv).",";
			if ($labelYukoCnt == $hitIndex) {
                // ユーザーIDとメールアドレスに分離する
                get_id_mail($vv, $wkID, $wkMail);
				$csv .= csv_string($wkID).",";
				$csv .= csv_string($wkMail).",";
			} else {
				$csv .= csv_string($vv).",";
			}

			$labelYukoCnt ++;
		}
		//末尾の未対応項目数分の追加
		for ($i = 0; $labelYukoCnt + $i < $labelcnt; $i++) {
			$csv .= '"-",';
		}
		//$csv = rtrim($csv,",");
		$csv .= "\n";//I改行コード挿入
	}

//--- Cform  ・・・ 予約日時が対象！！

	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename=' . date('Ymd',strtotime($stratYmd)).'_'. date('Ymd',strtotime($endYmd)).'.csv');
	print($csv);
	exit();
}

//----------------------------------------------------------------------
//  CSVダウンロード処理 (END)
//----------------------------------------------------------------------

cffsg($warningMesse02,$cfilePath);

?>



<?php if(empty($form_data['status'])) header('Location:/'); ?>
<?php require_once( '../../../common/element/doctype.php' ); ?>
<?php require_once( '../../../common/config.ini'); ?>


<body>
<div id="header">
<div class="navbar navbar-fixed-top">
<div class="navbar-inner">
<div class="container">
<a href="<?php echo URL; ?>/admin/" class="brand">Cyfons管理画面</a>
<?php require_once( dirname(__FILE__).'/../../../../common/element/gnav_builder.php'); ?>
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
<?php require_once( dirname(__FILE__).'/../../../../common/element/tab_form_setting_mailform.php'); ?>



<?php if(!empty($messe))echo "<p class=\"alert alert-error\">{$messe}</p>"; ?>


<div class="waku"><p>受信メールを日付で検索します。</p>

<form action="" method="post">
<p><input type="text" name="start_ymd" class="datepicker" size="15" style="width:120px;" value="<?php echo (!empty($stratYmd)) ? $stratYmd : '';?>" /> から <input type="text" name="end_ymd" class="datepicker" size="15" style="width:120px;" value="<?php echo (!empty($endYmd)) ? $endYmd : '';?>" /> までのメールを  	
<input type="submit" name="kikan_search" class="btn btn-primary" value="　絞り込み検索　" /> 
<input type="submit" name="kikan_download" class="btn btn-primary" value="　絞り込みCSVダウンロード　" />
</p>
</form>

</div>


<div class="waku">
<p><i style="margin:2px 3px 0 0;" class="icon-ok-sign"></i><span style="font-weight:bold;">検索結果</span></p>

<?php
if(count($res) > 0){
	echo '<p>'.count($res).'件ありました。</p>';
?>
<div style="overflow-x:auto;">
<table class="formTable05">
<tr>

<th style="width:12%;"><p>メール受信日</p></th>

<?php
	//フォーム項目を取得
	// 存在しない場合は、formInit.dat から初期化する。cf. getListSorted()
	// 検索結果の表示は、全項目でなく先頭の「お問い合わせ日」+ formInit.datの先頭３項目とする 
	//  2016/4/4  複数メールフォーム対応
	if ($_GET['id'] == 1) {
		$getFormData = getListSorted_INIT($cmsInitFilePath);
	}else{
		$getFormData = getListSorted_INIT($cmsInitFilePath2);
	}

	$labelcnt = count($getFormData) + 1;  //管理ラベル数の取得   +1は「お問い合わせ日」の分


	foreach($getFormData as $getFormDataVal){
		$getFormDataValArr = explode(',',$getFormDataVal);
		echo '<th style="width:15%;">';
		echo (!empty($getFormDataValArr[2])) ? '<p>'.$getFormDataValArr[2].'</p>' : '';
		echo '</th>';
	}
?>

</tr>



<?php
	foreach($res as $val){
?>


<tr class="resultTable<?php echo $ymdArrKey;?>">
<?php

	$labelYukoCnt = 0;
    $wkID = "";
    $wkMail = "";

	$hitIndex = 2;
	if ($_GET['id'] == 1) {
		/* 基本フォームの場合はインデックスが1つ多い */
		$hitIndex = 3;
    }


	foreach($val as $kk => $vv){
		echo '<td>';

        //メールアドレスの場合は、ユーザーIDと分離する
		//echo (!empty($vv)) ? '<p>'.$vv.'</p>' : '-';

		if ($labelYukoCnt == $hitIndex) {
            // ユーザーIDとメールアドレスに分離する
            get_id_mail($vv, $wkID, $wkMail);
			echo (!empty($wkMail)) ? '<p>'.$wkMail.'</p>' : '-';
		} else {
			echo (!empty($vv)) ? '<p>'.$vv.'</p>' : '-';
		}


		echo '</td>';
		$labelYukoCnt ++;





		/* 先頭４項目のみ表示 2015/5/1 */
		// 複数メールフォーム対応  追加フォームについては先頭３項目のみ表示　2016/4/4
		if ($_GET['id'] == 1) {
			if ($labelYukoCnt > 3) 
			{ 
				break;
			}
		} else {
			if ($labelYukoCnt > 2) 
			{ 
				break;
			}
		}
	}

	//末尾の未対応項目数分の追加
	for ($i = 0; $labelYukoCnt + $i < $labelcnt; $i++) {
		// $csv .= "-,";
		echo '<td>-</td>';
	}

?>
</tr>

<?php
	}
?>

</table>
</div>

<?php
}else{
	echo '<p>データがありません</p><br /><br />';	
}
?>

</div>



</div>
</div>
</div>
</body>
</html>
