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
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.bussinesslead.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name"> Business Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('bussiness_name') is-invalid @enderror" type="text" name="bussiness_name" id="name" value="{{ old('bussiness_name', $targetBusiness->bussiness_name) }}"/>
                            <input type="hidden" name="id" value="{{ $targetBusiness->id }}">
                            @error('title') {{ $message }} @enderror
                            @error('bussiness_name') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name"> Category <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control @error('category') is-invalid @enderror" name="category" id="category">
                                @foreach ($directoryCategories as $item)
                                    <option value="{{ $item->id }}" {{ ($targetBusiness->category == $item->id) ? 'selected' : '' }}>{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('category') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="service_description"> Service Description <span class="m-l-5 text-danger"> *</span></label>
                            <textarea class="form-control @error('service_description') is-invalid @enderror" type="text" name="service_description" id="service_description">{{ $targetBusiness->service_description }}</textarea>
                            @error('service_description') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name"> Description <span class="m-l-5 text-danger"> *</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" type="text" name="description" id="description">{{ $targetBusiness->description }}</textarea>
                            @error('description') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="email"> Email <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{ $targetBusiness->email }}"/>
                            @error('email') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="mobile_no"> Mobile number (primary) <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('mobile_no') is-invalid @enderror" type="text" name="mobile_no" id="mobile_no" value="{{ $targetBusiness->mobile_no }}"/>
                            @error('mobile_no') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="alt_mobile_no"> Mobile number (alternate) </label>
                            <input class="form-control @error('alt_mobile_no') is-invalid @enderror" type="text" name="alt_mobile_no" id="alt_mobile_no" value="{{ $targetBusiness->alt_mobile_no }}"/>
                            @error('alt_mobile_no') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="bussiness_address"> Bussiness Address <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('bussiness_address') is-invalid @enderror" type="text" name="bussiness_address" id="name" value="{{ $targetBusiness->bussiness_address }}"/>
                            @error('bussiness_address') {{ $message ?? '' }} @enderror
                        </div>
                    </div>


                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="facebook_link"> Facebook link <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('facebook_link') is-invalid @enderror" type="text" name="facebook_link" id="name" value="{{ $targetBusiness->facebook_link }}"/>
                            @error('facebook_link') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="twitter_link"> Twitter link <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('twitter_link') is-invalid @enderror" type="text" name="twitter_link" id="name" value="{{ $targetBusiness->twitter_link }}"/>
                            @error('twitter_link') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="instagram_link"> Instagram link <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('instagram_link') is-invalid @enderror" type="text" name="instagram_link" id="name" value="{{ $targetBusiness->instagram_link }}"/>
                            @error('instagram_link') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="linkedin_link"> Linkedin link <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('linkedin_link') is-invalid @enderror" type="text" name="linkedin_link" id="name" value="{{ $targetBusiness->linkedin_link }}"/>
                            @error('linkedin_link') {{ $message ?? '' }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="youtube_link"> YouTube link <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('youtube_link') is-invalid @enderror" type="text" name="youtube_link" id="name" value="{{ $targetBusiness->youtube_link }}"/>
                            @error('youtube_link') {{ $message ?? '' }} @enderror
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label" for="monday_opening_hour"> Monday Opening Hour <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('monday_opening_hour') is-invalid @enderror" type="text" name="monday_opening_hour" id="monday_opening_hour" value="{{ $targetBusiness->monday_opening_hour }}"/>
                        @error('monday_opening_hour') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="tuesday_opening_hour"> Tuesday Opening Hour <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('tuesday_opening_hour') is-invalid @enderror" type="text" name="tuesday_opening_hour" id="tuesday_opening_hour" value="{{ $targetBusiness->tuesday_opening_hour }}"/>
                        @error('tuesday_opening_hour') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="wednesday_opening_hour"> Wednesday Opening Hour <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('wednesday_opening_hour') is-invalid @enderror" type="text" name="wednesday_opening_hour" id="wednesday_opening_hour" value="{{ $targetBusiness->wednesday_opening_hour }}"/>
                        @error('wednesday_opening_hour') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="thursday_opening_hour"> Thursday Opening Hour <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('thursday_opening_hour') is-invalid @enderror" type="text" name="thursday_opening_hour" id="thursday_opening_hour" value="{{ $targetBusiness->thursday_opening_hour }}"/>
                        @error('thursday_opening_hour') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="friday_opening_hour"> Friday Opening Hour <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('friday_opening_hour') is-invalid @enderror" type="text" name="friday_opening_hour" id="friday_opening_hour" value="{{ $targetBusiness->friday_opening_hour }}"/>
                        @error('friday_opening_hour') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="saturday_opening_hour"> Saturday Opening Hour <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('saturday_opening_hour') is-invalid @enderror" type="text" name="saturday_opening_hour" id="saturday_opening_hour" value="{{ $targetBusiness->saturday_opening_hour }}"/>
                        @error('saturday_opening_hour') {{ $message ?? '' }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="sunday_opening_hour"> Sunday Opening Hour <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('sunday_opening_hour') is-invalid @enderror" type="text" name="sunday_opening_hour" id="sunday_opening_hour" value="{{ $targetBusiness->sunday_opening_hour }}"/>
                        @error('sunday_opening_hour') {{ $message ?? '' }} @enderror
                    </div>


                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="type">Company Type</label>
                            <select id="type" name="type" class="form-control">
                                <option value="">--- Select  ---</option>
                                <option value="1" {{ ($targetBusiness->type == 1) ? 'selected' : '' }}>Single</option>
                                <option value="2" {{ ($targetBusiness->type == 2) ? 'selected' : '' }}>Multiple</option>
                            </select>
                            @error('type') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    </div>


                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Business Lead</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.bussinesslead.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
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
    $('#service_description').summernote({
        height: 400
    });
    $('#description').summernote({
        height: 400
    });
</script>
@endpush
