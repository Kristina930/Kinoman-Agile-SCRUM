$(function(){
    $('#load').css({opacity: 1.0, visibility: "visible"}).animate({opacity: 0}, 400);
    $('#load').promise().done(function(){
        $('#load').css('zIndex',-1);
    });
  });


const sliderMain = new Swiper(".slider_main", {
    // freeMode: true,
    // centeredSlides: true,
    mousewheel: false,
    parallax: false,
    loop: true,
    loopAdditionalSlides: 0,
    breakpoints: {
        320: {
            slidesPerView: 2,
            spaceBetween: 20,
        },
        480: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
        680: {
            slidesPerView: 4,
            spaceBetween: 20,
        },
    },
    slidesPerGroup: 4,
    speed: 1000,
    navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
    },
    pagination: {
        el: '.collections-pagination',
        clickable: false,
        renderBullet: function (index, className) {
            return '<div class="' + className + '">' +  
            '</div>';
        },
    },
});
