jQuery(function(e){var t=e("#js-pagetop");if(t.hide().click(function(){return e("body, html").animate({scrollTop:0},1e3),!1}),e(window).scroll(function(){e(this).scrollTop()>100?t.fadeIn("slow"):t.fadeOut()}),e("#js-news-ticker").length&&e.simpleTicker(e("#js-news-ticker"),{effectType:"roll"}),e(".p-index-content02").length&&(e(".p-index-content02__item-catch").autoHeight({column:3}),e(".p-index-content02__item-desc").autoHeight({column:3})),e(".p-showcase__inner").length&&e(".p-showcase__inner").on("inview",function(t,i){i&&e(this).stop().addClass("is-active")}),e(".p-index-content04__carousel").length&&e(".p-index-content04__carousel").slick({autoplay:!0,dots:!0,infinite:!0,arrows:!1,slidesToShow:5,responsive:[{breakpoint:768,settings:{slidesToShow:3}}]}),e(".p-index-content07__review").length&&e(".p-index-content07__review").slick({autoplay:!0,dots:!0,infinite:!0,arrows:!1,slidesToShow:1}),e("#js-comment__tab").length){var i=e("#js-comment__tab");i.find("a").click(function(){return e(this).parent().hasClass("is-active")||(e(e(".is-active a",i).attr("href")).animate({opacity:"hide"},0),e(".is-active",i).removeClass("is-active"),e(this).parent().addClass("is-active"),e(e(this).attr("href")).animate({opacity:"show"},1e3)),!1})}});