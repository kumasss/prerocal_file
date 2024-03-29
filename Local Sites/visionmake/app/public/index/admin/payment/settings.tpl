
		<div class="row">
			<div class="offset9">
				<button id="form-update-btn-action" class="btn btn-primary btn-large">保存</button>
				<button id="setting-mode-button" class="btn btn-large"></button>
			</div>
		</div>
		<br/>

        <div id="validation-message"></div>

		<form id="form-seller-setting" class="form-horizontal" role="form" method="post">
			<input type="hidden" name="id" value="#{$editdata->id}"/>

		<div class="row">

				<div class="panel panel-default">

				    <div class="panel-heading">
				    	<div class="well">
					         <h4 class="panel-title">自動メール送信元アドレス</h4>
					         <br />※空欄の場合は、管理者メールアドレスで送信します
				         </div>
				    </div>

					<div class="panel-body">

						<div class="control-group">
							<div class="row">
								<div class="span2">
									送信者名
								</div>
								<div>
										<input name="sender_name" id="sender-name" class="form-control input-xlarge" maxlength="200" value="#{$editdata->sender_name}"></input>
										<p class="form-control-static"></p>
								</div>
							</div>
						</div>
						<div class="control-group">
							<div class="row">
								<div class="span2">
									メールアドレス
								</div>
								<div>
										<input name="sender_email" id="sender-email" class="form-control input-xlarge" maxlength="200" value="#{$editdata->sender_email}"></input>
										<p class="form-control-static"></p>
								</div>
							</div>
						</div>

					</div><!-- //end of panel body -->

				</div><!-- //end of panel -->

				<div class="panel panel-default">

				    <div class="panel-heading">
				    	<div class="well">
					         <h4 class="panel-title">決済完了時メール（デフォルト）</h4>
					         <br />※paypal決済完了時、銀行振込確認後に送信されるメールになります
					         <br />※商品ごとに変更可能
				         </div>
				    </div>

					<div class="panel-body">

		<div class="container">
			<div class="row">
				<div class="span7">

						<div class="control-group">
							<div class="row">
								<div class="span1">
									タイトル
								</div>
								<div class="span6">
									<input name="mail_title" id="mail-title"  class="form-control span5"  maxlength="100" placeholder="100文字まで" value="#{$editdata->mail_title}"/>
									<span class="form-control-static"></span>
								</div>
							</div>
						</div>

						<div class="control-group">
							<div class="row">
								<div class="span1">
									本文
								</div>
								<div class="span6">
									<textarea name="mail_body" id="mail-body"  class="form-control span5"  rows="50" maxlength="2000" placeholder="2000文字まで">#{$editdata->mail_body}</textarea>
									<span class="form-control-static"></span>
								</div>
							</div>
						</div>
				</div>

				<div class="span5">
					<div class="control-group">
						<div class="span1"></div>
						<table id="mail-body-keywords" class="table table-condensed">
							<thead>
								<tr>
									<th>キーワード</th>
									<th>対象データ</th>
								</tr>
							</thead>
<?php foreach (TxController::$replaced_words['COMMON_MAIL_KEY_COLUMN'] as $word) :?>
							<tr <?php echo ($word[2] ? 'class="required"' : '');?>>
								<td class="keyword"><?php echo "%$word[0]%";?></td>
								<td><?php echo $word[1];?></td>
							</tr>
<?php endforeach;?>
						</table>
					</div>
				</div>
			</div><!-- //end of row -->
		</div><!-- //end of container -->

					</div><!-- //end of panel body -->

				</div><!-- //end of panel -->


				<div class="panel panel-default">

				    <div class="panel-heading">
				    	<div class="well">
					         <h4 class="panel-title">銀行申込時メール（デフォルト）</h4>
					         <br />※商品ごとに変更可能
				         </div>
				    </div>

				   	<div class="panel-body">

		<div class="container">
			<div class="row">
				<div class="span7">

				   	<div class="control-group">
							<div class="row">
								<div class="span1">
									タイトル
								</div>
								<div class="span6">
									<input name="bank_req_title" id="bank-req-title"  class="form-control span5"  maxlength="100" placeholder="100文字まで" value="#{$editdata->bank_req_title}"/>
									<span class="form-control-static"></span>
								</div>
							</div>
						</div>
						<div class="control-group">
							<div class="row">
								<div class="span1">
									本文
								</div>
								<div class="span6">
									<textarea name="bank_req_body" id="bank-req-body"  class="form-control span5"  rows="50" maxlength="2000" placeholder="2000文字まで">#{$editdata->bank_req_body}</textarea>
									<span class="form-control-static"></span>
								</div>
							</div>
						</div>
				</div>

				<div class="span5">
					<div class="control-group">
						<div class="span1"></div>
						<table id="bankapp-mail-body-keywords" class="table table-condensed">
							<thead>
								<tr>
									<th>キーワード</th>
									<th>対象データ</th>
								</tr>
							</thead>
