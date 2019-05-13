
	<div class="row">
		<form id="search-keywords">
		<table class="table">
			<thead>
				<tr>
					<th>タイトル or 商品ID指定</th>
					<th>取引ID指定</th>
					<th>決済メールアドレス指定</th>
					<th>会員名・メールアドレス指定</th>
				</tr>
			</thead>
			<tbody>
					<td>
						<input type="text" name="trxs_title" placeholder="タイトルもしくは商品ID"/>
					</td>
					<td>
						<input type="text" name="trxs_txnid" placeholder="取引ID"/>
					</td>
					<td>
						<input type="text" name="trxs_email" placeholder="決済メールアドレス"/>
					</td>
					<td>
						<input type="text" name="trxs_username" placeholder="会員名・メールアドレス"/>
					</td>
			</tbody>
		</table>
		</form>
	</div>

	<div class="row">

		<form class="form-horizontal">
			<input type="hidden" id="search-filters" name="search_filters" value="" />
			<div class="span4">
				<div class="control-group">
					<label  class="control-label" for="filter-buttons1">「決済先」絞り込み</label>
					<div id="filter-buttons1" class="btn-group controls search-filter-buttons" data-toggle="buttons-checkbox">
					  <button type="button" class="btn" name="paypal">PayPal</button>
					  <button type="button" class="btn" name="bank">銀行</button>
					</div>
				</div>
			</div>
			<div class="span6">
				<div class="control-group">
					<label  class="control-label" for="filter-buttons2">「取引状態」絞り込み</label>
					<div id="filter-buttons2" class="btn-group controls search-filter-buttons" data-toggle="buttons-checkbox">
					  <button type="button" class="btn" name="<?php echo STATUS_COMPLETED; ?>">完了</button>
					  <button type="button" class="btn" name="<?php echo STATUS_UNKNOWN; ?>">不明</button>
					  <button type="button" class="btn" name="<?php echo STATUS_REFUNDED; ?>">返金</button>
					  <button type="button" class="btn" name="<?php echo STATUS_UNCONFIRMED; ?>">未確認</button>
					  <button type="button" class="btn" name="<?php echo STATUS_CANCELED; ?>">キャンセル</button>
					</div>
				</div>
			</div>
			<div class="span1">
				<button type="button" id="form-search-action" class="btn btn-primary btn-xxlarge">検索</button>
			</div>

		</form>

	</div>

	<div class="panel panel-default">

		<div id="sys-message"></div>

<?php if ( count($records) > 0) : ?>
		<div class="row">
			<div class="span4">
			該当件数： <span id ="total-records">#{$total_records}</span>　件
			</div>
			<div class="span4">
				<span id="pager"></span>
			</div>
			<div class="span4">
				<div class="input-group">
				  <span class="input-group-addon">表示件数：</span>
					<select name="items_onpage_option" id="items-onpage-option" class="form-control">
						<option value="50">50</option>
						<option value="100">100</option>
						<option value="150">150</option>
						<option value="300">300</option>
					</select>
				</div>
			</div>
		</div>
<?php endif;?>

		<div class="panel-body">

			<form id="form-checklist" class="form-inline" role="form">

				<div class="row">
						<table style="width:100%;table-layout:fixed;" class="table table-bordered">
<?php if ( count($records) > 0) : ?>
							<thead>
								<tr style="background: aliceblue;">
									<th style="width:30%;">日時・タイトル</th>
									<th style="width:12%;">決済先・金額</th>
									<th style="width:30%;">取引ID＋振込名・メールアドレス</th>
									<th>状態・会員メールアドレス</th>
								</tr>
							</thead>
<?php endif;?>
							<tbody id="data-list" class="table-bordered">
<?php foreach ($records as $index=>$item): ?>
							<tr style="background: <?php echo ($index%2 == 0 ? 'white' : '#eaeef4'); ?>;">
								<td class="pop-data">
								#{$item->order_time}
								</td>

								<td class="pop-data">
								#{$item->x_payment_by}
								</td>

								<td class="pop-data">
						<?php if ( $item->txn_id) :?>
									<a href="paypal_log.php?txn=#{$item->txn_id}" class="popup-detail-link">#{$item->txn_id}</a>
						<?php elseif ( $item->bank_txn_id) : ?>
											#{$item->bank_txn_id}　#{$item->x_account}
						<?php endif;?>
								</td>

								<td class="rewritable">

									<span class="status span1">#{$item->jstatus}</span>
									<span class="pull-right">

