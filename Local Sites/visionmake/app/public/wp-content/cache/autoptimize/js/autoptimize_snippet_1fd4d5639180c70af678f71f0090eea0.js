jQuery(document).ready(function(t){t("#js-cta").on("inview",function(c,a){var n;n=t(this).hasClass("p-cta--1")?1:t(this).hasClass("p-cta--2")?2:3,a&&(t.ajax({type:"post",url:tcd_cta.admin_url,data:{action:"tcd_cta_impression",security:tcd_cta.ajax_nonce,cta_index:n},success:function(){},error:function(){},complete:function(){}}),t("#js-cta").off("inview"))}),t("#js-cta__btn").click(function(){var c,a=t(this).parents("#js-cta");c=a.hasClass("p-cta--1")?1:a.hasClass("p-cta--2")?2:3,t.ajax({type:"post",url:tcd_cta.admin_url,data:{action:"tcd_cta_click",security:tcd_cta.ajax_nonce,cta_index:c},success:function(){},error:function(){},complete:function(){}})}),t("#js-cta-conversion").on("inview",function(c,a){a&&(t.ajax({type:"post",url:tcd_cta.admin_url,data:{action:"tcd_cta_conversion",security:tcd_cta.ajax_nonce},success:function(){},error:function(){},complete:function(){}}),t("#js-cta-conversion").off("inview"))}),t(".js-cta-reset").click(function(c){var a=t(this).parents(".c-ab-table");if(c.preventDefault(),window.confirm(tcd_cta.confirm_text)){var n=t(this).data("cta-index");t.ajax({type:"post",url:tcd_cta.admin_url,data:{action:"tcd_cta_reset",security:tcd_cta.ajax_nonce,cta_index:n},success:function(){var t=a.find(".c-ab-table__row").eq(n);t.find(".c-ab-table__impression").text("0"),t.find(".c-ab-table__click").text("0"),t.find(".c-ab-table__ctr").text("0%"),t.find(".c-ab-table__conversion").text("0"),t.find(".c-ab-table__cvr").text("0%")},error:function(){},complete:function(){}})}})});