<?php foreach (TxController::$replaced_words['BANK_APPLY_MAIL_KEY_COLUMN'] as $word) :?>
							<tr <?php echo ($word[2] ? 'class="required"' : '');?>>
								<td class="keyword"><?php echo "%$word[0]%";?></td>
								<td><?php echo $word[1];?></td>
							</tr>
<?php endforeach;?>
						</table>
					</div>
				</div>
			</div><!-- //end of row -->
		</div><!-- //end of container -->

					</div><!-- //end of panel body -->

				</div><!-- //end of panel -->


				<div class="panel panel-default">

				    <div class="panel-heading">
				         <h4 class="panel-title well">返金メール</h4>
				    </div>

					<div class="panel-body">

		<div class="container">
			<div class="row">
				<div class="span7">

						<div class="control-group">
							<div class="row">
								<div class="span1">
									タイトル
								</div>
								<div class="span6">
									<input name="payback_mail_title" id="payback-mail-title"  class="form-control span5"  maxlength="100" placeholder="100文字まで" value="#{$editdata->payback_mail_title}"/>
									<span class="form-control-static"></span>
								</div>
							</div>
						</div>

						<div class="control-group">
							<div class="row">
								<div class="span1">
									本文
								</div>
								<div class="span6">
									<textarea name="payback_mail_body" id="payback-mail-body"  class="form-control span5"  rows="50" maxlength="2000" placeholder="2000文字まで">#{$editdata->payback_mail_body}</textarea>
									<span class="form-control-static"></span>
								</div>
							</div>
						</div>

				</div>

				<div class="span5">
					<div class="control-group">
						<div class="span1"></div>
						<table class="table table-condensed">
							<thead>
								<tr>
									<th>キーワード</th>
									<th>対象データ</th>
								</tr>
							</thead>
<?php foreach (TxController::$replaced_words['REFUND_MAIL_KEY_COLUMN'] as $word) :?>
							<tr>
								<td><?php echo "%$word[0]%";?></td>
								<td><?php echo $word[1];?></td>
							</tr>
