jQuery(function($){

	/**
	 * グローバルナビゲーション
	 */
	$('#js-menu-button').click(function() {
		$(this).toggleClass('is-active');
		$('#js-global-nav').slideToggle();		
		return false;
	});
	$('.menu-item-has-children > a span').click(function() {
		$(this).toggleClass('is-active').closest('.menu-item-has-children').toggleClass('is-active');
		$(this).parent('a').next('.sub-menu').slideToggle();
		return false;
	});

});	
