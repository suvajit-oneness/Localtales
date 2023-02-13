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
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Property</button>
                        <a class="btn btn-secondary" href="{{ route('admin.property.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.property.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                         <div class="form-group">
                            <label class="control-label" for="business_id">Business</label>
                            <select name="business_id" id="business_id" class="form-control @error('business_id') is-invalid @enderror">
                                <option value="">Select a Business</option>
                                @foreach($businesses as $business)
                                    <option value="{{ $business->id }}">{{ $business->business_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}"/>
                            @error('title') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Property Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                            @error('image') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="overview">Overview</label>
                            <textarea class="form-control" rows="4" name="overview" id="overview">{{ old('overview') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="amenities">Amenities</label>
                            <textarea class="form-control" rows="4" name="amenities" id="amenities">{{ old('amenities') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="near_by">Near By</label>
                            <textarea class="form-control" rows="4" name="near_by" id="near_by">{{ old('near_by') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Address <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" id="address" value="{{ old('address') }}"/>
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
                            <label class="control-label" for="name">Contact Person <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('contact_person') is-invalid @enderror" type="text" name="contact_person" id="contact_person" value="{{ old('contact_person') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Contact Email Id <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('contact_email') is-invalid @enderror" type="text" name="contact_email" id="contact_email" value="{{ old('contact_email') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Contact Phone No <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('contact_phone') is-invalid @enderror" type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone') }}"/>
                        </div>
                        
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Property</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.banner.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection