<?php
session_start();
require_once('site-config.php');
require_once('authorize.php');
require_once('./common/users.php');
require_once('./common/mails.php');
require_once('./common/builders.php');

$mailsObj = new mails();
$buildersObj = new builders();
if (isAuthAlive() == true) {
    $usersObj = new users();
    $email = htmlspecialchars($_SESSION[SESSION_USER_ID]);
    $form_data['email'] = $email;
    $form_data['auth'] = USER_ROLL;
    $form_data['scenario_id'] = SCENARIOS_ID;
    $usersObj->search_email($form_data, $user);
    $user = $user[0];
    $user['group_name'] = $usersObj->db_get_group_name($user['group_id']);

    $buildersObj->get_data($_REQUEST, $data);
    $row = array();
    $row['title'] = "";
    $row['header'] = "";
    $row['contents'] = "";
    $row['footer'] = "";
    if (isset($data['id'])) {
        $mailsObj->get_extra_mail_contents($list, $data['id']);
        if (!empty($list)) {
            $row = $list[0];
            $extra_mail_send_date = $row['send_done'];

            // 号外メールを送信した実績日を格納
            $user['today'] = $extra_mail_send_date;

            $row['header'] = $buildersObj->txtReplace($row['header'], $user, $extra_mail_send_date);
            $row['title'] = $buildersObj->txtReplace($row['title'], $user, $extra_mail_send_date);
            $row['contents'] = $buildersObj->txtReplace($row['contents'], $user, $extra_mail_send_date);
            $row['footer'] = $buildersObj->txtReplace($row['footer'], $user, $extra_mail_send_date);
        }
    }
} else {
    header('Location:' . URL . '/index.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo $row['title'] ?></title>
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <link rel="stylesheet" href="<?php echo URL; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URL; ?>/css/bootstrap.css">
    <style>
        dl {
            margin-top: 10px;
        }

        dt {
            border-bottom: 1px #aaa solid;
            margin-bottom: 0.5em;
            padding: 3px 0.5em 3px 0.5em;
        }

        dd {
            margin-bottom: 1.5em;
        }
    </style>
</head>
<body>
<div class="container" style="">
    <dl>
        <dt>タイトル</dt>
        <dd><?php echo $row['title']; ?></dd>
        <dt>記事</dt>
        <dd>
            <?php if (!empty($row['header'])) {
                echo nl2br($row['header']);
                echo '<br>';
            } ?>
            <?php echo nl2br($row['contents']); ?><br>
            <?php if (!empty($row['footer'])) {
                echo nl2br($row['footer']);
                echo '<br>';
            } ?>
        </dd>
    </dl>
</div><!-- end of container -->
</body>
</html>