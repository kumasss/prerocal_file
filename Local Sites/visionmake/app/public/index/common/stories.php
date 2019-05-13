<?php
 require_once( dirname(__FILE__).'/main.php' ); class Stories extends main { function db_add_story( $data ) { try { $sql = "
			INSERT INTO `stories` (
				`id` ,
				`group_id` ,
				`step_mail_id` ,
				`story_no` ,
				`created`
			)
			VALUES (
				NULL, :group_id, :step_mail_id, NULL, NOW()
			)"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_id', (int)$data['group_id'], PDO::PARAM_INT ); $this->stmt->bindValue( ':step_mail_id', (int)$data['step_mail_id'], PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_edit_group( $data ) { try { $sql = "UPDATE `stories`
					SET `group_name` = :group_name, `modified` = NOW()
					WHERE `stories`.`id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_name', $data['group_name'] ); $this->stmt->bindValue( ':id', $data['id'], PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function get_all_group( &$data, $start=0, $num=999 ) { $result = FALSE; $this->db_all_group( $start, $num ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_all_group( $start, $num ) { try { $sql = "SELECT * FROM `stories` LIMIT :start, :num"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':start', $start, PDO::PARAM_INT ); $this->stmt->bindValue( ':num', $num, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_group( $id, &$data ) { $result = false; $this->db_group( $id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $data = $row[0]; $result = true; } return $result; } private function db_group( $id ) { try { $sql = "SELECT * FROM `stories` WHERE `id` = :id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function db_delete_group( $id ) { try { $sql = "DELETE FROM `stories`
					WHERE `id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function is_stories_group( $group_id ) { $result = false; $this->db_is_stories_group( $group_id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $result = $row[0]['cnt']; } return $result; } private function db_is_stories_group( $group_id ) { try { $sql = "SELECT COUNT(*) as cnt
					FROM `stories`
					WHERE `group_id` = :group_id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_id', $group_id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function count_group( $id ) { $result = false; $this->db_count_group($id); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $result = $row[0]['cnt']; } return $result; } private function db_count_group( $id ) { try { $sql = "SELECT COUNT(*) as cnt
					FROM `groups` gr
					left JOIN users u
					ON gr.id=u.group_id
					WHERE u.auth != 9
					AND gr.id = :id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function add_story( $group_ids, $step_mail_id ) { $this->get_group_id( $group_ids, $group ); if( in_array( 1, $group )) { if( $this->get_all_group_id( $group_id_arr )) { foreach( $group_id_arr as $group_id ) { $name = 'group_id-'.$group_id['id']; $data[$name] = $group_id['id']; $group = array_merge( $group, $data ); } } } $data=array(); foreach( $group as $group_id ){ $data['group_id'] = $group_id; $data['step_mail_id'] = $step_mail_id; $this->db_add_story($data); } } private function get_group_id( $group_id, &$data ) { $arr = explode( ',', $group_id ); foreach( $arr as $val ){ $name = 'group_id-'.$val; $data[$name] = $val; } } private function get_all_group_id( &$data ) { $result = FALSE; try { $sql = "SELECT `id` FROM `groups`"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } } catch( PDOException $e ){ die( $e->getMessage() ); } return $result; } function db_delete_story( $step_mail_id ) { try { $sql = "DELETE FROM `stories`
					WHERE `step_mail_id` = :step_mail_id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':step_mail_id', $step_mail_id, PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_delete_story_group_id( $group_id ) { try { $sql = "DELETE FROM `stories`
					WHERE `group_id` = :group_id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_id', $group_id, PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } private function serach_stories_noid() { $result = false; try { $sql = "SELECT id from (
					SELECT
					sto.id as id,sm.id as stepid
					FROM
					`stories` as sto
					LEFT JOIN
					`step_mails` as sm ON sto.step_mail_id = sm.id
					) as sto_table
					where stepid is null;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $result = $row; } return $result; } catch( PDOException $e ){ die( $e->getMessage() ); } } function make_storyno( $group_ids ) { $result = FALSE; $id_arr = $this->serach_stories_noid(); if ($id_arr && is_array($id_arr)) { foreach ($id_arr as $id) { $this->db_delete_group( $id['id'] ); if(DEBUG){ $this->log_out("INFO" , __FILE__ , __LINE__, "/*------------------stories から削除------------------*/"); $this->log_out("INFO" , __FILE__ , __LINE__, $id['id']); } } } $group = array(); if( $this->get_all_group_id( $group_id_arr )) { foreach( $group_id_arr as $group_id ) { $name = 'group_id-'.$group_id['id']; $data[$name] = $group_id['id']; $group = array_merge( $group, $data ); } } foreach( $group as $group_id ) { $this->db_get_group_stepmail( $group_id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $story_no = 1; foreach( $row as $mail ){ $this->db_make_storyno( $mail['id'], $story_no ); $story_no++; } $result = TRUE; } } return $result; } private function db_get_group_stepmail( $group_id ) { try { $sql = "SELECT
					sto.`id` as id,
					sto.`story_no` as stories_story_no,
					sm.`story_no` as step_mails_story_no
					FROM
					`stories` sto LEFT JOIN `step_mails` sm
					ON
					sto.step_mail_id = sm.id
					WHERE  sto.`group_id` = :group_id
					ORDER BY sm.`send_date` ASC, sm.`send_time` ASC, sm.`created` ASC"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_id', $group_id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } private function db_make_storyno( $id, $story_no ) { try { $sql = "UPDATE `stories`
					SET `story_no` = :story_no
					WHERE `stories`.`id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':story_no', (int)$story_no, PDO::PARAM_INT ); $this->stmt->bindValue( ':id', (int)$id, PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function get_all_stepmail() { try { $sql = "SELECT * FROM `step_mails` ORDER BY `send_date` ASC, `send_time` ASC " ; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $stepmails = $row; foreach( $stepmails as $stepmail ) { $stepmail_id = $stepmail['id']; $story_no = (!empty($stepmail['story_no'])) ? $stepmail['story_no']:1; $group_id = (!empty($stepmail['group_id'])) ? $stepmail['group_id']:1; $this->add_story( $group_id, $stepmail_id ); $this->make_storyno( $group_id ); } } } catch(PDOException $e){ die($e->getMessage()); } } private function is_mail_stories( $stepmail_id ) { $result = FALSE; try { $sql = "SELECT count(*) as cnt
					FROM `stories`
					WHERE `stories`.`step_mail_id` = :stepmail_id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':stepmail_id', (int)$stepmail_id, PDO::PARAM_INT ); $this->stmt->execute(); $row = $this->stmt->fetchAll(); if( $row[0]['cnt'] != 0 ) { $result = TRUE; } } catch( PDOException $e ){ die( $e->getMessage() ); } return $result; } function get_stepmailid_by_storyno_groupid( $group_id, $story_no ) { $result = FALSE; try { $sql = "SELECT step_mail_id
			FROM `stories`
			WHERE `group_id` = :group_id
			AND `story_no` = :story_no"; $stmt = $this->pdo->prepare( $sql ); $stmt->bindValue( ':group_id', (int)$group_id, PDO::PARAM_INT ); $stmt->bindValue( ':story_no', (int)$story_no, PDO::PARAM_INT ); $stmt->execute(); $row = $stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $result = $row[0]['step_mail_id']; } } catch( PDOException $e ){ die( $e->getMessage() ); } return $result; } function check_stories_nogroup() { if (!$this->db_get_stories_group_id( $st_gr_arr )) return; if (!$this->get_group_arr( $gr_arr )) return; foreach ($st_gr_arr as $st_gr) { foreach ($gr_arr as $gr) { $gr_flg = FALSE; if ($st_gr['group_id'] == $gr['id']) { $gr_flg = TRUE; break; } } if (!$gr_flg) { $this->del_stories_nogroup_id( $st_gr['group_id'] ); } } return TRUE; } private function db_get_stories_group_id( &$data ) { $result = FALSE; try { $sql = "SELECT `group_id` FROM `stories` GROUP BY `group_id`"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function get_group_arr( &$gr_arr ) { $result = FALSE; try { $sql = "SELECT id FROM `groups`"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $gr_arr = $row; $result = TRUE; } return $result; } private function del_stories_nogroup_id( $group_id ) { try { $sql = "DELETE FROM `stories`
					WHERE `group_id` = :group_id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_id', $group_id, PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function check_input_group_name( $form ) { $this->check_group_name($form["group_name"]); return true; } private function check_group_name( $group_name ) { if(mb_strlen($group_name,"UTF-8") < 2 ) { $this->err['title'] = 'グループ名を正確に入力してください。'; } if(mb_strlen($group_name,"UTF-8") >= 20 ) { $this->err['title'] = 'グループは20文字以内で入力してください。'; } } function get_err() { return $this->err; } } ?>