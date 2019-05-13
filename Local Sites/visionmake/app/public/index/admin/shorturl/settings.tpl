			<div class="panel panel-default">

				<div class="panel-heading"></div>

				<div id="api-message"></div>

				<div class="panel-body">

					<form id="form-register" class="form-horizontal" role="form">

						<input type="hidden" name="last_short_code" value="#{$editdata->short_code}"></input>

						<div class="control-group">
							<label for="group_code" class="span2 control-label">カテゴリー</label>
							<div class="span2">
								<select name="group_code" id="group_code" class="form-control">
<?php foreach ($group_menu as $item): ?>
									<option value="#{$item->id}" <?php if ( $item->id == $editdata->group_code) echo "selected"; ?>>#{$item->name}</option>
<?php endforeach ?>
								</select>
							</div>
						</div>

						<div class="control-group">
							<label for="title" class="span2 control-label">タイトル</label>
							<div class="span8">
								<input name="title" id="dst-title" class="form-control input-xxlarge" maxlength="200" placeholder="200文字まで" value="#{$editdata->title}"></input>
							</div>
						</div>

						<div class="control-group">
							<label for="long-url" class="span2 control-label">ジャンブ先URL</label>
							<div class="span4">
								<input name="long_url" id="long-url" class="form-control input-xxlarge" maxlength="2000" placeholder="2000文字まで" value="#{$editdata->long_url}"></input>
							</div>
<!--
								<button class="btn btn-primary" id="get-title">短縮URL取得</button>
-->
						</div>

						<div class="control-group">
							<label for="long-url" class="span2 control-label">短縮コード</label>
							<div class="span5">
							<input name="short_code" id="short-code" class="form-control" maxlength="8" placeholder="英数記号1～8文字" value="#{$editdata->short_code}"></input>
<?php if ( ! $editdata->id) : ?>
								&nbsp;
								<input type="checkbox" name="auto_short_code" id="auto-short-code">&nbsp;自動作成
<?php endif ?>
							</div>
						</div>

						<div class="control-group">
							<div class="offset2">
								<button id="form-register-action" class="btn btn-primary input-xlarge"><?php echo ($editdata->id ? "更新" : "登録"); ?></button>
							</div>
						</div>

						<div class="control-group">
							<label for="short-url" class="span2 control-label">短縮URL</label>
							<div class="span8">
								<input name="short_url" id="short-url" class="form-control span5" maxlength="2000" value="#{$editdata->short_url}"></input>
								<button  id="copy-short-url" class="btn btn-primary">選択</button>
							</div>
						</div>

					</form>

<!--
						<div class="control-group">
							<div class="span2 offset1">
								<div class="checkbox">
									<label>
										<input type="checkbox">有効期限を使う
									</label>
								</div>
							</div>
						</div>

						<div class="control-group">
							<label for="date-period" class="span2 control-label">有効期限</label>
							<div class="span2">
								<input type="text" id="date-period" class="form-control datePeriod" placeholder="DATE">
							</div>
						</div>

						<div class="control-group">
							<label for="after-url" class="span2 control-label">期限後URL</label>
							<div class="span4">
								<input maxlength="255" class="form-control  input-xlarge " id="edit-after-url" placeholder="URL"></input>
							</div>
								<button class="btn btn-primary" id="edit-after-url">編集</button>
						</div>
-->
				</div><!-- end of panel-body -->

				<div class="panel-footer">
				</div>

			</div><!-- end of panel -->

<?php if ($editdata->id) : ?>
			<br/>

			<div class="container">
				<div class="row">
					<div class="span6">
						<p>※（）内は登録ページ表示回数とメール配信数の合計です</p>
					</div>
				</div>

				<div class="row">
					<div class="span4">
					<p>※年月クリックで詳細を表示します</p>
					</div>
					<div id="monthly-talbe-help" class="span4">
						<p>※月日クリックで詳細を表示します</p>
					</div>
				</div>

				<div class="row">

					<div id="yearly-table" class="span4">
						<table class="table table-hover table-bordered ">
							<thead>
								<tr>
									<th>年月</th>
									<th>アクセス数</th>
								</tr>
							</thead>
							<tbody class="table-striped">
<?php foreach ($records as $i=>$item): ?>
								<tr>
									<td><a href="monthly.php?code=#{$item['shortcode']}&y=#{$item['year']}&m=#{$item['month']}">#{$item['year']}年#{$item['month']}月</a></td>
									<td>#{$item['click']}&nbsp;(#{$item['access']})</td>
								</tr>
