@extends('site.app')

@section('title') Job Application Form @endsection 

<style>
    #otherCat{
        display:none;
    }
</style>

@section('content')
    <section class="my-5 form_b_sec">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <form action="{{route('apply')}}" enctype="multipart/form-data" method="POST">@csrf
                        <input type="hidden" name="job_id" value="{{$job[0]->id}}">
                        <div class="row justify-content-center">
                            <div class="col-6">
                                <div class="div1">
                                    <h6>Submit your application!</h6>
                                    <div class="did-floating-label-content">
                                        <input type="text" class="did-floating-input" placeholder="Full Name" name="name" value="{{ old('name') ? old('name') : auth()->guard('user')->user()->name }}">
                                        <label class="did-floating-label">Full Name <span
                                            class="m-l-5 text-danger">*</span></label>
                                        <p><span class="text-danger">@error('name'){{$message}}@enderror</span></p>
                                    </div>
                                    <div class="did-floating-label-content">
                                        <input type="email" class="did-floating-input" placeholder="Email address" name="email" value="{{ old('email') ? old('email') : auth()->guard('user')->user()->email  }}">
                                        <label class="did-floating-label">Email address <span
                                            class="m-l-5 text-danger">*</span></label>
                                        <p><span class="text-danger">@error('email'){{$message}}@enderror</span></p>
                                    </div>
                                    <div class="did-floating-label-content">
                                        <input type="text" class="did-floating-input" placeholder="Contact number" name="mobile" value="{{ old('mobile') ? old('mobile') : auth()->guard('user')->user()->mobile  }}">
                                        <label class="did-floating-label">Contact number <span
                                            class="m-l-5 text-danger">*</span></label>
                                        <p><span class="text-danger">@error('mobile'){{$message}}@enderror</span></p>
                                    </div>
                                    <div class="did-floating-label-content">
                                        <input type="text" class="did-floating-input" placeholder="Address" name="address" value="{{ old('address') ? old('address') : auth()->guard('user')->user()->address  }}">
                                        <label class="did-floating-label">Address <span
                                            class="m-l-5 text-muted">(optional)</span></label>
                                        <p><span class="text-danger">@error('address'){{$message}}@enderror</span></p>
                                    </div>
                                    <div class="did-floating-label-content">
                                        <div class="did-floating-label-content">
                                            {{-- <select type="text" class="did-floating-input" placeholder="" name="gender" id="ddlViewBy" onChange="queryCheck()"> --}}
                                            <select type="text" class="did-floating-input" placeholder="" name="gender" id="ddlViewBy">
                                                <option value="" selected disabled>Select</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <label class="did-floating-label">Gender <span
                                                class="m-l-5 text-muted">(optional)</span></label>
                                        </div>
                                        {{-- <label class="did-floating-label genderTitle w-25 bg-white">Gender</label> --}}
                                        <p><span class="text-danger">@error('gender'){{$message}}@enderror</span></p>
                                    </div>
                                    <div id="otherCat">
                                        <div class="did-floating-label-content">
                                            <textarea type="text" class="did-floating-input" rows="4" name="other">{{ old('other') }}</textarea>
                                            <label class="did-floating-label">Write something</label>
                                            <p><span class="text-danger">@error('other'){{$message}}@enderror</span></p>
                                        </div>
                                    </div>
                                    <div class="did-floating-label-content">
                                        <input type="file" multiple class="did-floating-input" name="cv">
                                        <label class="did-floating-label">Resume <span
                                            class="m-l-5 text-danger">*</span></label>
                                        <p><span class="text-danger">@error('cv'){{$message}}@enderror</span></p>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn main-btn">Submit</button>
                                        <a href="{{ url('job') }}" class="btn main-btn ml-3">Go to Job</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    {{-- {{session('success')}} --}}

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

        document.querySelector('.genderTitle').innerHTML = ss.value;

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