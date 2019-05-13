jQuery(function($){

	/**
	 * ページトップ
	 */
	var pagetop = $('#js-pagetop');
	pagetop.hide().click(function() {
		$('body, html').animate({
			scrollTop: 0
		}, 1000);
		return false;
	});
  $(window).scroll(function() {
  	if ($(this).scrollTop() > 100) {
    	pagetop.fadeIn('slow');
    } else {
    	pagetop.fadeOut();
    }   
  }); 

	/**
	 * トップページ
	 */

	// ニュースティッカー
	if ($('#js-news-ticker').length) {
		$.simpleTicker($("#js-news-ticker"),{'effectType':'roll'});
	}

	// 3つのボックスコンテンツ
	if ($('.p-index-content02').length) {
		$('.p-index-content02__item-catch').autoHeight({column:3});
		$('.p-index-content02__item-desc').autoHeight({column:3});
	}

	// ショーケース
	if ($('.p-showcase__inner').length) {
		$('.p-showcase__inner').on('inview', function(event, isInView, visiblePartX, visiblePartY) {
			if (isInView) {
				$(this).stop().addClass('is-active');
			}
		});
	}
	
	// カルーセル
	if ($('.p-index-content04__carousel').length) {
		$('.p-index-content04__carousel').slick({
			autoplay: true,
			dots: true,
			infinite: true,	
			arrows: false,
			slidesToShow: 5,
			responsive: [
				{
					breakpoint: 768,
						settings: {
			  			slidesToShow: 3
						}
				}
			]
		});
	}

	// レビューリスト
	if ($('.p-index-content07__review').length) {
		$('.p-index-content07__review').slick({
			autoplay: true,
			dots: true,
			infinite: true,	
			arrows: false,
			slidesToShow: 1
		});
	}

	/**
	 * ブログ詳細
	 */
	if ($('#js-comment__tab').length) {
		var commentTab = $('#js-comment__tab');
		commentTab.find('a').click(function() {
			if (!$(this).parent().hasClass('is-active')) {
				$($('.is-active a', commentTab).attr('href')).animate({opacity: 'hide'}, 0);
				$('.is-active', commentTab).removeClass('is-active');
				$(this).parent().addClass('is-active');
				$($(this).attr('href')).animate({opacity: 'show'}, 1000);
			}
			return false;
		});
	}
});	
