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
                <form action="{{ route('admin.dirsubcategory.store') }}" method="POST" role="form" enctype="multipart/form-data">@csrf
                    <h3 class="tile-title">Create Sub category
                        <span class="top-form-btn">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Category</button>

                            <a class="btn btn-secondary" href="{{ route('admin.dirsubcategory.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                        </span>
                    </h3>
                    <hr>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="child_category">Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('child_category') is-invalid @enderror" type="text" name="child_category" id="child_category" value="{{ old('child_category') }}" />
                            @error('child_category') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="child_category_image">Image <span class="m-l-5 text-danger">*</span></label>
                            <p class="small text-danger mb-2">Size must be less than 200kb</p>
                            <input class="form-control @error('child_category_image') is-invalid @enderror" type="file" name="child_category_image" id="child_category_image" />
                            @error('child_category_image') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Category</button>
                        <a class="btn btn-secondary" href="{{ route('admin.dirsubcategory.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