<?php endforeach;?>
						</table>
					</div>
				</div>
			</div><!-- //end of row -->
		</div><!-- //end of container -->

					</div><!-- //end of panel body -->

				</div><!-- //end of panel -->


					<div class="panel panel-default">

					    <div class="panel-heading">
					         <h4 class="panel-title well">銀行情報</h4>
					    </div>

						<div class="panel-body">

							<table class="table table-bordered remove-border-bottom">
								<tr>
									<th>銀行名</th>
									<td>
										<input name="bank_name" id="bank-name" class="form-control input-large" maxlength="40" placeholder="全角40文字まで" value="#{$editdata->bank_name}"></input>
										<p class="form-control-static"></p>
									</td>
									</tr>
								<tr>
									<th>支店名</th>
									<td>
									<input name="bank_branch_name" id="bank-branch-name" class="form-control input-large" maxlength="40" placeholder="全角40文字まで" value="#{$editdata->bank_branch_name}"></input>
									<div class="form-control-static"></div>
									</td>
								</tr>
								<tr>
									<th>口座種別</th>
									<td>
										<input type="hidden" id="option-bank-type" name="bank_type" value="#{$editdata->bank_type}"></input>
										<div  id="bank-type" class="btn-group" data-toggle="buttons-radio">
											<button type="button" class="btn active" name="0">普通</button>
											<button type="button" class="btn" name="1">当座</button>
										</div>
										<div class="form-control-static"></div>
									</td>
								</tr>
								<tr>
									<th>口座番号</th>
									<td>
										<input name="bank_account_number" id="bank-account-number" class="form-control input-large" maxlength="40" placeholder="半角40文字まで" value="#{$editdata->bank_account_number}"></input>
										<div class="form-control-static"></div>
									</td>
								</tr>

								<tr>
									<th>口座名義</th>
									<td>
										<input name="bank_account" id="bank-account" class="form-control input-large" maxlength="40" value="#{$editdata->bank_account}"></input>
										<div class="form-control-static"></div>
										<br> ※銀行により使用許容文字が異なりますのでご注意ください（半角カナ・カナ大文字等）
									</td>
								</tr>

							</table>

						</div><!-- //end of panel body -->

					</div><!-- //end of panel -->


					<div class="panel panel-default">

					    <div class="panel-heading">
					         <h4 class="panel-title well">PayPal API</h4>
					    </div>

						<div class="panel-body">

							<div class="container">
								<div class="control-group">
									<div class="row">
										<div class="span2">
										<strong>アクセス先</strong>
										</div>
										<div class="span5">
											<input type="hidden" id="option-sandbox-mode" name="api_sandbox_mode" value="#{$editdata->api_sandbox_mode}"></input>
											<div  id="sandbox-mode" class="btn-group" data-toggle="buttons-radio">
												<button type="button" class="btn" name="0">本番</button>
												<button type="button" class="btn active" name="1">サンドボックス</button>
											</div>
											<div class="form-control-static"></div>
										</div>
									</div>
								</div>
								<div class="control-group">
									<div class="row">
										<div class="span2">
										<strong>通知URL</strong>
										</div>
										<div class="span7">
											#{URL}/purchase/ipn_listener.php
											<br /><span class="required">上記URLをPaypalに設定してください。</span>
											<br />※設定場所：
											<br />【ビジネスアカウントの場合】
											<br />Paypal管理画面→個人設定→販売ツール→即時払い通知→[IPNの設定の選択] 
											<br />【プレミアアカウントの場合】
											<br />Paypal管理画面→売り手の設定→即時払い通知→[IPNの設定の選択]
											<br />また「IPNメッセージ」を「受信する(有効)」にチェックを入れて保存してください
										</div>
									</div>
								</div>

							</div>

							<table class="table table-bordered remove-border-bottom">
								<th colspan="2">本番環境のAPI署名</th>
								<tr>
									<th class="span2">APIユーザー名</th>
									<td>
										<input name="api_username" id="api-username" class="form-control input-large" maxlength="200" value="#{$editdata->api_username}"></input>
										<p class="form-control-static"></p>
									</td>
									</tr>
								<tr>
									<th>APIパスワード</th>
									<td>
									<input name="api_password" id="api-password" class="form-control input-large" maxlength="20" value="#{$editdata->api_password}"></input>
									<div class="form-control-static"></div>
									</td>
								</tr>
								<tr>
									<th>署名</th>
									<td>
										<input name="api_signature" id="api-signature" class="form-control input-large" maxlength="80" value="#{$editdata->api_signature}"></input>
										<div class="form-control-static"></div>
									</td>
								</tr>
							</table>

							<table class="table table-bordered remove-border-bottom">
								<th colspan="2">サンドボックス環境のAPI署名</th>
								<tr>
									<th class="span2">APIユーザー名</th>
									<td>
										<input name="api_sand_username" id="api-sand-username" class="form-control input-large" maxlength="200" value="#{$editdata->api_sand_username}"></input>
										<p class="form-control-static"></p>
									</td>
									</tr>
								<tr>
									<th>APIパスワード</th>
									<td>
									<input name="api_sand_password" id="api-sand-password" class="form-control input-large" maxlength="20" value="#{$editdata->api_sand_password}"></input>
									<div class="form-control-static"></div>
									</td>
								</tr>
								<tr>
									<th>署名</th>
									<td>
										<input name="api_sand_signature" id="api-sand-signature" class="form-control input-large" maxlength="80" value="#{$editdata->api_sand_signature}"></input>
										<div class="form-control-static"></div>
									</td>
								</tr>
							</table>

						</div><!-- //end of panel body -->

					</div><!-- //end of panel -->


		</div><!-- //end of row -->


		</form>

		<div id="alert-base" class="alert" role="alert" style="display:none;"></div>
		<div id="pp-api-state" style="display:none;"><span #{$ppapi_state_col}>#{$ppapi_state}</span></div>

		<script>

			$(document).ready( function() {

				$('input').keypress(function(ev) {
					if ((ev.which && ev.which === 13) || (ev.keyCode && ev.keyCode === 13)) {
						return false;
					} else {
						return true;
					}
				});

				var alertMessage = function(type,msg) {
					$('.temp-alert').remove();
					var alt = $('#alert-base').clone();
					alt.removeAttr('id');
					alt.addClass(type).addClass('temp-alert');
					alt.append(msg);
					$('#validation-message').empty().append(alt);
					alt.show();
				};


				$.fn.extend({

					dispMode : function(mode) {

						$(this).data.mode = mode;

						if ( mode == 'view') {

							$(this).find('textarea,input').each( function() {
								$(this).hide();
								var text = $(this).val().replace(/\r?\n/g, "<br />");
								$(this).next('.form-control-static').html(text).show();
//								$(this).next('.view-keep').show();
							});

							$('#setting-mode-button')
								.removeClass('btn-default')
								.addClass('btn-primary')
								.text('編集');

							$('#form-update-btn-action').hide();

							$('#bank-type').hide().next('.form-control-static').show();

							$('#sandbox-mode').hide().next('.form-control-static').show();



						} else if ( mode == 'edit') {

							$('.form-control-static').hide();

							$(this).find('textarea,input').each( function() {
								$(this).show();
								$(this).next('.form-control-static').hide();
							});

							$('#setting-mode-button')
								.removeClass('btn-primary')
								.addClass('btn-default')
								.text('キャンセル');
							$('#form-update-btn-action').show();

							$('#bank-type').show().next('.form-control-static').hide();

							$('#sandbox-mode').show().next('.form-control-static').hide();

						}

						return $(this);
					}
				});


				var registerProc = function(button) {

					var $keyword1 = $('#bankapp-mail-body-keywords tr.required td.keyword').first();
					var kw1 = $keyword1.text();
					if ( $('textarea#bank-req-body').val().indexOf(kw1) === -1) {
							alertMessage('alert-danger','銀行申込時メールの本文内容に必須キーワード「'+kw1+'」が含まれていません');
							button.attr("disabled", false);
							return false;
					}

					var $keyword2 = $('#mail-body-keywords tr.required td.keyword').first();
					var kw2= $keyword2.text();
					if ( $('textarea#mail-body').val().indexOf(kw2) === -1) {
							alertMessage('alert-danger','決済完了時メールの本文内容に必須キーワード「'+kw2+'」が含まれていません');
							button.attr("disabled", false);
							return false;
					}
/*
					var api_mode = $('#option-sandbox-mode').val();

					if ( api_mode === '0') {
						if ( $('#api-username').val().trim() === '' || $('#api-password').val().trim() === '' || $('#api-signature').val().trim() === '') {
							alertMessage('alert-danger','本番用のAPI情報を設定してください');
							button.attr("disabled", false);
							return false;
						}
					} else {
						if ( $('#api-sand-username').val().trim() === '' || $('#api-sand-password').val().trim() === '' || $('#api-sand-signature').val().trim() === '') {
							alertMessage('alert-danger','サンドボックス用のAPI情報を設定してください');
							button.attr("disabled", false);
							return false;
						}
					}
*/
					var data = $('#form-seller-setting').serializeArray();

					$.ajax({
							type:"POST",
							url: "settings.php",
							data:JSON.stringify(data),
							contentType: 'application/json',
							success: function(html) {
								$('#settings').html(html);
							},
							error: function() {
									alert("通信エラーが発生しました。画面をリロードして設定しなおしてください");
									return false;
							},
							complete: function() {
								button.attr("disabled", false);
								$('span#paypal-mode').html( $('#pp-api-state').html());
							}
						});
				};

				$('#form-update-btn-action').click( function(e) {

					e.preventDefault();

					$('#validation-message').empty();

					var sender_email = $('#sender-email').val();
					if ( sender_email == '' || sender_email.trim() == '') {
					} else {
						if( !sender_email.match(/^([a-zA-Z0-9])+([a-zA-Z0-9\._+-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/)) {
							alertMessage('alert-danger','正しいメールアドレスをを入力して下さい');
							return false;
						}
					}

					$('textarea').each( function() {
						var val = $(this).val();
						if ( val) {
							$(this).val( val.trim());
						}
//						console.log( $(this).val());
					});

					var button = $(this);
					button.attr("disabled", true);
					registerProc(button);
				});

				$('#setting-mode-button').click( function() {

					if ( $(this).hasClass('edit')) {
						// cancel
						$.ajax({
							type:"GET",
							url: "settings.php",
							success: function(html) {
								$('#settings').html(html);
							}
						});

					} else {
						$('#form-seller-setting').dispMode('edit');
						$(this).removeClass('view').addClass('edit');
					}
				});


				$('#bank-type .btn').click( function() {
					var bank_type_name = $(this).text();
					var bank_type_val = $(this).attr('name');
					$('#option-bank-type').val(bank_type_val);
					$('#bank-type').next('.form-control-static').text(bank_type_name);
				});

				$('#sandbox-mode .btn').click( function() {
					var sandbox_mode_name = $(this).text();
					var sandbox_mode_val = $(this).attr('name');
					$('#option-sandbox-mode').val(sandbox_mode_val);
					$('#sandbox-mode').next('.form-control-static').text(sandbox_mode_name);
				});

				var initSwitches= function() {
					var bt = $('#option-bank-type').val();
					if ( !bt) bank_type = 0;
					$('#bank-type').children('button.btn').each( function() {
						$(this).removeClass('active');
						if ( $(this).attr('name') == bt) {
							$(this).click();
						}
					});

					var bt2 = $('#option-sandbox-mode').val();
					if ( !bt2) sandbox_mode = 0;
					$('#sandbox-mode').children('button.btn').each( function() {
						$(this).removeClass('active');
						if ( $(this).attr('name') == bt2) {
							$(this).click();
						}
					});

				};

				initSwitches();



				$('#form-seller-setting').dispMode('view');

			});
		</script>
