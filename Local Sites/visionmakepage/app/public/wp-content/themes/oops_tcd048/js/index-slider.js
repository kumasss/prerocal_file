function index_slider(delay) {
	var indexSlider = jQuery('#js-index-slider');
	var indexSliderItem = jQuery('.p-index-slider__item', indexSlider);
	var sliderNum = indexSliderItem.length;
	var index = 0;
	var speed = 1000;
	indexSliderItem.first().addClass('is-active');	
	// スライドが2枚以上の時のみ、スライドの入れ替えを行う
	if (sliderNum > 1) {
		var timer = setInterval(function() {
			index = (index + 1) % sliderNum;
			jQuery('.is-active', indexSlider).fadeOut(speed).removeClass('is-active');
			indexSliderItem.eq(index).fadeIn(speed).addClass('is-active');
		}, 8000);
	}
}
