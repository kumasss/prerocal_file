
			<div class="panel panel-default">

				<div class="panel-heading">
				</div>

				<div id="api-error"></div>

				<div class="panel-body">

					<form id="form-search" class="form-inline" role="form" method="POST" action="list.php">

						<div class="control-group">
							<label for="date-start" class="control-label">クリック日付絞込</label>
							<input type="text" name="filter_date_from" id="date-from" class="form-control input-small datePeriod" placeholder="クリックして設定">
							&nbsp;～&nbsp;
							<input type="text" name="filter_date_to" id="date-to" class="form-control input-small datePeriod" placeholder="クリックして設定">

							<label for="select-filter-categories" class="control-label">&nbsp;&nbsp;カテゴリー</label>
							<select id="select-filter-categories" class="form-control chzn-select" multiple="multiple">
								<option value="all"></option>
<?php foreach ($categories as $item): ?>
								<option value="#{$item->id}">#{$item->name}</option>
<?php endforeach ?>
							</select>
							<input type="hidden" name="filter_categories" id="selected-fliter-categories">
						</div>

						<div class="control-group">
							<label for="after-url" class="control-label">&nbsp;&nbsp;検索</label>
							<input type="text" name="filter_url" maxlength="255" class="form-control input-xlarge" placeholder="URL,タイトルなど"></input>
						</div>

						<div class="control-group">
							<label for="after-url" class="control-label">並び替え</label>
							<select name="order_column" id="select-order-column" class="form-control input-small">
<?php foreach ($sort_types as $i=>$item): ?>
									<option value="#{$i}">#{$item}</option>
<?php endforeach ?>
							</select>
							<input type="hidden" name="order_categories" id="selected-order-column">
							<button class="btn btn-primary" id="form-search-action">解析</button>
							<br />
						</div>

					</form>

<?php if (empty($records)): ?>
<?php else: ?>

					<form id="form-checklist" class="form-inline" role="form">

						<div class="row">
							<div><div style="text-align:right;">※（）内は登録ページ表示回数とメール配信数の合計です。1時間毎にデータを反映します</div>
								<table style="width:100%;table-layout:fixed;" class="table table-hover table-bordered">
									<thead>
									<tr>
										<th style="width:5%;"><input type="checkbox" id="check-all"></th>
										<th style="width:10%;">カテゴリー</th>
										<th style="width:20%;">タイトル（クリックで詳細）</th>
										<th style="width:10%;">短縮URL</th>
										<th style="width:40%;">URL</th>
										<th style="width:8%;">クリック</th>
										<th style="width:12%;">登録日</th>
									</tr>
									</thead>
									<tbody id="data-list" class="table-striped">
<?php foreach ($records as $item): ?>
									<tr>
										<td><input type="checkbox" class="checkbox"></td>
										<td>
										<?php if ( isset($category_map[$item->group_code])) : ?>
											#{$category_map[$item->group_code]->name}
										<?php else : ?>
											設定なし
										<?php endif; ?>
										</td>
										<td class="key"><a href="#{$item->short_code}">#{$item->title}</a></td>
										<td>#{$item->short_code}</td>
										<td class="longurl"><a href="#{$item->long_url}"  class="popup">#{$item->long_url}</a></td>
										<td class="click-cnt">#{$item->click}&nbsp;(#{$item->access})</td>
										<td>#{$item->created->format('Y年m月d日')}</td>
									</tr>
<?php endforeach ?>
									</tbody>
								</table>
							</div>
						</div><!-- end of row -->

					</form>

					<div class="control-group">
						<label for="form-checklist-action" class="control-label">チェックしたものを</label>
							<select  id="checklist-action" class="form-control input-large">
<?php foreach ($action_menus as $i=>$item): ?>
									<option value="#{$i}">#{$item}</option>
<?php endforeach ?>
							</select>
							<button type="submit" class="btn btn-primary" id="form-checklist-action">実行</button>
					</div><!-- end of control-group -->

					<br />
					<br />
