@extends('site.app')
@section('title') Submit query @endsection
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/fontawesome.min.css" integrity="sha512-P9vJUXK+LyvAzj8otTOKzdfF1F3UYVl13+F8Fof8/2QNb8Twd6Vb+VD52I7+87tex9UXxnzPgWA3rH96RExA7A==" crossorigin="anonymous" referrerpolicy="no-referrer" /> --}}

@section('content')
    <section class="my-5 form_b_sec query">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="" enctype="multipart/form-data" method="POST">@csrf
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <div class="div1">
                                    @if(Session::get('success'))
                                        <div class="text-center">
                                            <div class="alert alert-primary">Thank you for your query. This is your ticket: {{ strtoupper(Session::get('success')) }}. We will contact soon.</div>
                                        </div>
                                    @endif

                                    <h6>Submit your query!</h6>

                                    <div class="did-floating-label-content">
                                        <input type="text" class="did-floating-input" placeholder="Name" name="name" value="{{ old('name') }}">
                                        <label class="did-floating-label">Name *</label>
                                        <p><span class="text-danger">@error('name'){{$message}}@enderror</span></p>
                                    </div>

                                    <div class="did-floating-label-content">
                                        <input type="email" class="did-floating-input" placeholder="Email" name="email" value="{{ old('email') }}">
                                        <label class="did-floating-label">Email *</label>
                                        <p><span class="text-danger">@error('email'){{$message}}@enderror</span></p>
                                    </div>

                                    <div class="did-floating-label-content">
                                        <select type="text" class="did-floating-input" placeholder="" name="query_catagory" id="ddlViewBy" onChange="queryCheck()">
                                            <option value="" selected disabled>Select</option>
                                            @foreach ($query_catagory_all as $item)
                                                <option value="{{ $item->name }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <div class="select-icon">
                                            <i class="fa fa-angle-down" aria-hidden="true"></i>
                                        </div>
                                        <label class="did-floating-label">Categories</label>
                                        <p><span class="text-danger">@error('query_catagory'){{$message}}@enderror</span></p>
                                    </div>

                                    <div id="otherCat" style="display: none">
                                        <div class="did-floating-label-content">
                                            <textarea type="text" class="did-floating-input" rows="4" name="other">{{ old('other') }}</textarea>
                                            <label class="did-floating-label">Write something</label>
                                            <p><span class="text-danger">@error('other'){{$message}}@enderror</span></p>
                                        </div>
                                    </div>

                                    <div class="did-floating-label-content">
                                        <textarea type="text" placeholder="Write your query" class="did-floating-input query-input" rows="4" name="query">{{ old('query') }}</textarea>
                                        <label class="did-floating-label">Write your query *</label>
                                        <p><span class="text-danger">@error('query'){{$message}}@enderror</span></p>
                                    </div>

                                    <div class="did-floating-label-content">
                                        <input type="file" multiple class="did-floating-input file-input form-control" name="related_images[]">
                                        <label class="did-floating-label">Give query related images</label>
                                        <p><span class="text-danger">@error('related_images'){{$message}}@enderror</span></p>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <a href="{{ url('/') }}" class="btn main-btn">Go to Home</a>
                                        <button type="submit" class="btn main-btn ml-3">Submit</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- {{session('success')}} --}}

                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function queryCheck() {
            var ss = document.getElementById('ddlViewBy');
            if (ss.value != 'Other') {
                document.getElementById('otherCat').style.display = 'none';
            } else {
                document.getElementById('otherCat').style.display = 'block';
            }
        }
    </script>

    {{-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    {{-- <script>

        Swal.fire({

            title: '<h2>Success!</h2><h5>Your Query Submitted Successfully!</h5>',

            html: "<small><b>Ticket Id: </b>{{ session('success') }}<small>",

            icon: 'success',

            confirmButtonText: 'Okay'

        })

    </script> --}}

    {{-- @if (session('success'))
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

    @endif --}}
    
@endpush

