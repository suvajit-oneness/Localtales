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
                <h3 class="tile-title">{{ $subTitle }}
                    <span class="top-form-btn">

                        <a class="btn btn-secondary" href="{{ route('admin.blog.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>


                <form action="{{ route('admin.blog.store') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Article Title <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
                                id="title" value="{{ old('title') }}" />
                            @error('title')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="pin"> Category <span class="m-l-5 text-danger">
                                    *</span></label>
                            <select class="form-control" name="blog_category_id">
                                <option value="" hidden selected>Select Categoy...</option>
                                @foreach ($blogcat as $index => $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('blog_category_id')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="pin"> Sub Category <span class="m-l-5 text-danger">
                                    *</span></label>
                            <select class="form-control" name="blog_sub_category_id">
                                <option value="" hidden selected>Select Sub Categoy...</option>
                                @foreach ($blogsubcat as $index => $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('blog_sub_category_id')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="pin"> Tertiary Category <span class="m-l-5 text-danger">
                                    *</span></label>
                            <select class="form-control" name="blog_tertiary_category_id">
                                <option value="" hidden selected>Select Tertiary Categoy...</option>
                                @foreach ($blogtercat as $index => $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('blog_tertiary_category_id')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="pincode"> Select Postcode</label>
                            <select class="form-control" name="pincode">
                                <option value="" hidden selected>Select Postcode...</option>
                                @foreach ($pin as $index => $item)
                                    <option value="{{ $item->id }}">{{ $item->pin }}</option>
                                @endforeach
                            </select>
                            @error('pincode')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="suburb_id"> Suburb </label>
                            <select class="form-control" name="suburb_id">
                                <option value="" hidden selected>Select Suburb...</option>
                                @foreach ($suburb as $index => $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            @error('suburb_id')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="content">Content</label>
                            <textarea type="text" class="form-control" rows="4" name="content" id="content">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_title">Meta Title</label>
                            <input class="form-control" rows="4" name="meta_title" id="meta_title"
                                value="{{ old('meta_title') }}" />
                            @error('meta_title')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_key">Meta Key</label>
                            <input class="form-control" rows="4" name="meta_key"
                                id="meta_key"{{ old('meta_key') }} />
                            @error('meta_key')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_description">Meta Description</label>
                            <textarea class="form-control" rows="4" name="meta_description" id="meta_description">{{ old('meta_description') }}</textarea>
                            {{-- <input name="meta_description" type="text" id="upload" onchange="" hidden> --}}
                            @error('meta_description')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_key">Tag</label>
                            <input class="form-control" rows="4" name="tag"
                                id="tag"{{ old('tag') }} />
                            @error('tag')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Article Banner Image</label>
                            <input class="form-control @error('banner_image') is-invalid @enderror" type="file"
                                id="banner_image" name="banner_image" />
                            @error('banner_image')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Article Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file"
                                id="image" name="image" />
                            @error('image')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Article Image2</label>
                            <input class="form-control @error('image2') is-invalid @enderror" type="file"
                                id="image2" name="image2" />
                            @error('image2')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div><br>
                    <h3 class="tile-title">Create Sticky Content</h3><br>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="heading">Article Sticky Heading<span class="m-l-5 text-danger"> *</span></label>
                             <input class="form-control @error('heading') is-invalid @enderror" type="text" name="heading" id="heading" value="{{ old('heading') }}"/>
                             @error('heading') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="sticky_content">Article Sticky Content <span class="m-l-5 text-danger"> *</span></label>
                             <textarea class="form-control @error('sticky_content') is-invalid @enderror" type="text" name="sticky_content" id="sticky_content">{{ old('sticky_content') }}</textarea>
                             @error('sticky_content') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="btn_text">Article Sticky button Text <span class="m-l-5 text-danger"> *</span></label>
                             <input class="form-control @error('btn_text') is-invalid @enderror" type="text" name="btn_text" id="btn_text" value="{{ old('btn_text') }}"/>
                             @error('btn_text') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="btn_link">Article Sticky button Link <span class="m-l-5 text-danger"> *</span></label>
                             <input class="form-control @error('btn_link') is-invalid @enderror" type="text" name="btn_link" id="btn_link" value="{{ old('btn_link') }}"/>
                             @error('btn_link') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-10">
                                <label class="control-label">Article Sticky Image</label>
                                <input class="form-control @error('sticky_image') is-invalid @enderror" type="file" id="sticky_image" name="sticky_image"/>
                                @error('sticky_image') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save
                            Article</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.blog.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
                {{-- <form action="{{ route('admin.blog.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="title">Blog Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}"/>
                            @error('title') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="pin"> Category <span class="m-l-5 text-danger"> *</span></label>
                                <select class="form-control" name="blog_category_id">
                                    <option hidden selected>Select Categoy...</option>
                                    @foreach ($blogcat as $index => $item)
                                        <option value="{{$item->id}}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                @error('blog_category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                        </div>
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="pin"> Sub Category <span class="m-l-5 text-danger"> *</span></label>
                                <select class="form-control" name="blog_sub_category_id">
                                    <option hidden selected>Select Sub Categoy...</option>
                                    @foreach ($blogsubcat as $index => $item)
                                        <option value="{{$item->id}}">{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                @error('blog_sub_category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="content">Content</label>
                            <input type="text" class="form-control" rows="4" name="content" id="content"{{ old('content') }}/>@error('content') {{ $message ?? '' }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_title">Meta Title</label>
                            <input class="form-control" rows="4" name="meta_title" id="meta_title"{{ old('meta_title') }}/>@error('meta_title') {{ $message ?? '' }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_key">Meta Key</label>
                            <input class="form-control" rows="4" name="meta_key" id="meta_key"{{ old('meta_key') }}/>@error('meta_key') {{ $message ?? '' }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_description">Description</label>
                            <textarea class="form-control" rows="4" name="meta_description" id="meta_description">{{ old('meta_description') }}</textarea>
                            <input name="meta_description" type="text" id="upload" onchange="" hidden>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Blog Image</label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                            @error('image') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Blog</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.blog.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form> --}}
            </div>
        </div>
    </div>
@endsection
