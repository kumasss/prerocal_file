<?php
session_start();
require_once('site-config.php');
require_once('authorize.php');
require_once('./common/builders.php');
$buildersObj = new builders();
$buildersObj->get_all_setting($settings_data);
$buildersObj->get_all_img_uploaders2($img_uploaders_data, $position = HEADER, 0, 1);
$data['site_name'] = htmlspecialchars_decode($settings_data['site_name'], ENT_QUOTES);
$data['head'] = htmlspecialchars_decode($settings_data['head']);
$data['css'] = htmlspecialchars_decode($settings_data['css']);
$data['header_img'] = (!empty($img_uploaders_data)) ? URL . '/' . $img_uploaders_data[0]['store_folder'] . '/' . $img_uploaders_data[0]['store_file'] : null;
$errorMessage = '';
$auth = '';
$userid = '';
$password = '';
if (!$buildersObj->get_all_top($tops_data)) {
    echo $err['top'] = "トップページが作成されていません。";
} else {
    $data['title'] = htmlspecialchars_decode(nl2br($tops_data['title']));
    $data['contents'] = htmlspecialchars_decode(nl2br($tops_data['contents']));
    $data['description'] = $tops_data['description'];
    $data['keyword'] = $tops_data['keyword'];
}
if (!empty($_SESSION[SESSION_USER_ID]) && !empty($_SESSION[SESSION_PASSWORD])) {
    $auth = jdgAuth($_SESSION[SESSION_USER_ID], $_SESSION[SESSION_PASSWORD], $data);
    if ($auth === AUTH_RES_PASS) {
        session_regenerate_id(true);
        header("Location: main.php");
    } else {
        $_SESSION = array();
        @session_destroy();
    }
}
if (!empty($_POST["login"])) {
    if (!empty($_POST["userid"]) && !empty($_POST["password"])) {
        $userid = htmlspecialchars(trim($_POST["userid"]));
        $password = htmlspecialchars(trim($_POST["password"]));
        $auth = jdgAuth($userid, $password, $data);
    } else {
        $auth = AUTH_RES_EXCEPTION;
    }
    switch ($auth) {
        case AUTH_RES_PASS:
            break;
        case AUTH_RES_EXCEPTION:
            $errorMessage = '<p style="color:red;">正確に入力してください。</p>';
            break;
        default:
            $errorMessage = '<p style="color:red;">正確に入力してください。</p>';
            break;
    }
    if ($auth == AUTH_RES_PASS) {
        session_regenerate_id(true);
        $_SESSION[SESSION_USER_ID] = $userid;
        $_SESSION[SESSION_PASSWORD] = $password;
        $_SESSION[SESSION_REG_DATE] = $data['reg_date'];
        $_SESSION[SESSION_GROUP_ID] = $data['group_id'];
        $_SESSION['auth'] = USER_ROLL;
        $page = (isset($_SESSION["page"])) ? htmlspecialchars(trim($_SESSION["page"])) : null;
        $mode = (isset($_SESSION["mode"])) ? htmlspecialchars(trim($_SESSION["mode"])) : null;
        $host = (isset($_SESSION["host"])) ? htmlspecialchars(trim($_SESSION["host"])) : null;
        $req_uri = (isset($_SESSION["req_uri"])) ? htmlspecialchars(trim($_SESSION["req_uri"])) : null;
        if (!empty($page)) {
            if (is_numeric($page)) {
                $url = "/page.php?page=" . $page;
            } elseif (isset($mode)) {
                $url = "/" . $page . ".php?mode=" . $mode;
            } else {
                $url = "/" . $page . ".php";
            }
        } elseif (!empty($req_uri) & !empty($host)) {
            $url = $req_uri;
            if (!empty($_SERVER['HTTPS'])) {
                $http = 'https://';
            } else {
                $http = 'http://';
            }
            header("Location:" . $http . $host . $url);
            exit;
        } else {
            $url = "/main.php";
        }
        header("Location:" . URL . $url);
        exit;
    }
} ?>
<?php ?>
<!-- Doctype -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?php echo ($data['title']) ? $data['title'] . '&nbsp;|&nbsp;' . $data['site_name'] : $data['site_name']; ?></title>
    <meta name="description" content="<?php echo $data['description']; ?>">
    <meta name="keywords" content="<?php echo $data['keyword']; ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <link rel="stylesheet" href="<?php echo URL; ?>/css/zerogrid.css">
    <link rel="stylesheet" href="<?php echo URL; ?>/css/style.css">
    <link rel="stylesheet" href="<?php echo URL; ?>/css/bootstrap.css">
    <link rel="stylesheet" href="<?php echo URL; ?>/css/responsive.css">
    <link rel="stylesheet" href="<?php echo URL; ?>/css/advanced.css">
    <link rel="stylesheet" href="<?php echo URL; ?>/css/font.css">
    <link rel="stylesheet" href="<?php echo URL; ?>/template/<?php echo $data['css']; ?>">
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>

    <?php echo (!empty($data['head'])) ? htmlspecialchars_decode($data['head']) : null; ?>
