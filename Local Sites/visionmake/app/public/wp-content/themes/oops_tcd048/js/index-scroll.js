jQuery(function($) {

	var header = $('#js-header');
	var globalNav = $('.p-global-nav');
	var currentMenuClassName = 'current-menu-item';	
	
	$(window).on('scroll.onepagescroll', '', onScroll);

	$('.p-global-nav a[href^="#"]').click(function(e) {
		
		e.preventDefault();
		$(window).off('onepagescroll');

		if (!$(this).parent().hasClass(currentMenuClassName)) {

			$('.' + currentMenuClassName).removeClass(currentMenuClassName);
			$(this).parent().addClass(currentMenuClassName);
			
			// スクロール
			if ($(window).width() <= 991 ) {
				$('body, html').animate({
					scrollTop: $($(this).attr('href')).offset().top  - header.height() // ヘッダーの高さと微調整
				}, 1000, '', function() {
				});
			} else {
				$('body, html').animate({
					scrollTop: $($(this).attr('href')).offset().top  - 70 + 1 // ヘッダーの高さと微調整
				}, 1000, '', function() {
					$(window).on('scroll.onepagescroll', '', onScroll);
				});
			}

		}
	});

	function onScroll() {

		var scrollTop = $(window).scrollTop();

		// ヘッダーを固定する
		if ($(this).scrollTop() > 300) {
      header.addClass('is-active');
    } else {
      header.removeClass('is-active');
    }

		globalNav.find('a[href^="#"]').each(function() {
				
			var target = $($(this).attr('href'));
			
			// ターゲットが存在しない場合を除外する
			if (target.length) {
				
				// コンテンツの位置を取得
				var targetPosition = target.offset().top;
				targetPosition = targetPosition - 70; // ヘッダーの高さと微調整
				
				// スクロール位置がターゲットコンテンツに含まれる時、カレント表示する
				if (targetPosition <= scrollTop && scrollTop <= targetPosition + target.height()) {
					if (!$(this).parent().hasClass(currentMenuClassName)) {
						globalNav.find('.' + currentMenuClassName ).removeClass(currentMenuClassName);
						$(this).parent().addClass(currentMenuClassName);
					}
				}
			}
		});
	}

});
