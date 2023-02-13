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
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Directory</button>
                        <a class="btn btn-secondary" href="{{ route('admin.directory.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.directory.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label class="control-label" for="name">Owner Name <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name') }}"/>
                        @error('name') {{ $message ?? '' }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label">Image</label>
                        <p class="small text-danger mb-2">Size must be less than 200kb</p>
                        <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image" value="{{ old('image') }}"/>
                        @error('image') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Email Id <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{ old('email') }}"/>
                        @error('email') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Password <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" value="{{ old('password') }}"/>
                        @error('password') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Mobile No <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('mobile') is-invalid @enderror" type="text" name="mobile" id="mobile" value="{{ old('mobile') }}"/>
                        @error('mobile') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="pin"> Category <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="category_id">
                                <option hidden selected>Select Category...</option>
                                @foreach ($dircategory as $index => $item)
                                    <option value="{{$item->id}}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>

                    </div>

                    <div class="form-group">
                        <label class="control-label" for="establish_year">Establish Year<span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('establish_year') is-invalid @enderror" type="text" name="establish_year" id="establish_year" value="{{ old('establish_year') }}"/>
                        @error('establish_year') {{ $message ?? '' }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">ABN <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('ABN') is-invalid @enderror" type="text" name="ABN" id="ABN" value="{{ old('ABN') }}"/>
                        @error('ABN') {{ $message ?? '' }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="monday">Monday <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('monday') is-invalid @enderror" type="text" name="monday" id="monday" value="{{ old('monday') }}"/>
                        @error('monday') {{ $message ?? '' }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">TuesDay <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('tuesday') is-invalid @enderror" type="text" name="tuesday" id="tuesday" value="{{ old('tuesday') }}"/>
                        @error('tuesday') {{ $message ?? '' }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">Wednesday <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('wednesday') is-invalid @enderror" type="text" name="wednesday" id="wednesday" value="{{ old('wednesday') }}"/>
                        @error('wednesday') {{ $message ?? '' }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">Thursday <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('thursday') is-invalid @enderror" type="text" name="thursday" id="thursday" value="{{ old('thursday') }}"/>
                        @error('thursday') {{ $message ?? '' }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">Friday <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('friday') is-invalid @enderror" type="text" name="friday" id="friday" value="{{ old('friday') }}"/>
                        @error('friday') {{ $message ?? '' }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">Saturday<span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('saturday') is-invalid @enderror" type="text" name="saturday" id="saturday" value="{{ old('saturday') }}"/>
                        @error('saturday') {{ $message ?? '' }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">Sunday <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('sunday') is-invalid @enderror" type="text" name="sunday" id="sunday" value="{{ old('sunday') }}"/>
                        @error('sunday') {{ $message ?? '' }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">Public Holiday <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('public_holiday') is-invalid @enderror" type="text" name="public_holiday" id="public_holiday" value="{{ old('public_holiday') }}"/>
                        @error('public_holiday') {{ $message ?? '' }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">Category Tree<span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('category_tree') is-invalid @enderror" type="text" name="category_tree" id="category_tree" value="{{ old('category_tree') }}"/>
                        @error('category_tree') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="description">Description</label>
                        <textarea class="form-control" rows="4" name="description" id="summernote-description" value="{{ old('description') }}"/>
                            @error('description') {{ $message ?? '' }} @enderror</textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="service_description">Service Description</label>
                        <textarea class="form-control" rows="4" name="service_description" id="summernote-service_description" value="{{ old('service_description') }}"/>
                            @error('service_description') {{ $message ?? '' }} @enderror</textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Address <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" id="address" value="{{ old('address') }}"/>
                        @error('address') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Pin Code <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('pin') is-invalid @enderror" type="text" name="pin" id="pin" value="{{ old('pin') }}"/>
                        @error('pin') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Latitude <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('lat') is-invalid @enderror" type="text" name="lat" id="lat" value="{{ old('lat') }}"/>
                        @error('lat') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Longitude <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('lon') is-invalid @enderror" type="text" name="lon" id="lon" value="{{ old('lon') }}"/>
                        @error('lon') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Opening Hours <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('opening_hour') is-invalid @enderror" type="text" name="opening_hour" id="opening_hour" value="{{ old('opening_hour') }}"/>
                        @error('opening_hour') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Website <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('website') is-invalid @enderror" type="text" name="website" id="website" value="{{ old('website') }}"/>
                        @error('website') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Facebook Link <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('facebook_link') is-invalid @enderror" type="text" name="facebook_link" id="facebook_link" value="{{ old('facebook_link') }}"/>
                        @error('facebook_link') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Twitter Link <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('twitter_link') is-invalid @enderror" type="text" name="twitter_link" id="twitter_link" value="{{ old('twitter_link') }}"/>
                        @error('twitter_link') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Instagram Link <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('instagram_link') is-invalid @enderror" type="text" name="instagram_link" id="instagram_link" value="{{ old('instagram_link') }}"/>
                        @error('instagram_link') {{ $message ?? '' }} @enderror
                    </div>
                    {{-- <div class="form-group">
                        <label class="control-label">Banner Image</label>
                        <input class="form-control @error('banner_image') is-invalid @enderror" type="file" id="banner_image" name="banner_image" value="{{ old('banner_image') }}"/>
                        @error('banner_image') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label">Image2</label>
                        <input class="form-control @error('image2') is-invalid @enderror" type="file" id="image2" name="image2" value="{{ old('image2') }}"/>
                        @error('image2') {{ $message ?? '' }} @enderror
                    </div> --}}
                </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Directory</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.directory.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $('#summernote-description').summernote({
        height: 400
    });
    $('#summernote-service_description').summernote({
    height: 400
    });
</script>
@endpush
