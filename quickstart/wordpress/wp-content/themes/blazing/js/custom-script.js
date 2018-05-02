jQuery(document).ready(function($) {
    jQuery('.nav li.dropdown').find('.mobile-eve').each(function() {
        jQuery(this).on('click', function(event) {
            event.preventDefault();
            if (jQuery(window).width() < 768) {
                var nav = $(this).parent().parent();
                if (nav.hasClass('open')) {
                    nav.removeClass('open');
                } else {
                    nav.addClass('open');
                }
            }
            return false;
        });
    });


    $(window).scroll(function() {
        if ($(window).width() > 768) {
            if ($(this).scrollTop() > 100) {
                $('.site-header').addClass('sticky-head');
            } else {
                $('.site-header').removeClass('sticky-head');
            }
        } else {
            if ($(this).scrollTop() > 100) {
                $('.site-header').addClass('sticky-head');
            } else {
                $('.site-header').removeClass('sticky-head');
            }
        }
    });

    $(document).on('click', '.product-categories .cat-parent', function(event) {
        event.preventDefault();
        if ($(this).hasClass('show-cat-child')) {
            $(this).removeClass('show-cat-child');
        } else {
            $(this).addClass('show-cat-child');
        }
    });

    $('.nav-pills a').click(function(e) {
        e.preventDefault();
        $(this).tab('show');
    });


    /* Lignt Box*/
    var blog_carousel = $('.blog-carousel .post-zoom').simpleLightbox();
    var blog_gallery = $('.blog-gallery .post-zoom').simpleLightbox();

    new WOW().init();

});

jQuery(document).ready(function($) {
    
    $(".home-carousel").owlCarousel({
        loop: true,
        items: 1,
        nav: true,
        dots: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                dots: false,
            },
            500: {
                dots: true,
            }
        }
    });

    $(".newproducts-carasol").owlCarousel({
        loop: true,
        items: 5,
        margin: 20,
        nav: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            300: {
                items: 2,
            },
            667: {
                items: 3,
            },
            991: {
                items: 4,
            },
            1170: {
                items: 5,
            }
        }
    });

    $(".featured-products-carousel").owlCarousel({
        loop: true,
        items: 5,
        margin: 30,
        nav: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
            },
            600: {
                items: 3,
                nav: true,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
            },
            1030: {
                items: 4,
                nav: true,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
            },
            1360: {
                items: 5,
                nav: true,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
            }
        }
    });

    $(".blog-carousel").owlCarousel({
        loop: true,
        items: 3,
        nav: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
                nav: true,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
            },
            600: {
                items: 2,
                nav: true,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
            },
            992: {
                items: 3,
                nav: true,
                navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']
            }
        }
    });

    $(".deals-carousel").owlCarousel({
        items: 1,
        loop: true,
        dots: true,
        navText: ['Previous Deal', 'Next Deal'],
        navClass: ["owl-prev", "owl-next"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            448: {
                items: 2,
            },
            768: {
                items: 1,
            },
        }
    });

    $(".tabs-carousel").owlCarousel({
        items: 4,
        loop: true,
        nav: true,
        margin: 25,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        navClass: ["owl-prev", "owl-next"],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            700: {
                items: 2,
            },
            1100: {
                items: 3,
            },
        }
    });
    $(".testimonial-carousel").owlCarousel({
        loop: true,
        items: 1,
        nav: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>']

    });
    $(".team-carousel").owlCarousel({
        loop: true,
        items: 5,
        margin: 30,
        nav: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            500: {
                items: 2,
            },
            709: {
                items: 3,
            },
            992: {
                items: 4,
            },
            1200: {
                items: 5,
            },
        }

    });
    $(".brands-carousel").owlCarousel({
        loop: true,
        items: 5,
        margin: 30,
        nav: true,
        navText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        responsiveClass: true,
        responsive: {
            0: {
                items: 1,
            },
            500: {
                items: 2,
            },
            709: {
                items: 3,
            },
            992: {
                items: 4,
            },
            1200: {
                items: 5,
            },
        }

    });


    $(document).scroll(function() {
        var top = $(document).scrollTop();
        if (top > 300) {
            $('.backbtn').show();
        } else {
            $('.backbtn').hide();
        }
    });
});