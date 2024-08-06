(function ($) {
    'use strict';

    var roberto_window = $(window);

    // ****************************
    // :: 1.0 Preloader Active Code
    // ****************************

    roberto_window.on('load', function () {
        $('#preloader').fadeOut('1000', function () {
            $(this).remove();
        });
    });


    // ********************************
    // :: 8.0 Search Button Active Code
    // ********************************
    $('.search-btn').on('click', function () {
        $('.search-form').toggleClass('search-form-active');
    });

    // ***************************
    // :: 10.0 Tooltip Active Code
    // ***************************
    if ($.fn.tooltip) {
        $('[data-toggle="tooltip"]').tooltip();
    }

    // ****************************
    // :: 13.0 Scrollup Active Code
    // ****************************
    if ($.fn.scrollUp) {
        roberto_window.scrollUp({
            scrollSpeed: 1500,
            scrollText: '<i class="fa fa-chevron-up" aria-hidden="true"></i>'
        });
    }

    // *********************************
    // :: 15.0 Prevent Default 'a' Click
    // *********************************
    $('a[href="#"]').on('click', function ($) {
        $.preventDefault();
    });


    // *******************************
    // :: 17.0 Nice Select Active Code
    // *******************************
    if ($.fn.countdown) {
        $('select').niceSelect();
    }


})(jQuery);