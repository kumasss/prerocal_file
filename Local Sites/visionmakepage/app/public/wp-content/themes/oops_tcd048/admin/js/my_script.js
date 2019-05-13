jQuery(document).ready(function($){

	// アコーディオンの開閉
	$('.theme_option_field').on('click', '.theme_option_subbox_headline', function(){
  	$(this).parent('.sub_box').toggleClass('active');
   	return false;
  });

  // theme option tab
  $('#my_theme_option').cookieTab({
  	tabMenuElm: '#theme_tab',
   	tabPanelElm: '#tab-panel'
  });

	// radio button for page custom fields
  $(".ml_custom_fields_select .template li label").click(function() {
  	$(".ml_custom_fields_select .template li label").removeClass('active');
    $(this).addClass('active');
  });

  $(".ml_custom_fields_select .side_content li label").click(function () {
  	$(".ml_custom_fields_select .side_content li label").removeClass('active');
   	$(this).addClass('active');
  });

  // custom field repeater add row
  $(".field-repeater a.button-add-row").click(function(){
  	var clone = $(this).attr("data-clone");
  	var $parent = $(this).closest(".field-repeater");
  	if (clone && $parent.size()) {
    	$parent.find("table.cf_repeater tbody").append(clone);
  	}
  	return false;
  });

  // custom field repeater delete row
  $("table.cf_repeater").on("click", ".button-delete-row", function(){
  	var del = true;
  	var confirm_message = $(this).closest("table.cf_repeater").attr("data-delete-confirm");
  	if (confirm_message) {
    		del = confirm(confirm_message);
  	}
  	if (del) {
    		$(this).closest("tr").remove();
  	}
  	return false;
  });

  // theme option repeater sortable
  $('.topt_repeater').sortable({
  	placeholder: 'sortable-placeholder',
  	helper: "clone",
  	forceHelperSize: true,
  	forcePlaceholderSize: true
	});
	
  // theme option header content
	var header_content_slider = $("#header_content_slider");
	var header_content_video = $("#header_content_video");
	var header_content_youtube = $("#header_content_youtube");
  var header_content_video_catch = $("#header_content_video_catch");
  $("#header_content_button_type1").click(function() {
  	header_content_slider.show();
  	header_content_video.hide();
  	header_content_youtube.hide();
    header_content_video_catch.hide();
  });
  $("#header_content_button_type2").click(function() {
  	header_content_slider.hide();
  	header_content_video.show();
  	header_content_youtube.hide();
    header_content_video_catch.show();
  });
  $("#header_content_button_type3").click(function() {
  	header_content_slider.hide();
  	header_content_video.hide();
  	header_content_youtube.show();
    header_content_video_catch.show();
  });

  // ヘッダーコンテンツ　動画のボタン
  $(".show_video_catch_button input:checkbox").click(function(event) {
   if ($(this).is(":checked")) {
    $(this).parents('.show_video_catch_button').next().show();
   } else {
    $(this).parents('.show_video_catch_button').next().hide();
   }
  });

	// color picker
	$('.c-color-picker').wpColorPicker();

	// CTA
	var ctaType = $('.cta-type');
	var ctaContent = $('.cta-content');
	ctaType.click(function() {
		var parent = $(this).parents('.sub_box');
		parent.find('.cta-content').hide();
		parent.find('.cta-' + $(this).val() + '-content').show();
	});

	// セレクトボックスでランダム表示を選択した時のみ表示
	$('#js-cta-display').change(function() {
		if ('4' === $(this).val()) {
			$('#js-cta-random-display').removeClass('u-hidden');
		} else {
			$('#js-cta-random-display').addClass('u-hidden');
		}
	});
	$('#js-footer-cta-display').change(function() {
		if ('4' === $(this).val()) {
			$('#js-footer-cta-random-display').removeClass('u-hidden');
		} else {
			$('#js-footer-cta-random-display').addClass('u-hidden');
		}
	});
});