<?php endforeach ?>
							</tbody>
						</table>
					</div>

					<div id="monthly-table"></div>

					<div id="daily-table"></div>

				</div><!-- end of row -->

			</div><!-- end of container -->
<?php endif ?>

			<div id="alert-base" class="alert alert-dismissible" role="alert" style="display: none;">
				<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
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

				var alertMessage = function(type,msg) {
					var alt = $('#alert-base').clone(true);
					alt.removeAttr('id');
					alt.addClass(type);
					alt.append(msg);
					$('#api-message').empty().append(alt);
					alt.show();
				};


				var registerProc = function(button) {

					var data = $('#form-register').serializeArray();

					$.ajax({
							type:"POST",
							url:"regist.php",
							data:JSON.stringify(data),
							contentType: 'application/json',
//							dataType: "json",
							success: function(json_data) {
								if ( json_data.status == '1') {
									alertMessage('alert-success','新規追加しました');
//									console.log( $('#auto-short-code').prop('checked'));
									if ( $('#auto-short-code').prop('checked') == true) {
										$('#short-code').val('');
									}
									return true;
								} else if ( json_data.status == '2' || json_data.status == '0') {
									alertMessage('alert-success','更新しました');
									return true;
								} else if ( json_data.status == '3') {
									alertMessage('alert-danger','登録済みの短縮コードで新規追加はできません');
									return false;
								} else if ( json_data.status == '4') {
									alertMessage('alert-danger','保存中にエラーが発生しました。<br/>URLが不正です');
									return false;
								}
								alertMessage('alert-danger','保存中にエラーが発生しました。<br/>画面をリロードしてから再登録してください');
							},
							error: function() {
									alert("通信エラーが発生しました。画面をリロードして設定しなおしてください");
									return false;
							},
							complete: function() {
									button.attr("disabled", false);
									return true;
							}
						});
				};


				$('#form-register-action').click( function(e) {

					e.preventDefault();

					$('#api-message').empty();

					if ( !$('#dst-title').val().trim()) {
						alertMessage('alert-danger','タイトルを指定してください');
						return false;
					}

					var inputShortCode = $("input[name='short_code']").val().trim();

					if ( ! $('#auto-short-code').prop('checked')) {
						if ( ! inputShortCode) {
							alertMessage('alert-danger','短縮コードを指定してください');
							return false;
						}
					}

					var url = $('#long-url').val().trim();

					if ( url) {

						var button = $(this);
						button.attr("disabled", true);

						if ( !inputShortCode) {
							$.getJSON( 'proxy.php', function(data) {
								if ( data.status == '200') {
									if ( $('#auto-short-code').prop('checked')) {
										$('#short-code').val(data.code);
									}
									$('#copy-short-url').prev().val('%{SHORT_URL_BASE}'+data.code);
									registerProc(button);
								} else {
									alertMessage('alert-danger','短縮コードを取得できませんでした<br/>画面をリロードし再登録してください');
								}
							}).fail( function() {
								alert('通信エラーが発生したため短縮コードを取得できませんでした');
							}).always( function() {
								button.attr("disabled", false);
							});

						} else {
							if ( inputShortCode.match(/[^0-9A-Za-z\-_\.!\'\(\)]+/)) {
								alertMessage('alert-danger','短縮コードに設定できない文字・記号が含まれています');
								button.attr("disabled", false);
								return false;
							}
							if ( inputShortCode.length < 1 || inputShortCode.length > 8) {
								alertMessage('alert-danger','短縮コードは、1～8文字以内で入力して下さい');
								button.attr("disabled", false);
								return false;
							}

							$('#copy-short-url').prev().val('%{SHORT_URL_BASE}'+inputShortCode);
							registerProc(button);
						}

					} else {
						alertMessage('alert-danger','URLを指定してください');
						return false;
					}

			});

				$('#copy-short-url').click( function(e) {
					e.preventDefault();
					$(this).prev().focus().select();
				});

				$('#auto-short-code')
					.prop('checked','on')
					.click( function(e) {
							$('#short-code').prop('readonly',$(this).prop('checked'));
						});

				$('#short-code').prop('readonly',true);


				//----------------

				$('#yearly-table a').click( function(e) {
					e.preventDefault();
					$('tr').removeClass('marked');
					$(this).parents('tr:first').addClass('marked');
					var url = $(this).attr('href');
					$.ajax({
						type: "GET",
						url: url
					}).done(function(html) {
						$('#daily-table').html('');
						$('#monthly-table').html(html);
					});
				});

				$('#monthly-talbe-help').hide();

			});
		</script>
