<?php
require_once(dirname(__FILE__) . '/main.php');

class users extends main
{
    private $user;

    function db_login($email, $password, $auth, &$user)
    {
        $result = false;
        $this->db_check_login($email, $password, $auth);
        $result = $this->stmt->fetchAll();
        $cnt = count($result);
        if ($cnt == 1) {
            $data = $result[0];
            $user['id'] = $data['id'];
            $user['email'] = $email;
            $user['password'] = $password;
            $user['auth'] = $auth;
            $user['group_id'] = $data['group_id'];
            $user['send_date'] = $data['send_date'];
            $user['created'] = $data['created'];
            $user['modified'] = $data['modified'];
            $result = true;
        }
        return $result;
    }

    private function db_check_login($email, $password, $auth)
    {
        try {
            $sql = "SELECT id, send_date, group_id, created, modified
					FROM `users`
					WHERE `email` = :email
					AND `password` = :password
					AND `auth` = :auth
					AND (`delete_flg` = '0' OR `delete_flg` = '10')";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(":email", $email, PDO::PARAM_STR);
            $this->stmt->bindValue(":password", $password, PDO::PARAM_STR);
            $this->stmt->bindValue(":auth", $auth, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function login_adminid($id, $max)
    {
        if (!preg_match("/^[a-zA-Z0-9_\-\+\.]{1," . $max . "}$/", $id)) {
            $this->err['email'] = '正確に入力してください。';
        } else {
            if ($this->db_login_adminid($id)) {
                return true;
            } else {
                $this->err['all'] = 'ユーザー情報が間違っています。';
            }
        }
        return false;
    }

    private function db_login_adminid($id)
    {
        try {
            $sql = "SELECT id
					FROM `settings`
					WHERE `admin_id` = :admin_id
					AND id=1";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(":admin_id", $id, PDO::PARAM_STR);
            $this->stmt->execute();
            $result = $this->stmt->fetchAll();
            $cnt = count($result);
            if ($cnt == 1) {
                return $result[0]['id'];
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return false;
    }

    function set_auth_session($data)
    {
        $_SESSION['id'] = $data['id'];
        $_SESSION['email'] = $data['email'];
        $_SESSION[SESSION_USER_ID] = $data['email'];
        $_SESSION['password'] = $data['password'];
        $_SESSION[SESSION_PASSWORD] = $data['password'];
        $_SESSION[SESSION_REG_DATE] = !empty($data['created']) ? $data['created'] : null;
        if (isset($data['auth'])) {
            $_SESSION['auth'] = $data['auth'];
        }
        if (isset($data['created'])) {
            $_SESSION['created'] = $data['created'];
        }
    }

    function get_auth_session($session, &$user)
    {
        $result = false;
        if (isset($session[SESSION_USER_ID]) && isset($session[SESSION_PASSWORD])) {
            $user['id'] = (int)$session['id'];
            $user['email'] = htmlspecialchars($session[SESSION_USER_ID], ENT_QUOTES);
            $user['password'] = htmlspecialchars($session[SESSION_PASSWORD], ENT_QUOTES);
            $user['auth'] = (int)$session['auth'];
            $user['created'] = htmlspecialchars($session['created'], ENT_QUOTES);
            $result = true;
        }
        return $result;
    }

    function check_pw($pw)
    {
        if (!preg_match("/^([a-zA-Z0-9])([a-zA-Z0-9!-\/:\[-`\{-\~]{5,31})$/", $pw)) {
            $this->err['password'] = 'パスワードは半角英数字及び記号6文字以上で入力してください。';
        }
    }

    function check_double_pw($pw1, $pw2)
    {
        if ($pw1 !== $pw2) {
            $this->err['password'] = 'パスワードを正しく入力してください。';
        }
    }

    function check_order_no($str, $num)
    {
        if (mb_strlen($str, "UTF-8") < 1 || mb_strlen($str, "UTF-8") > $num) {
            $this->err['order_no'] = '注文IDを正確に入力して下さい。';
        }
    }

    function check_flg($num, $word = null)
    {
        if ($num !== 0 & $num !== 1) {
            $word = (isset($word)) ? $word . 'は' : null;
            $this->err['flg'] = $word . '「0」か「1」で入力してください。';
        }
    }

    function check_login()
    {
        if ($this->check_input('email', 'password')) {
            $this->err['all'] = '入力項目に漏れがあります。';
        }
    }

    function redeclare_email($email)
    {
        $result = true;
        $stmt = $this->db_serach_login_name($email);
        $row = $stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $result = false;
            $this->err['email'] = 'すでに登録されています。';
        }
        return $result;
    }

    private function db_serach_login_name($email)
    {
        try {
            $this->stmt = $this->pdo->prepare("SELECT * FROM users WHERE `email` = :email AND `auth` != '9'");
            $this->stmt->bindValue(":email", $email);
            $this->stmt->execute();
            return $this->stmt;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_err()
    {
        $err = $this->err;
        $this->err = '';
        return $err;
    }

    function search_email($form_data, &$data)
    {
        $result = false;
        try {
            $sql = 'SELECT *
					FROM `users`
					WHERE `email` LIKE :email
					AND `scenario_id` = :scenario_id
					AND `auth` = :auth';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':email', '%' . $form_data['email'] . '%');
            $stmt->bindValue(':scenario_id', $form_data['scenario_id']);
            $stmt->bindValue(':auth', $form_data['auth']);
            $stmt->execute();
            $row = $stmt->fetchAll();
            $cnt = count($row);
            if ($cnt >= 1) {
                $data = $row;
                $result = true;
            }
            return $result;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function search_user_condition($form_data, &$data, $start = 0, $num = MAX_USER)
    {
        $result = 0;
        $f_create = false;
        $f_send_date = false;
        $f_story = false;
        if (!empty($form_data['create1']) && !empty($form_data['create2'])) {
            $form_data['create2'] = date('Y-m-d', strtotime("{$form_data['create2']}+ 1 day"));
            $f_create = true;
        } else {
            if (!empty($form_data['create1']) && !!empty($form_data['create2'])) {
                $form_data['create2'] = '2100-01-01';
                $f_create = true;
            } else {
                if (!!empty($form_data['create1']) && !empty($form_data['create2'])) {
                    $form_data['create1'] = '2000-01-01';
                    $form_data['create2'] = date('Y-m-d', strtotime("{$form_data['create2']}+ 1 day"));
                    $f_create = true;
                }
            }
        }
        if (!empty($form_data['send_date1']) && !empty($form_data['send_date2'])) {
            $form_data['send_date2'] = date('Y-m-d', strtotime("{$form_data['send_date2']}+ 1 day"));
            $f_send_date = true;
        } else {
            if (!empty($form_data['send_date1']) && !!empty($form_data['send_date2'])) {
                $form_data['send_date2'] = '2100-01-01';
                $f_send_date = true;
            } else {
                if (!!empty($form_data['send_date1']) && !empty($form_data['send_date2'])) {
                    $form_data['send_date1'] = '2000-01-01';
                    $form_data['send_date2'] = date('Y-m-d', strtotime("{$form_data['send_date2']}+ 1 day"));
                    $f_send_date = true;
                }
            }
        }
        if (ctype_digit($form_data['story_no1']) && ctype_digit($form_data['story_no2'])) {
            $f_story = true;
        } else {
            if (ctype_digit($form_data['story_no1']) && !ctype_digit($form_data['story_no2'])) {
                $form_data['story_no2'] = '999999999';
                $f_story = true;
            } else {
                if (!ctype_digit($form_data['story_no1']) && ctype_digit($form_data['story_no2'])) {
                    $form_data['story_no1'] = '0';
                    $f_story = true;
                }
            }
        }
        try {
            $sql_cnt = $this->make_search_sql($form_data, $start, $num, 0);
            $stmt = $this->pdo->prepare($sql_cnt);
            if (!empty($form_data['email'])) {
                $stmt->bindValue(':email', '%' . $form_data['email'] . '%');
            }
            if (!empty($form_data['name'])) {
                $stmt->bindValue(':name', '%' . $form_data['name'] . '%');
            }
            if (!empty($form_data['order_no'])) {
                $stmt->bindValue(':order_no', '%' . $form_data['order_no'] . '%');
            }
            if (!empty($form_data['group_id'])) {
                $stmt->bindValue(':group_id', $form_data['group_id']);
            }
            if (isset($form_data['delete_flg'])) {
                if ($form_data['delete_flg'] != '') {
                    $stmt->bindValue(':delete_flg', $form_data['delete_flg']);
                }
            }
            if ($f_story) {
                $stmt->bindValue(':story_no1', $form_data['story_no1']);
            }
            if ($f_story) {
                $stmt->bindValue(':story_no2', $form_data['story_no2']);
            }
            if ($f_create) {
                $stmt->bindValue(':create1', $form_data['create1']);
            }
            if ($f_create) {
                $stmt->bindValue(':create2', $form_data['create2']);
            }
            if ($f_send_date) {
                $stmt->bindValue(':send_date1', $form_data['send_date1']);
            }
            if ($f_send_date) {
                $stmt->bindValue(':send_date2', $form_data['send_date2']);
            }
            $stmt->bindValue(':auth', $form_data['auth']);
            $stmt->bindValue(':scenario_id', $form_data['scenario_id']);
            $stmt->execute();
            $row = $stmt->fetchAll();
            $cnt = $row[0]['cnt'];
            if ($cnt >= 1) {
                $sql_all = $this->make_search_sql($form_data, $start, $num, 1);
                $stmt = $this->pdo->prepare($sql_all);
                if (!empty($form_data['email'])) {
                    $stmt->bindValue(':email', '%' . $form_data['email'] . '%');
                }
                if (!empty($form_data['name'])) {
                    $stmt->bindValue(':name', '%' . $form_data['name'] . '%');
                }
                if (!empty($form_data['order_no'])) {
                    $stmt->bindValue(':order_no', '%' . $form_data['order_no'] . '%');
                }
                if (!empty($form_data['group_id'])) {
                    $stmt->bindValue(':group_id', $form_data['group_id']);
                }
                if (isset($form_data['delete_flg'])) {
                    if ($form_data['delete_flg'] != '') {
                        $stmt->bindValue(':delete_flg', $form_data['delete_flg']);
                    }
                }
                if ($f_story) {
                    $stmt->bindValue(':story_no1', $form_data['story_no1']);
                }
                if ($f_story) {
                    $stmt->bindValue(':story_no2', $form_data['story_no2']);
                }
                if ($f_create) {
                    $stmt->bindValue(':create1', $form_data['create1']);
                }
                if ($f_create) {
                    $stmt->bindValue(':create2', $form_data['create2']);
                }
                if ($f_send_date) {
                    $stmt->bindValue(':send_date1', $form_data['send_date1']);
                }
                if ($f_send_date) {
                    $stmt->bindValue(':send_date2', $form_data['send_date2']);
                }
                $stmt->bindValue(':auth', $form_data['auth']);
                $stmt->bindValue(':scenario_id', $form_data['scenario_id']);
                $stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
                $stmt->bindValue(':num', (int)$num, PDO::PARAM_INT);
                $stmt->execute();
                $data = $stmt->fetchAll();
                $result = $cnt;
            }
            return $result;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function make_search_sql($form_data, $start, $num, $mode = 0)
    {
        $sql = '';
        $where = '';
        $order = '';
        $limit = '';
        if ($mode == 0) {
            $sql = 'SELECT count(*) as cnt FROM `users`';
        } else {
            $sql = 'SELECT * FROM `users`';
        }
        $where = ' WHERE';
        if (!empty($form_data['email'])) {
            $arr_where[] = ' `email` LIKE :email';
        }
        if (!empty($form_data['name'])) {
            $arr_where[] = ' (`firstname` LIKE :name OR `lastname` LIKE :name)';
        }
        if (!empty($form_data['order_no'])) {
            $arr_where[] = ' `order_no` LIKE :order_no';
        }
        if (!empty($form_data['group_id'])) {
            $arr_where[] = ' FIND_IN_SET(:group_id, `group_id`)';
        }
        if (isset($form_data['delete_flg'])) {
            if ($form_data['delete_flg'] != '') {
                $arr_where[] = ' `delete_flg` = :delete_flg';
            }
        }
        if ($form_data['story_no1'] != '' & $form_data['story_no2'] != '') {
            $arr_where[] = ' `story_no` BETWEEN  :story_no1 AND :story_no2';
        }
        if (!empty($form_data['create1']) or !empty($form_data['create2'])) {
            $arr_where[] = ' `created` BETWEEN  :create1 AND :create2';
        }
        if (!empty($form_data['send_date1']) or !empty($form_data['send_date2'])) {
            $arr_where[] = ' `send_date` BETWEEN  :send_date1 AND :send_date2';
        }
        $arr_where[] = ' `auth` = :auth';
        $arr_where[] = ' `scenario_id` = :scenario_id';
        $where .= implode(" AND ", $arr_where);
        $order = " ORDER BY `users`.`id` DESC";
        $limit = " LIMIT :start, :num";
        $sql .= $where;
        $sql .= $order;
        if ($mode != 0) {
            $sql .= $limit;
        }
        return $sql;
    }

    function search_email_order($form_data, &$data)
    {
        $result = false;
        try {
            $sql = 'SELECT *
					FROM `users`
					WHERE `email` LIKE :email
					AND `order_no` LIKE :order_no
					AND `scenario_id` = :scenario_id
					AND `auth` = :auth';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':email', '%' . $form_data['email'] . '%');
            $stmt->bindValue(':order_no', '%' . $form_data['order_no'] . '%');
            $stmt->bindValue(':scenario_id', $form_data['scenario_id']);
            $stmt->bindValue(':auth', $form_data['auth']);
            $stmt->execute();
            $row = $stmt->fetchAll();
            $cnt = count($row);
            if ($cnt >= 1) {
                $data = $row;
                $result = true;
            }
            return $result;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_set_user($id)
    {
        $result = false;
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE id = :id');
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetchObject();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        if ($row !== false) {
            $this->user['id'] = $row->id;
            $this->user['user_id'] = $row->id;
            $this->user['email'] = $row->email;
            $this->user['password'] = $row->password;
            $this->user['firstname'] = $row->firstname;
            $this->user['lastname'] = $row->lastname;
            $this->user['order_no'] = $row->order_no;
            $this->user['story_no'] = $row->story_no;
            $this->user['scenario_id'] = $row->scenario_id;
            $this->user['group_id'] = $row->group_id;
            $this->user['auth'] = $row->auth;
            $this->user['delete_flg'] = $row->delete_flg;
            $this->user['deleted'] = $row->deleted;
            $this->user['send_date'] = $row->send_date;
            $this->user['ip'] = $row->ip;
            $this->user['host'] = $row->host;
            $this->user['created'] = $row->created;
            $this->user['modified'] = $row->modified;
            $result = true;
        }
        return $result;
    }

    function db_get_user()
    {
        return $this->user;
    }

    function count_users($scenario_id)
    {
        $this->db_count_users($scenario_id);
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        return $cnt;
    }

    private function db_count_users($scenario_id)
    {
        try {
            $this->stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `scenario_id` = :scenario_id AND `auth` !=9');
            $this->stmt->bindValue(':scenario_id', $scenario_id, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_user_id($email)
    {
        $result = false;
        $this->db_get_user_id($email);
        $row = $this->stmt->fetchAll();
        if (count($row) == 1) {
            $result = $row[0]['id'];
        }
        return $result;
    }

    private function db_get_user_id($email)
    {
        try {
            $this->stmt = $this->pdo->prepare('SELECT `id` FROM `users` WHERE `email` = :email AND `delete_flg` != 1');
            $this->stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_all_user_id($email)
    {
        $result = false;
        $this->db_get_all_user_id($email);
        $row = $this->stmt->fetchAll();
        if (count($row) == 1) {
            $result = $row[0]['id'];
        }
        return $result;
    }

    private function db_get_all_user_id($email)
    {
        try {
            $this->stmt = $this->pdo->prepare('SELECT `id` FROM `users` WHERE `email` = :email AND `auth` != 9 ORDER BY `users`.`id` DESC');
            $this->stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function is_user($email)
    {
        $result = false;
        $this->db_is_user($email);
        $cnt = $this->stmt->fetchColumn();
        if ($cnt >= 1) {
            $result = true;
        }
        return $result;
    }

    private function db_is_user($email)
    {
        try {
            $this->stmt = $this->pdo->prepare('SELECT COUNT(*) FROM `users` WHERE `email` = :email AND `delete_flg` != 1 AND `auth` != 9');
            $this->stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_user_cnt($email)
    {
        $result = false;
        $this->db_get_user_cnt($email);
        $row = $this->stmt->fetchAll();
        return count($row);
    }

    private function db_get_user_cnt($email)
    {
        try {
            $this->stmt = $this->pdo->prepare('SELECT `id` FROM `users` WHERE `email` = :email');
            $this->stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_settings($group_id = 1)
    {
        $result = false;
        $this->db_get_settings($group_id);
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if (count($row) == 1) {
            $result = $row[0];
        }
        return $result;
    }

    private function db_get_settings($group_id)
    {
        try {
            $this->stmt = $this->pdo->prepare('SELECT * FROM `settings` WHERE `group_id` =:group_id');
            $this->stmt->bindValue(':group_id', (int)$group_id, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_update_setting_user_password($data, $id)
    {
        try {
            $sql = 'UPDATE `settings`
					SET `user_password`=:user_password , `modified`=now()
		    		WHERE `id` = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':user_password', $data['user_password']);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_update_all_password($data)
    {
        try {
            $sql = 'UPDATE `users`
					SET `password`=:password, `modified`=now()
		    		WHERE `auth` !=9
					AND `delete_flg` =0';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':password', $data['user_password']);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_update_setting_form_password($data, $id)
    {
        try {
            $sql = 'UPDATE `settings`
					SET
					`form_password2`=:form_password2,
					`form_is_password2`=:form_is_password2,
					`form_email`=:form_email,
					`form_email2`=:form_email2,
					`form_is_email`=:form_is_email,
					`form_firstname`=:form_firstname,
					`form_is_firstname`=:form_is_firstname,
					`form_lastname`=:form_lastname,
					`form_is_lastname`=:form_is_lastname,
					`form_order_no`=:form_order_no,
					`form_is_order_no`=:form_is_order_no,
					`modified`=now()
		    		WHERE `id` = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':form_password2', $data['form_password2']);
            $stmt->bindValue(':form_is_password2', $data['form_is_password2']);
            $stmt->bindValue(':form_email', $data['form_email']);
            $stmt->bindValue(':form_email2', $data['form_email2']);
            $stmt->bindValue(':form_is_email', $data['form_is_email']);
            $stmt->bindValue(':form_firstname', $data['form_firstname']);
            $stmt->bindValue(':form_is_firstname', $data['form_is_firstname']);
            $stmt->bindValue(':form_lastname', $data['form_lastname']);
            $stmt->bindValue(':form_is_lastname', $data['form_is_lastname']);
            $stmt->bindValue(':form_order_no', $data['form_order_no']);
            $stmt->bindValue(':form_is_order_no', $data['form_is_order_no']);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_update_setting_automail($data, $id)
    {
        try {
            $sql = 'UPDATE `settings`
					SET
					`automail_add_admin`=:automail_add_admin,
					`automail_stop_admin`=:automail_stop_admin,
					`automail_edit_admin`=:automail_edit_admin,
					`automail_add_user`=:automail_add_user,
					`automail_stop_user`=:automail_stop_user,
					`automail_edit_user`=:automail_edit_user,
					`modified`=now()
		    		WHERE `id` = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':automail_add_admin', $data['automail_add_admin']);
            $stmt->bindValue(':automail_stop_admin', $data['automail_stop_admin']);
            $stmt->bindValue(':automail_edit_admin', $data['automail_edit_admin']);
            $stmt->bindValue(':automail_add_user', $data['automail_add_user']);
            $stmt->bindValue(':automail_stop_user', $data['automail_stop_user']);
            $stmt->bindValue(':automail_edit_user', $data['automail_edit_user']);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_update_setting_group_form_password($data, $id)
    {
        try {
            $sql = 'UPDATE `settings`
					SET
					`form_is_password`=:form_is_password ,
					`form_password`=:form_password ,
					`modified`=now()
		    		WHERE `group_id` = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':form_is_password', $data['form_is_password']);
            $stmt->bindValue(':form_password', $data['form_password']);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_update_setting_form_add_done_message($data)
    {
        try {
            $sql = 'UPDATE `settings`
					SET `form_add_done_message`=:form_add_done_message , `modified`=now()
		    		WHERE `id` = 1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':form_add_done_message', $data['form_add_done_message']);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_update_setting_form_stop_done_message($data)
    {
        try {
            $sql = 'UPDATE `settings`
					SET `form_stop_done_message`=:form_stop_done_message , `modified`=now()
		    		WHERE `id` = 1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':form_stop_done_message', $data['form_stop_done_message']);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function is_admin_id()
    {
        $result = false;
        try {
            $this->stmt = $this->pdo->prepare('SELECT `admin_id` FROM `settings` WHERE `id`=1');
            $this->stmt->execute();
            $row = $this->stmt->fetchAll();
            if (count($row) == 1) {
                if (!empty($row[0]['admin_id'])) {
                    $result = $this->get_admin_email();
                }
            }
            return $result;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function get_admin_email()
    {
        $result = false;
        try {
            $this->stmt = $this->pdo->prepare('SELECT `email` FROM `users` WHERE `id`=1');
            $this->stmt->execute();
            $row = $this->stmt->fetchAll();
            if (count($row) == 1) {
                $result = $row[0]['email'];
            }
            return $result;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_update_admin_id($admin_id, $id = 1)
    {
        try {
            $sql = 'UPDATE `settings`
					SET `admin_id`=:admin_id , `modified`=now()
		    		WHERE `id` =:id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':admin_id', $admin_id, PDO::PARAM_INT);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_update_site_name($name)
    {
        try {
            $sql = 'UPDATE `tp_settings`
					SET `site_name`=:site_name , `modified`=now()
		    		WHERE `id` = 1';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':site_name', $name);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function db_add_user($data)
    {
        $result = false;
        $now = (!empty($data['created'])) ? $data['created'] : $this->get_now_date();
        $story_no = (!empty($data['story_no'])) ? $data['story_no'] : 0;
        $group_id = (!empty($data['group_id'])) ? $data['group_id'] : 1;
        $send_date = (!empty($data['send_date'])) ? $data['send_date'] : null;
        try {
            $sql = 'INSERT INTO `users` (
					`email`, `password`, `firstname`, `lastname`, `order_no`, `story_no`, `scenario_id`, `group_id`, `auth`, `delete_flg`, `created`, `send_date`, `ip`, `host`)
					VALUES (
					:email, :password, :firstname, :lastname, :order_no, :story_no, :scenario_id, :group_id, :auth, :delete_flg, :created, :send_date, :ip, :host)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindValue(':password', $data['password'], PDO::PARAM_STR);
            $stmt->bindValue(':firstname', $data['firstname'], PDO::PARAM_STR);
            $stmt->bindValue(':lastname', $data['lastname'], PDO::PARAM_STR);
            $stmt->bindValue(':order_no', $data['order_no'], PDO::PARAM_STR);
            $stmt->bindValue(':story_no', $story_no, PDO::PARAM_INT);
            $stmt->bindValue(':scenario_id', $data['scenario_id'], PDO::PARAM_INT);
            $stmt->bindValue(':group_id', $group_id, PDO::PARAM_STR);
            $stmt->bindValue(':auth', $data['auth'], PDO::PARAM_INT);
            $stmt->bindValue(':delete_flg', $data['delete_flg'], PDO::PARAM_INT);
            $stmt->bindValue(':created', $now, PDO::PARAM_STR);
            $stmt->bindValue(':send_date', $send_date, PDO::PARAM_STR);
            $stmt->bindValue(':ip', $data['ip'], PDO::PARAM_STR);
            $stmt->bindValue(':host', $data['host'], PDO::PARAM_STR);
            $stmt->execute();
            $result = true;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $result;
    }

    private function db_last_id()
    {
        $id = $this->pdo->lastInsertId('id');
        return $id;
    }

    function db_update_admin($data, $id)
    {
        try {
            $sql = 'UPDATE `users`
					SET `email`=:email,`password`=:password, `modified`=NOW()
		    		WHERE `id` = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':email', $data['email']);
            $stmt->bindValue(':password', $data['password']);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_update_admin_name($name, $id)
    {
        try {
            $sql = 'UPDATE `users`
					SET `firstname`=:firstname,`modified`=now()
		    		WHERE `id` = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':firstname', $name);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function add_user($data)
    {
        $result = false;
        $result = $this->db_add_user($data);
        return $result;
    }

    function get_insert_user_id()
    {
        $result = false;
        $result = $this->db_last_id();
        return $result;
    }

    function db_update_users($data, $id)
    {
        try {
            $sql = 'UPDATE `users` SET
					`email`=:email,
					`firstname`=:firstname,
					`lastname`=:lastname,
					`order_no`=:order_no,
					`story_no`=:story_no,
					`delete_flg`=:delete_flg,
					`group_id`=:group_id,
					`modified`=now()
		    		WHERE `id` = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':email', $data['email']);
            $stmt->bindValue(':firstname', $data['firstname']);
            $stmt->bindValue(':lastname', $data['lastname']);
            $stmt->bindValue(':order_no', $data['order_no']);
            $stmt->bindValue(':story_no', $data['story_no']);
            $stmt->bindValue(':delete_flg', $data['delete_flg']);
            $stmt->bindValue(':group_id', $data['group_id']);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_update_users_email($data, $id)
    {
        try {
            $sql = 'UPDATE `users`
					SET `email`=:email, `modified`=now()
		    		WHERE `id` = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':email', $data['email']);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_update_users_password($data, $id)
    {
        try {
            $sql = 'UPDATE `users`
					SET `password`=:password, `modified`=now()
		    		WHERE `id` = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':password', $data['password']);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_update_users_groupid($data, $id)
    {
        try {
            $sql = 'UPDATE `users`
					SET `group_id`=:group_id, `story_no`=:story_no, `modified`=now()
		    		WHERE `id` = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':group_id', $data['group_id']);
            $stmt->bindValue(':story_no', $data['story_no']);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function db_add_user_csv($data)
    {
        $result = false;
        try {
            $sql = 'INSERT INTO `users` (
					`email`, `password`, `firstname`, `lastname`, `order_no`, `story_no`, `scenario_id`, `group_id`, `auth`, `delete_flg`, `created`, `send_date`)
					VALUES (
					:email, :password, :firstname, :lastname, :order_no, :story_no, :scenario_id, :group_id, :auth, :delete_flg, NOW(), :send_date)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':email', $data['email'], PDO::PARAM_STR);
            $stmt->bindValue(':password', $data['password'], PDO::PARAM_STR);
            $stmt->bindValue(':firstname', $data['firstname'], PDO::PARAM_STR);
            $stmt->bindValue(':lastname', $data['lastname'], PDO::PARAM_STR);
            $stmt->bindValue(':order_no', $data['order_no'], PDO::PARAM_STR);
            $stmt->bindValue(':story_no', $data['story_no'], PDO::PARAM_INT);
            $stmt->bindValue(':scenario_id', $data['scenario_id'], PDO::PARAM_INT);
            $stmt->bindValue(':group_id', $data['group_id'], PDO::PARAM_STR);
            $stmt->bindValue(':auth', $data['auth'], PDO::PARAM_INT);
            $stmt->bindValue(':delete_flg', $data['delete_flg'], PDO::PARAM_INT);
            $stmt->bindValue(':send_date', $data['send_date'], PDO::PARAM_STR);
            $stmt->execute();
            $result = true;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $result;
    }

    private function db_update_users_csv($data, $id)
    {
        $result = false;
        try {
            $sql = 'UPDATE `users`
					SET
					`firstname`=:firstname,
					`lastname`=:lastname,
					`email`=:email,
					`order_no`=:order_no,
					`story_no`=:story_no,
					`group_id`=:group_id,
					`delete_flg`=:delete_flg,
					`created`=:created,
					`send_date`=:send_date,
					`modified`=NOW()
					WHERE `id` = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':firstname', $data['firstname']);
            $stmt->bindValue(':lastname', $data['lastname']);
            $stmt->bindValue(':email', $data['email']);
            $stmt->bindValue(':order_no', $data['order_no']);
            $stmt->bindValue(':story_no', $data['story_no']);
            $stmt->bindValue(':group_id', $data['group_id']);
            $stmt->bindValue(':delete_flg', $data['delete_flg']);
            $stmt->bindValue(':created', $data['created']);
            $stmt->bindValue(':send_date', $data['send_date']);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
            $result = true;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $result;
    }

    function db_delflag_user($flg, $id)
    {
        $now = $this->get_now_date();
        try {
            $stmt = $this->pdo->prepare('UPDATE `users` SET `delete_flg` = :flg,`deleted`=:deleted WHERE `id` =:id AND `auth` != 9');
            $stmt->bindParam(':flg', $flg);
            $stmt->bindParam(':deleted', $now);
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function update_users_send_date($flg)
    {
        if ($flg) {
            $sql = 'UPDATE `users` SET `send_date` = now(),`modified`= now() WHERE `send_date` IS NULL AND `auth` != 9';
        } else {
            $sql = 'UPDATE `users` SET `send_date` = NULL,`modified`= now() WHERE `send_date` IS NOT NULL AND `auth` != 9';
        }
        try {
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function update_users_send_date_userid($user_id, $date = 0)
    {
        $diff = date('Y/m/d H:i:s', strtotime('-' . $date . ' day'));
        $sql = 'UPDATE `users` SET `send_date`=:diff,`modified`=NOW() WHERE `id`=:id';
        try {
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':diff', $diff, PDO::PARAM_INT);
            $this->stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function update_users_send_date_userid_created($user_id, $created)
    {
        $sql = 'UPDATE `users` SET `send_date`=:created,`modified`=NOW() WHERE `id`=:id';
        try {
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':created', $created, PDO::PARAM_STR);
            $this->stmt->bindValue(':id', $user_id, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_is_admin($id)
    {
        try {
            $stmt = $this->pdo->prepare('SELECT COUNT(*) FROM `users` WHERE `id` = :id AND `auth` = 9');
            $stmt->bindValue(':id', $id);
            $stmt->execute();
            $row = $stmt->fetchColumn();
            return $row;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function make_stop_url($scenario_id = null, $email)
    {
        $email = urlencode($email);
        $scenario_id = SCENARIOS_ID;
        $url = URL . '/formstop/?scenario_id=' . $scenario_id . '&email=' . $email;
        return $url;
    }

    function db_delete_user($id)
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM `users` WHERE `id` = :id AND `auth` != 9');
            $stmt->bindValue(':id', $id);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_delete_user_all()
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM `users` WHERE `auth` != 9');
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_all_user(&$data, $start = 0, $num = MAX_USER)
    {
        $result = false;
        $this->db_all_user($start, $num);
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $result = true;
        }
        return $result;
    }

    private function db_all_user($start, $num)
    {
        $start = (int)trim($start);
        $num = (int)trim($num);
        try {
            $sql = "SELECT * FROM `users` WHERE `auth` !=9 ORDER BY `users`.`created` DESC , `users`.`id` DESC LIMIT ";
            $sql .= $start . ',' . $num;
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function make_page_link($search, $cur_page, $num_pages, $disp = 8)
    {
        if (empty($search["group_id"])) {
            $search["group_id"] = "all";
        }
        $search_link = URL . '/admin/users/?';
        $search_arr[] = 'email=' . urlencode($search["email"]);
        $search_arr[] = 'name=' . urlencode($search["name"]);
        $search_arr[] = 'order_no=' . $search["order_no"];
        $search_arr[] = 'group_id=' . $search["group_id"];
        $search_arr[] = 'story_no1=' . $search["story_no1"];
        $search_arr[] = 'story_no2=' . $search["story_no2"];
        $search_arr[] = 'create1=' . $search["create1"];
        $search_arr[] = 'create2=' . $search["create2"];
        $search_arr[] = 'send_date1=' . $search["send_date1"];
        $search_arr[] = 'send_date2=' . $search["send_date2"];
        $search_arr[] = 'delete_flg=' . $search["delete_flg"];
        $search_arr[] = 'status=' . $search["status"];
        $search_link .= implode('&', $search_arr);
        $page_links = '';
        $next = $cur_page + 1;
        $prev = $cur_page - 1;
        $start = ($cur_page - floor($disp / 2) > 0) ? ($cur_page - floor($disp / 2)) : 1;
        $end = ($start > 1) ? ($cur_page + floor($disp / 2)) : $disp;
        if ($cur_page > 1) {
            $page_links .= '<li><a href="' . $search_link . '&page=' . $prev . '">&laquo; 前へ</a></li>';
        }
        if ($start >= 1) {
            $class = ($cur_page == 1) ? ' class="active"' : '';
            $page_links .= '<li' . $class . '><a href="' . $search_link . '&page=1">1</a></li>';
            if ($start > floor($disp / 2)) {
                $page_links .= '<li><a href="#">...</a></li>';
            }
        }
        for ($i = $start; $i <= $end; $i++) {
            $class = ($cur_page == $i) ? ' class="active"' : '';
            if ($i <= $num_pages && $i > 1) {
                $page_links .= '<li' . $class . '><a href="' . $search_link . '&page=' . $i . '">' . $i . '</a></li>';
            }
        }
        if ($num_pages > $end) {
            if ($num_pages - 1 > $end) {
                $page_links .= '<li><a href="#">...</a></li>';
            }
            $page_links .= '<li><a href="' . $search_link . '&page=' . $num_pages . '">' . $num_pages . '</a></li>';
        }
        if ($cur_page < $num_pages) {
            $page_links .= '<li><a href="' . $search_link . '&page=' . $next . '">次へ &raquo;</a></li>';
        }
        return $page_links;
    }

    function set_story_no_users()
    {
        if ($this->get_all_user($users)) {
            foreach ($users as $user) {
                if ($this->get_send_date($user['id'], $data)) {
                    if ($data['story_no'] > $user['story_no']) {
                        $row['story_no'] = $data['story_no'];
                    } else {
                        $row['story_no'] = $user['story_no'];
                    }
                } else {
                    $row['story_no'] = 0;
                }
                $this->db_update_users_story_no($row, $user['id']);
            }
        }
    }

    private function db_update_users_story_no($data, $id)
    {
        try {
            $sql = 'UPDATE `users`
					SET `story_no`=:story_no, `modified`=now()
					WHERE `id` = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':story_no', (int)$data['story_no'], PDO::PARAM_INT);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function del_logs_send_flg($user_id)
    {
        $this->db_del_step_logs_send_flg($user_id);
        $this->db_del_step_logs_extra_flg($user_id);
    }

    private function db_del_step_logs_send_flg($user_id)
    {
        try {
            $sql = 'DELETE FROM `step_mail_logs`
					WHERE `user_id` = :user_id
					AND `send_flg` = 0';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function db_del_step_logs_extra_flg($user_id)
    {
        try {
            $sql = 'DELETE FROM `extra_mail_logs`
					WHERE `user_id` = :user_id
					AND `send_flg` = 0';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':user_id', (int)$user_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function set_formadd($form_data, $group_id)
    {
        $file = '../../template/' . FNAME_FORM;
        $str = @file_get_contents($file);
        $url = URLADD . '?group_id=' . $group_id;
        $str = preg_replace('/<!--FORM_URL-->/is', $url, $str);
        if ($form_data['form_firstname'] || $form_data['form_lastname']) {
            $str = preg_replace('/<!--FORM_NAME-->/is', "\r\n", $str);
            $str = preg_replace('/<!--END_FORM_NAME-->/is', "\r\n", $str);
        } else {
            $str = preg_replace('/<!--FORM_NAME-->(.*)<!--END_FORM_NAME-->/is', "\r\n", $str);
        }
        if ($form_data['form_firstname']) {
            $str = preg_replace('/<!--FORM_FIRSTNAME-->/is', "\r\n", $str);
            $str = preg_replace('/<!--END_FORM_FIRSTNAME-->/is', "\r\n", $str);
        } else {
            $str = preg_replace('/<!--FORM_FIRSTNAME-->(.*)<!--END_FORM_FIRSTNAME-->/is', "\r\n", $str);
        }
        if ($form_data['form_lastname']) {
            $str = preg_replace('/<!--FORM_LASTNAME-->/is', "\r\n", $str);
            $str = preg_replace('/<!--END_FORM_LASTNAME-->/is', "\r\n", $str);
        } else {
            $str = preg_replace('/<!--FORM_LASTNAME-->(.*)<!--END_FORM_LASTNAME-->/is', "\r\n", $str);
        }
        if ($form_data['form_email']) {
            $str = preg_replace('/<!--FORM_EMAIL-->/is', "\r\n", $str);
            $str = preg_replace('/<!--END_FORM_EMAIL-->/is', "\r\n", $str);
        } else {
            $str = preg_replace('/<!--FORM_EMAIL-->(.*)<!--END_FORM_EMAIL-->/is', "\r\n", $str);
        }
        if ($form_data['form_email2']) {
            $str = preg_replace('/<!--FORM_W_EMAIL-->/is', "\r\n", $str);
            $str = preg_replace('/<!--END_FORM_W_EMAIL-->/is', "\r\n", $str);
        } else {
            $str = preg_replace('/<!--FORM_W_EMAIL-->(.*)<!--END_FORM_W_EMAIL-->/is', "\r\n", $str);
        }
        if ($form_data['form_password2']) {
            $str = preg_replace('/<!--FORM_PASSWORD-->/is', "\r\n", $str);
            $str = preg_replace('/<!--END_FORM_PASSWORD-->/is', "\r\n", $str);
        } else {
            $str = preg_replace('/<!--FORM_PASSWORD-->(.*)<!--END_FORM_PASSWORD-->/is', "\r\n", $str);
        }
        if ($form_data['form_order_no']) {
            $str = preg_replace('/<!--FORM_ORDER_NO-->/is', "\r\n", $str);
            $str = preg_replace('/<!--END_FORM_ORDER_NO-->/is', "\r\n", $str);
        } else {
            $str = preg_replace('/<!--FORM_ORDER_NO-->(.*)<!--END_FORM_ORDER_NO-->/is', "\r\n", $str);
        }
        $str = preg_replace('/\r\n\r\n|\r\r|\n\n|\t/', "", $str);
        return $str;
    }

    function set_formifadd($form_data)
    {
        $file = '../../template/' . FNAME_FORM_IFRAME;
        $str = @file_get_contents($file);
        $url = URLIF . '&group_id=' . $form_data['group_id'];
        $str = preg_replace('/<!--FORM_IFRAME-->/is', $url, $str);
        $str = preg_replace('/\r\n\r\n|\r\r|\n\n|\t/', "", $str);
        return $str;
    }

    function set_changegroup($group_id, $group_id2, $group_name, $group_name2)
    {
        $file = '../../template/' . FNAME_GROUP;
        $str = @file_get_contents($file);
        $url = URLGROUP . '?group_id=' . $group_id . '&group_id2=' . $group_id2;
        $str = preg_replace('/<!--FORM_URL-->/is', $url, $str);
        $str = preg_replace('/\r\n\r\n|\r\r|\n\n|\t/', "", $str);
        return $str;
    }

    function set_changeifgroup($group_id, $group_id2)
    {
        $file = '../../template/' . FNAME_GROUP_IFRAME;
        $str = @file_get_contents($file);
        $url = URLGIF . '&group_id=' . $group_id . '&group_id2=' . $group_id2;
        $str = preg_replace('/<!--FORM_IFRAME-->/is', $url, $str);
        $str = preg_replace('/\r\n\r\n|\r\r|\n\n|\t/', "", $str);
        return $str;
    }

    public function csvImport(&$data, $upload_key = 'csv', $save_directory = 'tmp', $max_filesize = 30000000)
    {
        $msg = false;
        if (isset($_FILES[$upload_key])) {
            try {
                $error = $_FILES[$upload_key]['error'];
                if (is_array($error)) {
                    throw new RuntimeException('複数ファイルの同時アップロードは許可されていません。');
                }
                switch ($error) {
                    case UPLOAD_ERR_INI_SIZE:
                        throw new RuntimeException('php.iniで許可されている最大サイズを超過しました。');
                    case UPLOAD_ERR_FORM_SIZE:
                        throw new RuntimeException('フォームで許可されている最大サイズを超過しました。');
                    case UPLOAD_ERR_PARTIAL:
                        throw new RuntimeException('ファイルが壊れています。');
                    case UPLOAD_ERR_NO_FILE:
                        throw new RuntimeException('ファイルが選択されていません。');
                    case UPLOAD_ERR_NO_TMP_DIR:
                        throw new RuntimeException('テンポラリディレクトリが見つかりません。');
                    case UPLOAD_ERR_CANT_WRITE:
                        throw new RuntimeException('テンポラリデータの生成に失敗しました。');
                    case UPLOAD_ERR_EXTENSION:
                        throw new RuntimeException('エクステンションでエラーが発生しました。');
                }
                $data['org_file'] = $_FILES[$upload_key]['name'];
                $ext = pathinfo($data['org_file'], PATHINFO_EXTENSION);
                $tmp_name = $_FILES[$upload_key]['tmp_name'];
                $data['size'] = $_FILES[$upload_key]['size'];
                $mictime = microtime();
                $data['store_file'] = substr($mictime, 11) . substr($mictime, 2, 6) . '.' . $ext;
                if ($data['org_file'] === '') {
                    throw new Exception('ファイル名が無効です。');
                }
                if ($data['size'] > $max_filesize) {
                    throw new RuntimeException("{$max_filesize}バイトを超過するファイルは受理できません。");
                }
                if (!is_uploaded_file($tmp_name)) {
                    throw new RuntimeException('不正なファイルです。');
                }
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $type = $finfo->file($tmp_name);
                if ($finfo === false) {
                    throw new RuntimeException('MimeType取得に失敗しました。');
                }
                if (strpos($type, 'application/octet-stream') !== 0) {
                    if (strpos($type, 'text/') !== 0) {
                        throw new RuntimeException('CSVファイルではありません。');
                    }
                }
                $path = realpath($save_directory);
                if ($path === false || !is_dir($path)) {
                    throw new LogicException('ディレクトリが存在しません。');
                }
                if (!is_writable($path)) {
                    throw new LogicException('ディレクトリに書き込み権限がありません。');
                }
                $new_name = "{$path}/{$data['store_file']}";
                if (is_file($new_name)) {
                    throw new RuntimeException("ファイル名が重複しています。");
                }
                if (!move_uploaded_file($tmp_name, $new_name)) {
                    throw new RuntimeException('アップロードされたファイルの保存に失敗しました。');
                }
                $msg = true;
            } catch (Exception $e) {
                $msg = $e->getMessage();
            }
        } else {
            $msg = '送信されたファイルはありません。';
        }
        return $msg;
    }

    function update_users_csv($filename, $data)
    {
        $this->db_is_scenario($data['scenario_id']);
        $row = $this->stmt->fetchAll();
        if (count($row) != 1) {
            $err['all'] = "属するシナリオがありません。";
            return;
        }
        $csvSuccessCnt = 0;
        $cnt_users = $this->count_users($data['scenario_id']);
        $max = MAX_USER - (int)$cnt_users;
        ini_set('auto_detect_line_endings', true);
        $csvData = file($filename, FILE_SKIP_EMPTY_LINES | FILE_IGNORE_NEW_LINES);
        $csvSuccessCnt = 0;
        $csvMaxCnt = 0;
        foreach ($csvData as $key => $line) {
            $this->err = array();
            if ($data['options0']) {
                $offset = 1;
            } else {
                $offset = 0;
            }
            if ($key >= $offset) {
                $keyword = '';
                $program_keyword = '';
                $program_keyword_2 = '';
                $record = explode(",", trim($line));
                mb_language('Japanese');
                $record_cnt = count($record);
                if ($record_cnt == 9) {
                    for ($i = 0; $i < 9; $i++) {
                        $num = $i + 1;
                        $dataname = 'data' . $num;
                        $$dataname = mb_convert_encoding(html_entity_decode($record[$i]), 'UTF-8', 'auto');
                    }
                    (!empty($data1)) ? $this->check_word_count($data1, 32) : $data1 = null;
                    (!empty($data2)) ? $this->check_word_count($data2, 32) : $data2 = null;
                    $this->check_mailadd($data3);
                    (!empty($data4)) ? $this->check_group($data4) : $data4 = 1;
                    (!empty($data5)) ? $this->check_word_count($data5, 32) : $data5 = null;
                    (!empty($data6)) ? $this->check_num($data6, 3) : $data6 = 0;
                    (!empty($data7)) ? $this->check_flg((int)$data7, '状態') : $data7 = 0;
                    (!empty($data8)) ? $this->check_word_count($data8, 32) : $data8 = $this->get_now_date();
                    (!empty($data9)) ? $this->check_word_count($data9, 32) : $data9 = null;
                    if (empty($this->err)) {
                        $user['firstname'] = $data1;
                        $user['lastname'] = $data2;
                        $user['email'] = $data3;
                        $user['group_id'] = $data4;
                        $user['order_no'] = $data5;
                        $user['story_no'] = $data6;
                        $user['delete_flg'] = $data7;
                        $user['created'] = $data8;
                        $user['send_date'] = $data9;
                        $user['scenario_id'] = $data['scenario_id'];
                        $user['password'] = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 6);
                        $user['auth'] = USER_ROLL;
                    } else {
                        $result['err'][]['data'] = ($key + 1) . "行目";
                        foreach ($this->err as $err_mess) {
                            $result['err'][]['massage'] = $err_mess;
                        }
                        $result['err'][]['data'] = $data1 . ' ' . $data2 . ' ' . $data3;
                        break;
                    }
                } else {
                    $result['err'][]['massage'] = 'CSVデータの個数が間違っています。';
                    break;
                }
                switch ($data['options1']) {
                    case '0':
                        if ($csvMaxCnt >= $max) {
                            $result['err'][]['massage'] = '最大会員登録数' . MAX_USER . 'を超えました。[00]';
                            break 2;
                        }
                        if ($this->redeclare_email($user['email'])) {
                            if ($this->db_add_user_csv($user)) {
                                $csvMaxCnt++;
                                $csvSuccessCnt++;
                            }
                        } else {
                            $result['err'][]['massage'] = 'すでに登録されています。';
                            $result['err'][]['data'] = $user['email'];
                        }
                        break;
                    case '1':
                        if ($this->redeclare_email($user['email'])) {
                            if ($csvMaxCnt >= $max) {
                                $result['err']['max']['massage'] = '最大会員登録数' . MAX_USER . 'を超えているので新規追加はできません。[01]';
                                break;
                            }
                            if ($this->db_add_user_csv($user)) {
                                $csvMaxCnt++;
                                $csvSuccessCnt++;
                            }
                        } else {
                            $id = $this->get_all_user_id($user['email']);
                            if ($id) {
                                if ($this->db_update_users_csv($user, $id)) {
                                    $csvSuccessCnt++;
                                }
                            } else {
                                $result['err'][]['massage'] = 'メールアドレスが複数登録されています。';
                                $result['err'][]['data'] = $user['email'];
                            }
                        }
                        break;
                    default:
                        break;
                }
            }
        }
        $result['status'] = $data['options1'];
        $result['cnt_text'] = count($csvData) - $offset;
        $result['cnt_success'] = $csvSuccessCnt;
        return $result;
    }

    function txtImport($data)
    {
        $this->db_is_scenario($data['scenario_id']);
        $row = $this->stmt->fetchAll();
        if (count($row) != 1) {
            $err['all'] = "属するシナリオがありません。";
            return;
        }
        $csvSuccessCnt = 0;
        $cnt_users = $this->count_users($data['scenario_id']);
        $max = MAX_USER - (int)$cnt_users;
        $group_id = $data['group_id'];
        $lines = $data['lines'];
        $arr = $this->txt2arr($data['lines']);
        foreach ($arr as $line) {
            if ($csvSuccessCnt >= $max) {
                $result['err'][]['massage'] = '最大会員登録数' . MAX_USER . 'を超えました。';
                break;
            }
            $this->err = array();
            $record = explode("\t", trim($line));
            mb_language('Japanese');
            $record_cnt = count($record);
            if ($record_cnt == 3) {
                $data1 = mb_convert_encoding(html_entity_decode($record[0]), 'UTF-8', 'auto');
                $data2 = mb_convert_encoding(html_entity_decode($record[1]), 'UTF-8', 'auto');
                $data3 = mb_convert_encoding(html_entity_decode($record[2]), 'UTF-8', 'auto');
                $this->check_word_count($data1, 32);
                $this->check_word_count($data2, 32);
                $this->check_mailadd($data3);
                if (empty($this->err)) {
                    $user['firstname'] = $data1;
                    $user['lastname'] = $data2;
                    $user['email'] = $data3;
                    $user['group_id'] = $group_id;
                } else {
                    $result['err'][]['massage'] = '入力データが間違っています。';
                    $result['err'][]['data'] = $data1;
                    $result['err'][]['data'] = $data2;
                    $result['err'][]['data'] = $data3;
                    break;
                }
            } elseif ($record_cnt == 2) {
                $data1 = mb_convert_encoding(html_entity_decode($record[0]), 'UTF-8', 'auto');
                $data2 = mb_convert_encoding(html_entity_decode($record[1]), 'UTF-8', 'auto');
                $this->check_word_count($data1, 32);
                $this->check_mailadd($data2);
                if (empty($this->err)) {
                    $user['firstname'] = $data1;
                    $user['email'] = $data2;
                    $user['group_id'] = $group_id;
                    $user['lastname'] = '';
                } else {
                    $result['err'][]['massage'] = '入力データが間違っています。';
                    $result['err'][]['data'] = $data1;
                    $result['err'][]['data'] = $data2;
                    break;
                }
            } elseif ($record_cnt == 1) {
                $data1 = mb_convert_encoding(html_entity_decode($record[0]), 'UTF-8', 'auto');
                $this->check_mailadd($data1);
                if (empty($this->err)) {
                    $user['email'] = $data1;
                    $user['group_id'] = $group_id;
                    $user['firstname'] = '';
                    $user['lastname'] = '';
                } else {
                    $result['err'][]['massage'] = '入力データが間違っています。';
                    foreach ($this->err as $err) {
                    }
                    $result['err'][]['massage'] = $err;
                    $result['err'][]['data'] = $data1;
                    break;
                }
            } else {
                $result['err'][]['massage'] = '入力データが間違っています。';
                break;
            }
            if ($data['is_story_no']) {
                $this->check_num($data['story_no'], 4);
                if (!empty($this->err)) {
                    $result['err'][]['massage'] = '配信開始ステップNoが間違っています。';
                    break;
                }
                $user['story_no'] = (int)$data['story_no'];
            } else {
                $user['story_no'] = 0;
            }
            $user['password'] = substr(str_shuffle('1234567890abcdefghijklmnopqrstuvwxyz'), 0, 6);
            $user['scenario_id'] = $data['scenario_id'];
            $user['order_no'] = '';
            $user['ip'] = '';
            $user['host'] = '';
            $user['auth'] = USER_ROLL;
            $user['delete_flg'] = FLG_NORMAL;
            switch ($data['options']) {
                case '0':
                    if ($this->redeclare_email($user['email'])) {
                        if ($this->db_add_user($user)) {
                            $csvSuccessCnt++;
                        }
                    } else {
                        $result['err'][]['massage'] = 'すでに登録されています。';
                        $result['err'][]['data'] = $user['email'];
                    }
                    break;
                case '1':
                    if (!$this->redeclare_email($user['email'])) {
                        $id = $this->get_user_id($user['email']);
                        if (!empty($id)) {
                            $this->db_delflag_user(FLG_DELETE, $id);
                            $csvSuccessCnt++;
                        }
                    } else {
                        $result['err'][]['massage'] = '登録されていません。';
                        $result['err'][]['data'] = $user['email'];
                    }
                    break;
                default;
                    break;
            }
        }
        $result['status'] = $data['options'];
        $result['cnt_text'] = count($arr);
        $result['cnt_success'] = $csvSuccessCnt;
        if ($csvSuccessCnt == 0) {
            $result['err'][]['massage'] = 'データを入力してください。';
        }
        return $result;
    }

    private function db_is_scenario($scenario_id)
    {
        try {
            $sql = "SELECT * FROM `scenarios` WHERE `id` = :scenario_id";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':scenario_id', $scenario_id, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function txt2arr($lines)
    {
        $array = explode("\n", $lines);
        $array = array_map('trim', $array);
        $array = array_filter($array, 'strlen');
        $array = array_values($array);
        return $array;
    }

    function get_send_date($id, &$data)
    {
        $result = false;
        $this->db_get_send_date($id);
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row[0];
            $result = true;
        }
        return $result;
    }

    private function db_get_send_date($id)
    {
        try {
            $sql = "SELECT `send_date`, `story_no`
					FROM `step_mail_logs`
					WHERE `user_id` =:id
					ORDER BY `send_date` DESC
					LIMIT 0 , 1";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_users_csv($data = null)
    {
        $line = '姓,名,メールアドレス,グループID,注文ID,ストーリーNo,状態(通常:0/停止:1/サーバーエラー:99),登録日,送信開始日' . "\n";
        if (!empty($data)) {
            for ($i = 0; $i < count($data); $i++) {
                $line .= $data[$i]['firstname'] . ',' . $data[$i]['lastname'] . ',' . $data[$i]['email'] . ',' . $data[$i]['group_id'] . ',' . $data[$i]['order_no'] . ',' . $data[$i]['story_no'] . ',' . $data[$i]['delete_flg'] . ',' . $data[$i]['created'] . ',' . $data[$i]['send_date'] . "\n";
            }
            $file = "users_list_" . date("Ymd-His") . '.csv';
        } else {
            $file = 'users_list_template.csv';
        }
        $csv_data = mb_convert_encoding($line, "sjis-win", 'utf-8');
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename={$file}");
        echo($csv_data);
    }

    private function check_group($group_id)
    {
        $this->check_num($group_id, 3);
        $this->check_is_group($group_id);
    }

    function check_is_group($group_id)
    {
        try {
            $sql = 'SELECT count(*) FROM `groups` WHERE `id` =:group_id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':group_id', $group_id);
            $stmt->execute();
            $row = $stmt->fetchColumn();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        if ($row == 1) {
            return true;
        }
        $this->err[] = 'グループIDが存在しないようです。';
        return false;
    }

    function db_get_group_id($group_code)
    {
        $result = false;
        try {
            $sql = 'SELECT `id` FROM `groups` WHERE `group_code` =:group_code';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':group_code', $group_code);
            $stmt->execute();
            $row = $stmt->fetchAll();
            $cnt = count($row);
            if ($cnt == 1) {
                $data = $row[0]['id'];
                $result = $data;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $result;
    }

    function db_get_group_name($group_id)
    {
        $result = false;
        try {
            $sql = 'SELECT `group_name` FROM `groups` WHERE `id` =:group_id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':group_id', $group_id);
            $stmt->execute();
            $row = $stmt->fetchAll();
            $cnt = count($row);
            if ($cnt == 1) {
                $data = $row[0]['group_name'];
                $result = $data;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $result;
    }

    function db_get_group_code($group_id)
    {
        $result = false;
        try {
            $sql = 'SELECT `group_code` FROM `groups` WHERE `id` =:group_id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':group_id', $group_id);
            $stmt->execute();
            $row = $stmt->fetchAll();
            $cnt = count($row);
            if ($cnt == 1) {
                $data = $row[0]['group_code'];
                $result = $data;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $result;
    }

    function get_serialnumber()
    {
        try {
            $stmt = $this->pdo->prepare('SELECT * FROM `serial` ');
            $stmt->execute();
            $row = $stmt->fetchObject();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        if (count($row) == 1) {
            return $row;
        }
        return null;
    }

    function set_chkflg($val)
    {
        try {
            $sql = 'UPDATE `serial`
					SET `chk_flg`=:chk_flg';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':chk_flg', $val);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function chkLicense()
    {
        $status = 0;
        $row = $this->get_serialnumber();
        if (!empty($row)) {
            $serialnumber = $row->serialnumber;
            $domain = $_SERVER['HTTP_HOST'];
            $receive = @file_get_contents(API_URL . "checkSerial?sn=" . $serialnumber . "&u=" . urlencode($domain));
            if ($receive == 'OK') {
                $this->set_chkflg('1');
                $status = 1;
            } elseif ($receive == 'NG3') {
                $this->set_chkflg('3');
                $status = 3;
            }
        }
        return $status;
    }

    function hide2go($license_flg)
    {
        switch ($license_flg) {
            case 1:
                $_SESSION['license_flg'] = 2;
                $go = urlencode('main.php');
                break;
            case 3:
                $this->session_dell();
                $_SESSION['license_flg'] = 3;
                $go = urlencode('login.php');
                break;
            default:
                $this->session_dell();
                $_SESSION['license_flg'] = 0;
                $go = urlencode('login.php');
                break;
        }
        return $go;
    }

    function hide2go2($license_flg)
    {
        switch ($license_flg) {
            case 1:
                $_SESSION['license_flg'] = 1;
                header('Location:' . URL . '/admin/users/index.php?status=admin');
                exit;
                break;
            case 3:
                $this->session_dell();
                $_SESSION['license_flg'] = 3;
                $go = urlencode('login.php');
                break;
            default:
                $this->session_dell();
                $_SESSION['license_flg'] = 0;
                $go = urlencode('login.php');
                break;
        }
        return $go;
    }

    function getInstallDomain()
    {
        $url = str_replace("http://", "", URL);
        $url = str_replace("https://", "", $url);
        $url_arr = @explode("/", $url);
        if (!isset($url_arr[0])) {
            $domain = $_SERVER['HTTP_HOST'];
        } else {
            $domain = $url_arr[0];
        }
        return $domain;
    }

    function getInstallDomain2()
    {
        $row = $this->get_serialnumber();
        if (!empty($row)) {
            $serialnumber = $row->serialnumber;
            $receive = file_get_contents(API_URL . "getInstallDomain?sn=" . $serialnumber);
            if ($receive) {
                return $receive;
            }
        }
        return "";
    }

    function setSerialNumber($serialnumber)
    {
        $sn = trim($serialnumber);
        $domain = $this->getInstallDomain();
        $receive = @file_get_contents(API_URL . "setDomain?sn=" . $sn . "&u=" . urlencode($domain));
        $arr_error = @explode("<errcode>", $receive);
        if (isset($arr_error[1])) {
            return $arr_error[1];
        } else {
            try {
                $stmt = $this->pdo->prepare("CREATE TABLE IF NOT EXISTS `serial` (
	  					`serialnumber` text NULL,
	  					`chk_flg` TINYINT( 1 ) NOT NULL DEFAULT '0'
					) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;");
                $stmt->execute();
            } catch (PDOException $e) {
                die($e->getMessage());
            }
            try {
                $sql = "TRUNCATE TABLE `serial`; INSERT INTO `serial` (`serialnumber`) VALUES (:serialnumber);";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':serialnumber', $sn);
                $stmt->execute();
            } catch (PDOException $e) {
                die($e->getMessage());
            }
        }
        return "";
    }

    function setAPI_URL()
    {
        if (!defined('API_URL')) {
            require_once(dirname(__FILE__) . '/config_org.ini');
            $str = @file_get_contents(dirname(__FILE__) . '/config.ini');
            $str .= "\n";
            $str .= "define( 'API_URL', '" . API_URL . "' );";
            @file_put_contents(dirname(__FILE__) . '/config.ini', $str);
        }
    }

    function get_user_row($email, &$data)
    {
        $result = false;
        try {
            $this->stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `email` = :email AND `delete_flg` != 1 AND `auth` != 9');
            $this->stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        $row = $this->stmt->fetchAll();
        if (count($row) == 1) {
            $data = $row[0];
            $result = true;
        }
        return $result;
    }

    function get_admin_row($email, &$data)
    {
        $result = false;
        try {
            $this->stmt = $this->pdo->prepare('SELECT * FROM `users` WHERE `email` = :email AND `delete_flg` != 1 AND `auth` = 9');
            $this->stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        $row = $this->stmt->fetchAll();
        if (count($row) == 1) {
            $data = $row[0];
            $result = true;
        }
        return $result;
    }

    function curl_json($url, $data)
    {
        $json = json_encode($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_AUTOREFERER => false,
        );
        curl_setopt_array($ch, $options);
        curl_setopt($ch, CURLOPT_HTTPHEADER,
            array('Content-Type: application/json', 'X-Requested-With: XmlHttpRequest', 'Accept: application/json'));
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result, true);
    }

    function is_order_users($order_no)
    {
        try {
            $sql = 'SELECT count(*) FROM `users` WHERE `order_no` =:order_no';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':order_no', $order_no);
            $stmt->execute();
            $row = $stmt->fetchColumn();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        if ($row == 1) {
            return true;
        }
        return false;
    }

    function system_backup()
    {
        $current_time = date("Ymd-His");
        $dl_file = "cyfons_backup_" . $current_time . '.sql';
        $tmp_file = dirname(__FILE__) . "/tmp_file_" . $current_time . '.sql';
        $tmp_file2 = dirname(__FILE__) . "/tmp_file2_" . $current_time . '.sql';
        $cmd = 'mysqldump';
        $cmd = $cmd . ' -h' . DB_HOST;
        $cmd = $cmd . ' -u' . DB_USER;
        $cmd = $cmd . ' -p' . DB_PASSWORD;
        $cmd = $cmd . ' ' . DB_NAME;
        $cmd = $cmd . ' --ignore-table=' . DB_NAME . ".ac_mail_logs";
        $cmd = $cmd . ' --ignore-table=' . DB_NAME . ".ac_site_logs";
        $cmd = $cmd . ' --ignore-table=' . DB_NAME . ".extra_mail_logs";
        $cmd = $cmd . ' --ignore-table=' . DB_NAME . ".step_mail_logs";
        $cmd = $cmd . ' --ignore-table=' . DB_NAME . ".su_api_access_log";
        $cmd = $cmd . ' --ignore-table=' . DB_NAME . ".su_click_log";
        $cmd = $cmd . ' > ' . $tmp_file;
        system($cmd);
        $cmd = 'mysqldump';
        $cmd = $cmd . ' -h' . DB_HOST;
        $cmd = $cmd . ' -u' . DB_USER;
        $cmd = $cmd . ' -p' . DB_PASSWORD;
        $cmd = $cmd . ' -d ' . DB_NAME;
        $cmd = $cmd . " ac_mail_logs";
        $cmd = $cmd . " ac_site_logs";
        $cmd = $cmd . " extra_mail_logs";
        $cmd = $cmd . " step_mail_logs";
        $cmd = $cmd . " su_api_access_log";
        $cmd = $cmd . " su_click_log";
        $cmd = $cmd . ' > ' . $tmp_file2;
        system($cmd);
        $filelist = array($tmp_file, $tmp_file2);
        $data = "";
        foreach ($filelist as $file) {
            $filedata = @file_get_contents($file);
            $data .= $filedata;
        }
        file_put_contents($tmp_file, $data);
        header("Content-Type: application/force-download");
        header("Content-Length: " . filesize($tmp_file));
        header("Content-disposition: attachment; filename={$dl_file}");
        readfile($tmp_file);
        unlink($tmp_file);
        unlink($tmp_file2);
    }

    function is_unit_folder()
    {
        $URLUNIT = dirname(__FILE__) . '/../admin/units/';
        return file_exists($URLUNIT);
    }

    function is_users_unit()
    {
        $sql = 'SELECT COUNT(`id`) FROM `un_settings` WHERE `id`=1';
        $this->db_sql($sql);
        return $this->get_sql();
    }

    function unlink_unit_folder()
    {
        $URLUNIT = dirname(__FILE__) . '/../admin/units/';
        $this->unlinkRecursive($URLUNIT, true);
    }

    function get_all_unit_settings()
    {
        $result = false;
        $this->db_get_all_units();
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if (count($row) >= 1) {
            $result = $row;
        }
        return $result;
    }

    private function db_get_all_units()
    {
        try {
            $this->stmt = $this->pdo->prepare("SELECT * FROM `un_settings` WHERE `unit_code` !='1'");
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function is_user_in_unit($user_id)
    {
        $result = false;
        $units = $this->get_all_unit_settings();
        if ($units === false) {
            return false;
        }
        foreach ($units as $unit) {
            $is_user = false;
            $data['user_id'] = $user_id;
            $data['unit_code'] = $unit['unit_code'];
            $data['unit_name'] = $unit['unit_name'];
            $is_user = $this->serach_unit_id($data);
            if ($is_user) {
                $user[] = $data;
                $result = $user;
            }
        }
        return $result;
    }

    function serach_unit_id($data)
    {
        $result = false;
        $stmt = $this->db_serach_unit_id($data);
        $row = $stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $result = true;
        }
        return $result;
    }

    private function db_serach_unit_id($data)
    {
        $users_table = 'un_users_' . trim($data['unit_code']);
        try {
            $this->stmt = $this->pdo->prepare("SELECT * FROM {$users_table} WHERE `user_id` = :user_id");
            $this->stmt->bindValue(":user_id", $data['user_id']);
            $this->stmt->execute();
            return $this->stmt;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function delflag_un_user($flg, $user_id)
    {
        $units = $this->get_all_unit_settings();
        if ($units === false) {
            return false;
        }
        foreach ($units as $unit) {
            $is_user = false;
            $data['user_id'] = $user_id;
            $data['unit_code'] = $unit['unit_code'];
            $is_user = $this->serach_unit_id($data);
            if ($is_user) {
                $this->db_delflag_un_user($flg, $data);
            }
        }
    }

    private function db_delflag_un_user($flg, $data)
    {
        $users_table = 'un_users_' . trim($data['unit_code']);
        try {
            $stmt = $this->pdo->prepare("UPDATE {$users_table} SET `delete_flg`=:flg,`deleted`=NOW() WHERE `user_id`=:user_id");
            $stmt->bindValue(':flg', $flg, PDO::PARAM_INT);
            $stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function delete_un_user($user_id)
    {
        $units = $this->get_all_unit_settings();
        if ($units === false) {
            return false;
        }
        foreach ($units as $unit) {
            $is_user = false;
            $data['user_id'] = $user_id;
            $data['unit_code'] = $unit['unit_code'];
            $is_user = $this->serach_unit_id($data);
            if ($is_user) {
                $this->db_delete_un_user($data);
            }
        }
    }

    private function db_delete_un_user($data)
    {
        $users_table = 'un_users_' . trim($data['unit_code']);
        try {
            $sql = "DELETE FROM " . $users_table . " WHERE `user_id` = :user_id;";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':user_id', $data['user_id'], PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }
} ?>