@extends('business.app')
@section('title')
    Change Password
@endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> Change Password</h1>

        </div>
    </div>
    <div class="col-md-8 mx-auto">
        <div class="tile">
            <span class="top-form-btn">
                <a class="btn btn-secondary" href="{{ route('business.dashboard') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
            </span>
            <h3 class="tile-title">Change Password
            </h3>
            <hr>
            <form action="{{ route('business.updatePassword') }}" method="POST" role="form" enctype="multipart/form-data">
                @csrf
                <div class="tile-body">
                    <div class="form-group">
                        <label class="mb-1">
                            <h6 class="mb-0 text-sm text-dark">Old Password</h6>
                        </label>
                        <input class="form-control @error('old_password') is-invalid @enderror" type="password"
                            name="old_password" id="old_password" value="{{old('old_password')}}">
                        @error('old_password')
                            <p class="small text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="mb-1">
                            <h6 class="mb-0 text-sm text-dark">New Password </h6>
                        </label>
                        <input class="form-control @error('new_password') is-invalid @enderror" type="password"
                            name="new_password" id="new_password" value="{{old('new_password')}}">
                        @error('new_password')
                            <p class="small text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="mb-1">
                            <h6 class="mb-0 text-sm text-dark">Confirm Password</h6>
                        </label>
                        <input class="form-control @error('confirm_new_password') is-invalid @enderror" type="password"
                            name="confirm_new_password" id="confirm_new_password" value="{{old('confirm_new_password')}}">
                        @error('confirm_new_password')
                            <p class="small text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                    <br>
                    <div class="tile-footer mt-3">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>
    </div>
@endsection
