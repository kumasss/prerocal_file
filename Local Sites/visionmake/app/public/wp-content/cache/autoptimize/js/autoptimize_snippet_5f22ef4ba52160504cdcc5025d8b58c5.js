jQuery(function(e){e("#js-menu-button").click(function(){return e(this).toggleClass("is-active"),e("#js-global-nav").slideToggle(),!1}),e(".menu-item-has-children > a span").click(function(){return e(this).toggleClass("is-active").closest(".menu-item-has-children").toggleClass("is-active"),e(this).parent("a").next(".sub-menu").slideToggle(),!1})});