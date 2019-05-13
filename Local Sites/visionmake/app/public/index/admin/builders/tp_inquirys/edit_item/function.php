<?php
//----------------------------------------------------------------------
// 　関数定義（基本的に変更不可） (START)
//----------------------------------------------------------------------
function h($string) {
  return htmlspecialchars($string, ENT_QUOTES,'utf-8');
}


//パーミッションチェック関数 
function permissionCheck($filePath,$commentFilePath,$pulldownFilePath,$closedFilePath,$dataDir,$perm_check01,$perm_check02,$perm_check03,$reservFileDir,$timeListFilePath){
	global $configFilePath,$cmsFilePath;
	$messe = '';
	if(!is_writable($dataDir)){
		$messe = $perm_check02;
		exit($messe);
	}
	elseif(!is_writable($reservFileDir)){
		$messe = "data/reservディレクトリのパーミッションが正しくありません。777等書き込み可能なパーミッションに変更する必要があります";
		exit($messe);
	}
	elseif (!is_writable($filePath)){
		$messe = str_replace(dirname(__FILE__).'/','',$filePath).$perm_check01;
	}
	elseif(!is_writable($closedFilePath)){
		$messe = str_replace(dirname(__FILE__).'/','',$closedFilePath).$perm_check01;
	}
	elseif(!is_writable($commentFilePath)){
		$messe = str_replace(dirname(__FILE__).'/','',$commentFilePath).$perm_check01;
	}
	elseif(!is_writable($timeListFilePath)){
		$messe = str_replace(dirname(__FILE__).'/','',$timeListFilePath).$perm_check01;
	}
	
	elseif(!is_writable($cmsFilePath)){
		$messe = str_replace(dirname(__FILE__).'/','',$cmsFilePath).$perm_check01;
	}
	elseif(!is_writable($configFilePath)){
		$messe = str_replace(dirname(__FILE__).'/','',$configFilePath).$perm_check01;
	}
	
	elseif(@$_GET['check']=='permission'){
		$messe = $perm_check03;
	}
	return $messe;
}

//カレンダー生成（一般ユーザー向け表示用）PC用表形式　※デフォルト


function copyright(){//無断削除禁止（改変を行うと一部または全機能が停止もしくはランダムで不具合が発生します）
	global $copyright;
	echo $copyright;
}

function Uqa4h78r(){
	global $copyright;echo $copyright;
}
function cffsg($warningMesse02,$cfilePath){
	if(filesize($cfilePath) != 415 && filesize($cfilePath) != 410 && filesize($cfilePath) != 122 && filesize($cfilePath) != 117) exit($warningMesse02);//ASCIIモードでの転送にも対応
}
//NULLバイト除去//
function sanitize($arr){
	if(is_array($arr)){
		return array_map('sanitize',$arr);
	}
	return str_replace("\0","",$arr);
}

//----------------------------------------------------------------------
// 　関数定義（基本的に変更不可） (END)
//----------------------------------------------------------------------
//----------------------------------------------------------------------
//  関数定義　メール　(START)
//----------------------------------------------------------------------
function checkMail($str){
	$mailaddress_array = explode('@',$str);
	if(preg_match("/^[\.!#%&\-_0-9a-zA-Z\?\/\+]+\@[!#%&\-_0-9a-z]+(\.[!#%&\-_0-9a-z]+)+$/", "$str") && count($mailaddress_array) ==2){
		return true;
	}else{
		return false;
	}
}
//Shift-JISの場合に誤変換文字の置換関数
function sjisReplace($arr,$encode){
	foreach($arr as $key => $val){
		$key = str_replace('＼','ー',$key);
		$resArray[$key] = $val;
	}
	return $resArray;
}
//送信メールにPOSTデータをセットする関数
function postToMail($arr){
	$resArray = '';
	foreach($arr as $key => $val){
		$out = '';
		if(is_array($val)){
			foreach($val as $item){ 
				$out .= $item . ', '; 
			}
			$out = rtrim($out,', ');
		}else{
			$out = $val;
		}
		if(get_magic_quotes_gpc()) { $out = stripslashes($out); }
		if($out != "confirm_submit" && $key != "httpReferer" && $key != 'confirm_reserv') {
			$resArray .= "■".$key."\n".$out."\n\n";
		}
	}
	return $resArray;
}


