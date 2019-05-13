
									<span class="status span1">#{$item->jstatus}</span>
									<span class="pull-right">

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
									</span>
									<span id="x-cf-user-name" data-x-cf-user-name="#{$item->x_cf_user_name}"></span>
									<span id="x-payment-amount" data-x-payment-amount="#{$item->x_payment_amount}円"></span>