<?php if ( !empty($item->cmdArray)): ?>

	<?php foreach ($item->cmdArray as $cmd) :?>

		<?php if ( $cmd->display) : ?>

										<button class="btn #{$cmd->cmdStlCls} state-action">#{$cmd->cmdName}</button>
										<input type="hidden" name="action" value="#{$cmd->cmdStatus}"/>

			<?php if ( $item->txn_id) :?>
										<input class="cmd-param" type="hidden" name="txn_id" value="#{$item->txn_id}"/>
										<input class="cmd-param"  type="hidden" name="payment_type" value="PAYPAL"/>
			<?php elseif ( $item->bank_txn_id) : ?>
										<input class="cmd-param"  type="hidden" name="txn_id" value="#{$item->bank_txn_id}"/>
										<input class="cmd-param"  type="hidden" name="payment_type" value="BANK"/>
			<?php endif; ?>

									<span class="state-change-message">
										#{$cmd->cmdChgMsg}
									</span>
		<?php endif; ?>
	<?php endforeach;?>

<?php endif;?>
									</span>

								</td>
							</tr>

							<tr style="background: <?php echo ($index%2 == 0 ? 'white' : '#eaeef4'); ?>;">
								<td class="tddash pop-data">
								#{$item->short_title}
								</td>

								<td class="tddash pop-data rewritable payment-amount">
								#{$item->x_payment_amount}円
								</td>

								<td class="tddash pop-data">
								#{$item->x_account_mail}
								</td>

								<td class="tddash pop-data rewritable user-name">
								#{$item->x_cf_user_name}
								</td>

							</tr>
