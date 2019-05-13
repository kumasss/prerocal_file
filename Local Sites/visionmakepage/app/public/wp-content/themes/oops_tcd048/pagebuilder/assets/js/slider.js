jQuery(document).ready(function($){

  if (typeof $.fn.slick == 'undefined') return;

  $('.pb_slider').slick({
    infinite: false,
    dots: false,
    arrows: true,
    slidesToShow: 1,
    slidesToScroll: 1,
    adaptiveHeight: false,
    autoplay: true,
    fade: true,
    easing: 'easeOutExpo',
    speed: 1000,
    autoplaySpeed: 10000,
    asNavFor: '.pb_slider_nav'
  });

  $('.pb_slider_nav').slick({
    focusOnSelect: true,
    infinite: false,
    dots: false,
    arrows: false,
    slidesToShow: 7,
    slidesToScroll: 1,
    autoplay: false,
    asNavFor: '.pb_slider'
  });

});