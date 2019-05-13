<?php
$target_dir = date('Y/m');
$filename   = date('md-His');

$base_path = str_replace('common/js/tiny_mce/plugins/quickuploadfile/upload.php','',str_replace('\\','/',__FILE__));
$base_url  = str_replace('common/js/tiny_mce/plugins/quickuploadfile/upload.php','',$_SERVER['SCRIPT_NAME']);
$fb_dir  =  'myfiles/file/';

$upload_maxsize = return_bytes(ini_get('upload_max_filesize'));

if(isset($_FILES['file']))
{
	if((0 < $_FILES['file']['error']) || ($upload_maxsize < $_FILES['file']['size']))
	{
		$msg = 'ファイルサイズが大き過ぎます。';
	}
	else
	{
		$ext = substr($_FILES['file']['name'], strrpos($_FILES['file']['name'],'.'));
		$ext = strtolower($ext);
		$ext = trim($ext, '.');
		$msg = '';
		switch($ext)
		{
			case 'txt' :
			case 'pdf' :
			case 'zip' :
				$tpl = $_POST['linkstr'];
				if(!$tpl) $tpl = 'ファイルダウンロード';
				break;
			default    :
				$msg = "<p>{$ext} - このファイルは扱えません。</p>";
				break;
		}
	}
}

if (empty($msg) && isset($_FILES['file']) && is_uploaded_file($_FILES['file']['tmp_name']))
{
	$upload_path = "{$base_path}{$fb_dir}{$ext}/{$target_dir}";
	$upload_dir  = "{$base_url}{$fb_dir}{$ext}/{$target_dir}";
	if(!is_file($upload_path) || !is_dir($upload_path)) mkdir_r($upload_path);
	
	$ph['ファイル名']     = "{$fb_dir}{$ext}/{$target_dir}/{$filename}.{$ext}";
	$str = parseText($tpl,$ph);
	move_uploaded_file($_FILES['file']['tmp_name'], "{$upload_path}/{$filename}.{$ext}");
?>
<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
<script>
	var FileDialog = {
		init : function(ed)
		{
			ed.execCommand('mceInsertContent', false,
			tinyMCEPopup.editor.dom.createHTML('a',
			{
				href : '<?php echo "{$upload_dir}/{$filename}.{$ext}"; ?>',
			},
			'<?php echo $str;?>')
			);
			
			tinyMCEPopup.editor.execCommand('mceRepaint');
			tinyMCEPopup.editor.focus();
			tinyMCEPopup.close();
		}
	}
	tinyMCEPopup.onInit.add(FileDialog.init, FileDialog);
</script>
<?php
}
else
{
	if(empty($msg)) $msg = "<p>ファイルを選択してください。</p>";
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
<script type="text/javascript" src="js/dialog.js"></script>
<link href="css/dialog.css" rel="stylesheet" type="text/css" />
<title>ファイルアップロード</title>
</head>
<body>
<?php echo $msg;?>
<form name="iform" action="" method="post" enctype="multipart/form-data">
  <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo $upload_maxsize;?>" />
  <input id="file" type="file" name="file" onchange="this.parentElement.submit()" />
  <input id="linkstr" type="hidden" name="linkstr" value="" />
</form>
拡張子「txt」「pdf」「zip」のファイルをアップロードできます。
<script>
	var linkstr = tinyMCEPopup.editor.selection.getContent({format : 'text'});
	if(!linkstr) linkstr = 'ファイルダウンロード';
	document.getElementById('linkstr').value = linkstr;
</script>
</body>
</html>
<?php }

function mkdir_r($dir)
{
	if(file_exists($dir)) return false;
	if(strpos($dir, '/')!==false && !file_exists(dirname($dir)))
	{
		if (mkdir_r(dirname($dir)) === false) return false;
	}
	$rs = mkdir($dir);
	if($rs) chmod($dir, 0777);
	return $rs;
}

function parseText($tpl,$ph)
{
	foreach($ph as $k=>$v)
	{
		$tpl = str_replace("[+{$k}+]",$v,$tpl);
	}
	return $tpl;
}

function return_bytes($val) {
    $val = trim($val);
    $last = strtolower(substr($val,-1));
    $val = (int)$val;
    switch($last) {
        case 'g': $val *= 1024;
        case 'm': $val *= 1024;
        case 'k': $val *= 1024;
    }

    return $val;
}
