<a type="button" class="btn help_btn" data-toggle="modal" data-target="#help_modal"><small class="d-block">Was this article</small><b>Helpful ?</b>
              </a>
<header class="header">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu"><line x1="3" y1="12" x2="21" y2="12"></line><line x1="3" y1="6" x2="21" y2="6"></line><line x1="3" y1="18" x2="21" y2="18"></line></svg>
        </button>
        <a class="navbar-brand" href="{{ URL::to('/') }}"><img class="w-100" src="{{ asset('front/img/main-logo.png')}}" alt="Local Tales"></a>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav m-auto">
            <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
              <a class="nav-link" href="{!! URL::to('/') !!}">Home</a>
            </li>

            <li class="dropdown nav-item {{ request()->is('postcode*')|| request()->is('suburb*') ? 'active' : '' }}">
                <a class="nav-link dropdown-toggle" href="" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Location</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{!! URL::to('postcode') !!}">Postcode</a>
                  <a class="dropdown-item" href="{!! URL::to('suburb') !!}">Suburb</a>
                </div>
              </li>
              <li class="nav-item {{ request()->is('directory*') ? 'active' : '' }}">
                <a class="nav-link" href="{!! URL::to('directory') !!}">Directory</a>
              </li>
            <li class="nav-item {{ request()->is('collection*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('collection.home') }}">Collection</a>
            </li>
            <li class="nav-item {{ request()->is('category*') ? 'active' : '' }}">
              <a class="nav-link" href="{!! URL::to('category') !!}">Category</a>
            </li>
            <li class="nav-item {{ request()->is('article*') ? 'active' : ''  }}">
                <a class="nav-link" href="{!! URL::to('article') !!}">Article</a>
              </li>
              <li class="nav-item ">
                <!--<a class="nav-link" href="{!! URL::to('article') !!}">Help</a>-->


              </li>
          </ul>
          <div class="form-inline my-2 my-lg-0 login-content-holder">
              @if(Auth::guard('user')->check())
						<a type="button" class="btn btn-login d-flex align-items-center justify-content-center" href="{!! URL::to('site-edit-profile') !!}" style="
                        height: 35px;">
							<!-- <span><img src="{{ asset('site/images/login-icon.png ')}}"></span> -->

							<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
							<span class="ml-1">Hi, {{Auth::guard('user')->user()->name}}</span>
						</a>
						@else
               <a type="button" class="btn btn-login d-flex align-items-center justify-content-center" href="{!! URL::to('login') !!}" style="
               height: 35px;"><img src="{{ asset('front/img/login.svg')}}"> Login</a>
               	@endif
            <a type="button" class="btn btn-login btn_buseness" href="{{ route('business.signup')}}"><img src="{{ asset('front/img/briefcase.svg')}}"> Business Signup</a>
          </div>
        </div>
    </nav>
</header>
<div class="modal fade" id="help_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Was this article helpful?</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="{{ route('front.help.store') }}" method="post" id="helpForm" role="form" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="page" value="{{url()->current()}}">
            <div class="form-check form-check-inline">
                <input type="radio" onclick="javascript:yesnoCheck();" name="type" id="yesCheck" value="yes">
                <label class="form-check-label" for="yesCheck"> Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input type="radio" onclick="javascript:yesnoCheck();" name="type" id="noCheck" value="no">
              <label class="form-check-label" for="noCheck"> No</label>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" id="" name="user_name" placeholder="Full Name">
            </div>
             <div class="form-group">
                <input type="email" class="form-control" id="" name="user_email" placeholder="Email">
            </div>
             <div id="ifYes" style="visibility:hidden">
             <div class="form-group">
                <textarea  id="no" name="comment" rows="3" placeholder="If No then enter your comment why it wasn’t helpful" class="form-control h-auto"></textarea>
            </div>
            </div>
            <button type="submit" class="btn btn-login" helpBtn>Save changes</button>
        </form>
      </div>
    </div>
  </div>
</div>

<style>
    #help_modal .form-check-inline{
        width:58px;
        margin-bottom:20px;
    }
    .help_btn{
        position: fixed;
        bottom: 15px;
        right: 15px;
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: #f15e51;
        border: 0;
        color:#fff !important;
        padding: 22px 15px;
        line-height: 1.3;
        z-index: 999;
        box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
    }
</style>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
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
</script>
<script
  src="https://code.jquery.com/jquery-3.6.0.min.js"
  integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
  crossorigin="anonymous"></script>
  {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
        // tooltip
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        // sweetalert fires | type = success, error, warning, info, question
        function toastFire(type = 'success', title, body = '') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: type,
                title: title,
                text: body,
                showConfirmButton: false,
                confirmButtonColor: '#c10909',
                timer: 1000
            })
        }

        // on session toast fires
        @if (Session::get('success'))
            toastFire('success', '{{ Session::get('success') }}');
        @elseif (Session::get('failure'))
            toastFire('danger', '{{ Session::get('failure') }}');
        @endif

    </script> --}}

  <script>
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
