
					<div class="span4">
						<table class="table table-hover table-bordered ">
							<thead>
								<tr>
									<th>時間</th>
									<th>アクセス数</th>
								</tr>
							</thead>
							<tbody class="table-striped">
<?php foreach ($records as $i=>$item): ?>
								<tr>
									<td>#{$item['hour']}時</td>
									<td>#{$item['click']}&nbsp;(#{$item['access']})</td>
								</tr>
<?php endforeach ?>
							</tbody>
						</table>
					</div>

