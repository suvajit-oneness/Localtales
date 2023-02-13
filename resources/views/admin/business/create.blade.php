@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}
                    <span class="top-form-btn">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Business</button>
                        <a class="btn btn-secondary" href="{{ route('admin.business.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.business.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="category_id">Category</label>
                            <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                <option value="">Select a Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Owner Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}"/>
                            @error('name') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Business Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('business_name') is-invalid @enderror" type="text" name="business_name" id="business_name" value="{{ old('business_name') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Email Id <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{ old('email') }}"/>
                            @error('email') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Password <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" value="{{ old('password') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Mobile No <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('mobile') is-invalid @enderror" type="text" name="mobile" id="mobile" value="{{ old('mobile') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="service_description">Service Description</label>
                            <textarea class="form-control" rows="4" name="service_description" id="service_description">{{ old('service_description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Address <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" id="address" value="{{ old('address') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Pin Code <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('pin') is-invalid @enderror" type="text" name="pin" id="pin" value="{{ old('pin') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Latitude <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('lat') is-invalid @enderror" type="text" name="lat" id="lat" value="{{ old('lat') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Longitude <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('lon') is-invalid @enderror" type="text" name="lon" id="lon" value="{{ old('lon') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Opening Hours <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('opening_hour') is-invalid @enderror" type="text" name="opening_hour" id="opening_hour" value="{{ old('opening_hour') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Website <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('website') is-invalid @enderror" type="text" name="website" id="website" value="{{ old('website') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Facebook Link <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('facebook_link') is-invalid @enderror" type="text" name="facebook_link" id="facebook_link" value="{{ old('facebook_link') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Twitter Link <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('twitter_link') is-invalid @enderror" type="text" name="twitter_link" id="twitter_link" value="{{ old('twitter_link') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Instagram Link <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('instagram_link') is-invalid @enderror" type="text" name="instagram_link" id="instagram_link" value="{{ old('instagram_link') }}"/>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Business</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.banner.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection