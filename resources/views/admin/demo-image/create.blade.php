@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div class="row w-100">
            <div class="col-md-6">
                <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
                <p></p>
            </div>
            <div class="col-md-6 text-right">

            </div>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">

            <form action="{{ route('admin.demo-image.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="title">Title <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="title">
                                <option hidden selected>Select Title...</option>
                                <option value="postcode">Postcode</option>
                                <option value="suburb">Suburb</option>
                                <option value="directory">Directory</option>
                                <option value="collection">Collection</option>
                                <option value="article">Article</option>
                                <option value="category">Category</option>
                                <option value="articlecategory">Article Category</option>
                                <option value="articlesubcategory">Article SecondaryCategory</option>
                                <option value="articletertiarycategory">Article TertiaryCategory</option>
                                <option value="help">Help</option>
                                <option value="contact">ContactUs</option>
                                <option value="about">AboutUs</option>
                                <option value="term">Terms</option>
                                <option value="privacy">Privacy</option>

                            </select>
                            @error('title') {{ $message ?? '' }} @enderror
                        </div>
                    <div class="form-group">
                        <label class="control-label"> Image</label>
                        <input class="form-control @error('image') is-invalid @enderror" type="file"
                            id="image" name="image" />
                        @error('image')
                            <p class="small text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
                <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Image</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.demo-image.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                </div>
                </form>
            </div>
        </div>
    </div>

@endsection

