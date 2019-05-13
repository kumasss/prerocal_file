<?php
require_once(dirname(__FILE__) . '/config.ini');

class main
{
    protected $pdo;
    protected $stmt;
    protected $reqData;
    protected $version;
    protected $err;

    function __construct()
    {
        try {
            if (version_compare(PHP_VERSION, '5.6.0') >= 0) {
                $this->pdo = new PDO('mysql:host=' . DB_HOST . ';charset=utf8;dbname=' . DB_NAME, DB_USER, DB_PASSWORD);
            } else {
                $options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',);
                $this->pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD, $options);
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        date_default_timezone_set('Asia/Tokyo');
        ini_set("session.bug_compat_42", 0);
        ini_set('display_errors', 1);
    }

    function __destruct()
    {
        $this->pdo = null;
    }

    function get_data($data, &$aryData)
    {
        $aryData = array();
        foreach ($data as $key => $value) {
            if (!is_array($value)) {
                $$key = isset($value) ? htmlspecialchars($value, ENT_QUOTES) : null;
                $this->reqData[$key] = $$key;
                $aryData = $this->reqData;
            }
        }
    }

    function str_length($str, $max)
    {
        $cnt = mb_strlen($str);
        if (isset($max) && $cnt > $max) {
            $ten = '...';
        } else {
            $ten = '';
        }
        return $ten;
    }

    function show_esc($var)
    {
        if ($var != '') {
            if (!is_array($var)) {
                $var = htmlspecialchars($var);
            } else {
                foreach ($var as $key => $value) {
                    $var[$key] = $this->show_esc($value);
                }
            }
        }
        return $var;
    }

    function html_decode($var)
    {
        if ($var != '') {
            if (!is_array($var)) {
                $var = htmlspecialchars_decode($var, ENT_QUOTES);
            } else {
                foreach ($var as $key => $value) {
                    $var[$key] = $this->html_decode($value);
                }
            }
        }
        return $var;
    }

    function get_now_date()
    {
        $now = date("Y-m-d H:i:s");
        return $now;
    }

    function make_password($chars = 8)
    {
        return substr(str_shuffle('1234567890qwertyuiopasdfghjklzxcvbnm'), 0, $chars);
    }

    function date_format($date, $format = 'Y/m/d')
    {
        $d = explode('-', $date);
        $pos = strpos($d[2], ' ');
        $d[2] = $pos !== false ? substr($d[2], 0, $pos) : $d[2];
        $format = preg_quote($format);
        $pattern = array('/Y/', '/m/', '/d/');
        $formatting = preg_replace($pattern, $d, $format);
        return $formatting;
    }

    function wbsRequest($method, $url, $params = array())
    {
        $data = http_build_query($params);
        $header = Array("Content-Type: application/x-www-form-urlencoded");
        $options = array('http' => Array('method' => $method, 'header' => implode("\r\n", $header),));
        $respons = get_headers($url);
        if (preg_match("/(404|403|500)/", $respons['0'])) {
            return false;
        }
        if ($method == 'GET') {
            $url = ($data != '') ? $url . '?' . $data : $url;
        } elseif ($method == 'POST') {
            $options['http']['content'] = $data;
        }
        $content = file_get_contents($url, false, stream_context_create($options));
        return $content;
    }

    function is_ajax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
    }

    function AboutDelay($start_time, $delay)
    {
        while (time() - $start_time < $delay) {
            sleep(1);
        }
    }

    function get_last_id()
    {
        $this->db_last_id();
        $row = $this->stmt->fetchAll();
        return $row[0][0];
    }

