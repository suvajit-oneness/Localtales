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
                    <form action="" enctype="multipart/form-data" method="POST">
                        @csrf
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <div class="div1">
                                    <h6>Submit your query!</h6>
                                    <div class="did-floating-label-content">
                                        <input type="text" class="did-floating-input" placeholder="Name..." name="name" value="{{ old('name') }}">
                                        <label class="did-floating-label">Name</label>
                                        <p><span class="text-danger">@error('name'){{$message}}@enderror</span></p>
                                    </div>
                                    <div class="did-floating-label-content">
                                        <input type="email" class="did-floating-input" placeholder="Email..." name="email" value="{{ old('email') }}">
                                        <label class="did-floating-label">Email</label>
                                        <p><span class="text-danger">@error('email'){{$message}}@enderror</span></p>
                                    </div>
                                    <div class="did-floating-label-content">
                                        <select type="text" class="did-floating-input" placeholder="" name="query_catagory" id="ddlViewBy" onChange="queryCheck()">
                                            <option value="">--Select a catagory--</option>
                                            @foreach ($query_catagory_all as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                                            @endforeach
                                            <option value="other">Other</option>
                                        </select>
                                        <label class="did-floating-label">Categories</label>
                                        <p><span class="text-danger">@error('query_catagory'){{$message}}@enderror</span></p>
                                    </div>
                                    <div id="otherCat">
                                        <div class="did-floating-label-content">
                                            <textarea type="text" class="did-floating-input" rows="4" name="other">{{ old('other') }}</textarea>
                                            <label class="did-floating-label">Write something</label>
                                            <p><span class="text-danger">@error('other'){{$message}}@enderror</span></p>
                                        </div>
                                       </div>
                                    <div class="did-floating-label-content">
                                        <textarea type="text" class="did-floating-input" rows="4" name="query">{{ old('query') }}</textarea>
                                        <label class="did-floating-label">Write your query</label>
                                        <p><span class="text-danger">@error('query'){{$message}}@enderror</span></p>
                                    </div>
                                    <div class="did-floating-label-content">
                                        <input type="file" multiple class="did-floating-input" name="related_images[]">
                                        <label class="did-floating-label">Give query related images:</label>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <button type="submit" class="btn main-btn ml-3">Submit</button>
                                    <a href="{{ url('') }}" class="btn main-btn ml-3">Go to Home</a>
                                </div>
                            </div>
                        </div>
                    </form>
                    {{session('success')}}
                    {{-- <div class="mt-4 mt-md-5">
                        <!-- <button type="button" class="btn main-btn btn_buseness">BACK TO HOME</button> -->
                        <button type="submit" class="btn main-btn ml-3">Go to Home</button>
                    </div> --}}
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

