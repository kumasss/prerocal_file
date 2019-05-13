<?php
require_once '../resources/mockdata.inc';
require_once dirname(__FILE__) . '/../config/Config.php';
?>
<!DOCTYPE html>
<!--[if lt IE 7]>	   <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>		   <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>		   <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="description" content="">
		<style>
			* {
				font-family: Verdana, "メイリオ", "ヒラギノ角ゴ Pro W3", "ＭＳ Ｐゴシック", sans-serif;
			}
		</style>

	</head>

	<body>

		<h3>ユーザー登録時のユーザー情報と商品情報との紐づけAPI 呼び出し</h3>

		<h4>
			1) Purchace: 管理画面で設定した登録ページURLに必須パラメータを付けてリクエスト
			<br/>※必須パラメータ：&order=取引ID&type=支払いタイプ
		</h4>

		<h4>
			2) Main: 登録ボタンが押されたら、取引IDが登録済みかどうかを登録ページからAPI呼び出しにて確認
		</h4>
		<p>
			<form name="api1">
				<input type="hidden" name="cmd" value="query"/>
				<div>
				[リクエストURL]
				<br/><?php echo UTAPI_URL; ?>
				<br/>[POST]
				<br/>[{"name":"cmd","value":"<?php echo UTAPI_CMD_QUERY;?>"}
				,{"name":"order","value":"<input type="text" name="order" size="12" value="<?php echo UTAPI_TEST_ORDER_ID; ?>"/>"}
				,{"name":"type","value":"
					    <select name="type">
					      <option>bank</option>
					      <option>paypal</option>
					    </select>
				"}]
				</div>
			</form>
		</p>
		レスポンスデータ： [{"result":"ok または ng"}]　※ng ならば、ユーザー登録中断

		<h4>
			3) Main: ok ならばユーザ作成後に次のAPI呼び出し
		</h4>
		<p>
			<form name="api2">
				<input type="hidden" name="cmd" value="insert"/>
				<div>
				[リクエストURL]
				<br/><?php echo UTAPI_URL; ?>
				<br/>[POST]
				<br/>[{"name":"cmd","value":"<?php echo UTAPI_CMD_INSERT;?>"}
				,{"name":"user","value":"<input type="text" name="user" size="3" value="<?php echo UTAPI_TEST_USER_ID; ?>"/>"}
				,{"name":"order","value":"<input type="text" name="order" size="12" value="<?php echo UTAPI_TEST_ORDER_ID; ?>"/>"}
				,{"name":"type","value":"
					    <select name="type">
					      <option>bank</option>
					      <option>paypal</option>
					    </select>
				"}]
				</div>
			</form>
		</p>
		レスポンスデータ： [{"result":"ok または ng"}]　※ng ならば、ユーザー登録中断

		<div>
			<br/>
			<input class="submit"  type="submit" value="テスト"/>
		</div>
		<hr/>

		<div id="result"></div>

		<script src="<?php echo URL; ?>/common/lightning/js/jquery-1.7.2.min.js"></script>
		<script src="<?php echo URL; ?>/common/lightning/js/jquery-ui-1.9.2.custom.min.js"></script>

		<script>

			$(document).ready( function() {

				$('input').keypress(function(ev) {
					if ((ev.which && ev.which === 13) || (ev.keyCode && ev.keyCode === 13)) {
						return false;
					} else {
						return true;
					}
				});

				apiUrl = '<?php echo UTAPI_URL; ?>';

				updateUser = function() {

					jsonData = JSON.stringify($( 'form[name=api2]').serializeArray());

					$.ajax({
						  type: 'POST',
					      url: apiUrl,
						  dataType: 'json',
						  data: jsonData,
						  complete: function(json){
								$('<p>').append('Res = '+json.responseText).appendTo($('#result'));
						  }
					});
				};

				$('.submit').click( function(e) {

					e.preventDefault();

					$('#result').empty();

					jsonData = JSON.stringify($( 'form[name=api1]').serializeArray());

					$('<p>').append('Req = '+jsonData).appendTo($('#result'));

					$.ajax({
						  type: 'POST',
					      url: '<?php echo UTAPI_URL; ?>',
						  dataType: 'json',
						  data: jsonData,
						  complete: function(json){
								$('<p>').append('Res = '+json.responseText).appendTo($('#result'));
								var resObj = JSON.parse(json.responseText);
								if ( resObj.result == '<?php echo UTAPI_RESULT_OK; ?>') {
									updateUser();
								}
						  }
						});
					});

			});
		</script>

	</body>
</html>