    private function db_last_id()
    {
        try {
            $sql = "SELECT LAST_INSERT_ID();";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function data_2_int($data)
    {
        if (!empty($data)) {
            return (int)$data;
        } else {
            return 0;
        }
    }

    /**
     * @param        $from_str
     * @param        $to_str
     * @param string $send_date
     *
     * @return mixed
     */
    function txtReplace($from_str, $to_str, $send_date = 'off')
    {
        $str = $from_str;
        if (!empty($to_str['firstname'])) {
            $str = str_replace('%name1%', $to_str['firstname'], $str);
        } else {
            $str = str_replace('%name1%', '', $str);
        }
        if (!empty($to_str['firstname'])) {
            $str = str_replace('%firstname%', $to_str['firstname'], $str);
        } else {
            $str = str_replace('%firstname%', '', $str);
        }
        if (!empty($to_str['lastname'])) {
            $str = str_replace('%name2%', $to_str['lastname'], $str);
        } else {
            $str = str_replace('%name2%', '', $str);
        }
        if (!empty($to_str['lastname'])) {
            $str = str_replace('%lastname%', $to_str['lastname'], $str);
        } else {
            $str = str_replace('%lastname%', '', $str);
        }
        if (!empty($to_str['password'])) {
            $str = str_replace('%password%', $to_str['password'], $str);
        } else {
            $str = str_replace('%password%', '', $str);
        }
        if (!empty($to_str['order_no'])) {
            $str = str_replace('%order_no%', $to_str['order_no'], $str);
        } else {
            $str = str_replace('%order_no%', '', $str);
        }
        if (!empty($to_str['email'])) {
            $str = str_replace('%email%', $to_str['email'], $str);
            $url = URLSTOP . '?email=';
            $url .= urlencode($to_str['email']);
            $str = str_replace('%stopurl%', $url, $str);
        } else {
            $str = str_replace('%stopurl%', URLSTOP, $str);
        }
        $str = str_replace('%form_stop%', URLSTOP, $str);
        if (!empty($to_str['group_name'])) {
            $str = str_replace('%group%', $to_str['group_name'], $str);
        } else {
            $str = str_replace('%group%', '', $str);
        }
        if (!empty($to_str['created'])) {
            $created = date('Y年m月d日', strtotime($to_str['created']));
            $str = str_replace('%registday%', $created, $str);
        } else {
            $str = str_replace('%registday%', '', $str);
        }
        if (!empty($to_str['send_date'])) {
            if ($send_date == 'off') {
                $today = $this->get_now_date();
                $send_date = date('Y/m/d', strtotime($to_str['send_date']));
                $passeddays = abs(floor(((strtotime($send_date) - strtotime($today)) / (60 * 60 * 24)) + 1));
            } else {
                $passeddays = (isset($send_date)) ? $send_date : '';
            }
            $str = str_replace('%passeddays%', $passeddays, $str);
        } else {
            $str = str_replace('%passeddays%', '0', $str);
        }
        $str = str_replace('%url%', URL, $str);
        $str = str_replace('%form_edit%', URLEDIT, $str);

        if (!empty($to_str['ip'])) {
            $str = str_replace('%ip%', $to_str['ip'], $str);
        } else {
            $str = str_replace('%ip%', '', $str);
        }

        if (!empty($to_str['host'])) {
            $str = str_replace('%host%', $to_str['host'], $str);
        } else {
            $str = str_replace('%host%', '', $str);
        }


        /**
         * 「今日」の設定
         */
        $today_dt = new DateTime();
        // 'today'が特別に設定されている場合、その日付をベースの日付とする
        if (!empty($to_str['today'])) {
            $today_dt = new DateTime($to_str['today']);
        }

        // 「今日」
        $str = str_replace('%today%',
            $today_dt->format('Y年m月d日'),
            $str);

        // 「今日」+N日
        $pattern = '/%today\+\d{1,10}%/';
        if (preg_match($pattern, $str)) {
            preg_match_all($pattern, $str, $match);
            foreach ($match["0"] AS $val) {
                $replace_base = $val;
                $str_Val = str_replace('%', '', $val);
                $str_Val = str_replace('today+', '', $str_Val);
                if (is_numeric($str_Val)) {
                    $temp_today_dt = clone $today_dt;
                    $str = str_replace($replace_base,
                        $temp_today_dt->modify('+' . $str_Val . ' days')->format('Y年m月d日'),
                        $str);
                }
            }
        }

        // 「今日」-N日
        $pattern = '/%today\-\d{1,10}%/';
        if (preg_match($pattern, $str)) {
            preg_match_all($pattern, $str, $match);
            foreach ($match["0"] AS $val) {
                $replace_base = $val;
                $str_Val = str_replace('%', '', $val);
                $str_Val = str_replace('today-', '', $str_Val);
                if (is_numeric($str_Val)) {
                    $temp_today_dt = clone $today_dt;
                    $str = str_replace($replace_base,
                        $temp_today_dt->modify('-' . $str_Val . ' days')->format('Y年m月d日'),
                        $str);
                }
            }
        }

        if (!empty($to_str['user_id'])) {
            $str = str_replace('%id%', $to_str['user_id'], $str);
        } else {
            $str = str_replace('%id%', '', $str);
        }
        if (!empty($to_str["stepmail_url"])) {
            $str = str_replace('%bnst%', $to_str['stepmail_url'], $str);
        } else {
            $str = str_replace('%bnst%', '', $str);
        }
        if (!empty($to_str["extramail_url"])) {
            $str = str_replace('%bnex%', $to_str['extramail_url'], $str);
        } else {
            $str = str_replace('%bnex%', '', $str);
        }
        return $str;
    }

    function add_backnumber($from_str, $to_str)
    {
        $str = $from_str;
        $backnumber = $this->make_backnumber($to_str);
        $str = str_replace('%backnumber%', $backnumber, $str);
        return $str;
    }

    private function make_backnumber($user)
    {
        $group_id = $user['group_id'];
        $auth = $user['auth'];
        $result = false;
        $user_id = htmlspecialchars(trim($_SESSION[SESSION_USER_ID]));
        if ($auth == 9) {
            $story_no = 99999;
        } else {
            try {
                $sql = "SELECT `story_no` FROM `users` WHERE `email` =:user_id LIMIT 0 , 1";
                $this->stmt = $this->pdo->prepare($sql);
                $this->stmt->bindValue(':user_id', $user_id);
                $this->stmt->execute();
                $row = $this->stmt->fetchAll();
                $story_no = $row[0]['story_no'];
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        if (empty($group_id)) {
            $group_id = 1;
        }
        try {
            $sql = "SELECT sm.`id`,sto.`story_no`, sm.`send_flg`, sm.`group_id`, sm.`title`, sm.`contents`, hd.header, ft.footer"
                . " FROM `stories` AS sto"
                . " LEFT JOIN `step_mails` AS sm ON sto.step_mail_id = sm.id"
                . " LEFT JOIN `headers` AS hd ON sm.header_id = hd.id"
                . " LEFT JOIN `footers` AS ft ON sm.footer_id = ft.id"
                . " WHERE sm.`send_flg` = 1"
                . " AND sto.story_no <= :story_no";
            if ($auth != 9) {
                $sql .= " AND sto.group_id = :group_id";
            }
            $sql .= " GROUP BY sm.`id`,sto.`story_no`, sm.`send_flg`, sm.`group_id`, sm.`title`, sm.`contents`, hd.header, ft.footer";
            $sql .= " ORDER BY sto.`story_no` ASC";
            $this->stmt = $this->pdo->prepare($sql);
            if ($auth != 9) {
                $this->stmt->bindValue(':group_id', $group_id);
            }
            $this->stmt->bindValue(':story_no', $story_no);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $href = '';
            $massage = '<ul>' . "\n";
            foreach ($data as $mail) {
                $mail['title'] = $this->txtReplace($mail['title'], $user);
                $href = 'window.open("stepmail.php?id=' . $mail['id'] . '","stepMail","scrollbars=yes,resizable=yes,toolbar=no,location=no,directories=no,status=no,menubar=no")';
                $massage .= '<li>';
                $massage .= "<a href='#' onclick='javascript:" . $href . "'>";
                $massage .= $mail['title'];
                $massage .= '</a>';
                $massage .= '</li>' . "\n";
            }
            $massage .= '</ul>' . "\n";
            $result = $massage;
        }
        return $result;
    }

    function add_extrabacknumber($from_str, $to_str)
    {
        $str = $from_str;
        $extrabacknumber = $this->make_extrabacknumber($to_str);
        $str = str_replace('%extrabacknumber%', $extrabacknumber, $str);
        return $str;
    }

    private function make_extrabacknumber($user)
    {
        $group_id = $user['group_id'];
        $created = $user['created'];
        $auth = $user['auth'];
        $result = false;
        if (empty($group_id)) {
            $group_id = 1;
        }
        $reg_date = $created;
        try {
            $sql = "SELECT em.`id`, em.`title`, em.`contents`, hd.header, ft.footer"
                . " FROM `extra_mails` em LEFT JOIN headers hd ON em.header_id = hd.id"
                . " LEFT JOIN footers AS ft ON em.footer_id = ft.id"
                . " WHERE em.`send_done` IS NOT NULL";
            if ($auth != 9) {
                $sql .= " AND (FIND_IN_SET(:group_id, em.`group_id`) OR FIND_IN_SET('1', em.`group_id`))";
            }
            $sql .= " AND em.`send_done` >= :reg_date ORDER BY em.`send_time` ASC";
            $this->stmt = $this->pdo->prepare($sql);
            if ($auth != 9) {
                $this->stmt->bindValue(':group_id', $group_id);
            }
            $this->stmt->bindValue(':reg_date', $reg_date);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $href = '';
            $massage = '<ul>' . "\n";
            foreach ($data as $mail) {
                $mail['title'] = $this->txtReplace($mail['title'], $user);
                $href = 'window.open("extramail.php?id=' . $mail['id'] . '","extraMail","scrollbars=yes,resizable=yes,toolbar=no,location=no,directories=no,status=no,menubar=no")';
                $massage .= '<li>';
                $massage .= "<a href='#' onclick='javascript:" . $href . "'>";
                $massage .= $mail['title'];
                $massage .= '</a>';
                $massage .= '</li>' . "\n";
            }
            $massage .= '</ul>' . "\n";
            $result = $massage;
        }
        return $result;
    }

    static function set_session($name, $data)
    {
        $_SESSION[$name] = $data;
    }

    static function get_session($name, $default = null)
    {
        if (isset($_SESSION[$name]) === false) {
            return $default;
        }
        return trim($_SESSION[$name]);
    }

    function session_dell()
    {
        $_SESSION = array();
        session_destroy();
    }

    function db_sql($sql)
    {
        try {
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_sql()
    {
        $result = false;
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt > 0) {
            $result = $row[0];
        }
        return $result;
    }

    function db_cnt_data($stmt)
    {
        $result = false;
        $cnt = $stmt->rowCount();
        if ($cnt != 0) {
            $result = true;
        }
        return $result;
    }

    function get_version()
    {
        $ver = '3.2612';
        if (main::get_session('update_check_flag', false) == false) {
            $version_info = explode("\n", file_get_contents('https://miyako:wk1234@cyfons.net/update/version.php'));
            if (isset($version_info[0])) {
                $latest_ver = trim($version_info[0]);
            }
            if (isset($version_info[1])) {
                $release_date = trim($version_info[1]);
            }
            if (is_numeric($latest_ver) && ($ver < $latest_ver)) {
                main::set_session('exists_update', $latest_ver);
                main::set_session('release_date', $release_date);
            }
            main::set_session('update_check_flag', true);
        }
        return $ver;
    }

    function unlinkRecursive($dir, $deleteRootToo)
    {
        if (!$dh = @opendir($dir)) {
            return;
        }
        while (false !== ($obj = readdir($dh))) {
            if ($obj == '.' || $obj == '..') {
                continue;
            }
            if (!@unlink($dir . '/' . $obj)) {
                $this->unlinkRecursive($dir . '/' . $obj, true);
            }
        }
        closedir($dh);
        if ($deleteRootToo) {
            @rmdir($dir);
        }
        return;
    }

    function get_file_list($dir, $file = 'index.php')
    {
        $files = glob(rtrim($dir, '/') . '/*/' . $file);
        $list = array();
        if ($files) {
            foreach ($files as $file) {
                if (is_file($file)) {
                    $list[] = $file;
                }
                if (is_dir($file)) {
                    $list = array_merge($list, get_file_list($file));
                }
            }
            return $list;
        }
    }

    function get_exist_TB($var_TableName)
    {
        $this->exist_TB($var_TableName);
        $row = $this->stmt->fetchAll();
        if (isset($row[0][0])) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    private function exist_TB($var_TableName)
    {
        try {
            $sql = "SHOW TABLES  like '$var_TableName'";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function check_input()
    {
        $result = false;
        $fields = func_get_args();
        foreach ($fields as $field) {
            if ($this->reqData[$field] == '') {
                $result[$field] = true;
            }
        }
        return $result;
    }

    function measure()
    {
        list($m, $s) = explode(' ', microtime());
        return ((float)$m + (float)$s);
    }

    function check_mailadd($mail)
    {
        if (!preg_match("/^([a-zA-Z0-9\+\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $mail)) {
            $this->err['email'] = '正確に入力して下さい。';
        }
    }

    function check_double_mail($em1, $em2)
    {
        if ($em1 !== $em2) {
            $this->err['email'] = 'メールアドレスを正しく入力してください。';
        }
    }

    function check_word_count($name, $num)
    {
        $name = trim($name);
        if (mb_strlen($name, "UTF-8") < 1 || mb_strlen($name, "UTF-8") > $num) {
            $this->err['name'] = $num . '文字までで入力してください。';
        }
    }

    function check_word_count2($name, $num)
    {
        $name = trim($name);
        if (mb_strlen($name, "UTF-8") < 1 || mb_strlen($name, "UTF-8") > $num) {
            $this->err['name2'] = $num . '文字までで入力してください。';
        }
    }

    function check_name($name, $num, $family = 'name1')
    {
        $name = trim($name);
        if (mb_strlen($name, "UTF-8") < 1 || mb_strlen($name, "UTF-8") > $num) {
            if ($family == 'name1') {
                $this->err['name1'] = '姓を' . $num . '文字までで入力してください。';
            } else {
                $this->err['name2'] = '名を' . $num . '文字までで入力してください。';
            }
        }
    }

    function check_num($num, $max)
    {
        if (!preg_match("/^[0-9]{1," . $max . "}$/", $num)) {
            $this->err['num'] = '半角数字' . $max . '文字までで入力してください。';
        }
    }

    function check_hankaku_count($str, $max)
    {
        if (!preg_match("/^[a-zA-Z0-9 -\/:-@\[-`\{-\~]{1," . $max . "}$/", $str)) {
            $this->err['hankaku'] = '半角英数字記号' . $max . '桁までで入力してください。';
        }
    }

    function check_adminid($id, $max)
    {
        if (!preg_match("/^[a-zA-Z0-9_\-\+\.]{1," . $max . "}$/", $id)) {
            $this->err['adminid'] = '半角英数字記号' . $max . '桁までで入力してください。';
        }
    }

    function checktime($hour, $min, $sec)
    {
        if ($hour < 0 || $hour > 23 || !is_numeric($hour)) {
            return false;
        }
        if ($min < 0 || $min > 59 || !is_numeric($min)) {
            return false;
        }
        if ($sec < 0 || $sec > 59 || !is_numeric($sec)) {
            return false;
        }
        return true;
    }

    function check_datetime_format($datetime)
    {
        $ret = false;
        $d1 = date("Y-m-d H:i:s", strtotime($datetime));
        $d2 = date("Y-n-j G:i:s", strtotime($datetime));
        $d3 = date("Y/n/j G:i", strtotime($datetime));
        if ($datetime === $d1) {
            $ret = true;
        }
        if ($datetime === $d2) {
            $ret = true;
        }
        if ($datetime === $d3) {
            $ret = true;
        }
        return $ret;
    }

    function log_out($log_level, $function, $line, $message)
    {
        $tmp_msg = date('y-m-d H:i:s ');
        $tmp_msg .= $log_level . " " . $function . " ";
        $tmp_msg .= $line . '：';
        $tmp_msg .= var_export($message, true);
        $base = dirname(dirname(__FILE__));
        $log_file_path = $base . "/log/debug" . date("Ymd") . ".log";
        error_log($tmp_msg . "\n", 3, $log_file_path);
    }
} ?>