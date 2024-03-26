$(document).ready(function () {

    $('.scrollto').click(function () {
        $('body,html').animate({
            scrollTop:$('#' + $(this).data('value')).offset().top - 76
        }, 1000)
    });

    $(window).scroll(function () {
        if ($(this).scrollTop() > 150) {
            $('#back-to-top').fadeIn();
        } else {
            $('#back-to-top').fadeOut();
        }
    });
    $('#back-to-top').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 200);
        return false;
    });


    // Дропдаун-меню при наведении курсора
    $(".dropdown").hover(
        function () {
            $('>.dropdown-menu', this).stop(true, true).show();
            $(this).addClass('open');
        },
        function () {
            $('>.dropdown-menu', this).stop(true, true).hide();
            $(this).removeClass('open');
        }
    );

    // Hamburger button changer
    document.addEventListener('click',function(e) {
        if (e.target.classList.contains('hamburger-toggle'))
            e.target.children[0].classList.toggle('active');
    })

    $('.owl123auto').owlCarousel({
        loop: true,
        responsiveClass: true,
        margin: 30,
        nav: true,
        navText : ['<span class="icon-angle-left"></span>', '<span class="icon-angle-right"></span>'],
        autoplay: true,
        responsive:{
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });
    $('.owl124').owlCarousel({
        loop: true,
        responsiveClass: true,
        margin: 26,
        nav: true,
        navText : ['<span class="icon-angle-left"></span>', '<span class="icon-angle-right"></span>'],
        responsive:{
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 4
            }
        }
    });
    $('.owlPalette').owlCarousel({
        loop: false,
        responsiveClass: true,
        margin: 5,
        nav: true,
        navText : ['<span class="icon-left-open"></span>', '<span class="icon-right-open"></span>'],
        dots: false,
        responsive:{
            0:{
                items: 3
            },
            600:{
                items: 4
            },
            1000:{
                items: 5,
                mouseDrag: false
            }
        }
    });
    $('.owl-carousel').owlCarousel();

    // Изображение товара с зумом при наведении
    $('#zoom_01').elevateZoom({
        gallery:'gallery_01', cursor: 'pointer', galleryActiveClass: "active", loadingIcon: "/public/img/loading.png",
        zoomType: "inner",
        cursor: "crosshair",
        zoomWindowFadeIn: 500,
        zoomWindowFadeOut: 750
    });
    $("#zoom_01").bind("click", function(e) {
        var ez =   $('#zoom_01').data('elevateZoom');
        ez.closeAll();
        $.fancybox(ez.getGalleryList());
        return false;
    });

    /*

        // Gets the video src from the data-src on each button
        var $videoSrc;
        $('.video-btn').click(function() {
            $videoSrc = $(this).data( "src" );
        });
        // when the modal is opened autoplay it
        $('#videoModal').on('shown.bs.modal', function (e) {
            // set the video src to autoplay and not to show related video. Youtube related video is like a box of chocolates... you never know what you're gonna get
            $("#video").attr('src', $videoSrc + "?rel=0&amp;showinfo=0&amp;modestbranding=1&amp;autoplay=1" );
        });
        // stop playing the youtube video when I close the modal
        $('#videoModal').on('hide.bs.modal', function (e) {
            // a poor man's stop video
            $("#video").attr('src', $videoSrc);
        });


    */

});