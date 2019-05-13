	<br/>

	<form id="form-register" class="form-horizontal" role="form" method="post">

		<input type="hidden" id="productId" name="id" value="#{$editdata->id}"/>
		<input type="hidden" name="unit_id" value="#{$editdata->unit_id}"/>
		<input type="hidden" name="version" value="#{$editdata->version}"/>

		<div class="well">
			<div class="row-fluid">
				<div class="control-group span4"></div>
				<div class="control-group span4">
						<button class="btn btn-primary btn-large input-xlarge center form-create-btn-action"><?php echo ($editdata->id ? '更新' : '作成'); ?></button>
				</div>
			</div>

			<div class="row-fluid">
				<div class="control-group span1"></div>
				<div class="control-group span1">URL</div>
				<div class="control-group">
					<input name="product_url" class="form-control payment-page-url span9" maxlength="1000" value="#{$editdata->product_url}" readonly/>
				</div>
			</div>
		</div>

		<div class="alert-message"></div>

		<div class="control-group well">
			<strong>商品基本情報</strong>
		</div>

		<div class="control-group">
			<div class="span1">タイトル</div>
			<input name="title" id="prd-title" class="form-control  span8" maxlength="30" placeholder="30文字まで" value="#{$editdata->title}"></input>
		</div>

		<div class="control-group">
			<div class="span1">説明</div>
			<textarea name="description" id="prd-desc" class="form-control  span8" rows="6" maxlength="200" placeholder="200文字まで">#{$editdata->description}</textarea>
		</div>

		<div class="control-group">
			<div class="span1">金額</div>
				<input name="price" id="prd-price" class="form-control input-small" maxlength="10" value="#{$editdata->price}" placeholder="半角数値"/>
				<span class="offset1 help-block">※税込金額で指定してください</span>
				<span class="offset1 help-block">※半角数字のみ入力できます</span>
				<span class="offset1 help-block">※金額を0円にすることで「販売されていません」と表示されます</span>
		</div>

		<div class="control-group well">
			<strong>完了後ページURL（任意）</strong>
		</div>
		<div class="required">　　※通常は設定の必要はありません</div>
		<br />

		<div class="control-group">
			<div class="span1">URL</div>
			<input name="after_url" id="after-url" class="form-control span9" maxlength="1000" value="#{$editdata->after_url}" placeholder="URL"></input>
		</div>

		<div class="offset1">
			<label>※空欄時は完了メッセージページを表示します。なお下記はサンプル表示ですのでこちらをご案内しても利用できません。</label>
			<ul>
				<li>
					<a target="_blank" href="<?php echo URL."/purchase/bank.php?id=$editdata->id&order=review"; ?>">銀行振込</a>
				</li>
				<li>
					<a target="_blank" href="<?php echo URL."/purchase/paypal.php?id=$editdata->id&order=review"; ?>">PayPal</a>（決済完了メールリンク経由確認画面）
				</li>
			</ul>
		</div>

		<div class="control-group well">
			<strong>購入者制限</strong>
		</div>

		<div class="control-group">
			<div class="span1">&nbsp;</div>
			<select id="sales-option" name="sales_option" value="#{$editdata->sales_option}">
<?php foreach ($sales_options as $sk=>$sv) : ?>
			  <option value="#{$sk}" <?php echo ($sk == $editdata->sales_option ? "selected" : ""); ?>>#{$sv[0]}</option>
<?php endforeach; ?>
			</select>
		</div>
		<span class="offset1 help-block">※「新規会員」は、会員ユーザーが未ログインの場合も対象となります</span>
		<br/>

		<div class="control-group well">
			<strong>所属グループ変更　※既存会員は変更先 / 新規会員は登録先</strong>
		</div>

		<div id="prd-option-group" class="control-group">
			<div class="span1">&nbsp;</div>
			<p>
				<input type="hidden" id="submit-group" name="prd_grp" value="#{$group_i}"/>
				<input type="hidden" id="submit-group-flag" name="prd_flag_grp" value="#{$group_f}"/>
				<input id="checkbox-group-flag" type="checkbox" <?php echo ($group_f ? 'checked' : ''); ?>/>&nbsp;設定する　　
				<select name="prd_opt" value="#{$group_i}">
