<?php
 require_once( dirname(__FILE__).'/main.php' ); class accanalyzes extends main { protected $err; function db_add_ac_site_logs( $data ) { try { $sql = "INSERT INTO `ac_site_logs` (
				`id` ,
				`short_code` ,
				`short_url` ,
				`site_url` ,
				`referer` ,
				`user_agent` ,
				`ip_address` ,
				`host` ,
				`created`
			)
			VALUES (
				NULL, :short_code, :short_url, :site_url, :referer, :user_agent, :ip_address, :host, NOW()
			);"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':short_code', $data['short_code'] ); $this->stmt->bindValue( ':short_url', $data['short_url'] ); $this->stmt->bindValue( ':site_url', $data['site_url'] ); $this->stmt->bindValue( ':referer', $data['referer'] ); $this->stmt->bindValue( ':user_agent', $data['user_agent'] ); $this->stmt->bindValue( ':ip_address', $data['ip_address'] ); $this->stmt->bindValue( ':host', $data['host'] ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_add_ac_mail_logs( $data ) { try { $sql = "INSERT INTO `ac_mail_logs` (
				`id`,
				`short_code`,
				`short_url`,
				`mail_id`,
				`mail_mode`,
				`user_id`,
				`created`
			) VALUES (
				NULL, :short_code, :short_url, :mail_id, :mail_mode, :user_id, NOW()
			)"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':short_code', $data['short_code'] ); $this->stmt->bindValue( ':short_url', $data['short_url'] ); $this->stmt->bindValue( ':mail_id', $data['mail_id'] ); $this->stmt->bindValue( ':mail_mode', $data['mail_mode'] ); $this->stmt->bindValue( ':user_id', $data['user_id'] ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_edit_accanalyze( $data ) { try { $sql = "UPDATE `accanalyzes` SET
				`send_err_num` = :send_err_num,
				`send_stop` = :send_stop,
				`send_num` = :send_num,
				`send_interval` = :send_interval,
				`send_now` = :send_now,
				`modified` = NOW()
				WHERE `id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':send_err_num', $data['send_err_num'], PDO::PARAM_INT ); $this->stmt->bindValue( ':send_stop', $data['send_stop'], PDO::PARAM_INT ); $this->stmt->bindValue( ':send_num', $data['send_num'], PDO::PARAM_INT ); $this->stmt->bindValue( ':send_interval', $data['send_interval'], PDO::PARAM_INT ); $this->stmt->bindValue( ':send_now', $data['send_now'], PDO::PARAM_INT ); $this->stmt->bindValue( ':id', $data['id'], PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_delete_accanalyze( $id ) { $now = $this->get_now_date(); try { $sql = "DELETE FROM `settings`
					WHERE `settings`.`id` = :id;"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':id', $id, PDO::PARAM_INT ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function db_all_delete_accanalyze() { try { $sql = "TRUNCATE TABLE `accanalyzes`"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->execute(); } catch( PDOException $e ){ die( $e->getMessage() ); } } function get_ac_site_logs( $data, &$log ) { $result = FALSE; $datetime = $data['date'].' '.$data['time']; $this->db_get_ac_site_logs( $datetime ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $log = $row; $result = TRUE; } return $result; } private function db_get_ac_site_logs( $datetime, $mode='UNIQUE' ) { try { if($mode==='UNIQUE'){ $sql = "
					SELECT
					count(t1.`short_code`) as cnt,
					t1.hour,
					t1.`short_code`
					FROM(
					SELECT 
					DATE_FORMAT(`created`, '%Y-%m-%d %H:00') as hour, 
					count(DISTINCT `ip_address`) as cnt,
					`site_url`,
					`short_code`,
					`ip_address`
					FROM ac_site_logs
					WHERE `created` >= :datetime
					GROUP BY hour,`short_code`,`ip_address`,`site_url`
					) as t1
					group by t1.hour, t1.`short_code`
					"; } else { $sql = "
					SELECT 
					DATE_FORMAT(`created`, '%Y-%m-%d %H:00') as hour, 
					count(id) as cnt,
					`short_code`
					FROM ac_site_logs
					WHERE `created` >= :datetime
					GROUP BY hour,`short_code`
					"; } $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':datetime', $datetime ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function get_ac_mail_logs( $data, &$log ) { $result = FALSE; $datetime = $data['date'].' '.$data['time']; $this->db_get_ac_mail_logs( $datetime ); $row = $this->stmt->fetchAll(); $cnt = count( $row ); if($cnt >= 1) { $log = $row; $result = TRUE; } return $result; } private function db_get_ac_mail_logs( $datetime ) { try { $sql = "
				SELECT 
				DATE_FORMAT(`created`, '%Y-%m-%d %H:00') as hour, 
				count(id) as cnt,
				`short_code`,
				`mail_id`,
				`mail_mode`
				FROM ac_mail_logs
				WHERE `created` >= :datetime
				GROUP BY hour,`mail_id`,`mail_mode`,`short_code`
				"; $this->stmt = $this->pdo->prepare( $sql ); $this->stmt->bindValue( ':datetime', $datetime ); $this->stmt->execute(); } catch(PDOException $e){ die($e->getMessage()); } } function ac_page( $data ) { $rtn = FALSE; require_once( 'simple_html_dom.php' ); $dom = str_get_html( $data ); $data = array(); foreach($dom->find('a') as $element) { $a_url = $element->href; $code_str = strstr($a_url, 'cf/'); if ( $code_str ) { $ccde = str_replace('cf/', '' , $code_str); $data['short_code'] = $ccde; $data['short_url'] = $a_url; $data['referer'] = (!empty($_SERVER["HTTP_REFERER"]))?$_SERVER["HTTP_REFERER"]:NULL; $data['ip_address'] = (!empty($_SERVER['REMOTE_ADDR']))?$_SERVER['REMOTE_ADDR']:NULL; $data['host'] = ''; $data['user_agent'] = ''; $data['site_url'] = (empty($_SERVER["HTTPS"])?"http://":"https://").$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]; $this->db_add_ac_site_logs( $data ); $rtn = TRUE; } } $dom = ''; return $rtn; } function ac_mail( $data, $mode='step' ) { $rtn = FALSE; if( preg_match_all('(https?://[-_.!~*\'()a-zA-Z0-9;/?:@&=+$,%#]+)', $data['message'], $result) !== FALSE ) { $mail_id = $data['mail_id']; $user_id = $data['user_id']; $data = array(); foreach( $result[0] as $url ) { $code_str = strstr($url, 'cf/'); if ( $code_str ) { $code = str_replace('cf/', '' , $code_str); $is = array_search( $code, $data ); if(empty( $is )) { $data['short_code'] = $code; $data['short_url'] = $url; $data['mail_mode'] = $mode; $data['mail_id'] = $mail_id; $data['user_id'] = $user_id; $this->db_add_ac_mail_logs( $data ); } $rtn = TRUE; } } } return $rtn; } function check_date( $date ) { if( !preg_match( "/^([0-9-]{10})$/", $date ) ) { $this->err['date'] = '日付指定が間違っています。'; } } function check_time( $data ) { if( !preg_match( "/^(?:(2[0-3])|([0-1][0-9])):([0-5][0-9])$/", $data ) ) { $this->err['date'] = '時間指定が間違っています。'; } } function get_err() { return $this->err; } } ?>