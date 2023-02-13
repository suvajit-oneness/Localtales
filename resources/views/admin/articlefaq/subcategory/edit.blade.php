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
                <form action="{{ route('admin.blogsubcatfaq.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="title">Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title', $targetsubCategory->title) }}"/>
                            <input type="hidden" name="id" value="{{ $targetsubCategory->id }}">
                            @error('title') {{ $message }} @enderror
                        </div>


                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="pin"> Category <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="category_id">
                                <option hidden selected>Select Category...</option>
                                @foreach ($categories as $index => $item)
                                <option value="{{$item->id}}" {{ ($item->id == $targetsubCategory->category_id) ? 'selected' : '' }}>{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>

                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Sub category</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.blogsubcatfaq.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>

                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
