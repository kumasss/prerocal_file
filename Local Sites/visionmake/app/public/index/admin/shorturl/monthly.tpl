
					<div class="span4">
						<table class="table table-hover table-bordered ">
							<thead>
								<tr>
									<th>月日</th>
									<th>アクセス数</th>
								</tr>
							</thead>
							<tbody class="table-striped">
<?php foreach ($records as $i=>$item): ?>
								<tr>
									<td><a href="daily.php?code=#{$item['shortcode']}&y=#{$item['year']}&m=#{$item['month']}&d=#{$item['day']}">#{$item['month']}月#{$item['day']}日</a></td>
									<td>#{$item['click']}&nbsp;(#{$item['access']})</td>
								</tr>
<?php endforeach ?>
							</tbody>
						</table>
					</div>

		<script>
			$(document).ready( function() {

				$('#monthly-table a').click( function(e) {
					e.preventDefault();
					$('#monthly-table tr').removeClass('marked');
					$(this).parents('tr:first').addClass('marked');
					var url = $(this).attr('href');
					$.ajax({
						type: "GET",
						url: url
					}).done(function(html) {
						$('#daily-table').html(html);
					});
				});

				$('#monthly-talbe-help').show();

			});
		</script>