//IDをセット
function generateID(){
//複数メールフォーム対応 2016/3/21
//	if(isset($_POST['mode']) && $_POST['mode'] == 'update'){ 
//		  $id = $_POST['id'];
//	}else{
//		  $id = @date("YmdHis");
//	}
//	return $id;
	if(isset($_POST['mode']) && $_POST['mode'] == 'update'){ 
		  $itemid = $_POST['itemid'];
	}else{
		  $itemid = @date("YmdHis");
	}
	return $itemid;
}

//並び順用関数
function dataListSort($lines){
	$jj = 0;
	$index=array();
//	$index2=array();
	foreach($lines as $val){
		$lines_array = explode(",",$val);
		// array[1]でなくarray[0]の日付IDでソート　2015/4/30
		// ここでは array[1]でみないといけない。   2015/5/2
		if(empty($lines_array[1])){
			$index[] = 0;
		}else{
			$index[] = $lines_array[1];
		}
//		$index2[] = $jj++;
	}
	// 先頭IDだけを見てソートする　2015/4/30 
	//array_multisort($index,SORT_ASC,SORT_NUMERIC,$index2,SORT_ASC,SORT_NUMERIC,$lines);

	array_multisort($index,SORT_ASC,SORT_STRING,$lines);
	return $lines;
}


/*ソートされた行の情報を取得する 2015/4/30*/
function getListSorted($cmsInitFilePath, $cmsFilePath){
	if (file_exists($cmsFilePath) == FALSE) {
		/* formInit.datをform.datにコピーする */
		copy($cmsInitFilePath, $cmsFilePath);
	}
	// 既にソートされているのでそのまま読み込む 2015/5/2
	//$lines = dataListSort(file($cmsFilePath));
	$lines = file($cmsFilePath);

	return $lines;
}

/*初期処理のソートされた行の情報を取得する(画面表示は基本項目のみ出力する！) 2015/5/1*/
function getListSorted_INIT($cmsInitFilePath){
	//$lines = dataListSort(file($cmsInitFilePath));

	$lines = dataListSort(file($cmsInitFilePath));

	$jj = 0;
	$index=array();
	foreach($lines as $val){
		$lines_array = explode(",",$val);
		if(empty($lines_array[0])){
			$index[] = 0;
		}else{
			$index[] = $lines_array[0];
		}
		$jj++;
		/*先頭から３行分のみ対象とする*/
		if ($jj == 3) {
			break;
		}
	}
	if (count($lines) > 3) {unset($lines[$jj]);}
	//array_multisort($index,SORT_ASC,SORT_STRING,$lines);
	return $lines;

}

