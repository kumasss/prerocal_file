<?php
 require_once(dirname(__FILE__).'/main.php'); class contact extends main { function count_users( $scenario_id=SCENARIOS_ID ) { $row = $this->db_count_users( $scenario_id ); return $row[0]->cnt; } private function db_count_users( $scenario_id ) { try { $stmt = $this->pdo->prepare( 'SELECT count(*) as cnt FROM `users` WHERE `scenario_id` = :scenario_id AND `auth` !=9' ); $stmt->bindValue( ':scenario_id', $scenario_id, PDO::PARAM_INT ); $stmt->execute(); return $stmt->fetchAll(PDO::FETCH_OBJ); } catch(PDOException $e){ die($e->getMessage()); } } function count_step_mails() { $row = $this->db_count_step_mails(); return $row[0]->cnt; } private function db_count_step_mails() { try { $stmt = $this->pdo->prepare( 'SELECT count(*) as cnt FROM `step_mails`' ); $stmt->execute(); return $stmt->fetchAll(PDO::FETCH_OBJ); } catch(PDOException $e){ die($e->getMessage()); } } function count_extra_mails() { $row = $this->db_count_extra_mails(); return $row[0]->cnt; } private function db_count_extra_mails() { try { $stmt = $this->pdo->prepare( 'SELECT count(*) as cnt FROM `extra_mails`' ); $stmt->execute(); return $stmt->fetchAll(PDO::FETCH_OBJ); } catch(PDOException $e){ die($e->getMessage()); } } function count_groups() { $row = $this->db_count_groups(); return $row[0]->cnt; } private function db_count_groups() { try { $stmt = $this->pdo->prepare( 'SELECT count(*) as cnt FROM `groups`' ); $stmt->execute(); return $stmt->fetchAll(PDO::FETCH_OBJ); } catch(PDOException $e){ die($e->getMessage()); } } function count_tp_contents() { $row = $this->db_count_tp_contents(); return $row[0]->cnt; } private function db_count_tp_contents() { try { $stmt = $this->pdo->prepare( 'SELECT count(*) as cnt FROM `tp_contents`' ); $stmt->execute(); return $stmt->fetchAll(PDO::FETCH_OBJ); } catch(PDOException $e){ die($e->getMessage()); } } function get_auth_name() { $row = $this->db_get_auth_name(); return $row[0]->name; } private function db_get_auth_name() { try { $stmt = $this->pdo->prepare( "SELECT CONCAT(firstname,IFNULL(lastname,'')) as name FROM `users` WHERE `auth` =9" ); $stmt->execute(); return $stmt->fetchAll(PDO::FETCH_OBJ); } catch(PDOException $e){ die($e->getMessage()); } } function check_title( $title, $num ) { if($this->check_count($title, $num)===FALSE) { $this->err['title'] = 'タイトルを正確に入力してください。'; } } function check_cat( $title, $num ) { if($this->check_count($title, $num)===FALSE) { $this->err['cat'] = 'カテゴリを正確に入力してください。'; } } function check_name( $title, $num, $dummy='dummy' ) { if($this->check_count($title, $num)===FALSE) { $this->err['name'] = 'お名前を正確に入力してください。'; } } function check_content( $title, $num ) { if($this->check_count($title, $num)===FALSE) { $this->err['content'] = '本文を正確に入力してください。'; } } private function check_count( $name, $num ) { $result = TRUE; if( mb_strlen($name,"UTF-8") < 1 || mb_strlen($name,"UTF-8") > $num ) { $result = FALSE; } return $result; } function get_err() { return $this->err; } } 