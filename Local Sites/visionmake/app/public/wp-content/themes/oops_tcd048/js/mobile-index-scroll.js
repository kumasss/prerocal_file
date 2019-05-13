jQuery(function($){

	/**
	 * スクロール
	 */
	$('a[href^="#"]').click(function() {
		var target = $($(this).attr('href'));
		if (target.length) {
			var targetPosition = target.offset();
			$('body, html').animate({
				scrollTop: targetPosition.top + 'px'
			}, 1000);
			return false;
		}
	});
});
