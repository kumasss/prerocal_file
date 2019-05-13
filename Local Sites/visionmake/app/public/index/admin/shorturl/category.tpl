
	<div id="sys-message"></div>

	<div class="row">
			<form id="form-category-list" class="form-inline" role="form">
				<table style="width:100%;table-layout:fixed;" class="table">
					<thead>
					<tr>
						<th style="width:8%;"></th>
						<th style="width:20%;">カテゴリー名</th>
						<th style="width:60%;">説明</th>
					</tr>
					</thead>
					<tbody id="data-list">
<?php foreach ($records as $n=>$item): ?>
					<tr class="ct-val">
						<td class="span2">
		<?php if ( $item->id ) : ?>
							　<input type="checkbox" name="del" value="" class="checkbox" />&nbsp;削除
		<?php endif; ?>
							<input type="hidden" name="id" value="#{$item->id}" />
							<input type="hidden" name="row" value="#{$n+1}" />
						</td>
						<td>
							<input type="text" name="name" value="#{$item->name}" maxlength="10" class="form-controll input-medium" <?php echo ( $item->id ? '': 'placeholder="新規（10字まで）"'); ?>/>
						</td>
						<td>
							<input type="text" name="description" value="#{$item->description}" maxlength="50"  class="form-controll input-xxlarge" <?php echo ( $item->id ? '': 'placeholder="50字まで"'); ?>/>
						</td>
					</tr>
<?php endforeach ?>
					</tbody>
				</table>
			</form>
	</div>

	<div class="row">
		<div class="pull-right">
		※カテゴリーを削除した時、設定されていた短縮URLのカテゴリーは「設定なし」と表示されます
		</div>
	</div>
	<br/>
	<div class="row">
		<div class="control-group span4"></div>
		<div class="control-group span4">
			<button id="form-update-btn-action" class="btn btn-primary btn-large input-xlarge">更新</button>
		</div>
	</div>


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
					$('#sys-message').empty().append(alt)
					alt.show();
				};

				re = new RegExp('[<>&,"]+');

				$('#form-update-btn-action').click( function(e) {

					e.preventDefault();
					$('#sys-message').empty();

					var datalist = new Array();

					var noError = true;
					var row = 1;

					$('#data-list tr.ct-val').each( function(e) {

						var item = $(this).find('input:not([type=checkbox])').serializeArray();

						if ( item.length == 4
								 && item[0].name == 'id' && item[1].name == 'row' &&  item[2].name == 'name') {

							if ( re.test( item[2].value) || re.test( item[3].value)) {
								alertMessage('alert-danger','半角記号　<>&,"　は設定できません');
								noError = false;
							}

							if ( $(this).find('.checkbox').prop('checked')) {
								item[1].value = 0;
							}

							var name =  '' + item[2].value.trim();
							if ( item[0].value && name == '') {
								item[2].value = name = '-';
							}

							if ( name != '') {
								datalist.push(item);
							}

						} else {
							console.log('data format error at row '+row);
							return false;
						}
						row++;
					});


					if ( datalist.length == 0 || noError == false) {
						return false;
					}

					var button = $(this);
					button.attr("disabled", true);

					$.ajax({
						type: "POST",
						url: "category.php",
						data:JSON.stringify( datalist),
						contentType: 'application/json',
					}).done(function(html) {
						$('#category').html(html);
						button.attr("disabled", false);
					});

				});

			});
		</script>
