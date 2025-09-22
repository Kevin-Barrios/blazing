$(document).ready(function(){
    // Slider de productos premium
    $(".intro-slider").owlCarousel({
        items: 3,          // cantidad visible
        margin: 20,
        loop: true,
        autoplay: true,
        autoplayTimeout: 3000,
        autoplayHoverPause: true,
        dots: true,
        nav: true,
        navText: [
            "<i class='fa fa-chevron-left'></i>",
            "<i class='fa fa-chevron-right'></i>"
        ],
        responsive:{
            0:{ items:1 },
            600:{ items:2 },
            1000:{ items:3 }
        }
    });

    // Hero slider (por si luego agregas más imágenes)
    $(".hero-slider").owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 4000,
        nav: false,
        dots: true
    });
});