<?php foreach ($sys_group as $sg) : ?>
					<option value="#{$sg->id}" <?php echo ( $group_i == $sg->id ? 'selected' : '');?>>#{$sg->group_name}(#{$sg->id})</option>
<?php endforeach; ?>
				</select>
			</p>
		</div>
		<span class="offset1 help-block">※「購入者制限」で「販売のみ」を選択した場合は設定できません</span>
		<br/>

		<div class="control-group well">
			<strong>銀行設定</strong>
		</div>

		<div class="control-group">
			<div class="span1">&nbsp;</div>
			<div>
				<input type="hidden" id="input-bank-flag" name="bank_flag" value="#{$editdata->bank_flag}"/>
				<input id="checkbox-bank-flag" type="checkbox" <?php echo ($editdata->bank_flag == 1 ? 'checked' : ''); ?>/>&nbsp銀行振込可　　振込期限：申し込み日から
				<input type="text" name="bank_tr_deadline" value="#{$editdata->bank_tr_deadline}" id="bank-tr-deadline" class="form-control input-small">&nbsp;日以内
			</div>
		</div>

		<div class="control-group well">
			<strong>銀行申込時メール</strong>
		</div>

		<div class="container">
			<div class="row">
				<div class="span7">
					<div class="control-group">
						<div class="span1">タイトル</div>
						<input name="bank_app_mail_title" id="bank-app-mail-title"  class="form-control span5"  maxlength="100" placeholder="100文字まで" value="#{$editdata->bank_app_mail_title}"/>
					</div>

					<div class="control-group">
						<div class="span1">本文</div>
						<textarea name="bank_app_mail_body" id="bank-app-mail-body"  class="form-control span5"  rows="50" maxlength="2000" placeholder="2000文字まで">#{$editdata->bank_app_mail_body}</textarea>
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

		<div class="control-group well">
			<strong>決済完了時メール（PayPal／銀行振込共通）</strong>
		</div>

		<div class="container">
			<div class="row">
				<div class="span7">

					<div class="control-group">
						<div class="span1">タイトル</div>
						<input name="mail_title" id="mail-title"  class="form-control span5"  maxlength="100" placeholder="100文字まで" value="#{$editdata->mail_title}"/>
					</div>

					<div class="control-group">
						<div class="span1">本文</div>
						<textarea name="mail_body" id="mail-body"  class="form-control span5"  rows="50" maxlength="2000" placeholder="2000文字まで">#{$editdata->mail_body}</textarea>
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

		<br/>
		<div class="alert-message"></div>

		<div class="well">
			<div class="row-fluid">
				<div class="control-group span4"></div>
				<div class="control-group span4">
						<button class="btn btn-primary btn-large input-xlarge center form-create-btn-action"><?php echo ($editdata->id ? '更新' : '作成'); ?></button>
				</div>
			</div>

			<div class="row-fluid">
				<div class="control-group span1"></div>
				<div class="control-group span1">URL</div>
				<div class="control-group">
					<input name="product_url" class="form-control payment-page-url span9" maxlength="1000" value="#{$editdata->product_url}" readonly/>
				</div>
			</div>
		</div>

	</form>


	<div id="alert-base" class="alert alert-dismissible" role="alert" style="display: none;">
	</div>

	<script>

			$(document).ready( function() {

				$('input').keypress(function(ev) {
					if ((ev.which && ev.which === 13) || (ev.keyCode && ev.keyCode === 13)) {
						return false;
					} else {
						return true;
					}
				});

/*				$('#prd-price').keydown( function(e) {
					c = e.keyCode;
					if ( c >= 96 && c <= 105 ||// テンキー0～9
							c >= 48 && c <= 57 ||// メインキー0～9
							c == 37 ||//←キー
							c == 39 ||//→キー
							c == 8 //BACKSPACE
					) {
						return true;
					}
					k = String.fromCharCode(c);
					if ( "0123456789".indexOf(k, 0) < 0) {
						return false;
					}
					return true;
				});
*/
				var alertMessage = function(type,msg) {
					$('.alert-message').each( function() {
						var alt = $('#alert-base').clone();
						alt.removeAttr('id');
						alt.addClass(type);
						alt.append(msg);
						$(this).empty().append(alt);
						alt.show();
					});
				};

				var registerProc = function(button) {

					var $keyword1 = $('#bankapp-mail-body-keywords tr.required td.keyword').first();
					var kw1 = $keyword1.text();
					if ( $('textarea#bank-app-mail-body').val().indexOf(kw1) === -1) {
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

					//--- support for disabled value
					var prdGrp = $('select[name=prd_opt]').val();
					$('#submit-group').val( prdGrp);

					var checkBoxGroup = $('#checkbox-group-flag').prop('checked') ? 1 : 0;
					$('#submit-group-flag').val( checkBoxGroup);
					//---

					var data = $('#form-register').serializeArray();

					$.ajax({
							type:"POST",
							url:"product.php",
							data:JSON.stringify(data),
							contentType: 'text/html',
							success: function(html) {
								$('#product').html(html);
							},
							error: function() {
									alert("通信エラーが発生しました。画面をリロードして設定しなおしてください");
									return false;
							},
							complete: function() {
								button.attr("disabled", false);
							}
						});
				};

				$('#checkbox-bank-flag').on( 'change', function() {

					var bankFlag = $('#checkbox-bank-flag').prop('checked') ? 1 : 0;

					if ( bankFlag) {
						$.getJSON(
								'settings.php',
								'action=check',
								function(data) {
									if ( data !== true) {
										alert('銀行情報が設定されていません。\n「設定」タブで銀行情報を設定してください');
										bankFlag = false;
										 $('#checkbox-bank-flag').prop('checked','');
									}
								}
						);
					}
					$('#input-bank-flag').val( bankFlag);
				});

				$('.form-create-btn-action').click( function(e) {

					e.preventDefault();

					$('#alert-message').empty();

					if ( !$('#prd-title').val().trim()) {
						alertMessage('alert-danger','タイトルを指定してください');
						return false;
					}

					var price = $('#prd-price').val().trim();
					if ( !price || price < 0) {
						alertMessage('alert-danger','金額を指定してください（0円以上）');
						return false;
					}

					if ( price.match(/[^0-9]+/)) {
						alertMessage('alert-danger','金額に半角数値以外の文字が含まれています');
                        return false;
					}

					var bankFlag = $('#checkbox-bank-flag').prop('checked') ? 1 : 0;
					if ( bankFlag) {
						var deadline = $('#bank-tr-deadline').val().trim();
						if ( !deadline || deadline < 1) {
							alertMessage('alert-danger','振込期限を指定してください');
							return false;
						}
					}

					$('textarea').each( function() {
						var val = $(this).val();
						if ( val) {
							$(this).val( val.trim());
						}
					});

					var button = $(this);
					button.attr("disabled", true);
					registerProc(button);
				});

				$('#sales-option').on('change', function() {
					var salesOpt = $(this).val();
					$checkBoxGroup = $('#checkbox-group-flag');
					$selectGroup = $('select[name=prd_opt]');
					if ( salesOpt === "#{SALES_OPT_USER_FREE}") {
						$checkBoxGroup.prop('checked',false).prop('disabled',true);
						$selectGroup.val(0).prop('disabled',true);
					} else if ( salesOpt === "#{SALES_OPT_NEW_USER_ONLY}") {
						$checkBoxGroup.prop('checked',true).prop('disabled',true);
						$selectGroup.prop('disabled',false);
					} else if ( salesOpt === "#{SALES_OPT_USER_ONLY}") {
						$checkBoxGroup.prop('disabled',false);
						if ( $checkBoxGroup.prop('checked')) {
							$selectGroup.prop('disabled',false);
						} else {
							$selectGroup.prop('disabled',true);
						}
					} else if ( salesOpt === "#{SALES_OPT_USER_NEED}") {
						$checkBoxGroup.prop('checked',true).prop('disabled',true);
						$selectGroup.prop('disabled',false);
					}
				}).trigger('change');

				$('#checkbox-group-flag').on('change', function() {
					var salesOpt = $('#sales-option').val();
					if ( salesOpt === "#{SALES_OPT_USER_ONLY}") {
						$('select[name=prd_opt]').prop('disabled', !$(this).prop('checked'));
					}
				});

			});
	</script>
