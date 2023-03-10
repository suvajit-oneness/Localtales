@extends('site.appprofile')
@section('title') Edit Profile @endsection

@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> Edit Profile</h1>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="{{ route('site.dashboard.updateProfile') }}" method="POST" role="form" enctype="multipart/form-data">@csrf
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
							<h6 class="mb-0 text-sm text-dark">Mobile Number</h6>
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
							<h6 class="mb-0 text-sm text-dark">Postcode</h6>
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
@endsection

@push('scripts')
    <script>
		
    </script>
@endpush
