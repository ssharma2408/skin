(function($) {
    "use strict";
    $(document).ready(function() {

        /* -------------------------------------------------
            menu 
        ------------------------------------------------- */
        if ($('.menu-bar').length) {
            $(".menu-bar").on('click', function() {
                $(".ba-navbar").toggleClass("show", "linear");
                $('body').toggleClass('menu-opened');
            });
            $('body').on('click', function(event) {
                if (!$(event.target).closest('.menu-bar').length && !$(event.target).closest('.ba-navbar').length) {
                    $('.ba-navbar').removeClass('show');
                    $('body').removeClass('menu-opened');
                }
            });
        }

        /* -------------------------------------------------
            add balance 
        ------------------------------------------------- */
        if ($('.ba-add-balance-btn').length) {
            $(".ba-add-balance-btn").on('click', function() {
                $(".add-balance-inner-wrap").toggleClass("add-balance-inner-wrap-show", "linear");
            });
            $('body').on('click', function(event) {
                if (!$(event.target).closest('.ba-add-balance-btn').length && !$(event.target).closest('.add-balance-inner-wrap').length) {
                    $('.add-balance-inner-wrap').removeClass('add-balance-inner-wrap-show');
                }
            });
        }

        /*------------------------------------------------
            Search Popup
        ------------------------------------------------*/
        var bodyOvrelay = $('#body-overlay');
        var searchPopup = $('#search-popup');
        var sidebarMenu = $('#sidebar-menu');

        $(document).on('click', '#body-overlay', function(e) {
            e.preventDefault();
            bodyOvrelay.removeClass('active');
            searchPopup.removeClass('active');
            sidebarMenu.removeClass('active');
        });
        $(document).on('click', '.search', function(e) {
            e.preventDefault();
            searchPopup.addClass('active');
            bodyOvrelay.addClass('active');
        });

        /* -------------------------------------------------------------
            carousels js
        ------------------------------------------------------------- */
        $('.carousel-1').owlCarousel({
            loop: true,
            nav: false,
            dots: false,
            smartSpeed: 1500,
            items: 1,
        });

        //carousel-2
        $('.carousel-2').owlCarousel({
            loop: true,
            nav: false,
            dots: false,
            smartSpeed: 1500,
            margin: 20,
            items: 2,
        });

        //carousel-3
        $('.carousel-3').owlCarousel({
            loop: true,
            nav: false,
            dots: false,
            smartSpeed: 1500,
            margin: 20,
            items: 2,
            stagePadding: 70,
        });

        //carousel-4
        $('.carousel-4').owlCarousel({
            loop: true,
            nav: false,
            dots: false,
            smartSpeed: 1500,
            margin: 20,
            items: 3,
        });

        //carousel-5
        $('.carousel-5').owlCarousel({
            loop: true,
            nav: false,
            dots: false,
            smartSpeed: 1500,
            margin: 10,
            items: 4,
        });


        /*------------------------------------------------
            trading-product-slider
        ------------------------------------------------*/
        var leftArrow = '<i class="fa fa-angle-left"></i>';
        var rightArrow = '<i class="fa fa-angle-right"></i>';
        $('.send-money-slider').owlCarousel({
            stagePadding: 50,
            loop: true,
            margin: 10,
            nav: false,
            dots: false,
            smartSpeed: 1500,
            responsive: {
                0: {
                    items: 2
                },
                374: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        });

        $('.blog-slider').owlCarousel({
            loop: true,
            margin: 10,
            nav: false,
            dots: false,
            smartSpeed: 1500,
            responsive: {
                0: {
                    items: 2
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 5
                }
            }
        });

        /* -------------------------------------------------------------
        	RoundCircle Progress js
        ------------------------------------------------------------- */
        if ($('.chart-circle').length) {
            $('.chart-circle').each(function() {
                let $this = $(this);
                $this.circleProgress({
                    fill: {
                        color: $this.attr('data-color')
                    },
                    size: $this.height(),
                    startAngle: -Math.PI / 4 * 2,
                    emptyFill: 'rgba(0,0,0,0.2)',
                    lineCap: 'round'
                });
            });
        }

        /* circle-one */
        $('.single-goal-one .chart-circle').circleProgress({
            fill: {
                gradient: ["#1dcc70", "#1dcc70"]
            }
        });
        /* circle-two */
        $('.single-goal-two .chart-circle').circleProgress({
            fill: {
                gradient: ["#9a3ada", "#9a3ada"]
            }
        });
        /* circle-three */
        $('.single-goal-three .chart-circle').circleProgress({
            fill: {
                gradient: ["#ff396f", "#ff396f"]
            }
        });
        /* circle-four */
        $('.single-goal-four .chart-circle').circleProgress({
            fill: {
                gradient: ["#6236ff", "#6236ff"]
            }
        });


        /*-----------------
        auto notification 
        ------------------*/
        $('#overlay').modal('show');

        setTimeout(function() {
            $('#overlay').modal('hide');
        }, 1500);


    });

    $(window).on('load', function() {

        /*-----------------
            preloader
        ------------------*/
        var preLoder = $("#preloader");
        preLoder.fadeOut(0);

        /*-----------------
            back to top
        ------------------*/
        var backtoTop = $('.back-to-top')
        backtoTop.fadeOut();

        /*---------------------
            Cancel Preloader
        ----------------------*/
        $(document).on('click', '.cancel-preloader a', function(e) {
            e.preventDefault();
            $("#preloader").fadeOut(2000);
        });

    });

})(jQuery);