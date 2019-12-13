$(document).ready(function () {
    var swiper = new Swiper('#nav-opt1', {
        slidesPerView: 10,
        spaceBetween: 6,
        watchOverflow: true,
        freeMode: true,
        scrollbar: {
            el: '.swiper-scrollbar',
            hide: false,
        },
        breakpoints: {
            // when window width is <= 410px
            410: {
                slidesPerView: 2.2,
                spaceBetween: 10,
            },
            // when window width is <= 480px
            480: {
                slidesPerView: 2.5,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 3.3,
                spaceBetween: 14
            },
            // when window width is <= 992px
            992: {
                slidesPerView: 4.5,
                spaceBetween: 15
            }
        },
    });
});