<?php endforeach ?>
							</tbody>
						</table>
					</div>
				</div><!-- end of row -->

			</form>


		</div><!-- end of panel-body -->
	</div><!-- end of panel -->

	<div  id="detail-dialog" class="modal fade">
	</div><!-- /.modal -->

	<div  id="command-confirm-dialog" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">状態変更の確認</h4>
				</div>
				<div class="modal-body">
					<table class="table table-bordered action-detail">
					</table>
				</div>
				<div class="modal-footer state-action-off">
	      			<div class="center-block">
						<button type="button" class="btn btn-default  btn-large" data-dismiss="modal">閉じる</button>
					</div>
				</div>
				<div class="modal-footer state-action-on">
	      			<div class="center-block">
		      			<span style="font-size:24px;">実行してもよろしいですか？</span>
						<button type="button" id="btn-command-action" class="btn btn-primary btn-large">はい</button>
						<button type="button" class="btn btn-default  btn-large" data-dismiss="modal">いいえ</button>
					</div>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<div  id="command-user-matching-dialog" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">ユーザー検索</h4>
				</div>
				<div class="modal-body">
					<table class="table table-bordered action-detail">
					</table>
					<div id="user-search-form">
						<div class="modal-body">
							取引情報とユーザー情報を紐づけられませんでした。手動で紐づけを行ってください。
						</div>
						<div class="modal-body">
							<form class="form-inline" role="search" method="post" action="user_matching.php">
								<input type="hidden" name="command" value="Search"/>
								<div class="form-group">
									<label>名前：</label>
									<input name="search_name" class="form-control input-small" maxlength="200"></input>
									　
									<label>email：</label>
									<input name="search_email" class="form-control" maxlength="100"></input>
									　
									<button  id="user-search-btn" class="btn btn-primary">検索</button>
								</div>
							</form>
							<div id="user-search-result"></div>
						</div>
					</div>
				</div>

				<div class="modal-footer">
	      			<div class="center-block">
						<button type="button" class="btn btn-default" data-dismiss="modal">キャンセル</button>
					</div>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<script>

		$(document).ready( function() {

			var saveKeywords = function() {
				$('form#search-keywords :input').each( function() {
					$.cookie( $(this).attr('name'), $(this).val().trim(), { expires: 700 });
				});
			}

			var getFilters = function() {
				var arr =  new Array();
				$('.search-filter-buttons .btn').each( function() {
					if ( $(this).hasClass('active')) {
						arr.push( $(this).attr('name'));
					}
				});
				return arr;
			};

			var loadFiltersFromCookie = function() {

				var val = $.cookie('trx-filters');

				if ( val) {
					var arr = val.split(",");
					for ( var i=0; i < arr.length; i++) {
						var selector = '.search-filter-buttons button[name='+arr[i]+']';
						$(selector).addClass('active');
					}
				}

				$('form#search-keywords :input').each( function() {
					var name = $(this).attr('name');
					if ( name) {
						$(this).val( $.cookie(name));
					}
				});

			};

			loadFiltersFromCookie();

			$('#form-search-action').click( function(e) {

				e.preventDefault();

				// save filters to cookie
				saveKeywords();
				$.cookie('trx-filters', getFilters(), { expires: 700 });

				var button = $(this);
				button.attr("disabled", true);
				$.ajax({
					type: "GET",
					url: "transaction.php",
			        timeout: 10000,
				}).done(function(html) {
					$('#transaction').html(html);
					button.attr("disabled", false);
				});

			});

			var saftyArg = function(default_value, opt_arg, opt_callback) {
				  if (opt_arg === undefined) {
				    return default_value;
				  }
				  if (opt_callback === undefined) {
				    return opt_arg;
				  }
				  return opt_callback(default_value, opt_arg);
			};

			$('#pager').pagination({
		        items:  saftyArg(100,$('#total-records').text()),
		        itemsOnPage: saftyArg(50,$.cookie('trx-items-onpage')),
		        currentPage: saftyArg(1,$.cookie('trx-draw-page')),
		        cssStyle: 'light-theme',
		        prevText: '<<',
		        nextText: '>>',
			    onPageClick: function(pageNum) {
					$.cookie('trx-draw-page', pageNum, { expires: 700 });
					$('#form-search-action').click();
			    },
			    onInit: function() {
					var itemsOnPage =  $.cookie('trx-items-onpage');
					if ( itemsOnPage) {
						$('#items-onpage-option option').each( function() {
							$(this).prop('selected', $(this).val() == itemsOnPage);
						});
					}
				}
		    });

			$('#items-onpage-option').on('change',function() {
				var itemsOnPage = $(this).val();
				$.cookie('trx-items-onpage', itemsOnPage, { expires: 700 });
				$('#pager').pagination('updateItemsOnPage', itemsOnPage);
			});


			$('.popup-detail-link').click( function(e) {
				e.preventDefault();
				$.ajax({
					type:"GET",
					url:  $(this).attr('href'),
			        timeout: 10000,
					success: function(html) {
						$('#detail-dialog').html(html).modal('show');
					},
					error: function() {
							alert("通信エラーが発生しました。画面をリロードして設定しなおしてください");
							return false;
					},
					complete: function() {
					}
				});
			});


			var sendParam;
			var $updateElem;
			var $updateElem2;
			var $updateElem3;

			postAction =  function() {

				$.ajax({
			        type: "POST",
					url: "transaction.php",
			        data: sendParam,
			        cache: false,
			        timeout: 30000,
					success: function(html) {
						$updateElem.empty().append(html).effect('highlight',{},2000);
						var $retUserName = $('span#x-cf-user-name',$updateElem);
						if ( $retUserName) {
							var userName = $retUserName.data('x-cf-user-name');
							$updateElem2.text(userName).effect('highlight',{},2000);
							$retUserName.remove();
						}
						var $retPaymentAmount = $('span#x-payment-amount',$updateElem);
						if ( $retPaymentAmount) {
							var paymentAmount = $retPaymentAmount.data('x-payment-amount');
							$updateElem3.text(paymentAmount).effect('highlight',{},2000);
							$retPaymentAmount.remove();
						}
					},
					complete: function() {
					}
				});
			};

			$('#btn-command-action').on('click', function(e) {
				e.preventDefault();
				$('#command-confirm-dialog').modal('hide');
				postAction();
			});

			$('#user-search-btn').on('click',function(e) {

				e.preventDefault();

				var val_name = $('#user-search-form input[name=search_name]').val();
				var val_email = $('#user-search-form input[name=search_email]').val();

				$("#user-search-result").empty().append('<<検索中です>>');

				$('#command-user-matching-dialog button').each( function() {
					$(this).attr("disabled", true);
				});

				$.getJSON(
						"user_matching.php"
						,{
							action:'Search'
							,search_name:val_name
							,search_email:val_email
						}
					)
					.success( function(result) {

								var table = $('<table class="table table-bordered"><thead><tr><td>氏名</td><td>email</td><td>紐付け対象</td></tr></thead>');

								for(var i=0;i<result.length;i++) {

									var row = $('<tr>')
										.append('<td>'+result[i].firstname+"　"+result[i].lastname)
										.append('<td>'+result[i].email)
										.append('<td><button class="btn btn-primary command-action">確定</button><input type="hidden" name="user" value="'+result[i].id+'">');

									table.append(row);
								}
								resultData = table;

							$("#user-search-result").empty().append(resultData);
					})
					.error( function(jqXHR, textStatus, errorThrown) {
						$("#user-search-result").empty().append(jqXHR.responseText);
					})
					.complete(function() {
						$('#command-user-matching-dialog button').each( function() {
							$(this).attr("disabled", false);
						});
					});

			});

			$(document).on('click','.command-action', function(e) {

				e.preventDefault();
				e.stopPropagation();

				$(this).parents('tr').addClass('mark-tr');

				if ( confirm("確定してもよろしいですか？")) {

					var $form = $('<form/>');
					$form.append( $(this).next('input[type=hidden]').clone());
				    targetParam = $form.serializeArray();

				    sendParam = sendParam.concat(targetParam);

				    if ( Object.keys(sendParam).length == 0) {
					    return false;
				    }

				    $('#command-user-matching-dialog').modal('hide');

				    postAction();
				}

				$(this).parents('tr').removeClass('mark-tr');

			});

			$(document).on('click','.state-action', function(e) {

				e.preventDefault();
				e.stopPropagation();

				var $form = $('<form/>');

				//set action command
				$form.append( $(this).next('input[type=hidden]').clone());

			    $(this).siblings('input[type=hidden].cmd-param').each( function() {
				    $form.append( $(this).clone());
			    });

			    var type = $(this).siblings('input[type=hidden].cmd-param[name=payment_type]').eq(0).val();
			    if ( type == 'PAYPAL') {
				    $('.state-action-off').show();
				    $('.state-action-on').hide();
			    } else {
				    $('.state-action-on').show();
				    $('.state-action-off').hide();
				}

			    sendParam = $form.serializeArray();

			    if ( Object.keys(sendParam).length == 0) {
				    return false;
			    }

				var detail1 = $(this).parents('tr').first();
			    var detail2 = detail1.next();

			    $updateElem = $('.rewritable',detail1);
			    $updateElem2 = $('.rewritable.user-name',detail2);
			    $updateElem3 = $('.rewritable.payment-amount',detail2);

			    var data = '<thead><tr style="background: aliceblue;">';
			    data += '<th style="width:30%;">日時・タイトル</th><th style="width:12%;">決済先・金額</th>';
			    data += '<th style="width:30%;">取引ID＋振込名・メールアドレス</th><th>状態・会員名</th></tr></thead>';

			    data += '<tr>';
			    detail1.children('.pop-data').each( function() {
				    data += '<td>'+$(this).text().trim()+'</td>';
			    });
			    statusText = '';
			    detail1.find('.status').each( function() {
				    statusText = $(this).text().trim();
				    data += '<td>'+statusText+'</td>';
			    });
			    data += '</tr><tr>';
			    detail2.children('.pop-data').each( function() {
				    data += '<td>'+$(this).text().trim()+'</td>';
			    });
			    data += '</tr>';

			    var message = $('~ span.state-change-message',this).first().html();
			    if ( message) {
		        	data += '<tr class="tr-cmd-warn"><td colspan="4">'+message+'</td></tr>';
			    }

				if ( $(this).hasClass('action-matching')) {

					$.ajax({
				        type: "GET",
						url: "user_matching.php",
				        data: sendParam,
				        cache: false,
				        timeout: 10000,
				        statusCode: {
				        	 404: function(resp) {
					        	 $('#command-user-matching-dialog table.action-detail').empty().append(data);
					        	 $('#command-user-matching-dialog').modal('show');
				        	 },
				        	 200: function() {
//					        	 data += '<tr><td colspan="4"><span style="font-size:24px;"><center>'+statusText+' → <strong>完了</strong></center></span></td></tr>';
					        	 $('#command-confirm-dialog table.action-detail').empty().append(data);
					        	 $('#command-confirm-dialog').modal('show');
							}
				        },
					});

				} else {

					var stateText = $(this).text();
//		        	 data += '<tr><td colspan="4"><span style="font-size:24px;"><center>'+statusText+' → <strong>' + stateText + '</strong></center></span></td></tr>';
					$('#command-confirm-dialog table.action-detail').empty().append(data);
					$('#command-confirm-dialog').modal('show');
				}

				return false;

			});

		});
	</script>