//並び順変更
function orderChange($file_path){
	$writeData = '';
	$fp = fopen($file_path, "r+b") or die("ファイルオープンエラー");
	$lines = file($file_path);
	
	if (flock($fp, LOCK_EX)) {
		ftruncate($fp,0);
		rewind($fp);
		foreach($_POST['sort'] as $key => $val){
			foreach($lines as $lines_val){
				$lines_array = explode(',',$lines_val);
				if($lines_array[0] == $val){
					$lines_array[1] = $key;
					
						$loopNum = count($lines_array) -1;
						for($i = 0;$i < $loopNum;$i++){
							$writeData .= rtrim($lines_array[$i],"\n").',';
						}
					$writeData .= "\n";
					break 1;
				}
			}
		}
		fwrite($fp, $writeData);
	}
	fflush($fp);
	flock($fp, LOCK_UN);
	fclose($fp);
}
//指定IDデータ削除
function delData($file_path){
	$itemid = (isset($_POST["itemid"])) ? $_POST["itemid"] : exit('強制終了しました！削除する項目IDが指定されていません');
	$id = (isset($_GET["id"])) ? $_GET["id"] : exit('強制終了しました！削除するIDが指定されていません');
	
	$lines = file($file_path);
	$fp = fopen($file_path, "r+b") or die("ファイルオープンエラー");
	$lines_deleted = '';

	if(flock($fp, LOCK_EX)) {
		ftruncate($fp,0);
		rewind($fp);
		foreach($lines as $lines_val){
			$lines_array = explode(',',$lines_val);
			if($lines_array[0] != $itemid){
				fwrite($fp, $lines_val);
			}
			
			//削除対象のデータを退避しておき、foreach文を抜けた後の処理で、delete.datに追加書き込みする！　2015/4/24
			else{
				$lines_deleted = rtrim($lines_val);
			}
		}
		
	}
	fflush($fp);
	flock($fp, LOCK_UN);
	fclose($fp);



	// 指定データをdelete.dat に追加書き込みする   2015/4/24
	// 複数メールフォーム対応 2016/3/18
	//global $cmsDeleteFilePath;
	global $cmsDeleteFilePath_last,$dataDir;
	if ($id == 1) {
		$inqid = '';
	}else{
		$inqid = $id;
	}
	$cmsDeleteFilePath = $dataDir.$inqid.$cmsDeleteFilePath_last;


	$fp = fopen($cmsDeleteFilePath, "a+") or die("削除管理ファイル オープンエラー");
	
	if(flock($fp, LOCK_EX)) {
		$delDate = @date("YmdHis");  // 削除年月日
		$data = $lines_deleted.'1,'.$delDate;
		fwrite($fp, $data."\n");
	}
	fflush($fp);
	flock($fp, LOCK_UN);
	fclose($fp);


	// formOrder.datの更新 (cmsOrderFilePath)       2015/4/24
	//    form.datとdelete.datの内容を元に作成する
	updateFormOrderDat();



}



//CSV処理用の並び順用関数  2015/4/22 
function dataListSort_ForCSV($lines){
	$jj = 0;
	$index=array();
//	$index2=array();
	foreach($lines as $val){
		$lines_array = explode(",",$val);
		// array[1]でなくarray[0]の日付IDでソート
		if(empty($lines_array[0])){
			$index[] = 0;
		}else{
			$index[] = $lines_array[0];
		}
//		$index2[] = $jj++;
	}
	
	//array_multisort($index,SORT_ASC,SORT_NUMERIC,$index2,SORT_ASC,SORT_NUMERIC,$lines);
	array_multisort($index,SORT_ASC,SORT_STRING,$lines);
	return $lines;
}


	// 存在しない場合は、formInit.dat から初期化する。cf. getListSorted() 2015/4/30
function getListSorted_ForCSV($cmsInitFilePath, $cmsOrderFilePath){
	if (file_exists($cmsOrderFilePath) == FALSE) {
		/* formInit.datをformOrder.datにコピーする */
		copy($cmsInitFilePath, $cmsOrderFilePath);
	}
	$lines = dataListSort_ForCSV(file($cmsOrderFilePath));

	return $lines;

}


//----------------------------------------------------------------------
//  関数定義　CSV関連　(START)   2015/4/22
//----------------------------------------------------------------------

//改行、カンマ用の当て字を改行コードに相互変換
function dataToBrcodeAndKanma($str,$mode = 0){
	if($mode > 0){
		
		$str = str_replace('__br__',"\n",$str);	
		$str = str_replace('__kanma__',",",$str);
		
	}
	else{
		$str = str_replace(array("\n","\r"),array('__br__',''),$str);	
		$str = str_replace(",",'__kanma__',$str);	
	}
	return $str;
}

// CSV文字列として変換する
function csv_string($str){
	$csv_data = $str;
	$csv_data = str_replace('"','""',$csv_data);
	$csv_data = str_replace(',','、',$csv_data);
	return '"'.mb_convert_encoding($csv_data, "sjis-win", "utf-8").'"';
}


