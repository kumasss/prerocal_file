<?php
require_once(dirname(__FILE__) . '/main.php');
require_once(dirname(__FILE__) . '/logs.php');
require_once(dirname(__FILE__) . '/bodys.php');
require_once(dirname(__FILE__) . '/users.php');

class mails extends main
{
    function db_add_stepmail($data, $update = true)
    {
        $data['id'] = (!empty($data['id'])) ? $data['id'] : null;
        $data['scenario_id'] = SCENARIOS_ID;
        $data['created'] = (!empty($data['created'])) ? $data['created'] : $this->get_now_date();
        try {
            $sql = "INSERT INTO `step_mails`(
			`id`,
			`scenario_id`,
			`title`,
			`header_id`,
			`contents`,
			`footer_id`,
			`send_date`,
			`send_time`,
			`send_flg`,
			`group_id`,
			`created`)
			VALUES ( :id, :scenario_id, :title, :header_id, :contents, :footer_id, :send_date, :send_time, :send_flg, :group_id, :created )";
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->beginTransaction();
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':id', $data['id']);
            $this->stmt->bindValue(':scenario_id', $data['scenario_id']);
            $this->stmt->bindValue(':title', $data['title']);
            $this->stmt->bindValue(':header_id', $data['header_id']);
            $this->stmt->bindValue(':contents', $data['contents']);
            $this->stmt->bindValue(':footer_id', $data['footer_id']);
            $this->stmt->bindValue(':send_date', $data['send_date']);
            $this->stmt->bindValue(':send_time',
                $this->get_send_time_combined($data['send_time_hour'], $data['send_time_minute']));
            $this->stmt->bindValue(':send_flg', $data['send_flg']);
            $this->stmt->bindValue(':group_id', $data['group_id']);
            $this->stmt->bindValue(':created', $data['created']);
            $this->stmt->execute();
            $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            die($e->getMessage());
        }
    }

    function get_insert_id(&$data)
    {
        $result = false;
        try {
            $sql = "SELECT LAST_INSERT_ID() FROM `step_mails`";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
            $row = $this->stmt->fetchAll();
            $cnt = count($row);
            if ($cnt >= 1) {
                $data = $row[0][0];
                $result = true;
            }
            return $result;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            die($e->getMessage());
        }
    }

    function db_edit_stepmail($data)
    {
        try {
            $sql = "UPDATE `step_mails`
					SET 
					`title` = :title,
					`header_id` = :header_id, 
					`contents` = :contents,
					`footer_id` = :footer_id,
					`send_date` = :send_date,
					`send_time` = :send_time,
					`send_flg` = :send_flg,
					`group_id` = :group_id,
					`modified` = NOW()
					WHERE `step_mails`.`id` = :id";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':title', $data['title']);
            $this->stmt->bindValue(':header_id', $data['header_id']);
            $this->stmt->bindValue(':contents', $data['contents']);
            $this->stmt->bindValue(':footer_id', $data['footer_id']);
            $this->stmt->bindValue(':send_date', $data['send_date']);
            $this->stmt->bindValue(':send_time',
                $this->get_send_time_combined($data['send_time_hour'], $data['send_time_minute']));
            $this->stmt->bindValue(':send_flg', $data['send_flg']);
            $this->stmt->bindValue(':group_id', $data['group_id']);
            $this->stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_delete_stepmail($data)
    {
        try {
            $sql = "DELETE FROM `step_mails`
					WHERE `step_mails`.`id` = :id;";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_delete_all_stepmail()
    {
        try {
            $sql = "TRUNCATE TABLE `step_mails`";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_delete_all_stories()
    {
        try {
            $sql = "TRUNCATE TABLE `stories`";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function reset_data_stepmail()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `step_mails_bak` LIKE  `step_mails` ";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        $sql = "DELETE FROM `step_mails_bak` ";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        $sql = "INSERT INTO `step_mails_bak` SELECT * FROM `step_mails` ";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
    }

    private function reset_data_stories()
    {
        $sql = "CREATE TABLE IF NOT EXISTS `stories_bak` LIKE  `stories` ";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        $sql = "DELETE FROM `stories_bak` ";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        $sql = "INSERT INTO `stories_bak` SELECT * FROM `stories` ";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
    }

    function is_data_step_mails_bak()
    {
        $result = false;
        try {
            $sql = "SELECT COUNT(*) FROM `step_mails_bak`";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
            $row = $this->stmt->fetchColumn();
            if ($row >= 1) {
                $result = true;
            }
            return $result;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function is_data_stories_bak()
    {
        $result = false;
        try {
            $sql = "SELECT COUNT(*) FROM `stories_bak`";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
            $row = $this->stmt->fetchColumn();
            if ($row >= 1) {
                $result = true;
            }
            return $result;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function restore_data_stepmail()
    {
        $sql = "DELETE FROM `step_mails` ";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        $sql = "INSERT INTO `step_mails` SELECT * FROM `step_mails_bak` ";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
    }

    function restore_data_stories()
    {
        $sql = "DELETE FROM `stories` ";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
        $sql = "INSERT INTO `stories` SELECT * FROM `stories_bak` ";
        $this->stmt = $this->pdo->prepare($sql);
        $this->stmt->execute();
    }

    function get_all_stepmail(&$data, $group = null, $start = 0, $num = 999)
    {
        $result = false;
        $this->db_all_stepmail($group, $start, $num);
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $result = true;
        }
        return $result;
    }

    /**
     * 指定したグループの全てのステップメールを取得するメソッド
     *
     * @param $group
     * @param $start
     * @param $num
     */
    private function db_all_stepmail($group, $start, $num)
    {
        try {
            $sql = "SELECT
              sm.id
              , sm.scenario_id
              , sm.title
              , sm.header_id
              , sm.contents
              , sm.footer_id
              , sm.story_no
              , sm.send_flg
              , sm.group_id
              , sm.send_date
              , sm.send_time
              , sm.created
              , sm.modified
              , hd.header
              , ft.footer
              , sto.story_no AS sto_story_no
			FROM
			`stories` sto
			LEFT JOIN
			(`step_mails` sm LEFT JOIN headers hd ON sm.header_id = hd.id) LEFT JOIN footers AS ft ON sm.footer_id = ft.id
			ON sto.step_mail_id = sm.id";
            if (!empty($group) & $group != 'all') {
                $sql .= " WHERE FIND_IN_SET(" . $group . ",sto.`group_id`)";
            }
            $sql .= " GROUP BY sm.id
              , sm.scenario_id
              , sm.title
              , sm.header_id
              , sm.contents
              , sm.footer_id
              , sm.story_no
              , sm.send_flg
              , sm.group_id
              , sm.send_date
              , sm.send_time
              , sm.created
              , sm.modified
              , hd.header
              , ft.footer
              , sto.story_no ORDER BY sto.`story_no`, sm.`send_date` ASC , sm.`send_time` ASC 
			LIMIT :start, :num";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':start', (int)$start, PDO::PARAM_INT);
            $this->stmt->bindValue(':num', (int)$num, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_stepmail_count(&$cnt)
    {
        $result = false;
        $this->db_get_stepmail_count();
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $result = true;
        }
        return $result;
    }

    private function db_get_stepmail_count()
    {
        try {
            $sql = "SELECT * FROM `step_mails`";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function count_step($group = null)
    {
        $group = trim($group);
        $this->db_count_step($group);
        $cnt = $this->stmt->fetchAll();
        return $cnt;
    }

    private function db_count_step($group)
    {
        try {
            $sql = 'SELECT COUNT(*) as cnt FROM `step_mails`';
            if (!empty($group) & $group != 'all') {
                $sql .= " where FIND_IN_SET('1',`group_id`) OR FIND_IN_SET(" . $group . ",`group_id`)";
            }
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function count_extra($group = null)
    {
        $group = trim($group);
        $this->db_count_extra($group);
        $cnt = $this->stmt->fetchAll();
        return $cnt;
    }

    private function db_count_extra($group)
    {
        try {
            $sql = 'SELECT COUNT(*) as cnt FROM `extra_mails`';
            if (!empty($group) & $group != 'all') {
                $sql .= " where FIND_IN_SET('1',`group_id`) OR FIND_IN_SET(" . $group . ",`group_id`)";
            }
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_stepmail($id, &$data)
    {
        $result = false;
        $this->db_stepmail($id);
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt == 1) {
            $data = $row[0];
            $result = true;
        }
        return $result;
    }

    private function db_stepmail($id)
    {
        try {
            $sql = "SELECT * FROM `step_mails` WHERE `id` = :id";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function is_stepmail($id)
    {
        $result = false;
        $this->db_is_stepmail($id);
        $cnt = $this->stmt->fetchColumn();
        if ($cnt >= 1) {
            $result = true;
        }
        return $result;
    }

    private function db_is_stepmail($id)
    {
        try {
            $sql = "SELECT COUNT(*) FROM `step_mails` WHERE `id` = :id";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function is_extramail($id)
    {
        $result = false;
        $this->db_is_extramail($id);
        $cnt = $this->stmt->fetchColumn();
        if ($cnt >= 1) {
            $result = true;
        }
        return $result;
    }

    private function db_is_extramail($id)
    {
        try {
            $sql = "SELECT COUNT(*) FROM `extra_mails` WHERE `id` = :id";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_is_step_mail_logs_users(&$data)
    {
        $result = false;
        try {
            $sql = "
			SELECT
			el.id,
			el.user_id,
			u.email
			FROM `step_mail_logs` AS el
			LEFT JOIN `users` u
			ON el.`user_id` = u.`id`
			WHERE `send_flg` = 99 AND u.email IS NULL";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
            $row = $this->stmt->fetchAll();
            $cnt = count($row);
            if ($cnt >= 1) {
                $data = $row;
                $result = true;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $result;
    }

    /**
     * 「extra_mail_logs」テーブルと「users」テーブルを突き合わせ、
     * 「email」項目が設定されていないユーザー情報を取得するメソッド
     *
     * @param $data
     *
     * @return bool
     */
    function db_is_extra_mail_logs_users(&$data)
    {
        $result = false;
        try {
            $sql = "SELECT
			el.id,
			el.user_id,
			u.email
			FROM `extra_mail_logs` AS el
			LEFT JOIN `users` u
			ON el.`user_id` = u.`id`
			WHERE u.email IS NULL
            GROUP BY
              el.id
              , el.user_id
              , u.email";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
            $row = $this->stmt->fetchAll();
            $cnt = count($row);
            if ($cnt >= 1) {
                $data = $row;
                $result = true;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $result;
    }

    function make_group_id($form_data, &$data)
    {
        $result = false;
        $arr = array();
        for ($i = 1; $i < 1000; $i++) {
            $name = 'group_id-' . $i;
            if (isset($form_data[$name])) {
                $arr[] = $form_data[$name];
            }
            if (is_array($arr)) {
                $data = implode(',', $arr);
                $result = true;
            }
        }
        return $result;
    }

    function get_group_id($group_id, &$data)
    {
        $arr = explode(',', $group_id);
        foreach ($arr as $val) {
            $name = 'group_id-' . $val;
            $data[$name] = $val;
        }
    }

    function get_step_csv($data = null)
    {
        $line = "id,タイトル,ヘッダー,本文,フッター,稼働(非稼働:0/稼働:1),グループid,配信時期,配信時間,登録日\r\n";
        for ($i = 0; $i < count($data); $i++) {
            $line .= $data[$i]['id'] . ',' . $data[$i]['title'] . ',' . $data[$i]['header_id'] . ',' . $data[$i]['contents'] . ',' . $data[$i]['footer_id'] . ',' . $data[$i]['send_flg'] . ',' . $data[$i]['group_id'] . ',' . $data[$i]['send_date'] . ',' . $data[$i]['send_time'] . ',' . $data[$i]['created'] . "\r\n";
        }
        $file = "step_mails_data_" . date("Ymd-His") . '.csv';
        $csv_data = mb_convert_encoding($line, "sjis-win", 'utf-8');
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename={$file}");
        echo($csv_data);
    }

    function get_step_export($data = null)
    {
        $line = "";
        $cnt_data = count($data);
        for ($i = 0; $i < $cnt_data; $i++) {
            $line .= "STEPID: \r\n";
            $line .= $data[$i]['id'] . "\r\n";
            $line .= "-----\r\n";
            $line .= "TITLE: \r\n";
            $line .= $this->html_decode($data[$i]['title']);
            $line .= "\r\n";
            $line .= "-----\r\n";
            $line .= "HEADERID: \r\n";
            $line .= $data[$i]['header_id'] . "\r\n";
            $line .= "-----\r\n";
            $line .= "CONTENTS: \r\n";
            $line .= $this->html_decode($data[$i]['contents']);
            $line .= "\r\n";
            $line .= "-----\r\n";
            $line .= "FOOTERID: \r\n";
            $line .= $data[$i]['footer_id'] . "\r\n";
            $line .= "-----\r\n";
            $line .= "SENDFLG: \r\n";
            $line .= $data[$i]['send_flg'] . "\r\n";
            $line .= "-----\r\n";
            $line .= "GROUPID: \r\n";
            $line .= $data[$i]['group_id'] . "\r\n";
            $line .= "-----\r\n";
            $line .= "SENDDATE: \r\n";
            $line .= $data[$i]['send_date'] . "\r\n";
            $line .= "-----\r\n";
            $line .= "SENDTIME: \r\n";
            $line .= $data[$i]['send_time'] . "\r\n";
            $line .= "-----\r\n";
            $line .= "CREATED: \r\n";
            $line .= $data[$i]['created'] . "\r\n";
            if ($i < $cnt_data) {
                $line .= "--------\r\n";
            }
        }
        $file = "step_mails_data_" . date("Ymd-His") . '.txt';
        $csv_data = $line;
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename={$file}");
        echo($csv_data);
    }

    function update_step_data($filename, $data)
    {
        $csvSuccessCnt = 0;
        $max = 9999;
        $txtRow = file_get_contents($filename);
        $txtConv = $txtRow;
        $arr_data = preg_split("/^-{8}(\r\n|\n|\r)$/m", $txtConv);
        preg_match_all('/^STEPID:\s/m', $txtConv, $out, PREG_SET_ORDER);
        $cnt_mail = count($out);
        $deleteFlg = true;
        foreach ($arr_data as $key => $arr_mail) {
            if (empty($arr_mail)) {
                break;
            }
            $mails = preg_split("/^-{5}(\r\n|\n|\r)$/m", $arr_mail);
            if (count($mails) != 10) {
                $n = $key + 1;
                $result['err'][]['massage'] = $n . '個目のメールデータの項目数が間違っています。データの確認をして不具合があった場合には復元を試してください。(err1)';
                break;
            }
            $arr_stepkey = array(
                'STEPID',
                'TITLE',
                'HEADERID',
                'CONTENTS',
                'FOOTERID',
                'SENDFLG',
                'GROUPID',
                'SENDDATE',
                'SENDTIME',
                'CREATED'
            );
            $record_cnt = 0;
            foreach ($mails as $mail_data) {
                foreach ($arr_stepkey as $stepkey) {
                    $match = '/^' . $stepkey . ':\s/m';
                    if (preg_match($match, $mail_data, $str)) {
                        $record_cnt++;
                        $rep_mail_data = preg_replace($match, '', $mail_data);
                        $rep_mail_data = trim($rep_mail_data);
                        $csv_data[$record_cnt] = $rep_mail_data;
                        break;
                    }
                }
            }
            if ($record_cnt == 10) {
                $this->err = array();
                $csv_data[1] = (int)mb_convert_kana($csv_data[1], 'n', 'utf-8');
                $csv_data[3] = (int)mb_convert_kana($csv_data[3], 'n', 'utf-8');
                $csv_data[5] = (int)mb_convert_kana($csv_data[5], 'n', 'utf-8');
                $csv_data[6] = (int)mb_convert_kana($csv_data[6], 'n', 'utf-8');
                $csv_data[7] = (int)mb_convert_kana($csv_data[7], 'n', 'utf-8');
                $csv_data[8] = (int)mb_convert_kana($csv_data[8], 'n', 'utf-8');
                $csv_data[2] = htmlspecialchars($csv_data[2], ENT_QUOTES);
                $csv_data[4] = htmlspecialchars($csv_data[4], ENT_QUOTES);
                (!empty($csv_data[1])) ? $this->check_num($csv_data[1], 9) : $csv_data[1] = null;
                $this->check_title($csv_data[2]);
                (!empty($csv_data[3])) ? $this->check_header($csv_data[3]) : $csv_data[3] = 0;
                $this->check_contents($csv_data[4]);
                (!empty($csv_data[5])) ? $this->check_footer($csv_data[5]) : $csv_data[5] = 0;
                (!empty($csv_data[6])) ? $this->check_flg($csv_data[6], '状態') : $csv_data[6] = 0;
                (!empty($csv_data[7])) ? $this->check_group($csv_data[7]) : $csv_data[7] = 1;
                (!empty($csv_data[8])) ? $this->check_date($csv_data[8]) : $csv_data[8] = 0;
                (!empty($csv_data[9])) ? $this->check_time($csv_data[9]) : $csv_data[9] = 0;
                (!empty($csv_data[10])) ? $this->check_datetime($csv_data[10]) : $csv_data[10] = $this->get_now_date();
                if ($csv_data[8] == 0 & $csv_data[9] == 0) {
                    $csv_data[8] = 0;
                }
                if (empty($this->err)) {
                    $arr_send_time = explode(':', $csv_data[9]);
                    $stepmail['id'] = $csv_data[1];
                    $stepmail['scenario_id'] = 1;
                    $stepmail['title'] = $csv_data[2];
                    $stepmail['header_id'] = $csv_data[3];
                    $stepmail['contents'] = $csv_data[4];
                    $stepmail['footer_id'] = $csv_data[5];
                    $stepmail['story_no'] = 0;
                    $stepmail['send_flg'] = $csv_data[6];
                    $stepmail['group_id'] = $csv_data[7];
                    $stepmail['send_date'] = $csv_data[8];
                    $stepmail['send_time_hour'] = $arr_send_time[0];
                    $stepmail['send_time_minute'] = $arr_send_time[1];
                    $stepmail['created'] = $csv_data[10];
                    $stepmail['modified'] = '';
                } else {
                    $result['err'][]['data'] = ($key + 1) . "個目のデータ";
                    foreach ($this->err as $err_mess) {
                        $result['err'][]['massage'] = $err_mess;
                    }
                    $result['err'][]['data'] = 'id=' . $csv_data[1] . '：' . $csv_data[2];
                    break;
                }
                switch ($data['options1']) {
                    case '0':
                        require_once('stories.php');
                        $storiesObj = new stories();
                        if ($deleteFlg) {
                            $this->reset_data_stepmail();
                            $this->reset_data_stories();
                            $this->db_delete_all_stepmail();
                            $this->db_delete_all_stories();
                        }
                        $this->db_add_stepmail($stepmail, false);
                        if (empty($stepmail['id'])) {
                            $this->get_insert_id($step_mail_id);
                        } else {
                            $step_mail_id = $stepmail['id'];
                        }
                        $storiesObj->add_story($stepmail['group_id'], $step_mail_id);
                        $storiesObj->make_storyno($stepmail['group_id']);
                        $csvSuccessCnt++;
                        $deleteFlg = false;
                        break;
                    case '1':
                        break;
                    default:
                        break;
                }
                if ($csvSuccessCnt >= $max) {
                    break;
                }
            } else {
                $n = $key + 1;
                $result['err'][]['massage'] = $n . '個目のメールデータの項目数が間違っています。データの確認をして不具合があった場合には復元を試してください。(err2)';
                break;
            }
        }
        $result['status'] = $data['options1'];
        $result['cnt_text'] = $cnt_mail;
        $result['cnt_success'] = $csvSuccessCnt;
        return $result;
    }

    function update_story_no($scenario_id)
    {
        $this->db_select_update_story_no($scenario_id);
        $result = $this->stmt->fetchAll();
        if (!empty($result)) {
            $story_no = 1;
            foreach ($result as $data) {
                $this->db_update_story_no($data['id'], $story_no);
                $story_no++;
            }
            $no = $story_no - 1;
        } else {
            $no = 0;
        }
        $this->db_update_users_max_story_no($no);
    }

    private function db_select_update_story_no($scenario_id)
    {
        try {
            $sql = "SELECT `id`
			FROM `step_mails`
			WHERE `scenario_id` = :scenario_id
			ORDER BY `send_date` ASC, `send_time` ASC, `created` ASC";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':scenario_id', $scenario_id);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function db_update_story_no($stepmail_id, $story_no)
    {
        try {
            $sql = "UPDATE `step_mails` 
			SET
			`story_no` = :story_no,
			`modified` = now()
			WHERE `step_mails`.`id` = :id";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':story_no', (int)$story_no, PDO::PARAM_INT);
            $this->stmt->bindValue(':id', (int)$stepmail_id, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_last_story_no($scenario_id)
    {
        $this->db_select_last_story_no($scenario_id);
        $result = $this->stmt->fetchAll();
        if (!empty($result)) {
            return $result[0];
        }
        return false;
    }

    private function db_select_last_story_no($scenario_id)
    {
        try {
            $sql = "
			SELECT
			`send_date` 
			FROM
			`step_mails` 
			WHERE
			`scenario_id` = :scenario_id 
			ORDER BY `send_date` DESC, `send_time` DESC
			LIMIT 0 , 1";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':scenario_id', $scenario_id);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function is_smtp()
    {
        $mailer = false;
        if (defined('MAILER')) {
            $mailer = MAILER;
        }
        if ($mailer) {
            require_once(dirname(__FILE__) . '/mailers.php');
            $mailersObj = new mailers();
            $smtp_data = $mailersObj->get_mailer();
            if ($smtp_data['is_smtp']) {
                return true;
            }
        }
        return false;
    }

    function send_split_step_mail_smtp($setting)
    {
        require_once('accanalyzes.php');
        require_once('settings.php');
        $accanalyzesObj = new accanalyzes();
        $settingsObj = new settings();
        $logsObj = new logs();
        $usersObj = new users();
        require dirname(__FILE__) . '/../common/mailer/PHPMailerAutoload.php';
        require_once(dirname(__FILE__) . '/../common/mailers.php');
        $mailersObj = new mailers();
        $smtp_data = $mailersObj->get_mailer();
        date_default_timezone_set('Asia/Tokyo');
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = $mailersObj->get_smtpdebug();
        $mail->Debugoutput = $mailersObj->get_debugoutput();
        $mail->CharSet = $mailersObj->get_mail_charset();
        $mail->Encoding = $mailersObj->get_mail_encoding();
        $mail->SMTPAuth = $mailersObj->get_smtpauth();
        $mail->SMTPKeepAlive = $mailersObj->get_smtpkeepalive();
        $mail->Timeout = $mailersObj->get_timeout();
        $verify_peer = $mailersObj->get_verify_peer();
        $verify_peer_name = $mailersObj->get_verify_peer_name();
        $allow_self_signed = $mailersObj->get_allow_self_signed();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => $verify_peer,
                'verify_peer_name' => $verify_peer_name,
                'allow_self_signed' => $allow_self_signed
            )
        );
        $mail->Host = $smtp_data['host'];
        $mail->Port = $smtp_data['port'];
        $mail->Username = $smtp_data['username'];
        $mail->Password = $smtp_data['password'];
        switch ($smtp_data['secure']) {
            case '1':
                echo 'SSL';
                $mail->SMTPSecure = 'ssl';
                break;
            case '2':
                echo 'TLS';
                $mail->SMTPSecure = 'tls';
                break;
            default:
                break;
        }
        $this->get_admin_user($admin_user);
        $mail->setFrom($admin_user['email'], $admin_user['firstname']);
        $send_stepmail = $settingsObj->get_send_stepmail();
        $cnt_send_list = $this->get_step_mail_list_count();
        $cnt = 0;
        $start = microtime(true);
        for ($i = 0; $i < $cnt_send_list; $i += $setting['send_num']) {
            $this->get_step_mail_list_split(0, $setting['send_num'], $users);
            if (is_array($users)) {
                foreach ($users as $user) {
                    if ($this->is_user_id($user['user_id'])) {
                        $time = microtime(true) - $start;
                        if ($time > 480) {
                            return;
                        }
                        $user['group_name'] = $usersObj->db_get_group_name($user['group_id']);
                        $user['stepmail_url'] = $this->get_backnumber_url($user['user_id']);
                        $user['extramail_url'] = $this->get_backnumber_url($user['user_id'], true);
                        $rep_subject = $this->txtReplace($user['title'], $user);
                        $rep_message = $this->txtReplace($user['contents'], $user);
                        $rep_subject = htmlspecialchars_decode($rep_subject, ENT_QUOTES);
                        $rep_message = htmlspecialchars_decode($rep_message, ENT_QUOTES);
                        if (DEBUG) {
                            $this->log_out("INFO", __FILE__, __LINE__, "/*------------------ステップ------------------*/");
                            $this->log_out("INFO", __FILE__, __LINE__, $user['email']);
                            $this->log_out("step_mail_logs_story_no", __FILE__, __LINE__,
                                $user['step_mail_logs_story_no']);
                            $this->log_out("cnt", __FILE__, __LINE__, $cnt);
                        }
                        if (!$send_stepmail) {
                            echo "stop split stepmail ";
                            return;
                        }
                        if (DEBUG < 2) {
                            $name = (!empty($user['firstname'])) ? $user['firstname'] : '';
                            $name .= (!empty($user['lastname'])) ? $user['lastname'] : '';
                            $mail->ClearAddresses();
                            $mail->AddAddress($user['email'], $name);
                            $mail->Subject = $rep_subject;
                            $mail->Body = $rep_message;
                            if (!$mail->send()) {
                                echo "Step Mailer Error: " . $mail->ErrorInfo;
                                $ret = 0;
                            } else {
                                echo "Step Message sent!";
                                $ret = 1;
                            }
                        } else {
                            $ret = 1;
                        }
                        $data['send_date'] = $this->get_now_date();
                        if ($ret) {
                            $data['send_flg'] = 1;
                            $is_log = $logsObj->is_step_mail_logs_user($user['step_mail_id'], $user['user_id']);
                            if ($is_log) {
                                $logsObj->db_del_step_mail_logs_user($user['step_mail_id'], $user['user_id']);
                            }
                        } else {
                            $data['send_flg'] = 0;
                        }
                        $logsObj->db_update_step_mail_log($data, $user['id']);
                        $data['user_id'] = $user['user_id'];
                        $data['mail_id'] = $user['step_mail_id'];
                        $data['message'] = $rep_message;
                        $accanalyzesObj->ac_mail($data, 'step');
                        $cnt++;
                        if ($cnt >= $cnt_send_list) {
                            break;
                        }
                    } else {
                        $this->del_step_log_user_id($user['user_id']);
                    }
                }
            }
            if (DEBUG < 3) {
                sleep($setting['send_interval']);
            }
        }
        $this->db_del_stepmail_contents(1);
    }

    function send_split_step_mail($setting)
    {
        require_once('accanalyzes.php');
        require_once('settings.php');
        $accanalyzesObj = new accanalyzes();
        $settingsObj = new settings();
        $logsObj = new logs();
        $usersObj = new users();
        $send_stepmail = $settingsObj->get_send_stepmail();
        mb_language("uni");
        mb_internal_encoding("UTF-8");
        $this->get_admin_user($admin_user);
        $sender_name = $admin_user['firstname'];
        $sender_email = $admin_user['email'];
        $header = "From:" . mb_encode_mimeheader($sender_name) . "<" . $sender_email . ">\n";
        $cnt_send_list = $this->get_step_mail_list_count();
        $cnt = 0;
        $start = microtime(true);
        for ($i = 0; $i < $cnt_send_list; $i += $setting['send_num']) {
            $this->get_step_mail_list_split(0, $setting['send_num'], $users);
            if (is_array($users)) {
                foreach ($users as $user) {
                    if ($this->is_user_id($user['user_id'])) {
                        $time = microtime(true) - $start;
                        if ($time > 480) {
                            return;
                        }
                        $user['group_name'] = $usersObj->db_get_group_name($user['group_id']);
                        $user['stepmail_url'] = $this->get_backnumber_url($user['user_id']);
                        $user['extramail_url'] = $this->get_backnumber_url($user['user_id'], true);
                        $rep_subject = $this->txtReplace($user['title'], $user);
                        $rep_message = $this->txtReplace($user['contents'], $user);
                        $rep_subject = htmlspecialchars_decode($rep_subject, ENT_QUOTES);
                        $rep_message = htmlspecialchars_decode($rep_message, ENT_QUOTES);
                        if (DEBUG) {
                            $this->log_out("INFO", __FILE__, __LINE__, "/*------------------ステップ------------------*/");
                            $this->log_out("INFO", __FILE__, __LINE__, $user['email']);
                            $this->log_out("step_mail_logs_story_no", __FILE__, __LINE__,
                                $user['step_mail_logs_story_no']);
                            $this->log_out("cnt", __FILE__, __LINE__, $cnt);
                        }
                        if (!$send_stepmail) {
                            echo "stop split stepmail ";
                            return;
                        }
                        if (DEBUG < 2) {
                            $name = (!empty($user['firstname'])) ? $user['firstname'] : '';
                            $name .= (!empty($user['lastname'])) ? $user['lastname'] : '';
                            $to = mb_encode_mimeheader($name) . "<" . $user['email'] . ">";
                            $ret = @mb_send_mail($to, $rep_subject, $rep_message, $header);
                        } else {
                            $ret = 1;
                        }
                        $data['send_date'] = $this->get_now_date();
                        if ($ret) {
                            $data['send_flg'] = 1;
                            $is_log = $logsObj->is_step_mail_logs_user($user['step_mail_id'], $user['user_id']);
                            if ($is_log) {
                                $logsObj->db_del_step_mail_logs_user($user['step_mail_id'], $user['user_id']);
                            }
                        } else {
                            $data['send_flg'] = 0;
                        }
                        $logsObj->db_update_step_mail_log($data, $user['id']);
                        $data['user_id'] = $user['user_id'];
                        $data['mail_id'] = $user['step_mail_id'];
                        $data['message'] = $rep_message;
                        $accanalyzesObj->ac_mail($data, 'step');
                        $cnt++;
                        if ($cnt >= $cnt_send_list) {
                            break;
                        }
                    } else {
                        $this->del_step_log_user_id($user['user_id']);
                    }
                }
            }
            if (DEBUG < 3) {
                sleep($setting['send_interval']);
            }
        }
        $this->db_del_stepmail_contents(1);
    }

    private function db_del_stepmail_contents($send_flg = 1)
    {
        try {
            $sql = "UPDATE `step_mail_logs` SET `contents` = '' WHERE `send_flg` = :send_flg;";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':send_flg', $send_flg);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function is_user_id($user_id)
    {
        $result = false;
        try {
            $sql = "SELECT count(*)  cnt
					FROM  `users` 
					WHERE  `id` = :user_id";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $this->stmt->execute();
            $row = $this->stmt->fetchAll();
            $result = $row[0]['cnt'];
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $result;
    }

    function del_step_log_user_id($user_id)
    {
        try {
            $sql = "DELETE
					FROM step_mail_logs 
					WHERE 
					user_id = :user_id";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':user_id', $user_id);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_add_extra_mail($data)
    {
        $data['scenario_id'] = 1;
        $send_time = $data['send_time_year'] . "/" . $data['send_time_month'] . "/" . $data['send_time_day'] . " " . $this->get_send_time_combined($data['send_time_hour'],
                $data['send_time_minute']);
        try {
            $sql = "INSERT INTO `extra_mails`(
				`scenario_id`,
				`title`,
				`header_id`,
				`contents`,
				`footer_id`,
				`group_id` ,
				`send_time`,
				`created`)
				VALUES(:scenario_id, :title, :header_id, :contents, :footer_id, :group_id, :send_time, NOW())";
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->beginTransaction();
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':scenario_id', $data['scenario_id']);
            $this->stmt->bindValue(':title', $data['title']);
            $this->stmt->bindValue(':header_id', $data['header_id']);
            $this->stmt->bindValue(':contents', $data['contents']);
            $this->stmt->bindValue(':footer_id', $data['footer_id']);
            $this->stmt->bindValue(':group_id', $data['group_id']);
            $this->stmt->bindValue(':send_time', $send_time);
            $this->stmt->execute();
            $this->pdo->commit();
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            die($e->getMessage());
        }
    }

    function db_edit_extra_mail($data)
    {
        $send_time = $data['send_time_year'] . "/" . $data['send_time_month'] . "/" . $data['send_time_day'] . " " . $this->get_send_time_combined($data['send_time_hour'],
                $data['send_time_minute']);
        try {
            $sql = "UPDATE `extra_mails`
					SET 
					`title` = :title, `header_id` = :header_id, 
					`contents` = :contents,
					`footer_id` = :footer_id,
					`group_id` = :group_id,
					`send_time` = :send_time,
					`modified` = NOW()
					WHERE `extra_mails`.`id` = :id";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':title', $data['title']);
            $this->stmt->bindValue(':header_id', $data['header_id']);
            $this->stmt->bindValue(':contents', $data['contents']);
            $this->stmt->bindValue(':footer_id', $data['footer_id']);
            $this->stmt->bindValue(':group_id', $data['group_id']);
            $this->stmt->bindValue(':send_time', $send_time);
            $this->stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_delete_extra_mail($data)
    {
        $now = $this->get_now_date();
        try {
            $sql = "DELETE FROM `extra_mails`
					WHERE `extra_mails`.`id` = :id;";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':id', $data['id'], PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_all_extra_mail(&$data, $group = null, $start = 0, $num = 999)
    {
        $result = false;
        $this->db_all_extra_mail($group, $start, $num);
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $result = true;
        }
        return $result;
    }

    private function db_all_extra_mail($group, $start, $num)
    {
        $start = (int)trim($start);
        $num = (int)trim($num);
        try {
            $sql = "SELECT `id`, `title`, `group_id`,
			DATE_FORMAT(`send_time`, '%Y-%m-%d') AS `send_date`,
			DATE_FORMAT(`send_time`, '%H:%i') AS `send_time`,
			DATE_FORMAT(`send_done`, '%Y-%m-%d') AS `send_done_date`,
			DATE_FORMAT(`send_done`, '%H:%i') AS `send_done_time`
			FROM `extra_mails`";
            if (!empty($group) & $group != 'all') {
                $sql .= " WHERE FIND_IN_SET(" . $group . ",`group_id`)";
                if ($group != 1) {
                    $sql .= " OR FIND_IN_SET(1,`group_id`)";
                }
            }
            $sql .= " ORDER BY `send_date` DESC, `send_time` DESC, `id` DESC LIMIT ";
            $sql .= $start . ',' . $num;
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':start', $start, PDO::PARAM_INT);
            $this->stmt->bindValue(':num', $num, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_extra_mail($id, &$data)
    {
        $result = false;
        $this->db_extra_mail($id);
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt == 1) {
            $data = $row[0];
            $result = true;
        }
        return $result;
    }

    private function db_extra_mail($id)
    {
        try {
            $sql = "SELECT * FROM `extra_mails` WHERE `id` = :id";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_extra_fullmail(&$data, $id)
    {
        $result = false;
        try {
            $sql = "SELECT em.`id`, em.`title`, em.`contents`, em.`group_id`,  hd.header, ft.footer
				FROM `extra_mails` em LEFT JOIN headers hd ON em.header_id = hd.id
				LEFT JOIN footers AS ft ON em.footer_id = ft.id
				WHERE em.`id` = :id";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':id', $id);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row[0];
            $result = true;
        }
        return $result;
    }

    function get_last_extra_mail_id()
    {
        $this->db_last_extra_mail_id();
        $row = $this->stmt->fetchAll();
        return $row[0][0];
    }

    private function db_last_extra_mail_id()
    {
        try {
            $sql = "SELECT LAST_INSERT_ID();";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function update_send_done($id, $send_done)
    {
        try {
            $sql = "UPDATE `extra_mails`
					SET 
					`send_done` = :send_done,
					`modified` = NOW()
					WHERE `extra_mails`.`id` = :id";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':send_done', $send_done);
            $this->stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function check_send_done($extra_mails)
    {
        $logsObj = new logs();
        $result = false;
        foreach ($extra_mails as $mail) {
            $pos = strpos($mail['send_done_date'], '0000');
            if ($pos !== false || is_null($mail['send_done_date'])) {
                $done = $logsObj->check_extra_mail_log($mail['id'], 1);
                $sending = $logsObj->check_extra_mail_log($mail['id'], 99);
                if ($done & !$sending) {
                    $send_date = $logsObj->get_extra_mail_logs_send_done($mail['id']);
                    $this->update_send_done($mail['id'], $send_date);
                    $result = true;
                }
            }
        }
        return $result;
    }

    function get_headers_list()
    {
        try {
            $stmt = $this->pdo->prepare('SELECT id, header
				FROM `headers` 
				ORDER BY `created` ASC');
            $stmt->execute();
            $row = $stmt->fetchAll();
            return $row;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return true;
    }

    function get_footers_list()
    {
        try {
            $stmt = $this->pdo->prepare('SELECT id, footer
				FROM `footers` 
				ORDER BY `created` ASC');
            $stmt->execute();
            $row = $stmt->fetchAll();
            return $row;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return true;
    }

    function check_input_mails($form)
    {
        $this->check_title($form["title"]);
        $this->check_contents($form["contents"]);
        return true;
    }

    private function check_title($title)
    {
        if (mb_strlen($title, "UTF-8") < 2) {
            $this->err['title'] = 'タイトルを入力してください。';
        }
        if (mb_strlen($title, "UTF-8") >= 200) {
            $this->err['title'] = 'タイトルは200文字以内で入力してください。';
        }
    }

    private function check_header($header_id)
    {
        $this->db_is_header($header_id);
    }

    private function check_contents($contents)
    {
        if (mb_strlen($contents, "UTF-8") < 2) {
            $this->err['contents'] = '記事を入力してください。';
        }
    }

    private function check_footer($footer_id)
    {
        $this->db_is_footer($footer_id);
    }

    private function check_story_no($story_no)
    {
        $max = 3;
        if (!preg_match("/^[0-9]{1," . $max . "}$/", $story_no)) {
            $this->err['story_no'] = 'ストーリーNoは半角数字' . $max . '桁までで入力してください。';
        }
    }

    private function check_flg($num, $word = null)
    {
        if ($num !== 0 & $num !== 1) {
            $word = (isset($word)) ? $word . 'は' : null;
            $this->err['flg'] = $word . '「0」か「1」で入力してください。';
        }
    }

    private function check_group($group_id)
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
        if ($row != 1) {
            $this->err['group'] = 'グループIDが存在しません。';
        }
    }

    private function check_date($date)
    {
        $max = 3;
        if (!preg_match("/^[0-9]{1," . $max . "}$/", $date)) {
            $this->err['date'] = '配信時期は半角数字' . $max . '桁までで入力してください。';
        }
    }

    private function check_time($time)
    {
        $ret = false;
        $arr_time = explode(":", $time);
        if (count($arr_time) == 3) {
            $ret = $this->checktime($arr_time[0], $arr_time[1], $arr_time[2]);
        }
        if (!$ret) {
            $this->err['time'] = '配信時間のフォーマットが間違えています。ex.10:00:00';
        }
    }

    private function check_datetime($datetime)
    {
        if (!$this->check_datetime_format($datetime)) {
            $this->err['datetime'] = '登録日、変更日のフォーマットが間違えています。ex.2015-01-01 01:00:00';
        }
    }

    function check_group_id($group_id)
    {
        if (mb_strlen($group_id, "UTF-8") < 1) {
            $this->err['group_id'] = 'グループを選択してください。';
        }
    }

    private function check_scenario($scenario_id)
    {
        $this->db_is_scenario($scenario_id);
    }

    private function db_is_scenario($scenario_id)
    {
        try {
            $sql = "SELECT count(*) FROM `scenarios` WHERE `id` = :scenario_id";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':scenario_id', $scenario_id, PDO::PARAM_INT);
            $this->stmt->execute();
            $row = $this->stmt->fetchColumn();
            if ($row != 1) {
                $this->err['scenario'] = "属するシナリオがありません。";
                return;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function db_is_header($header_id)
    {
        try {
            $sql = "SELECT count(*) FROM `headers` WHERE `id` = :header_id";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':header_id', $header_id, PDO::PARAM_INT);
            $this->stmt->execute();
            $row = $this->stmt->fetchColumn();
            if ($row != 1) {
                $this->err['headers'] = "ヘッダーが存在しません。";
                return;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function db_is_footer($footer_id)
    {
        try {
            $sql = "SELECT count(*) FROM `footers` WHERE `id` = :footer_id";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':footer_id', $footer_id, PDO::PARAM_INT);
            $this->stmt->execute();
            $row = $this->stmt->fetchColumn();
            if ($row != 1) {
                $this->err['footers'] = "フッターが存在しません。";
                return;
            }
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function check_str4b($str)
    {
        $match = '';
        $word = '不明な文字';
        $in = preg_match('/[\xF0-\xF7][\x80-\xBF][\x80-\xBF][\x80-\xBF]/', $str, $match);
        if ($in) {
            if (is_array($match)) {
                $word = $match[0];
            }
            $this->err['str4'] = "使用できない文字が含まれています [{$word}]";
            return;
        }
    }

    function get_err()
    {
        return $this->err;
    }

    function get_stepmail_users_list0(&$data)
    {
        $result = false;
        $this->db_stepmail_users_list0();
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $result = true;
        }
        return $result;
    }

    function get_stepmail_users_list1(&$data)
    {
        $result = false;
        $this->db_stepmail_users_list1();
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $result = true;
        }
        return $result;
    }

    function get_stepmail_users_list2(&$data, $story_no)
    {
        $result = false;
        $this->db_stepmail_users_list2($story_no);
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $result = true;
        }
        return $result;
    }

    function get_stepmail_users_list3($id, $story_no, &$data)
    {
        $result = false;
        $this->db_stepmail_users_list3($id, $story_no);
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $result = true;
        }
        return $result;
    }

    private function db_stepmail_users_list0()
    {
        try {
            $sql = "SELECT
			u.id,
			u.email,
			u.password,
			u.firstname,
			u.lastname,
			u.order_no,
			u.group_id,
			u.story_no,
			u.send_date,
			u.created,
			st.id AS step_mail_id,
			st.send_date AS step_mail_send_date,
			st.send_flg AS step_mail_send_flg,
			sto.story_no AS stories_story_no
			FROM `stories` as sto 
			INNER JOIN `users` u
			ON u.group_id = sto.group_id
			INNER JOIN step_mails st 
			ON st.id = sto.step_mail_id
			WHERE u.`delete_flg` = 0
			AND u.`auth` != 9
			AND u.story_no = 0
			AND sto.story_no = 1
			";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function db_stepmail_users_list1()
    {
        try {
            $sql = "SELECT
			u.id,
			u.email,
			u.password,
			u.firstname,
			u.lastname,
			u.order_no,
			u.group_id,
			u.story_no,
			u.send_date,
			u.created,
			st.id AS step_mail_id,
			st.send_date AS step_mail_send_date,
			st.send_flg AS step_mail_send_flg,
			sto.story_no AS stories_story_no
			FROM `stories` as sto 
			INNER JOIN `users` u
			ON u.group_id = sto.group_id
			INNER JOIN step_mails st 
			ON st.id = sto.step_mail_id
			WHERE DATEDIFF(NOW(), DATE_FORMAT(u.send_date, '%Y-%m-%d')) >= st.send_date";
            if (DEBUG < 3) {
                $sql .= " AND st.send_time BETWEEN SUBTIME(CURTIME(), '00:05:00') AND ADDTIME(CURTIME(), '00:05:00')";
            }
            $sql .= " AND u.`delete_flg` = 0
			AND u.`auth` != 9
			AND (sto.story_no > 1 AND sto.story_no = u.story_no+1)";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function db_stepmail_users_list2($story_no = null)
    {
        try {
            $sql = "SELECT
			u.id,
			u.email,
			u.password,
			u.firstname,
			u.lastname,
			u.order_no,
			u.group_id,
			u.story_no,
			u.send_date,
			u.created,
			st.id AS step_mail_id,
			st.send_date AS step_mail_send_date,
			st.send_flg AS step_mail_send_flg,
			sto.story_no AS stories_story_no
			FROM `stories` as sto 
			INNER JOIN `users` u
			ON u.group_id = sto.group_id
			INNER JOIN step_mails st 
			ON st.id = sto.step_mail_id
			WHERE";
            if (!is_null($story_no)) {
                $sql .= " DATEDIFF(NOW(),DATE_FORMAT(u.send_date, '%Y-%m-%d')) >= st.send_date";
                $sql .= " AND (DATE_FORMAT(u.send_date, '%Y-%m-%d') IS NOT NULL OR DATE_FORMAT(u.send_date, '%Y-%m-%d')!='')";
            } else {
                $sql .= " DATEDIFF(NOW(),u.created) >= st.send_date";
                $sql .= " AND (DATE_FORMAT(u.send_date, '%Y-%m-%d') IS NULL OR DATE_FORMAT(u.send_date, '%Y-%m-%d')='')";
            }
            if (DEBUG < 3) {
                $sql .= " AND st.send_time BETWEEN SUBTIME(CURTIME(),'00:05:00') AND ADDTIME(CURTIME(),'00:05:00')";
            }
            $sql .= " AND u.`delete_flg` = 0
			AND u.`auth` != 9
			AND sto.story_no = u.story_no+1";
            if (DEBUG) {
                $this->log_out("INFO", __FILE__, __LINE__, "/*------------------通常送信SQL------------------*/");
                $this->log_out("sql", __FILE__, __LINE__, $sql);
            }
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function db_stepmail_users_list3($id, $step_mail_id)
    {
        try {
            $sql = "SELECT
			u.id,
			u.email,
			u.password,
			u.firstname,
			u.lastname,
			u.order_no,
			u.group_id,
			u.story_no,
			u.send_date,
			u.created,
			st.id AS step_mail_id,
			st.send_date AS step_mail_send_date,
			st.send_flg AS step_mail_send_flg,
			sto.story_no AS stories_story_no
			FROM `stories` as sto 
			INNER JOIN `users` u
			ON u.group_id = sto.group_id
			INNER JOIN step_mails st 
			ON st.id = sto.step_mail_id
			WHERE u.id = :id
			AND DATEDIFF(NOW(),u.send_date) >= st.send_date";
            if (DEBUG < 3) {
                $sql .= " AND st.send_time BETWEEN SUBTIME(CURTIME(), '00:05:00') AND ADDTIME(CURTIME(), '00:05:00')";
            }
            $sql .= " AND u.`delete_flg` = 0
			AND u.`auth` != 9
			AND st.id = :step_mail_id
			";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $this->stmt->bindValue(':step_mail_id', (int)$step_mail_id, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    private function db_stepmail_users_list_count()
    {
        try {
            $sql = "SELECT COUNT(*)
			FROM `users` u
			INNER JOIN scenarios sc
			ON u.scenario_id = sc.id 
			LEFT JOIN step_mails st
			ON sc.id = st.scenario_id
			LEFT JOIN step_mail_logs sl
			ON u.id = sl.user_id
			AND st.id = sl.step_mail_id
			WHERE DATEDIFF(NOW(),u.send_date) = st.send_date
			AND st.send_time BETWEEN SUBTIME(CURTIME(), '00:05:00') AND ADDTIME(CURTIME(), '00:05:00')
			AND u.`delete_flg` = 0
			GROUP BY u.`id`";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_stepmail_resend_users_list(&$data)
    {
        $result = false;
        $this->db_stepmail_resend_users_ist();
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $result = true;
        }
        return $result;
    }

    private function db_stepmail_resend_users_ist()
    {
        try {
            $sql = "SELECT
			u.id,
			u.email,
			u.password,
			u.firstname,
			u.lastname,
			u.order_no,
			u.group_id,
			u.story_no,
			u.send_date,
			u.created,
			st.id AS step_mail_id,
			st.send_date AS step_mail_send_date,
			st.send_flg AS step_mail_send_flg,
			sto.story_no AS stories_story_no,
			sl.send_flg
			FROM `stories` as sto 
			INNER JOIN `users` u ON u.group_id = sto.group_id
			INNER JOIN step_mails st ON st.id = sto.step_mail_id
			INNER JOIN `step_mail_logs` AS sl ON u.`id` = sl.`user_id` AND st.id = sl.step_mail_id
			WHERE sl.`send_flg` = 0
			AND u.`delete_flg` = 0";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_step_mail_list_split($start, $num, &$data)
    {
        $result = false;
        $this->db_get_step_mail_list_split($start, $num);
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $result = true;
        }
        return $result;
    }

    private function db_get_step_mail_list_split($start, $end)
    {
        try {
            $sql = 'SELECT
			sl.id,
			sl.title,
			sl.contents,
			sl.story_no AS step_mail_logs_story_no,
			sl.step_mail_id,
			u.id AS user_id,
			u.email,
			u.password,
			u.firstname,
			u.lastname,
			u.group_id,
			u.order_no,
			u.story_no AS users_story_no,
			u.send_date,
			u.ip,
			u.host,
			u.created
			FROM `step_mail_logs` AS sl
			INNER JOIN `users` u
			ON sl.`user_id` = u.`id`
			WHERE `send_flg` =99
			LIMIT ' . $start . ',' . $end;
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_step_mail_list_count()
    {
        $this->db_get_step_mail_list_count();
        $row = $this->stmt->fetchAll();
        $cnt = $row[0][0];
        return $cnt;
    }

    private function db_get_step_mail_list_count()
    {
        try {
            $sql = 'SELECT COUNT(*)
			FROM `step_mail_logs` AS sl
			INNER JOIN `users` u
			ON sl.`user_id` = u.`id`
			WHERE `send_flg` = 99';
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function count_step_mail()
    {
        $this->db_count_step_mail();
        $cnt = $this->stmt->fetchAll();
        return $cnt[0][0];
    }

    private function db_count_step_mail()
    {
        try {
            $this->stmt = $this->pdo->prepare('SELECT COUNT(*) FROM `step_mails`');
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_update_users_story_no($data, $id)
    {
        try {
            $sql = 'UPDATE `users`
					SET `story_no` = :story_no, `modified`=now()
		    		WHERE `id` = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':story_no', (int)$data['story_no'], PDO::PARAM_INT);
            $stmt->bindValue(':id', (int)$id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function db_update_users_max_story_no($story_no)
    {
        try {
            $sql = 'UPDATE `users`
					SET `story_no` = :story_no, `modified`=now()
					WHERE `story_no` > :story_no';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':story_no', (int)$story_no, PDO::PARAM_INT);
            $stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function update_users_max_story_no()
    {
        if (!$this->get_group_arr($gr_arr)) {
            return;
        }
        if (!$this->get_stories_max_arr($max_arr)) {
            return;
        }
        foreach ((array)$gr_arr as $gr) {
            foreach ((array)$max_arr as $max) {
                if ($max['group_id'] == $gr['id']) {
                    $user_arr = $this->get_users_max_no($max);
                    if (is_array($user_arr)) {
                        foreach ($user_arr as $user) {
                            $data['story_no'] = $max['max_story_no'];
                            $id = $user['id'];
                            $this->db_update_users_story_no($data, $id);
                        }
                    }
                }
            }
        }
    }

    private function get_group_arr(&$gr_arr)
    {
        $result = false;
        try {
            $sql = "SELECT id FROM `groups`";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $gr_arr = $row;
            $result = true;
        }
        return $result;
    }

    private function get_stories_max_arr(&$max_arr)
    {
        $result = false;
        try {
            $sql = "SELECT `group_id`, MAX(`story_no`) AS max_story_no FROM `stories` GROUP by `group_id`";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $max_arr = $row;
            $result = true;
        }
        return $result;
    }

    private function get_users_max_no($max)
    {
        $result = false;
        try {
            $sql = "SELECT `id`,`story_no` FROM `users` WHERE FIND_IN_SET(:group_id,`group_id`) AND (`story_no` > :max_story_no) ORDER BY `id` ASC";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':group_id', $max['group_id'], PDO::PARAM_STR);
            $this->stmt->bindValue(':max_story_no', $max['max_story_no'], PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $result = $row;
        }
        return $result;
    }

    function get_extra_mail_users_list(&$data)
    {
        $result = false;
        $this->db_extra_mail_users_list();
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $result = true;
        }
        return $result;
    }

    private function db_extra_mail_users_list()
    {
        try {
            $sql = "SELECT
			u.id,
			u.email,
			u.password,
			u.firstname,
			u.lastname,
			u.order_no,
			u.send_date,
			u.created,
			u.scenario_id, 
			u.group_id AS user_group_id,
			u.`delete_flg`,
			ex.id AS extra_mail_id,
			ex.group_id AS extra_group_id
			FROM `users` u
			INNER JOIN scenarios sc ON u.scenario_id = sc.id
			LEFT JOIN `extra_mails` ex ON sc.id = ex.scenario_id 
			LEFT JOIN extra_mail_logs el ON u.id = el.user_id
			AND ex.id = el.extra_mail_id
			WHERE ex.send_time
			BETWEEN SUBTIME(NOW(), '00:05:00')
			AND ADDTIME(NOW(), '00:05:00')
			AND u.`delete_flg`=0
			AND u.`auth` !=9
			AND ISNULL(el.`send_flg`)";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_extra_mail_users_list3(&$data)
    {
        $result = false;
        $this->get_extra_mail_users_list($users);
        if (!is_array($users)) {
            return $result;
        }
        $i = 0;
        foreach ($users as $user) {
            $flg = false;
            $group_id_arr = explode(",", $user['extra_group_id']);
            if (in_array('1', $group_id_arr) || in_array($user['user_group_id'], $group_id_arr)) {
                $i++;
                $flg = true;
            }
            if ($flg) {
                $data[$i]['id'] = $user['id'];
                $data[$i]['email'] = $user['email'];
                $data[$i]['password'] = $user['password'];
                $data[$i]['firstname'] = $user['firstname'];
                $data[$i]['lastname'] = $user['lastname'];
                $data[$i]['user_group_id'] = $user['user_group_id'];
                $data[$i]['order_no'] = $user['order_no'];
                $data[$i]['send_date'] = $user['send_date'];
                $data[$i]['created'] = $user['created'];
                $data[$i]['scenario_id'] = $user['scenario_id'];
                $data[$i]['delete_flg'] = $user['delete_flg'];
                $data[$i]['extra_mail_id'] = $user['extra_mail_id'];
                $result = $data;
            }
        }
        return $result;
    }

    function get_extra_mail_resend_users_list(&$data)
    {
        $result = false;
        $this->db_extra_mail_resend_users_list();
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $result = true;
        }
        return $result;
    }

    private function db_extra_mail_resend_users_list()
    {
        try {
            $sql = "SELECT
			u.`id`, 
			u.`email`,
			u.`firstname`,
			u.`lastname`,
			u.scenario_id,
			u.group_id AS user_group_id,
			el.`send_flg`,
			el.`extra_mail_id`
			FROM `users` u
			INNER JOIN `extra_mail_logs` AS el ON u.`id` = el.`user_id`
			WHERE el.`send_flg` = 0
			AND u.`delete_flg` = 0
			GROUP BY
              u.`id`
              , u.`email`
              , u.`firstname`
              , u.`lastname`
              , u.scenario_id
              , u.group_id
              , el.`send_flg`
              , el.`extra_mail_id`";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_all_mail_users_list(&$data)
    {
        $result = false;
        $this->db_get_all_mail_users_list();
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $result = true;
        }
        return $result;
    }

    private function db_get_all_mail_users_list()
    {
        try {
            $sql = "SELECT *  FROM `users` WHERE `scenario_id` = 1 AND `auth` !=9 AND `delete_flg` = 0";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_extra_mail_list_split($start, $num, &$data)
    {
        $result = false;
        $this->db_get_extra_mail_list_split($start, $num);
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $result = true;
        }
        return $result;
    }

    private function db_get_extra_mail_list_split($start, $end)
    {
        try {
            $sql = 'SELECT
			el.id,
			el.title,
			el.contents,
			el.extra_mail_id,
			el.user_id,
			u.email,
			u.password,
			u.firstname,
			u.lastname,
			u.order_no,
			u.group_id,
			u.send_date,
			u.ip,
			u.host,
			u.created
			FROM `extra_mail_logs` AS el
			INNER JOIN `users` u ON el.`user_id` = u.`id`
			WHERE `send_flg` = 99
			LIMIT ' . $start . ',' . $end;
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_extra_mail_list_count()
    {
        $this->db_get_extra_mail_list_count();
        $row = $this->stmt->fetchAll();
        $cnt = $row[0][0];
        return $cnt;
    }

    private function db_get_extra_mail_list_count()
    {
        try {
            $sql = 'SELECT COUNT(*) FROM `extra_mail_logs` WHERE `send_flg` = 99';
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_send_date_split($send_date)
    {
        $split = explode("-", $send_date);
        $send_date_split['year'] = $split[0];
        $send_date_split['month'] = $split[1];
        $send_date_split['day'] = $split[2];
        return $send_date_split;
    }

    function get_send_time_split($send_time)
    {
        $split = explode(":", $send_time);
        $send_time_split['hour'] = $split[0];
        $send_time_split['minute'] = $split[1];
        return $send_time_split;
    }

    function get_send_time_combined($hour, $minute)
    {
        $send_time = $hour . ":" . $minute . ":00";
        return $send_time;
    }

    function send_preview_mail($data, $user, $setting)
    {
        $headersObj = new headers();
        $footersObj = new footers();
        $usersObj = new users();
        mb_language("uni");
        mb_internal_encoding("UTF-8");
        $to = $user['email'];
        $this->get_admin_user($admin_user);
        $sender_name = $admin_user['firstname'];
        $sender_email = $user['email'];
        $header = "From:" . mb_encode_mimeheader($sender_name) . "<" . $sender_email . ">\n";
        $headersObj->get_header($data['header_id'], $mess_header);
        $footersObj->get_footer($data['footer_id'], $mess_footer);
        $subject = $data['title'];
        $message = '';
        if (!empty($mess_header['header'])) {
            $message .= $mess_header['header'] . "\n";
        }
        $message .= $data['contents'] . "\n";
        if (!empty($mess_footer['footer'])) {
            $message .= $mess_footer['footer'] . "\n";
        }
        $user['group_name'] = $usersObj->db_get_group_name($user['group_id']);
        $rep_subject = $this->txtReplace($subject, $user);
        $rep_message = $this->txtReplace($message, $user);
        $rep_subject = htmlspecialchars_decode($rep_subject, ENT_QUOTES);
        $rep_message = htmlspecialchars_decode($rep_message, ENT_QUOTES);
        @mb_send_mail($to, $rep_subject, $rep_message, $header);
    }

    function send_extra_mail($data, $user, $setting)
    {
        $headersObj = new headers();
        $footersObj = new footers();
        $usersObj = new users();
        $logsObj = new logs();
        $group_id = date('YmdHis');
        $headersObj->get_header($data['header_id'], $header);
        $footersObj->get_footer($data['footer_id'], $footer);
        $message = '';
        if (!empty($header['header'])) {
            $message .= $header['header'] . "\n";
        }
        $message .= $data['contents'] . "\n";
        if (!empty($footer['footer'])) {
            $message .= $footer['footer'] . "\n";
        }
        $data['contents'] = $message;
        $data['send_flg'] = 99;
        $data['group_id'] = $group_id;
        $data['send_date'] = null;
        $this->get_extra_mail_users_list3($users_list);
        if (empty($users_list)) {
            return false;
        }
        foreach ($users_list as $send_user) {
            $logsObj->db_add_extra_mail_log($data, $send_user['id']);
        }
        return true;
    }

    function send_split_extra_mail_smtp($setting)
    {
        require_once('accanalyzes.php');
        require_once('settings.php');
        $accanalyzesObj = new accanalyzes();
        $settingsObj = new settings();
        $logsObj = new logs();
        $usersObj = new users();
        require dirname(__FILE__) . '/../common/mailer/PHPMailerAutoload.php';
        require_once(dirname(__FILE__) . '/../common/mailers.php');
        $mailersObj = new mailers();
        $smtp_data = $mailersObj->get_mailer();
        date_default_timezone_set('Asia/Tokyo');
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = $mailersObj->get_smtpdebug();
        $mail->Debugoutput = $mailersObj->get_debugoutput();
        $mail->CharSet = $mailersObj->get_mail_charset();
        $mail->Encoding = $mailersObj->get_mail_encoding();
        $mail->SMTPAuth = $mailersObj->get_smtpauth();
        $mail->SMTPKeepAlive = $mailersObj->get_smtpkeepalive();
        $mail->Timeout = $mailersObj->get_timeout();
        $verify_peer = $mailersObj->get_verify_peer();
        $verify_peer_name = $mailersObj->get_verify_peer_name();
        $allow_self_signed = $mailersObj->get_allow_self_signed();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => $verify_peer,
                'verify_peer_name' => $verify_peer_name,
                'allow_self_signed' => $allow_self_signed
            )
        );
        $mail->Host = $smtp_data['host'];
        $mail->Port = $smtp_data['port'];
        $mail->Username = $smtp_data['username'];
        $mail->Password = $smtp_data['password'];
        switch ($smtp_data['secure']) {
            case '1':
                echo 'SSL';
                $mail->SMTPSecure = 'ssl';
                break;
            case '2':
                echo 'TLS';
                $mail->SMTPSecure = 'tls';
                break;
            default:
                break;
        }
        $this->get_admin_user($admin_user);
        $mail->setFrom($admin_user['email'], $admin_user['firstname']);
        $send_extramail = $settingsObj->get_send_extramail();
        $cnt_send_list = $this->get_extra_mail_list_count();
        $start = microtime(true);
        for ($i = 0; $i < $cnt_send_list; $i = $i + $setting['send_num']) {
            $this->get_extra_mail_list_split(0, $setting['send_num'], $users);
            if (is_array($users)) {
                foreach ($users as $user) {
                    if ($this->is_user_id($user['user_id'])) {
                        $time = microtime(true) - $start;
                        if ($time > 480) {
                            return;
                        }
                        $user['group_name'] = $usersObj->db_get_group_name($user['group_id']);
                        $user['stepmail_url'] = $this->get_backnumber_url($user['user_id']);
                        $user['extramail_url'] = $this->get_backnumber_url($user['user_id'], true);
                        $rep_subject = $this->txtReplace($user['title'], $user);
                        $rep_message = $this->txtReplace($user['contents'], $user);
                        $rep_subject = htmlspecialchars_decode($rep_subject, ENT_QUOTES);
                        $rep_message = htmlspecialchars_decode($rep_message, ENT_QUOTES);
                        if (DEBUG) {
                            $this->log_out("INFO", __FILE__, __LINE__, "/*------------------号外------------------*/");
                            $this->log_out("INFO", __FILE__, __LINE__, $user['email']);
                        }
                        if (!$send_extramail) {
                            echo "stop split extramail";
                            return;
                        }
                        if (DEBUG < 2) {
                            $name = (!empty($user['firstname'])) ? $user['firstname'] : '';
                            $name .= (!empty($user['lastname'])) ? $user['lastname'] : '';
                            $mail->ClearAddresses();
                            $mail->AddAddress($user['email'], $name);
                            $mail->Subject = $rep_subject;
                            $mail->Body = $rep_message;
                            if (!$mail->send()) {
                                echo "Extra Mailer Error: " . $mail->ErrorInfo;
                                $ret = 0;
                            } else {
                                echo "Extra Message sent!";
                                $ret = 1;
                            }
                        } else {
                            $ret = 1;
                        }
                        $data['send_date'] = $this->get_now_date();
                        if ($ret) {
                            $data['send_flg'] = 1;
                            $is_log = $logsObj->is_extra_mail_logs_user($user['extra_mail_id'], $user['user_id']);
                            if ($is_log) {
                                $logsObj->db_del_extra_mail_logs_user($user['extra_mail_id'], $user['user_id']);
                            }
                        } else {
                            $data['send_flg'] = 0;
                        }
                        $logsObj->db_update_extra_mail_log($data, $user['id']);
                        $this->update_send_done($user['extra_mail_id'], $data['send_date']);
                        $data['user_id'] = $user['user_id'];
                        $data['mail_id'] = $user['extra_mail_id'];
                        $data['message'] = $rep_message;
                        $accanalyzesObj->ac_mail($data, 'extra');
                    } else {
                        $logsObj->del_extra_log_user_id($user['user_id']);
                    }
                }
                if (DEBUG < 3) {
                    sleep($setting['send_interval']);
                }
            }
            $this->db_del_extramail_contents(1);
        }
    }

    function send_split_extra_mail($setting)
    {
        require_once('accanalyzes.php');
        require_once('settings.php');
        $accanalyzesObj = new accanalyzes();
        $settingsObj = new settings();
        $logsObj = new logs();
        $usersObj = new users();
        $send_extramail = $settingsObj->get_send_extramail();
        mb_language("uni");
        mb_internal_encoding("UTF-8");
        $this->get_admin_user($admin_user);
        $sender_name = $admin_user['firstname'];
        $sender_email = $admin_user['email'];
        $header = "From:" . mb_encode_mimeheader($sender_name) . "<" . $sender_email . ">\n";
        $cnt_send_list = $this->get_extra_mail_list_count();
        $start = microtime(true);
        for ($i = 0; $i < $cnt_send_list; $i = $i + $setting['send_num']) {
            $this->get_extra_mail_list_split(0, $setting['send_num'], $users);
            if (is_array($users)) {
                foreach ($users as $user) {
                    if ($this->is_user_id($user['user_id'])) {
                        $time = microtime(true) - $start;
                        if ($time > 480) {
                            return;
                        }
                        $user['group_name'] = $usersObj->db_get_group_name($user['group_id']);
                        $user['stepmail_url'] = $this->get_backnumber_url($user['user_id']);
                        $user['extramail_url'] = $this->get_backnumber_url($user['user_id'], true);
                        $rep_subject = $this->txtReplace($user['title'], $user);
                        $rep_message = $this->txtReplace($user['contents'], $user);
                        if (DEBUG) {
                            $this->log_out("INFO", __FILE__, __LINE__, "/*------------------号外------------------*/");
                            $this->log_out("INFO", __FILE__, __LINE__, $user['email']);
                            $this->log_out("rep_subject", __FILE__, __LINE__, $rep_subject);
                            $this->log_out("rep_message", __FILE__, __LINE__, $rep_message);
                        }
                        $rep_subject = htmlspecialchars_decode($rep_subject, ENT_QUOTES);
                        $rep_message = htmlspecialchars_decode($rep_message, ENT_QUOTES);
                        if (!$send_extramail) {
                            echo "stop split extramail";
                            return;
                        }
                        if (DEBUG < 2) {
                            $name = (!empty($user['firstname'])) ? $user['firstname'] : '';
                            $name .= (!empty($user['lastname'])) ? $user['lastname'] : '';
                            $to = mb_encode_mimeheader($name) . "<" . $user['email'] . ">";
                            $ret = @mb_send_mail($to, $rep_subject, $rep_message, $header);
                        } else {
                            $ret = 1;
                        }
                        $data['send_date'] = $this->get_now_date();
                        if ($ret) {
                            $data['send_flg'] = 1;
                            $is_log = $logsObj->is_extra_mail_logs_user($user['extra_mail_id'], $user['user_id']);
                            if ($is_log) {
                                $logsObj->db_del_extra_mail_logs_user($user['extra_mail_id'], $user['user_id']);
                            }
                        } else {
                            $data['send_flg'] = 0;
                        }
                        $logsObj->db_update_extra_mail_log($data, $user['id']);
                        $this->update_send_done($user['extra_mail_id'], $data['send_date']);
                        $data['user_id'] = $user['user_id'];
                        $data['mail_id'] = $user['extra_mail_id'];
                        $data['message'] = $rep_message;
                        $accanalyzesObj->ac_mail($data, 'extra');
                    } else {
                        $logsObj->del_extra_log_user_id($user['user_id']);
                    }
                }
                if (DEBUG < 2) {
                    sleep($setting['send_interval']);
                }
            }
            $this->db_del_extramail_contents(1);
        }
    }

    private function db_del_extramail_contents($send_flg = 1)
    {
        try {
            $sql = "UPDATE `extra_mail_logs` SET `contents` = '' WHERE `send_flg` = :send_flg;";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':send_flg', $send_flg);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function send_auto_mail_smtp($data, $user, $settings)
    {
        $to = '';
        $bcc = '';
        $bodysObj = new bodys();
        $usersObj = new users();
        require dirname(__FILE__) . '/../common/mailer/PHPMailerAutoload.php';
        require_once(dirname(__FILE__) . '/../common/mailers.php');
        $mailersObj = new mailers();
        $smtp_data = $mailersObj->get_mailer();
        date_default_timezone_set('Asia/Tokyo');
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->SMTPDebug = $mailersObj->get_smtpdebug();
        $mail->Debugoutput = $mailersObj->get_debugoutput();
        $mail->CharSet = $mailersObj->get_mail_charset();
        $mail->Encoding = $mailersObj->get_mail_encoding();
        $mail->SMTPAuth = $mailersObj->get_smtpauth();
        $mail->SMTPKeepAlive = $mailersObj->get_smtpkeepalive();
        $mail->Timeout = $mailersObj->get_timeout();
        $verify_peer = $mailersObj->get_verify_peer();
        $verify_peer_name = $mailersObj->get_verify_peer_name();
        $allow_self_signed = $mailersObj->get_allow_self_signed();
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => $verify_peer,
                'verify_peer_name' => $verify_peer_name,
                'allow_self_signed' => $allow_self_signed
            )
        );
        $mail->Host = $smtp_data['host'];
        $mail->Port = $smtp_data['port'];
        $mail->Username = $smtp_data['username'];
        $mail->Password = $smtp_data['password'];
        switch ($smtp_data['secure']) {
            case '1':
                $mail->SMTPSecure = 'ssl';
                break;
            case '2':
                $mail->SMTPSecure = 'tls';
                break;
            default:
                break;
        }
        $this->get_admin_user($admin_user);
        if (!isset($data['send_settings'])) {
            $data['send_settings'] = 99;
        }
        switch ($data['send_settings']) {
            case(0):
                $name = (!empty($user['firstname'])) ? $user['firstname'] : '';
                $name .= (!empty($user['lastname'])) ? $user['lastname'] : '';
                $to = $user['email'];
                $bcc = $admin_user['email'];
                break;
            case(1):
                $name = (!empty($admin_user['firstname'])) ? $admin_user['firstname'] : '';
                $name .= (!empty($admin_user['lastname'])) ? $admin_user['lastname'] : '';
                $to = $admin_user['email'];
                break;
            case(2):
                $name = (!empty($user['firstname'])) ? $user['firstname'] : '';
                $name .= (!empty($user['lastname'])) ? $user['lastname'] : '';
                $to = $user['email'];
                break;
            default:
                return;
                break;
        }
        $mail->ClearAddresses();
        $mail->AddAddress($to, $name);
        if (!empty($bcc)) {
            $mail->addBCC($bcc);
        }
        $mail->setFrom($admin_user['email'], $admin_user['firstname']);
        if ($data['status'] != 'STOP') {
            $type = 0;
        } else {
            $type = 1;
        }
        $bodysObj->get_all_body($type, 0, 1, $body);
        $subject = $body[0]['title'];
        $message = $body[0]['body'];
        $user['group_name'] = $usersObj->db_get_group_name($user['group_id']);
        $user['stepmail_url'] = $this->get_backnumber_url($user['user_id']);
        $user['extramail_url'] = $this->get_backnumber_url($user['user_id'], true);
        $rep_subject = $this->txtReplace($subject, $user);
        $rep_message = $this->txtReplace($message, $user);
        $rep_subject = htmlspecialchars_decode($rep_subject, ENT_QUOTES);
        $rep_message = htmlspecialchars_decode($rep_message, ENT_QUOTES);
        $mail->Subject = $rep_subject;
        $mail->Body = $rep_message;
        if (!$mail->send()) {
            echo "auto Mailer Error: " . $mail->ErrorInfo;
        }
    }

    function send_auto_mail($data, $user, $settings)
    {
        $to = '';
        $bcc = '';
        $bodysObj = new bodys();
        $usersObj = new users();
        mb_language("uni");
        mb_internal_encoding("UTF-8");
        $this->get_admin_user($admin_user);
        if (!isset($data['send_settings'])) {
            $data['send_settings'] = 99;
        }
        switch ($data['send_settings']) {
            case(0):
                $name = (!empty($user['firstname'])) ? $user['firstname'] : '';
                $name .= (!empty($user['lastname'])) ? $user['lastname'] : '';
                $to = mb_encode_mimeheader($name) . "<" . $user['email'] . ">";
                $bcc = $admin_user['email'];
                break;
            case(1):
                $to = $admin_user['email'];
                break;
            case(2):
                $name = (!empty($user['firstname'])) ? $user['firstname'] : '';
                $name .= (!empty($user['lastname'])) ? $user['lastname'] : '';
                $to = mb_encode_mimeheader($name) . "<" . $user['email'] . ">";
                break;
            default:
                return;
                break;
        }
        $sender_name = $admin_user['firstname'];
        $sender_email = $admin_user['email'];
        $header = "From:" . mb_encode_mimeheader($sender_name) . "<" . $sender_email . ">\n";
        if (!empty($bcc)) {
            $header .= "Bcc:" . "<" . $bcc . ">\n";
        }
        if ($data['status'] != 'STOP') {
            $type = 0;
        } else {
            $type = 1;
        }
        $bodysObj->get_all_body($type, 0, 1, $body);
        $subject = $body[0]['title'];
        $message = $body[0]['body'];
        $user['group_name'] = $usersObj->db_get_group_name($user['group_id']);
        $rep_subject = $this->txtReplace($subject, $user);
        $rep_message = $this->txtReplace($message, $user);
        $rep_subject = htmlspecialchars_decode($rep_subject, ENT_QUOTES);
        $rep_message = htmlspecialchars_decode($rep_message, ENT_QUOTES);
        @mb_send_mail($to, $rep_subject, $rep_message, $header);
    }

    function get_admin_user(&$data)
    {
        $result = false;
        try {
            $sql = "SELECT
			`id`,
			`firstname`,`lastname`,
			`email`
			FROM `users` 
			WHERE `auth` = 9";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row[0];
            $result = true;
        }
        return $result;
    }

    function get_step_mail(&$data, $id = 0)
    {
        $result = false;
        try {
            $sql = "SELECT sm.`id`, sm.`title`, sm.`contents`, hd.header, ft.footer, sm.send_date
				FROM `step_mails` sm LEFT JOIN headers hd ON sm.header_id = hd.id
				LEFT JOIN footers AS ft ON sm.footer_id = ft.id
				WHERE sm.`send_flg` = 1";
            if (!empty($id)) {
                $sql .= " AND sm.`id` = :id";
            }
            $this->stmt = $this->pdo->prepare($sql);
            if (!empty($id)) {
                $this->stmt->bindValue(':id', $id);
            }
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $result = true;
        }
        return $result;
    }


    /**
     * ステップメールを送信した実績日時を取得する関数
     *
     * @param int $step_mail_id ステップメールのID
     * @param int $user_id      ユーザーID
     *
     * @return メール送信実績日（データが取得できなかった場合は「null」を返す）
     */
    function get_step_mail_send_date($step_mail_id = "0", $user_id = "0")
    {
        $result = null;
        try {
            $sql = "SELECT `send_date` FROM `step_mail_logs`"
                . " WHERE `step_mail_id` = :step_mail_id AND `user_id` = :user_id";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':step_mail_id', $step_mail_id);
            $this->stmt->bindValue(':user_id', $user_id);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt == 1) {
            $result = $row[0]['send_date'];
        }
        return $result;
    }

    function get_step_fullmail(&$data, $id = 0)
    {
        $result = false;
        try {
            $sql = "SELECT sm.`id`, sm.`title`, sm.`contents`, hd.header, ft.footer
				FROM `step_mails` sm LEFT JOIN headers hd ON sm.header_id = hd.id
				LEFT JOIN footers AS ft ON sm.footer_id = ft.id
				WHERE sm.`id` = :id";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':id', $id);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $result = true;
        }
        return $result;
    }

    function get_extra_mail_contents(&$data, $id = 0)
    {
        $result = false;
        try {
            $sql = "SELECT em.`id`, em.`title`, em.`contents`, hd.header, ft.footer, em.send_done
				FROM `extra_mails` em LEFT JOIN headers hd ON em.header_id = hd.id
				LEFT JOIN footers AS ft ON em.footer_id = ft.id
				WHERE em.`send_done` IS NOT NULL
				";
            if (!empty($id)) {
                $sql .= " AND em.`id` = :id";
            }
            $this->stmt = $this->pdo->prepare($sql);
            if (!empty($id)) {
                $this->stmt->bindValue(':id', $id);
            }
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt >= 1) {
            $data = $row;
            $result = true;
        }
        return $result;
    }

    function get_backnumber_step_mails($user_id = null, &$logs)
    {
        $result = false;
        if (!isset($user_id)) {
            return $result;
        }
        $this->db_backnumber_mails($user_id);
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt != 0) {
            $logs = $row;
            $result = true;
        }
        return $result;
    }

    private function db_backnumber_mails($user_id)
    {
        try {
            $sql = "SELECT step.*, head.header, foot.footer FROM users, step_mails AS step
					LEFT JOIN headers AS head ON head.id = step.header_id
					LEFT JOIN footers AS foot ON foot.id = step.footer_id
					WHERE DATE_ADD(users.send_date, INTERVAL step.send_date DAY) < NOW()
					AND (step.group_id = users.group_id OR step.group_id = 1)
					AND users.id = :user_id
					ORDER BY step.story_no";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_backnumber_extra_mails(&$logs, $group_id = null, $user_id = null, $start = 0, $num = 999)
    {
        $result = false;
        if (!isset($group_id) || !isset($user_id)) {
            return $result;
        }
        $this->db_get_backnumber_extra_mails($group_id, $user_id, $start, $num);
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt != 0) {
            $logs = $row;
            $result = true;
        }
        return $result;
    }

    private function db_get_backnumber_extra_mails($group, $user_id, $start, $num)
    {
        try {
            $sql = "SELECT mail.id, mail.title, mail.group_id, mail.contents, head.header, foot.footer,
			DATE_FORMAT(mail.send_time, '%Y-%m-%d') AS send_date,
			DATE_FORMAT(mail.send_time, '%H:%i') AS send_time,
			DATE_FORMAT(mail.send_done, '%Y-%m-%d') AS send_done_date,
			DATE_FORMAT(mail.send_done, '%H:%i') AS send_done_time
			FROM extra_mails AS mail
			LEFT JOIN headers AS head ON head.id = mail.header_id
			LEFT JOIN footers AS foot ON foot.id = mail.footer_id
			RIGHT JOIN extra_mail_logs AS log ON mail.id = log.extra_mail_id
			WHERE log.user_id = :user_id
			AND mail.send_done < NOW()
			AND (";
            if (!empty($group) && $group != 'all') {
                $sql .= " FIND_IN_SET(" . $group . ",mail.group_id)";
                if ($group != 1) {
                    $sql .= " OR FIND_IN_SET(1,mail.group_id)";
                }
            }
            $sql .= ") ORDER BY log.send_date DESC, mail.send_time DESC, mail.id DESC";
            $sql .= " LIMIT :start , :num";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $this->stmt->bindValue(':start', $start, PDO::PARAM_INT);
            $this->stmt->bindValue(':num', $num, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function get_backnumber_url($user_id = null, $is_extra = false)
    {
        $result = false;
        if (!isset($user_id)) {
            return $result;
        }
        $this->db_get_backnumber_url((int)$user_id);
        $row = $this->stmt->fetchAll();
        $cnt = count($row);
        if ($cnt == 1) {
            $group = $row[0];
            $group_code = !empty($group["group_code"]) ? $group["group_code"] : substr(md5($group["id"]), 0, 8);
            $result = $group_code . sprintf("%06d", $user_id) . substr(md5($group_code . $user_id), 0, 11);
            if ($is_extra) {
                $result .= "11";
            }
            $result = URL . "/bn/?key=" . $result;
        }
        return $result;
    }

    private function db_get_backnumber_url($user_id)
    {
        try {
            $sql = "SELECT * FROM groups WHERE id = (SELECT group_id FROM users WHERE id = :user_id)";
            $this->stmt = $this->pdo->prepare($sql);
            $this->stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $this->stmt->execute();
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    function make_page_link($search, $cur_page, $num_pages, $disp = 8)
    {
        if (empty($search["status"])) {
            $search["status"] = "step";
        }
        if (empty($search["group_id"])) {
            $search["group_id"] = "all";
        }
        if (empty($search["sort"])) {
            $search["sort"] = "";
        }
        if (empty($search["sortby"])) {
            $search["sortby"] = "";
        }
        $search_link = URL . '/admin/mails/?status=' . $search["status"] . '&';
        $search_arr[] = 'group_id=' . $search["group_id"];
        $search_arr[] = 'sort=' . $search["sort"];
        $search_arr[] = 'sortby=' . $search["sortby"];
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
} ?>