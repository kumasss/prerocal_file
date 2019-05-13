<?php
session_start();
// load modules
require_once('../site-config.php');
require_once('../common/users.php');
require_once('../common/mails.php');
require_once('../common/groups.php');
require_once('../common/builders.php');
$userObj = new users();
$mailsObj = new mails();
$groupObj = new groups();
$buildersObj = new builders();



function err_redirect($line) {
	//echo $line;
	http_response_code(404);
	exit;
}

// 表示したくない項目を空白に置き換える
function content_filter($text) {
	$text = str_replace("%form_edit%", "", $text);
	$text = str_replace("%form_stop%", "", $text);
	$text = str_replace("%stopurl%", "", $text);
	$text = str_replace("%passeddays%", "", $text);
	$text = str_replace("%password%", "", $text);
	return $text;
}


/* NOTE: キーを分割する */
$key = htmlspecialchars($_GET["key"]);
if (
	empty($key) ||//キーの有無
	!(strlen($key) >= 25 && strlen($key) <= 27) ||//長さチェック
	empty($group_code = substr($key, 0, 8))	||
	empty($user_id = (int)substr($key, 8, 6))	||
	empty($key_hash = substr($key, 14, 11))
) err_redirect(__LINE__);
$mail_type = !empty(substr($key, 25, 2)) ? substr($key, 25, 2) : NULL;

//ハッシュが正しいかチェックする
if (substr(md5($group_code . $user_id), 0, 11) != $key_hash) {
	err_redirect(__LINE__);
}


// ユーザ情報の取得
$userObj->db_set_user($user_id);
$user = $userObj->db_get_user();

// ユーザチェック
if ($user == NULL || $user['delete_flg'] != 0) err_redirect(__LINE__);

// グループのコードが一致するか確認する
$groupcheck_result = $groupObj->check_same_group_code($group_code);
if ($groupcheck_result == 0 && $group_code != substr(md5($user["group_id"]), 0, 8)) {
	err_redirect(__LINE__);
}
$groupObj->get_group($user["group_id"], $group);

if (!isset($mail_type) || $mail_type != "11") {// ステップメール取得
	$mailsObj->get_backnumber_step_mails($user_id, $mails);
} else {// 号外メール取得
	$mailsObj->get_backnumber_extra_mails($mails, (int)$user["group_id"], $user_id);
}
$stepmail_url = $mailsObj->get_backnumber_url($user_id);
$extramail_url = $mailsObj->get_backnumber_url($user_id, true);


// 置換する文字列の定義
$replace_str["firstname"] = !empty($user["firstname"]) ? $user["firstname"] : "";
$replace_str["lastname"] = !empty($user["lastname"]) ? $user["lastname"] : "";
$replace_str["email"] = !empty($user["email"]) ? $user["email"] : "";
$replace_str["stepmail_url"] = !empty($stepmail_url) ? $stepmail_url : "";
$replace_str["extramail_url"] = !empty($extramail_url) ? $extramail_url : "";
$replace_str["group_name"] = !empty($group["group_name"]) ? $group["group_name"] : "";
$replace_str["user_id"] = !empty($user["id"]) ? $user["id"] : "";
$replace_str["password"] = "";
$replace_str["ip"] = "";
$replace_str["order_no"] = "";
$replace_str["stopurl"] = "";
$replace_str["form_stop"] = "";
$replace_str["created"] = "";
$replace_str["send_date"] = "";
$replace_str["passeddays"] = "";
$replace_str["host"] = "";
$replace_str["today"] = "";

// サイトの設定を取得する
$buildersObj->get_all_setting( $settings_data );
$buildersObj->get_all_img_uploaders2( $img_uploaders_data, $position=HEADER, 0, 1 );
$data['header_img'] = (!empty($img_uploaders_data)) ? URL.'/'.$img_uploaders_data[0]['store_folder'].'/'.$img_uploaders_data[0]['store_file']:NULL;
$data['site_name'] = htmlspecialchars_decode( $settings_data['site_name'], ENT_QUOTES );
$data['head'] = htmlspecialchars_decode( $settings_data['head'] );
$data['css'] = htmlspecialchars_decode( $settings_data['css'] );
$data['title'] = "メルマガバックナンバー一覧";
?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta charset="UTF-8">
		<meta name="robots" content="noindex">
		<title><?php echo ($data['title']) ? $data['title'].'&nbsp;|&nbsp;'.$data['site_name'] : $data['site_name'];?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
		<link rel="stylesheet" href="<?php echo URL; ?>/css/zerogrid.css">
		<link rel="stylesheet" href="<?php echo URL; ?>/css/style.css">
		<link rel="stylesheet" href="<?php echo URL; ?>/css/bootstrap.css">
		<link rel="stylesheet" href="<?php echo URL; ?>/css/responsive.css">
		<link rel="stylesheet" href="<?php echo URL; ?>/css/advanced.css">
		<link rel="stylesheet" href="<?php echo URL; ?>/css/font.css">
		<link rel="stylesheet" href="<?php echo URL; ?>/template/<?php echo $data['css']; ?>">
		<?php echo (!empty($data['head'])) ? htmlspecialchars_decode($data['head']) : NULL; ?>
	</head>
	<body>
		<header>
			<div class="wrap-header zerogrid">
				<?php if (empty($data['header_img'])) { ?>
					<div id="logotxt"><a href="<?php echo URL;?>"><?php echo ($data['site_name'])?$data['site_name']:'タイトル';?></a></div>
				<?php } else { ?>
					<div id="logoimg"><a href="<?php echo URL;?>"><img src="<?php echo $data['header_img'];?>" alt="<?php echo $data['site_name'];?>"></a></div>
				<?php } ?>
			</div>
		</header>
		<section id="content">
			<div class="wrap-content zerogrid">
				<div class="row block">
					<div id="main-content" class="col-full">
						<div class="wrap-col">
							<article>
								<div class="heading">
									<h2>メールマガジン：<?php echo $data["title"] ?></h2>
								</div>
								<div class="content">
									<?php if (empty($mails)) { ?>
										<p>表示可能なバックナンバーはありません。</p>
									<?php } else { ?>
										<table class="table table-hover backnumber_list">
											<tbody>
												<?php foreach($mails as $mail_key => $mail_list) { ?>
													<tr>
														<td style="cursor: pointer;">
															<h4><?php echo $mail_list["title"] ?></h4>
														</td>
													</tr>
													<tr>
														<td style="display: none;">
															<pre style="display: none;"><?php echo $mailsObj->txtReplace(content_filter($mail_list["header"] . "\r\n" . $mail_list["contents"] . "\r\n" . $mail_list["footer"]), $replace_str); ?></pre>
														</td>
													</tr>
												<?php } ?>
											</tbody>
										</table>
									<?php } ?>
								</div>
							</article>
						</div>
					</div>
				</div>
			</div>
		</section>
		<footer>
			<div class="copyright">
				<p>&copy;  <?php echo ($data['site_name']) ? $data['site_name'] : 'サイト名'; ?></p>
			</div>
		</footer>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script>
			$(function() {
				$("table.backnumber_list tr:even td").on("click", function() {
					$(this).parent().next().find("td").slideToggle();
					$(this).parent().next().find("pre").slideToggle();
				});
			});
		</script>
	</body>
</html>