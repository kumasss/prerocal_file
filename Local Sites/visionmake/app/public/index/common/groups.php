<?php
 require_once( dirname(__FILE__).'/main.php' ); class groups extends main { function db_add_group( $data ) { try { $sql = "INSERT INTO `groups` (`group_name`,`group_code`,`created`)
					VALUES (:group_name,:group_code, NOW())"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_name', $data['group_name'] ); $this->stmt->bindValue( ':group_code', $data['group_code'] ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_edit_group( $data ) { try { $sql = "UPDATE `groups`
					SET `group_name` = :group_name, `group_code` = :group_code, `modified` = NOW()
					WHERE `groups`.`id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_name', $data['group_name'] ); $this->stmt->bindValue( ':group_code', $data['group_code'] ); $this->stmt->bindValue( ':id', $data['id'], PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function make_group_code( $chars=8 ) { $flg = FALSE; $cnt = 0; while($cnt <= 99) { $group_code = $this->make_password( $chars ); $is_code = $this->check_same_group_code( $group_code ); if($is_code == 0) { $flg=TRUE; return $group_code; break; } $cnt++; } return $flg; } function get_all_group( &$data, $start=0, $num=999 ) { $result = FALSE; $this->db_all_group( $start, $num ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = TRUE; } return $result; } private function db_all_group( $start, $num ) { try { $sql = "SELECT * FROM `groups` ORDER BY `id` ASC LIMIT ".$start.",".$num; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_group( $id, &$data ) { $result = false; $this->db_group( $id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $data = $row[0]; $result = true; } return $result; } private function db_group( $id ) { try { $sql = "SELECT * FROM `groups` WHERE `id` = :id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function make_group_name( $groups_data, $group_id ) { $arr_group_name = array(); $arr_id = explode(',', $group_id); foreach($arr_id as $id){ foreach($groups_data as $group){ if( $group['id'] == $id ){ $arr_group_name[] = $group['group_name']; } } } if(!empty($arr_group_name)){ $group_name = implode(',', $arr_group_name); } else { $group_name = '<span class="red">存在しないグループ</span>'; } return $group_name; } function db_delete_group( $id ) { try { $sql = "DELETE FROM `groups`
					WHERE `id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_all_delete_groups() { try { $sql = "TRUNCATE `groups`"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_change_datetime_2_null() { try { $sql = "ALTER TABLE `groups` CHANGE `created` `created` DATETIME NULL, CHANGE `modified` `modified` DATETIME NULL"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function set_groups() { try { $sql = "INSERT INTO `groups` (`id`, `group_name`, `group_code`, `del_flg`, `created`, `modified`) VALUES (1, '共通', '', 0, NOW(), NULL);"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function count_group( $id ) { $result = false; $this->db_count_group($id); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $result = $row[0]['cnt']; } return $result; } private function db_count_group( $id ) { try { $sql = "SELECT COUNT(*) as cnt
					FROM `groups` gr
					left JOIN users u
					ON gr.id=u.group_id
					WHERE u.auth != 9
					AND gr.id = :id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function count_content_in_group( $group_id ) { $result = FALSE; $this->db_count_content_in_group( $group_id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $result = $row[0]['cnt']; } return $result; } private function db_count_content_in_group( $group_id ) { try { $sql = "SELECT COUNT(*) as cnt
					FROM `tp_contents` 
					WHERE FIND_IN_SET(:group_id,`group_id`)"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_id', $group_id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function count_mail_in_group( $group_id ) { $result = FALSE; $this->db_count_stepmail_in_group( $group_id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $result['step'] = $row[0]['cnt']; } $this->db_count_extramail_in_group( $group_id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $result['extra'] = $row[0]['cnt']; } return $result; } private function db_count_stepmail_in_group( $group_id ) { try { $sql = "SELECT COUNT(*) as cnt
					FROM `step_mails` 
					WHERE FIND_IN_SET(:group_id,`group_id`)"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_id', $group_id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } private function db_count_extramail_in_group( $group_id ) { try { $sql = "SELECT COUNT(*) as cnt
					FROM `extra_mails` 
					WHERE FIND_IN_SET(:group_id,`group_id`)"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_id', $group_id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function db_add_setting( $data ) { try { $sql = "INSERT INTO `settings`(
		    	`group_id`, `user_password`, `form_password`, `from_email`, `name_email`, `reply_email`, `send_err_num`, `send_err`, `send_stop`, `send_num`, `send_interval`, `send_now`, `automail_add_admin`, `automail_stop_admin`, `automail_edit_admin`, `automail_add_user`, `automail_stop_user`, `automail_edit_user`, `form_email`, `form_email2`, `form_password2`, `form_firstname`, `form_lastname`, `form_order_no`, `form_is_email`, `form_is_firstname`, `form_is_lastname`, `form_is_order_no`, `form_is_password`, `form_is_password2`, `form_add_done_message`, `form_stop_done_message`, `created`, `modified`
		    )
			SELECT
			:group_id, `user_password`, `form_password`, `from_email`, `name_email`, `reply_email`, `send_err_num`, `send_err`, `send_stop`, `send_num`, `send_interval`, `send_now`, `automail_add_admin`, `automail_stop_admin`, `automail_edit_admin`, `automail_add_user`, `automail_stop_user`, `automail_edit_user`, `form_email`, `form_email2`, `form_password2`, `form_firstname`, `form_lastname`, `form_order_no`, `form_is_email`, `form_is_firstname`, `form_is_lastname`, `form_is_order_no`, `form_is_password`, `form_is_password2`, `form_add_done_message`, `form_stop_done_message`, NOW(), NULL
			FROM `settings` WHERE `group_id`=1
			;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_id', $data['group_id'] ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function is_settings_group( $group_id ) { $result = false; $this->db_is_settings_group($group_id); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt == 1) { $result = $row[0]['cnt']; } return $result; } private function db_is_settings_group( $group_id ) { try { $sql = "SELECT COUNT(*) as cnt
					FROM `settings`
					WHERE `group_id` = :group_id"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_id', $group_id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function db_delete_setting( $group_id ) { try { $sql = "DELETE FROM `settings`
					WHERE `settings`.`group_id` = :group_id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_id', $group_id, PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_delete_setting_notid( $group_id ) { try { $sql = "DELETE FROM `settings`
					WHERE `settings`.`group_id` != :group_id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_id', $group_id, PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_cnt_settings() { try { $sql = "SELECT COUNT(*) as cnt
					FROM `settings`"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); $row = $this->stmt->fetchAll(); return $cnt = $row[0]['cnt']; } catch(PDOException $e){ die($e->getMessage()); } } function get_stepmail_id_group( $group_id, &$data ) { $result = false; $this->db_get_stepmail_id_group( $group_id ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $data = $row; $result = true; } return $result; } private function db_get_stepmail_id_group( $group_id ) { try { $sql = "SELECT `id` FROM `step_mails` where FIND_IN_SET(:group_id,`group_id`)"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_id', $group_id, PDO::PARAM_INT ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function add_group_all_section( $groups_data ) { $add_data = array( 0=>array('id'=>'all', 'group_name'=>'すべて') ); return $add_groups_data = array_merge( $add_data, $groups_data ); } function set_group_id( $form_data ) { $group_id = (!empty($form_data['group_id']))?$form_data['group_id']:''; if(empty($group_id)) { if(!empty($_SESSION['group_id'])) { $group_id = $_SESSION['group_id']; } else { $group_id = 1; } } else { $_SESSION['group_id'] = $group_id; } return $group_id; } function check_input_group_name( $form ) { $this->check_group_name($form["group_name"]); return true; } private function check_group_name( $group_name ) { if(mb_strlen($group_name,"UTF-8") < 2 ) { $this->err['title'] = 'グループ名を正確に入力してください。'; } if(mb_strlen($group_name,"UTF-8") >= 20 ) { $this->err['title'] = 'グループは20文字以内で入力してください。'; } $group_name=str_replace("　"," ",$group_name); $group_name=trim(str_replace(" ","",$group_name)); if($group_name==""){ $this->err['title'] = 'グループ名を正確に入力してください。'; } $group_name_cnt=$this->check_same_group_name( $group_name ); if($group_name_cnt>0){ $this->err['title'] = 'すでにあるグループ名を入力しようとしています。'; } } private function check_same_group_name( $group_name ){ try { $sql = "SELECT `id` FROM `groups` WHERE `group_name`  LIKE :group_name"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_name', $group_name ); $this->stmt->execute(); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { return $row[0]['id']; }else{ return $cnt; } } catch(PDOException $e){ die($e->getMessage()); } } function check_same_group_code( $group_code ){ try { $sql = "SELECT `id` FROM `groups` WHERE `group_code`  LIKE :group_code"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':group_code', $group_code ); $this->stmt->execute(); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { return $row[0]['id']; }else{ return $cnt; } } catch(PDOException $e){ die($e->getMessage()); } } function get_err() { return $this->err; } } ?>