</head>
<!-- Header -->
<body>
<header>
    <div class="wrap-header zerogrid">
        <?php if (empty($data['header_img'])) { ?>
            <div id="logotxt"><a
                        href="<?php echo URL; ?>"><?php echo ($data['site_name']) ? $data['site_name'] : 'タイトル'; ?></a>
            </div>
        <?php } else { ?>
            <div id="logoimg"><a href="<?php echo URL; ?>"><img src="<?php echo $data['header_img']; ?>"
                                                                alt="<?php echo $data['site_name']; ?>"></a></div>
        <?php }; ?>
    </div>
</header>
<!-- Content -->
<section id="content">
    <div class="wrap-content zerogrid">
        <div class="row block">
            <div id="main-content" class="col-full">
                <div class="wrap-col">
                    <article>

                        <div class="heading">
                            <?php echo '<h2>' . $data['title'] . '</h2>'; ?>
                            <div class="info"></div>
                        </div>
                        <div class="content">

                            <!-- Page original start -->
                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <fieldset>
                                    <div><?php echo $errorMessage ?></div>
                                    <label for="userid">User ID</label><input type="text" id="userid" name="userid"
                                                                              value="<?php echo $userid; ?>">
                                    <br>
                                    <label for="password">Password</label><input type="password" id="password"
                                                                                 name="password"
                                                                                 value="<?php echo $password; ?>">
                                    <br>
                                    <?php ?>
                                    <label></label><input type="submit" id="login" name="login" value="ログイン"
                                                          class="btn btn-primary">
                                </fieldset>
                            </form>
                            <p>
                                ※パスワードを忘れた方は
                                <a onclick="window.open('<?php echo URL; ?>/forgot.php','forgot','width=600,height=400,scrollbars=yes,resizable=yes,toolbar=no,location=no,directories=no,status=no,menubar=no');"
                                   href="<?php echo URL; ?>/index.php">こちら</a>
                                からパスワードの取得を行ってください。
                                <br>
                            </p>

                            <!-- Page original end -->
                        </div>
                    </article>
                </div>
            </div>

        </div>
    </div>
</section>
<!-- Footer -->
<footer>
    <div class="copyright">
        <p>&copy; <?php echo ($data['site_name']) ? $data['site_name'] : 'サイト名'; ?></p>
    </div>
</footer>
<script>
    $(function () {
        function clearMemory() {
            sessionStorage.clear();
            sessionStorage.setItem("status", "false");
            $('#session').attr("disabled", "disabled");
        }

        if (
            sessionStorage.getItem('id') == null ||
            sessionStorage.getItem('password') == null ||
        <?php echo !empty($errorMessage) ? "true" : "false"; ?>
        ) {
            clearMemory();
        }

        var tmp_user = "";
        var tmp_pass = "";
        $("#session").on("change", function () {
            if (!$('#session').prop("checked")) {
                $('#userid').val(tmp_user);
                $('#userid').removeAttr("readonly");
                $('#password').val(tmp_pass);
                $('#password').removeAttr("readonly");
            } else {
                tmp_user = $('#userid').val();
                $('#userid').val(sessionStorage.getItem('id'));
                $('#userid').attr("readonly", "readonly");
                tmp_pass = $('#password').val();
                $('#password').val(sessionStorage.getItem('password'));
                $('#password').attr("readonly", "readonly");
            }
        });

        $("form").on("submit", function () {
            if ($('#userid').val() != "" && $('#password').val() != "") {
                sessionStorage.setItem("id", $('#userid').val());
                sessionStorage.setItem("password", $('#password').val());
            } else {
                clearMemory();
            }
            return true;
        });
    });
</script>
</body>
</html>
