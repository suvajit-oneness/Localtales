@extends('site.appprofile')
@section('title') Dashboard @endsection
@section('content')
<div class="row">
    <div class="col-12 col-md-7 " style="padding-left:30px">
        <div class="card">
        	<div class="card-header">Update Profile</div>
            <div class="card-body">
            <form action="{{ route('site.dashboard.updateProfile') }}" method="POST" role="form" enctype="multipart/form-data">
            @csrf
            <div class="row">
	            <div class="col-sm-6">
	                <label class="mb-1">
	                    <h6 class="mb-0 text-sm text-dark">Name</h6>
	                </label>
	                <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ Auth::user()->name }}"/>
                            @error('name') {{ $message ?? '' }} @enderror
	            </div>
	            <div class="col-sm-6">
	                <label class="mb-1">
	                    <h6 class="mb-0 text-sm text-dark">Mobile No</h6>
	                </label>
	                <input class="form-control @error('mobile') is-invalid @enderror" type="text" name="mobile" id="mobile" value="{{ Auth::user()->mobile }}"/>
                            @error('mobile') {{ $message ?? '' }} @enderror
	            </div>
	            <div class="col-sm-6">
	                <label class="mb-1">
	                    <h6 class="mb-0 text-sm text-dark">Country</h6>
	                </label>
	                <input class="form-control" type="text" name="country" id="country" value="{{ Auth::user()->country }}"/>
	            </div>
	            <div class="col-sm-6">
	                <label class="mb-1">
	                    <h6 class="mb-0 text-sm text-dark">Address</h6>
	                </label>
	                <input class="form-control" type="text" name="address" id="address" value="{{ Auth::user()->address }}"/>
	            </div>
	            <div class="col-sm-6">
	                <label class="mb-1">
	                    <h6 class="mb-0 text-sm text-dark">City</h6>
	                </label>
	                <input class="form-control" type="text" name="city" id="city" value="{{ Auth::user()->city }}"/>
	            </div>
                <div class="col-sm-6">
	                <label class="mb-1">
	                    <h6 class="mb-0 text-sm text-dark">ZipCode</h6>
	                </label>
	                <input class="form-control" type="text" name="pincode" id="pincode" value="{{ Auth::user()->pincode }}"/>
	            </div>
	            <div class="col-sm-12">
	                <button type="submit" class="btn btn-blue text-center">Update</button>
	            </div>
	        </div>
	        </form>
	    </div>
        </div>
    </div>
@endsection