//---------------------------------------------------------
// form.datの内容を元にCSVに格納する  2015/4/22
//   arg1  回答内容の配列とする
//   使用するグローバル変数 ⇒ この使い方はNG！
//       ①csv_file_path　②cmsOrderFilePath  ③csv_data_esc
//         ↑ user.csv       formOder.dat            "1"
//
//   arg6  userテーブルのid (Call側で、get_user_id()を
//         用いて設定しておくこと)  2017/6/17
//---------------------------------------------------------
function csvBackup($csv_file_path,$cmsOrderFilePath,$csv_data_esc,$form_data,$cmsInitFilePath,$userid){


/*★cFormの元ソースではregDataは指定されてこない！
    ⇒ ここで固定で設定 */

	if (file_exists($cmsOrderFilePath) == FALSE) {
		/* formInit.datをformOrder.datにコピーする */
		copy($cmsInitFilePath, $cmsOrderFilePath);
	}

	// ①formOrder.dat ファイルから、並び順の情報を取得
	$lines = dataListSort_ForCSV(file($cmsOrderFilePath));

		//----------------------------------------------------------------------
		//  CSVファイルの存在チェック(BEGIN)
		//----------------------------------------------------------------------
		//ファイルが存在しない場合にはヘッダーをつけてファイルを生成します ⇒ ★Cyfonsではヘッダーは付けない！ 2015/4/27
		if(!file_exists($csv_file_path)){
			
			$csv  = "";//初期値

			$fp = fopen($csv_file_path, 'a');//ファイルを生成します
			flock($fp,LOCK_EX);
//			fwrite($fp,$csv);
			fflush($fp);
			flock($fp,LOCK_UN);
			fclose($fp);
			@chmod($csv_file_path, 0666);
		}
		//----------------------------------------------------------------------
		//  CSVファイルの存在チェック(END)
		//----------------------------------------------------------------------
		
		//----------------------------------------------------------------------
		//  CSV形式での保存処理(BEGIN)
		//----------------------------------------------------------------------
		// 入力フォームで入力された内容の保存
		$csv  = "";//初期値

		$csv .= csv_string(@date( "Y/m/d", time() )).",";  			//お問合せ画面での送信日



		$chkName = '';

		foreach($lines as $val){
			//データ未入力の場合には空データで埋める
			$out = "";
			
			$linesArray = explode(',',$val);

			//if(isset($_POST[$regDataVal]) && $_POST[$regDataVal] != ""){
			if(!empty($linesArray[2]) && !empty($linesArray[3])){


				// 削除フラグが指定され、かつ値が1でない
				if(!empty($linesArray[10]) && $linesArray[10] == 1){
					//過去に同名で定義および削除された項目があると、ここに来る
				}else{
					// form内の変数の名称($form_data[$linesArray[2]])を元にForm上の値を取得する。
					//   回答肢が複数ある場合の考慮が前半の処理

					//-- メールアドレスにusersテーブルのidを先頭に付加 2017/6/17 --
                    $isMail = 0;
					if (strcmp($linesArray[2], 'お問い合わせ件名') == 0) 
					{
						$chkName = 'title';
					}else{
						$chkName = $linesArray[2];

						if (strcmp($linesArray[2], 'メールアドレス') == 0) 
						{
							$isMail = 1;
						}
					}

					// 回答されない場合、値が設定されないことの考慮を追加  2015/11/6
					if (isset($form_data[$chkName])) {

						if(is_array($form_data[$chkName])){
							foreach($form_data[$chkName] as $item){ 
								$out .= $item . ', '; 
							}
							$out = rtrim($out,", ");
							
						}else{
							if ($isMail == 1) {
								/* メールアドレスの場合はuserテーブルのidを先頭に付加する 2017/6/17*/
								$out = $userid.'|'.$form_data[$chkName];
							}else{
								$out = $form_data[$chkName];
							}
						}
					}
				}
			}

			if ($out == '') {
				$out = "-";
			}

			$writeData = $out;
			
			if(get_magic_quotes_gpc()) { $writeData = stripslashes($writeData); }
			//先頭に0が含まれていたら「=」を追記　※エクセル先頭0消える問題対策
			if(strpos($writeData,'0') === 0 && $csv_data_esc ==1) {
				$csv .= '=';
			}
			$csv .= csv_string($writeData).",";
		}


		
		$csv = rtrim($csv,",");
		$csv .= "\n";//I改行コード挿入
		
		$fp = fopen($csv_file_path, 'a');  //'a'の場合ファイルポインタはファイルの最後になる
		
		flock($fp,LOCK_EX);
		fwrite($fp,$csv);
		fflush($fp);
		flock($fp,LOCK_UN);
		fclose($fp);
		
		//----------------------------------------------------------------------
		//  CSV形式での保存処理(END)
		//----------------------------------------------------------------------
}


