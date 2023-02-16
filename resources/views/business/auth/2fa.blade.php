@extends('site.app')

{{-- @section('title') {{ $pageTitle }} @endsection --}}
<style>
    #otherCat{
        display:none;    }
    </style>
@section('content')

    <section class="my-5 form_b_sec">

        <div class="container">

            <div class="row">

                <div class="col-12">
                    <form action="{{ route('2fa.post') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <div class="div1">
                        <p class="text-center">We sent code to email : {{ substr(Auth::guard('business')->user()->email, 0, 5) . '******' . substr(Auth::guard('business')->user()->email,  -2) }}</p>
                                    
                        @if ($message = Session::get('success'))
                        <div class="row">
                          <div class="col-md-12">
                              <div class="alert alert-success alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                  <strong>{{ $message }}</strong>
                              </div>
                          </div>
                        </div>
                    @endif

                    @if ($message = Session::get('error'))
                        <div class="row">
                          <div class="col-md-12">
                              <div class="alert alert-danger alert-block">
                                <button type="button" class="close" data-dismiss="alert">×</button> 
                                  <strong>{{ $message }}</strong>
                              </div>
                          </div>
                        </div>
                    @endif

                    <div class="form-group row">
                        <label for="code" class="col-md-4 col-form-label text-md-right">Code</label>

                        <div class="col-md-6">
                            <input id="code" type="number" class="form-control @error('code') is-invalid @enderror" name="code" value="{{ old('code') }}" required autocomplete="code" autofocus>

                            @error('code')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <a class="btn btn-link" href="{{ route('2fa.resend') }}">Resend Code?</a>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn main-btn ml-3">
                                Submit
                            </button>

                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- <script>

        Swal.fire({

            title: '<h2>Success!</h2><h5>Your Query Submitted Successfully!</h5>',

            html: "<small><b>Ticket Id: </b>{{ session('success') }}<small>",

            icon: 'success',

            confirmButtonText: 'Okay'

        })

    </script> --}}

    @if (session('success'))

        <script>

            Swal.fire({

                title: '<h2>Success!</h2><h5>Your Query Submitted Successfully!</h5>',

                html: "<small><b>Ticket Id: </b>{{ session('success') }}<small>",

                icon: 'success',

                confirmButtonText: 'Okay'

            })

        </script>

    @endif

    @if (session('error'))

        <script>

            Swal.fire({

                title: 'Error!',

                text: "{{ session('error') }}",

                icon: 'error',

                confirmButtonText: 'Okay'

            })

        </script>

    @endif
<script>
    function queryCheck() {
        var ss = document.getElementById('ddlViewBy');
        console.log(ss.value);
    if (ss.value != 'other') {
        console.log('here');
        document.getElementById('otherCat').style.display = 'none';

    } else {
        console.log('hi');
        document.getElementById('otherCat').style.display = 'block';
    }

}
    </script>
@endpush

