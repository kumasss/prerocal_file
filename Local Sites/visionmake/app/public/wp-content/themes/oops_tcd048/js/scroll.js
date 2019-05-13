jQuery(function($) {

	$(window).on('scroll', function() {

		var header = $('#js-header');
		var scrollTop = $(window).scrollTop();

		// ヘッダーを固定する
		if ($(this).scrollTop() > 300) {
      header.addClass('is-active');
    } else {
      header.removeClass('is-active');
    }
	});

});