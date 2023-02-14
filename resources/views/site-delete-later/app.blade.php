<!DOCTYPE html>
<html lang="en">

<head>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-VG69JJYG3S"></script>

    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-VG69JJYG3S');
    </script>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <meta name="description" content="@yield('description')">

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <link rel="stylesheet" href="{{ asset('front/css/bootstrap.css') }}">
    <link rel="stylesheet" href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css?ver=5.9.3' />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" />
    <link rel="stylesheet" href="{{ asset('front/css/swiper-bundle.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('front/css/main.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css"/>
    <link rel="stylesheet" href="{{ asset('site/css/style.css ') }}">
    <link rel="stylesheet" href="{{ asset('front/css/responsive.css') }}">

    @yield('styles')

    @stack('styles')
</head>

<body>
    @include('site.partials.header')

    @yield('content')

    @include('site.partials.footer')

    <script src="{{ asset('front/js/jquery-3.6.0.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="{{ asset('front/js/popper.min.js') }}"></script>
    <script src="{{ asset('front/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('front/js/jquery-equal-height.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script src="{{ asset('front/js/custom.js') }}"></script>
    <script src="{{ asset('site/js/slick.min.js') }}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>

    @stack('scripts')

    <script>
        feather.replace()

        $('[data-fancybox]').fancybox({
            protect: true
        });

        // on session toast fires
        @if (Session::get('success'))
            toastFire('success', '{{ Session::get('success') }}');
        @elseif (Session::get('failure'))
            toastFire('warning', '{{ Session::get('failure') }}');
        @endif
    </script>

    <script>
        $(".help-box").hide();

        $("#item").click(function() {
            if($(this).is(":checked")) {
                $(".help-box").show();
            } else {
                $(".help-box").hide();
            }
        });

        function yesnoCheck() {
            if (document.getElementById('noCheck').checked) {
                document.getElementById('ifYes').style.visibility = 'visible';
            }
            else document.getElementById('ifYes').style.visibility = 'hidden';
        }

        $(document).on('submit', '#helpForm', (event) => {
            event.preventDefault();

			const cartSvg = '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>';

            $.ajax({
                url: "{{ route('add.help.ajax') }}",
                type: "POST",
                data: {
                    _token: "{{csrf_token()}}",
                     type: $('#helpForm input[name="type"]:checked').val(),
                    user_name: $('#helpForm input[name="user_name"]').val(),
                    user_email: $('#helpForm input[name="user_email"]').val(),
                    comment: $('#helpForm textarea[name="comment"]').val(),
                    page: '{{url()->current()}}'
                },
                beforeSend: function() {
                    $('.helpBtn').attr('disabled', true).html(cartSvg+' Adding....');
                },
                success: function(result) {
                    if (result.error === false) {
                        $('.minihelpBtn').html(cartSvg+'<span class="badge badge-danger">'+result.count+'</span>');
                        toastFire('success', result.message);
                    } else {
                        toastFire('warning', result.message);
                    }
                    $('.helpBtn').attr('disabled', false).html(cartSvg+' Comment added');
                }
            });
        });
    </script>

    <script>
        // sweetalert fires | type = success, error, warning, info, question
        function toastFire(type = 'success', title, body = '') {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            showCloseButton: true,
            timer: 2000,
            timerProgressBar: false,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        Toast.fire({
            icon: type,
            title: title,
            // text: body
        })
        }

        $('.home-directory--slider').on('beforeChange', function(event, slick, currentSlide) {
        console.log('test1' + currentSlide);
        if (currentSlide == 0) {
            $('.directory-bar').addClass('active');
        }
        });

        $('.home-directory--slider').on('afterChange', function(event, slick, currentSlide) {
        console.log('test2' + currentSlide);
        if (currentSlide == 0) {
            $('.directory-bar').removeClass('active');
        }
        });

        //community slider
        $('.community-list').slick({
        dots: true,
        infinite: false,
        speed: 300,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 481,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }

        ]
        });

        //business slider
        $('.business-list').slick({
        dots: true,
        //infinite: false,
        speed: 300,
        centerMode: true,
        centerPadding: '60px',
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 481,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }

        ]
        });


        $('.home-banner--slider').slick({
        dots: false,
        arrows: false,
        infinite: false,
        speed: 600,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        cssEase: 'linear',
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 481,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }

        ]
        });

        $('.home-about--slider').slick({
        dots: false,
        arrows: false,
        infinite: false,
        speed: 300,
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        responsive: [{
                breakpoint: 1024,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            },
            {
                breakpoint: 481,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }

        ]
        });

        $('.home-directory--slider').slick({
        dots: false,
        arrows: true,
        infinite: false,
        speed: 600,
        variableWidth: true,
        slidesToScroll: 1,
        cssEase: 'linear',
        prevArrow: $('.left-arrow'),
        nextArrow: $('.right-arrow'),
        });

        $('.event-block:first').addClass('active');
        $('.event-block').hover(function() {
        if ($(this).hasClass('active')) {
            //$(this).removeClass('active');
        } else {
            $('.event-block.active').removeClass('active');
            $(this).addClass('active');
        }
        //$(this).next().slideToggle();
        //$('.site_accordian_details').not($(this).next()).slideUp();
        });

        // counter
        var a = 0;
        $(window).scroll(function() {
        const servicecounter = document.querySelector(".counter-list");
        if (!document.body.contains(servicecounter)) return;
        var oTop = $('.counter-list').offset().top - window.innerHeight;
        if (a == 0 && $(window).scrollTop() > oTop) {
            $('.counter-list li figure').each(function() {
                var $this = $(this),
                    countTo = $this.attr('data-count');
                $({
                    countNum: $this.text()
                }).animate({
                        countNum: countTo
                    },

                    {

                        duration: 1000,
                        easing: 'swing',
                        step: function() {
                            $this.text(Math.floor(this.countNum));
                        },
                        complete: function() {
                            $this.text(this.countNum);
                            //alert('finished');
                        }

                    });
            });
            a = 1;
        }

        });



        $(document).ready(function() {
        $('.ham').click(function(e) {
            e.stopPropagation();
            $('.navigation').toggleClass('slide');
        });

        $(document).click(function() {
            $('.navigation').removeClass('slide');
        });

        $('.navigation').click(function(e) {
            e.stopPropagation();
        });
        $('.filter_btn').click(function(e) {
            e.stopPropagation();
            $('.filter_wrap').slideToggle();
            $('.page-search-block').toggleClass('filter-open');
        });
        $('.filter_wrap').click(function(e) {
            e.stopPropagation();
        });

        $(document).click(function() {
            $('.filter_wrap').slideUp();
            $('.page-search-block').removeClass('filter-open');
        });

        });

        $('.filter_select').select2({
        width:"100%",
        });


        $('.filter_select').select2().on('select2:select', function (e) {
        var data = e.params.data;
        });


        $('.filter_select').select2().on('select2:open', (elm) => {
        const targetLabel = $(elm.target).prev('label');
        targetLabel.addClass('filled active');
        }).on('select2:close', (elm) => {
        const target = $(elm.target);
        const targetLabel = target.prev('label');
        const targetOptions = $(elm.target.selectedOptions);
        if (targetOptions.length === 0) {
            targetLabel.removeClass('filled active');
        }
        });


        $(document).on('.filter_selectWrap select2:open', () => {
        document.querySelector('.select2-search__field').focus();
        });


        $(".questionSetItemButton").click(function(){
        $(this).parents(".questionSetItem").hide();
        $(this).parents(".questionSetItem").next().show();
        });
        $(".questionSetItemButtonPrev").click(function(){
        $(this).parents(".questionSetItem").hide();
        $(this).parents(".questionSetItem").prev().show();
        });
        $("#questionModal").modal({
        show:false,
        backdrop:'static'
        });

        $(".openAlertModal").click(function(){
        $("#questionModal").addClass("questionModalHide");
        })
        $(".closeAlertThis, .leaveBtn, .stayBtn").click(function(){
        $("#questionModal").removeClass("questionModalHide");
        })
        $(".openreviewBbox").click(function(){

        })

        $('.jQueryEqualHeight').jQueryEqualHeight('.businessDirectoryCard h5');
        $('.jQueryEqualHeight').jQueryEqualHeight('.businessDirectoryCard .card-body');
        $('.jQueryEqualHeight').jQueryEqualHeight('.directoryCard h5');
        $('.jQueryEqualHeight').jQueryEqualHeight('.directoryCard .card-body');

        $('.jQueryEqualHeight').jQueryEqualHeight('.innerCatlistCard .card-body h5');
        $('.jQueryEqualHeight').jQueryEqualHeight('.innerCatlistCard .card-body');
        $('.jQueryEqualHeight').jQueryEqualHeight('.article_badge_wrap');

        var searchPadding = $(".filterSearchBoxWraper").innerHeight();
        $(".searchpadding").css({"padding-top": searchPadding + 10});
        $(".filterSearchBoxWraper").css({"bottom": - searchPadding});

        var collectionBreadcumb = $(".collection_breadcumb").innerHeight();
        $(".collectionbreadcumbPadding").css({"padding-top": collectionBreadcumb + 10});
        $(".collection_breadcumb").css({"bottom": - collectionBreadcumb});
    </script>
</html>
