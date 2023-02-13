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
                <form action="{{ route('admin.collection.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                            <label class="control-label" for="meta_key"> Keyword <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('meta_key') is-invalid @enderror" type="text" name="meta_key" id="meta_key" value="{{ old('meta_key', $targetcollection->meta_key) }}"/>
                            @error('meta_key') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="title"> Collection Name <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title', $targetcollection->title) }}"/>
                            @error('title') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                         {{--  <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="suburb"> Suburb <span class="m-l-5 text-danger"> *</span></label>
                                <input class="form-control @error('suburb') is-invalid @enderror" type="text" name="suburb" suburb="suburb" value="{{ old('suburb', $targetcollection->suburb) }}"/>
                                @error('suburb') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>--}}
                        <div class="page-search-block filterSearchBoxWraper" style="bottom: -83px;">
                            <div class="filterSearchBox">
                                <div class="row">
                                    <div class="mb-sm-0 col col-lg fcontrol position-relative filter_selectWrap filter_selectWrap2">
                                        <div class="select-floating-admin">
                                            <label>Suburb<span class="m-l-5 text-danger">
                                                *</span></label>
                                            <select class="filter_select form-control" name="suburb">
                                                <option value="" hidden selected>Select Suburb...</option>
                                                @foreach ($suburb as $index => $item)
                                                <option value="{{ $item->name }}"
                                                    {{ $item->name == $targetcollection->suburb ? 'selected' : '' }}>{{ $item->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="control-label" for="category">Category</label>
                            <input type="text" class="form-control"  name="category" id="category" value="{{ old('category', $targetcollection->category) }}"/>
                            @error('category') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>


                        <div class="form-group">
                            <label class="control-label" for="short_description"> Collection Description</label>
                            <textarea class="form-control" rows="4" name="short_description" id="short_description">{{ old('short_description', $targetcollection->short_description) }}</textarea>
                            {{-- <input name="meta_description" type="text" id="upload" onchange="" hidden> --}}
                            @error('description') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="meta_title"> Meta Title <span class="m-l-5 text-danger">
                                    *</span></label>
                            <input class="form-control @error('meta_title') is-invalid @enderror" type="text" name="meta_title"
                                id="meta_title" value="{{ old('meta_title',$targetcollection->meta_title) }}" />
                            @error('meta_title')
                                {{ $message ?? '' }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_description"> Meta Description <span class="m-l-5 text-danger">
                                    *</span></label>
                            <textarea class="form-control @error('meta_description') is-invalid @enderror" type="text"
                                name="meta_description" id="summernote-meta_description">{{ old('meta_description',$targetcollection->meta_description) }}</textarea>
                            @error('meta_description')
                                {{ $message ?? '' }}
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="pin_code">Postcode</label>
                            <input class="form-control" rows="4" name="pin_code" id="pin_code" value="{{ old('pin_code', $targetcollection->pin_code) }}"/>
                            @error('pin_code') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="paragraph1_heading">Paragraph1 Heading</label>
                            <input class="form-control" rows="4" name="paragraph1_heading" id="paragraph1_heading" value="{{ old('paragraph1_heading', $targetcollection->paragraph1_heading) }}"/>
                            @error('paragraph1_heading') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="paragraph1">Paragraph1</label>
                            <textarea class="form-control" rows="4" name="paragraph1" id="paragraph1" >{{ old('paragraph1', $targetcollection->paragraph1) }}"></textarea>
                            @error('paragraph1') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="paragraph2_heading">Paragraph2 Heading</label>
                            <input class="form-control" rows="4" name="paragraph2_heading" id="paragraph2_heading"value="{{ old('paragraph2_heading', $targetcollection->paragraph2_heading) }}"/>
                            @error('paragraph2_heading') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="paragraph2">Paragraph2</label>
                            <textarea class="form-control" rows="4" name="paragraph2" id="paragraph2">{{ old('paragraph2', $targetcollection->paragraph2) }}</textarea>
                            {{-- <input name="meta_description" type="text" id="upload" onchange="" hidden> --}}

                            @error('paragraph2') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="paragraph3_heading">Paragraph3 Heading</label>
                            <input class="form-control" rows="4" name="paragraph3_heading" id="paragraph3_heading" value="{{ old('paragraph3_heading', $targetcollection->paragraph3_heading) }}"/>
                            @error('paragraph3_heading') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="paragraph3">Paragraph3</label>
                            <textarea class="form-control" rows="4" name="paragraph3" id="paragraph3" >{{ old('paragraph3', $targetcollection->paragraph3) }}"</textarea>
                            @error('paragraph3') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="google_doc">Google Doc</label>
                            <input class="form-control" rows="4" name="google_doc" id="google_doc" value="{{ old('google_doc', $targetcollection->google_doc) }}"/>
                            @error('google_doc') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="completion">Completion</label>
                            <input class="form-control" rows="4" name="completion" id="completion" value="{{ old('completion', $targetcollection->completion) }}"/>
                            @error('completion') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="who">Who</label>
                            <input class="form-control" rows="4" name="who" id="paragraph3" value="{{ old('who', $targetcollection->who) }}"/>
                            @error('who') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="quality_check">Quality Check</label>
                            <input class="form-control" rows="4" name="quality_check" id="paragraph3" value="{{ old('quality_check', $targetcollection->quality_check) }}"/>
                            @error('quality_check') <p class="small text-danger">{{ $message }}</p> @enderror
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($targetcollection->image != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ asset('Collection/'.$targetcollection->image) }}" id="blogImage" class="img-fluid" alt="img">
                                        </figure>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label"> Image</label>
                                    <p class="small text-danger mb-2">Size must be less than 200kb</p>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                                    @error('image') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <input type="hidden" name="id" value="{{ $targetcollection->id }}">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Collection</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.collection.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
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
    $('#short_description').summernote({
        height: 400
    });
    $('#paragraph1').summernote({
        height: 400
    });
    $('#paragraph2').summernote({
        height: 400
    });
    $('#paragraph3').summernote({
        height: 400
    });
    $('#summernote-meta_description').summernote({
            height: 400
        });
</script>
@endpush
