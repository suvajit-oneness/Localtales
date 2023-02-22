<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/main.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/font-awesome/4.7.0/css/font-awesome.min.css') }}"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"> 
    {{--<script type="text/javascript" src="{{ asset('backend/js/select2.min.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/select2.min.css') }}">--}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="{{ asset('backend/js/jquery-3.2.1.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.css">
    <link rel="stylesheet" href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css?ver=5.9.3' />

    @yield('styles')

    @stack('styles')
</head>
<body class="app sidebar-mini rtl">
    @include('business.partials.header')

    @include('business.partials.sidebar')

    <main class="app-content" id="app">
        @yield('content')
    </main>

    <script src="{{ asset('backend/js/popper.min.js') }}"></script>
    <script src="{{ asset('backend/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('backend/js/main.js') }}"></script>
    <script src="{{ asset('backend/js/plugins/pace.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript">
        $('#summernote').summernote({
            height: 400
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/4.9.5/tinymce.min.js"></script>
    <script type="text/javascript">
        jQuery( "#page_type" ).on('change',function() {
          if(this.value == 'Categories'){
            $('#category_type select').removeAttr('disabled');
            $('#category_type').show();
            $('#country select').attr('disabled', 'disabled');
            $('#country').hide();
          }else if(this.value == 'Location'){
            $('#country select').removeAttr('disabled');
            $('#country').show();
            $('#category_type select').attr('disabled', 'disabled');
            $('#category_type').hide();
          }
          else{
            $('#category_type select').attr('disabled', 'disabled');
            $('#category_type').hide();
            $('#country select').attr('disabled', 'disabled');
            $('#country').hide();
          }
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
        // sweetalert fires | type = success, error, warning, info, question
        function toastFire(type, title, body = '') {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                showCloseButton: true,
                timer: 3000,
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

        // on session toast fires
        @if (Session::has("success"))
            toastFire("success", "{{ Session::get('success') }}");
        @elseif (Session::has("failure"))
            toastFire("warning", "{{ Session::get('failure') }}");
        @endif

        // click to read notification
        function readNotification(id, route) {
            $.ajax({
                url: "{{ route('business.notification.read') }}",
                method: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}',
                    id: id
                },
                success: function(result) {
                    window.location = "{{url('/')}}/"+route;
                }
            });
        }

        // check for push notifications
        function pushNotifications() {
            $.ajax({
                url: "{{ route('business.push.notification.check') }}",
                success: function(result) {
                    if (result.status == 200) {
                        // console.log(result.data);
                        try {
                            Notification.requestPermission().then(perm => {
                                // if permission is "DENIED"/ user clicks "DENY"
                                if (perm === "denied") {
                                    toastFire('warning', 'Browser Notification permission denied. Please Reset permission');
                                }
                                // if permission is "GRANTED"
                                else {
                                    const img = "{{asset('front/img/logo-icon-square.png')}}";

                                    // looping through notifications
                                    $.each(result.data, (key, val) => {
                                        let title = val.title;
                                        let text = val.description;
                                        let url = "{{url('/')}}/"+val.route;

                                        let notification = new Notification(title, {
                                            body: text,
                                            icon: img
                                        });

                                        notification.onclick = function () {
                                            window.open(url);
                                        };
                                    });
                                }
                            });
                        } catch (e) {
                            return false;
                        }
                    }
                }
            });
        }
        pushNotifications();
    </script> 

    @stack('scripts')
</body>
</html>
