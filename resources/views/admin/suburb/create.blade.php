@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
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
                <h3 class="tile-title">
                    <span class="top-form-btn">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save
                            Suburb</button>
                        <a class="btn btn-secondary" href="{{ route('admin.suburb.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.suburb.store') }}" method="post" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name"> Name <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                id="name" value="{{ old('name') }}" />
                            @error('name')
                                {{ $message ?? '' }}
                            @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="state"> State <span class="m-l-5 text-danger">
                                    *</span></label>
                                    @php
                                      $state=App\Models\State::orderby('name')->get();
                                    @endphp
                                    <select class="form-control" name="state">
                                        <option value="" hidden selected>Select...</option>
                                        @foreach ($state as $index => $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                            @error('state')
                                {{ $message ?? '' }}
                            @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="region_name">Region Name <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('region_name') is-invalid @enderror" type="text" name="region_name"
                                id="region_name" value="{{ old('region_name') }}" />
                            @error('region_name')
                                {{ $message ?? '' }}
                            @enderror
                        </div>

                    </div>
                    {{--  <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name"> Postcode <span class="m-l-5 text-danger">
                                    *</span></label>
                            <select class="form-control" name="pin_code">
                                <option hidden selected>Select Postcode...</option>
                                @foreach ($pin as $index => $item)
                                    <option value="{{ $item->pin }}">{{ $item->pin }}</option>
                                @endforeach
                            </select>
                            @error('pin_code')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>--}}
                    <div class="page-search-block filterSearchBoxWraper" style="bottom: -83px;">
                            <div class="filterSearchBox">
                                <div class="row">
                                    <div class="mb-sm-0 col col-lg fcontrol position-relative filter_selectWrap filter_selectWrap2">
                                        <div class="select-floating-admin">
                                            <label>Postcode<span class="m-l-5 text-danger">
                                                *</span></label>
                                            <select class="filter_select form-control" name="pin_code">
                                                <option value="" hidden selected>Select Postcode...</option>
                                                @foreach ($pin as $index => $item)
                                                <option value="{{ $item->pin }}">{{ $item->pin }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="house">Houses & Units <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('house') is-invalid @enderror" type="text" name="house"
                                id="house" value="{{ old('house') }}" />
                            @error('house')
                                {{ $message ?? '' }}
                            @enderror
                        </div>

                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="population">Total Population <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('population') is-invalid @enderror" type="text" name="population"
                                id="population" value="{{ old('population') }}" />
                            @error('population')
                                {{ $message ?? '' }}
                            @enderror
                        </div>

                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="description"> Description <span class="m-l-5 text-danger">
                                    *</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" type="text"
                                name="description" id="summernote_description" value="{{ old('description') }}" ></textarea>
                            @error('description')
                                {{ $message ?? '' }}
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="meta_title"> Meta Title <span class="m-l-5 text-danger">
                                *</span></label>
                        <input class="form-control @error('meta_title') is-invalid @enderror" type="text" name="meta_title"
                            id="meta_title" value="{{ old('meta_title') }}" />
                        @error('meta_title')
                            {{ $message ?? '' }}
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="meta_description"> Meta Description <span class="m-l-5 text-danger">
                                *</span></label>
                        <textarea class="form-control @error('meta_description') is-invalid @enderror" type="text"
                            name="meta_description" id="summernote-meta_description">{{ old('meta_description') }}</textarea>
                        @error('meta_description')
                            {{ $message ?? '' }}
                        @enderror
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="image"> Image <span class="m-l-5 text-danger">
                                    *</span></label>
                                    <p class="small text-danger mb-2">Size must be less than 200kb</p>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" name="image"
                                id="image" value="{{ old('image') }}" />
                            @error('image')
                                {{ $message ?? '' }}
                            @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save
                            Suburb</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.suburb.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
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
    $('#summernote_description').summernote({
        height: 400
    });
    $('#summernote-meta_description').summernote({
        height: 400
    });
</script>
@endpush
