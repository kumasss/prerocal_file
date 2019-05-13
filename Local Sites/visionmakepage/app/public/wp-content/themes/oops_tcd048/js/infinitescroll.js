function init_post_list(target, maxPage, finishedMsg, imgPath) {
	var $container = jQuery('#js-infinitescroll');
  $container.imagesLoaded(function(){
  	jQuery(target, '#js-infinitescroll').each(function(i){
    	jQuery(this).delay(i*150).queue(function(){
	    	jQuery(this).addClass('is-active').dequeue();
   		});
   	});
	  $container.infinitescroll({
	  	navSelector  : '#js-load-post',
	    nextSelector : '#js-load-post a',
	    itemSelector : target,
	    animate      : true,
	    extraScrollPx: 150,
	    maxPage: maxPage,
	    loading: {
	    	msgText : 'LOADING...',
	      finishedMsg : finishedMsg,
	      img: imgPath
	    }
	  },
		// callback
		function(newElements, opts) {
	  	var $newElems = jQuery(newElements);
	   	$newElems.imagesLoaded(function(){
	    	$newElems.each(function(i){
	      	jQuery(this).delay(i*150).queue(function(){
	        	jQuery(this).fadeTo('slow', 1).dequeue();
					});
	      });
			});
			if (opts.maxPage && opts.maxPage <= opts.state.currPage) {
	  		jQuery(window).off('.infscr');
	  	  jQuery('#js-load-post').remove();
	  	}
		});
	});
}
