
				<div class="modal-dialog">

					<div class="modal-content">

						<div class="modal-header">
							<h4 class="modal-title">取引詳細</h4>
						</div>

						<div class="modal-body">

							<div class="container">

<?php if ( empty($log)) : ?>
								<p class="text-center">ログは記録されていません。</p>
<?php else: ?>
								<div class="row">

									<table class="table span12">
										<thead>
											<tr>
												<th class="span2">項目</th>
												<th class="span10">値</th>
											</tr>
										</thead>
										<tbody>
<?php foreach ($log as $key=>$value) : ?>
										<tr>
											<td>#{$key}
											</td>
											<td>#{$value}
											</td>
										</tr>
<?php endforeach; ?>
										</tbody>
									</table>

								</div><!-- //end of row -->
<?php endif; ?>
							</div><!-- //end of container -->

						</div><!-- //end of modal-body -->

						<div class="modal-footer">
							<button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
						</div>

					</div><!-- /.modal-content -->

				</div><!-- /.modal-dialog -->



<script>
$(document).ready( function() {

});
</script>