<?php endif ?>


				</div><!-- end of panel-body -->

				<div class="panel-footer">
				</div>

			</div><!-- end of panel -->



			<div  id="delete-confirm-dialog" class="modal fade">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h4 class="modal-title">確認</h4>
						</div>
						<div class="modal-body">
			      			<p>本当に削除してもよろしいですか？</p>
						</div>
						<div class="modal-footer">
							<button type="button" id="btn-delete-action" class="btn btn-primary">削除実行</button>
							<button type="button" class="btn btn-default" data-dismiss="modal">中止</button>
						</div>
					</div><!-- /.modal-content -->
				</div><!-- /.modal-dialog -->
			</div><!-- /.modal -->


		<script>

			$(document).ready( function() {

				$('td.key a').click( function(e) {
					e.preventDefault();
					$.cookie("shortCode",$(this).attr('href'), { expires: 700 });
					$('a[data-toggle="tab"]').parent().removeClass('active');
					$('a[href=#settings]').click();
				});

				$(".chzn-select").chosen({
						placeholder_text_multiple :'すべて'
				});

				$(".popup").click(function(){
					window.open(this.href,"Preview","width=600,height=500,resizable=yes,scrollbars=yes");
					return false;
				});

				var loadFiltersFromCookie = function() {
					var data = $('#form-search').serializeArray();
					$(data).each( function(k,v) {
						var val = $.cookie(v.name);
						if ( val) {
							$('#form-search input[name='+v.name+']').val(val);
						}
					});

					var txt = $('#selected-fliter-categories').val();
					$('#select-filter-categories').val( txt.split(","));
					$("#select-filter-categories").trigger('chosen:updated');

					$('#select-order-column').val( $('#selected-order-column').val());
				};

				var saveFiltersToCookie = function() {
					$('#selected-fliter-categories').val( $('#select-filter-categories').val());
					$('#selected-order-column').val( $('#select-order-column').val());
					var data = $('#form-search').serializeArray();
					$(data).each( function(k,v) {
						$.cookie(v.name,v.value, { expires: 700 });
					});
					return data;
				};

				$('#form-search-action').click( function(e) {
					e.preventDefault();
					var fromDate = $('#date-from').val();
					var toDate = $('#date-to').val();
					if ( fromDate && toDate) {
						if ( fromDate > toDate) {
							alert('日付の開始日を終了日より後に指定することはできません');
							return false;
						}
					}

					var button = $(this);
					button.attr("disabled", true);
					$.ajax({
						type: "GET",
						url: "list.php",
						data: saveFiltersToCookie(),
					}).done(function(html) {
						$('#list').html(html);
						button.attr("disabled", false);
					});
				});

				var checklist = $('#form-checklist .checkbox');
				var noChecked = function() {
					var result = true;
					checklist.each( function() {
						if ( $(this).prop('checked')) {
							result = false;
							return true;
						}
					});
					return result;
				};
				checklist.change( function() {
					if ( noChecked()) {
						$('#check-all').removeAttr('checked');
						$('#form-checklist-action').prop('disabled', true);
					} else {
						$('#form-checklist-action').prop('disabled', false);
					}
					return false;
				}).change();

				$('#check-all').click( function() {
					if ( $(this).prop('checked')){
						$('.checkbox').attr('checked','checked');
					} else {
						$('.checkbox').removeAttr('checked');
					}
					checklist.change();
				});


				var checkListAction = function() {

					var sendParam = new Array();

					var command = new Object();
					command.name = "action";
					command.value =$('#checklist-action').val();

					sendParam.push(command);

					var data = new Object();
					data.name = "codes";
					data.value = new Array();

					$('#form-checklist .checkbox').each( function() {
						if ( $(this).prop('checked')) {
							var keyCode = $(this).parent().siblings('td.key').children('a').attr('href');
							data.value.push(keyCode);
						}
					});

					if ( data.value.length > 0) {
						sendParam.push(data);

						var button = $(this);
						button.attr("disabled", true);

						$.ajax({
							type: "POST",
							url: "list.php",
							data: sendParam,
						}).done(function(html) {
							$('#list').html(html);
							button.attr("disabled", false);
						});
					}

				};

				$('#btn-delete-action').click( function(e) {
					e.preventDefault();
					$('#delete-confirm-dialog').modal('hide');
					checkListAction();
				});

				$('#form-checklist-action').click ( function(e) {

					e.preventDefault();

					var command = $('#checklist-action').val();

					if ( command == 'delete') {
						$('#delete-confirm-dialog').modal('show');

					} else {
						checkListAction();
					}
				});

				$(".datePeriod").datepicker({
					showMonthAfterYear: true,
					showAnim :   "",
					yearSuffix:  '年',
					monthNames:  ["1月","2月","3月","4月","5月","6月","7月","8月","9月","10月","11月","12月"],
					dayNames: ['日', '月', '火', '水', '木', '金', '土'],
					dayNamesMin: ["日","月","火","水","木","金","土"],
					dateFormat:  "yy-m-d",
				});

				loadFiltersFromCookie();

			});
		</script>
