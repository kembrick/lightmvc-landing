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


});