//CSVデータの取得  ・・・ 流用元 user.php でCallされている。   表示機能で使用 2015/4/22
function by_tmpfile($file) {
	$res = array();

	/*ファイル存在チェック 2015/4/30*/
	if (file_exists($file) == FALSE) {return $res;}

	$buf = mb_convert_encoding(file_get_contents($file), 'utf-8', 'sjis-win');
	$fp = tmpfile();
	fwrite($fp, $buf);
	rewind($fp);
	while($line = fgetcsv($fp)) {
		$res[] = $line;
	}
	fflush($fp);
	flock($fp,LOCK_UN);
	fclose($fp);
	return $res;
}




// formOrder.datの更新 (cmsOrderFilePath)       2015/4/24
//    form.datとdelete.datの内容を元に作成する
function updateFormOrderDat(){

	// 複数メールフォーム対応 2016/3/18
	$id = (isset($_GET["id"])) ? $_GET["id"] : exit('強制終了しました！更新するIDが指定されていません');

	global $cmsFilePath_last,$cmsDeleteFilePath_last,$cmsOrderFilePath_last,$dataDir;
	if ($id == 1) {
		$inqid = '';
	}else{
		$inqid = $id;
	}
	$cmsFilePath = $dataDir.$inqid.$cmsFilePath_last;
	$cmsDeleteFilePath = $dataDir.$inqid.$cmsDeleteFilePath_last;
	$cmsOrderFilePath = $dataDir.$inqid.$cmsOrderFilePath_last;



	$lines = file($cmsFilePath);				//form.dat
	if (file_exists($cmsDeleteFilePath)) {			//delete.datの存在チェック 2015/7/16
		$deleteLines = file($cmsDeleteFilePath);	//delete.dat
	}

	//$fp = fopen($cmsOrderFilePath, "r+b") or die("formOrder.dat fopen Error!!");
	$fp = fopen($cmsOrderFilePath, "a+") or die("formOrder.dat fopen Error!!");

	// 俳他的ロック
	if (flock($fp, LOCK_EX)) {
		ftruncate($fp,0);	//ファイルの中身を空にする
		rewind($fp);
		
		//① form.dat の内容を書き込み
		foreach($lines as $val){
			fwrite($fp, $val);// 書き込み
		}

		//② delete.dat の内容を書き込み
		if (file_exists($cmsDeleteFilePath)) {			//delete.datの存在チェック 2015/7/16
			foreach($deleteLines as $val){
				fwrite($fp, $val);// 書き込み
			}
		}
	}
	fflush($fp);
	flock($fp, LOCK_UN);
	fclose($fp);
}


// form.datファイルのフォルダが未生成の場合作成する  2016/3/27  複数メールフォーム対応
//   作成例
//    ①/admin/builders/tp_inquirys/edit_item/data2
//    ②/admin/builders/tp_inquirys/edit_item/data2/form
//    ③/admin/builders/tp_inquirys/edit_item/data2/user
function createFormDatFolder($folderInqid)
{
    if (!file_exists($folderInqid)) {
        mkdir($folderInqid);
        mkdir($folderInqid.'/form');
        mkdir($folderInqid.'/user');
    }
}

//----------------------------------------------------------------------
//  関数定義(END)
//----------------------------------------------------------------------
?>