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
            <span class="top-form-btn">

<a class="btn btn-secondary" href="{{ route('admin.blog.index') }}"><i
        class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
</span>
                <h3 class="tile-title">{{ $subTitle }}</h3>

                <form action="{{ route('admin.blog.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="title">Article Title <span class="m-l-5 text-danger"> *</span></label>
                                 <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title', $targetblog->title) }}"/>
                                 <input type="hidden" name="id" value="{{ $targetblog->id }}">
                                 @error('title') {{ $message }} @enderror
                            </div>
                        </div>
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="blog_category_id"> Category<span class="m-l-5 text-danger"> *</span></label>
                                @if(strpos($targetblog->blog_category_id, ','))
                                <select class="form-control" name="blog_category_id[]" multiple>
                                    {{-- <option hidden selected></option> --}}
                                    @foreach ($blogcat as $index => $item)
                                    @php
                                        $cat = explode(",", $targetblog->blog_category_id);
                                        $isSelected = in_array($item->id,$cat) ? "selected='selected'" : "";
                                    @endphp
                                    @endphp
                                    <option  value="{{$item->id}}" {{ (in_array($item->id, $cat)) ? 'selected' : '' }} >{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                @else
                                <select class="form-control" name="blog_category_id[]" multiple>
                                    {{-- <option hidden selected></option> --}}
                                    @foreach ($blogcat as $index => $item)
                                    @php
                                        $isSelected = ($item->id == $targetblog->blog_category_id) ? "selected='selected'" : "";
                                    @endphp
                                    @endphp
                                    <option  value="{{$item->id}}" {{($item->id == $targetblog->blog_category_id) ? 'selected' : '' }}>{{ $item->title }}</option>
                                    @endforeach
                                </select>
                                @endif

                                @error('blog_category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                        </div>
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="blog_sub_category_id"> Sub Category </label>
                                <select class="form-control" name="blog_sub_category_id" disabled>
                                        <option value="">None</option>
                                        <option value="" {{ ($targetblog->blog_sub_category_id) ? 'selected' : '' }}>{{$targetblog->subcategory->title ?? ''}}</option>
                                </select>
                                @error('blog_sub_category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                        </div>
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="blog_tertiary_category_id"> Tertiary Category </label>
                                <select class="form-control" name="blog_tertiary_category_id" disabled>
                                <option value="">None</option>
                                <option value="" {{ ($targetblog->blog_tertiary_category_id) ? 'selected' : '' }}>{{$targetblog->subcategorylevel->title ?? ''}}</option>
                                </select>
                                @error('blog_tertiary_category_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                        </div>
                        <div class="page-search-block filterSearchBoxWraper" style="bottom: -83px;">
                            <div class="filterSearchBox">
                                <div class="row">
                                    <div class="mb-sm-0 col col-lg fcontrol position-relative filter_selectWrap filter_selectWrap2">
                        <div class="select-floating-admin">
                            <label class="control-label" for="pincode"> Select Postcode</label>
                            <select class="filter_select form-control" name="pincode">
                                <option value="" hidden selected>Select Postcode...</option>
                                @foreach ($pin as $index => $item)
                                <option value="{{$item->pin}}" {{ ($item->pin == $targetblog->pincode) ? 'selected' : '' }}>{{ $item->pin }}</option>
                                @endforeach
                            </select>
                            @error('pincode')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </div>
                        <div class="tile-body">
                            <div class="form-group">
                                <label class="control-label" for="suburb_id"> Suburb</label>
                                <select class="form-control" name="suburb_id" disabled>
                                <option value="">None</option>
                                <option value="" {{ ($targetblog->suburb_id) ? 'selected' : '' }}>{{$targetblog->suburb->name ?? ''}}</option>

                                </select>
                                @error('suburb_id') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="content">Content</label>
                            <textarea class="form-control" rows="4" name="content" id="summernote_content">{{ old('content', $targetblog->content) }}</textarea>
                            <input type="hidden" name="id" value="{{ $targetblog->id }}">
                            @error('content') {{ $message }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_title">Meta Title</label>
                            <input class="form-control @error('meta_title') is-invalid @enderror" type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $targetblog->meta_title) }}"/>
                            <input type="hidden" name="id" value="{{ $targetblog->id }}">
                            @error('meta_title') {{ $message }} @enderror

                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_key">Meta Key</label>
                            <input class="form-control @error('meta_key') is-invalid @enderror" type="text" name="meta_key" id="meta_key" value="{{ old('meta_key', $targetblog->meta_key) }}"/>
                            <input type="hidden" name="id" value="{{ $targetblog->id }}">
                            @error('meta_key') {{ $message }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="meta_description">Meta Description</label>
                            <textarea class="form-control" rows="4" name="meta_description" id="summernote_meta_description">{{ old('meta_description', $targetblog->meta_description) }}</textarea>
                            <input type="hidden" name="id" value="{{ $targetblog->id }}">
                        </div>
                        {{-- <div class="form-group">
                            <label class="control-label" for="tag">Tag</label>
                            <p class="small text-danger mb-2">(comma ,separated)</p>
                            <input class="form-control @error('tag') is-invalid @enderror" type="text" name="tag" id="tag" value="{{ old('tag', $targetblog->tag) }}" multiple/>
                            <input type="hidden" name="id" value="{{ $targetblog->id }}">
                            @error('tag') {{ $message }} @enderror
                        </div> --}}
                        <!--<div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($targetblog->banner_image != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ asset('Blogs/'.$targetblog->banner_image) }}" id="banner_image" class="img-fluid" alt="img">
                                        </figure>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label">Article Banner Image</label>
                                    <input class="form-control @error('banner_image') is-invalid @enderror" type="file" id="banner_image" name="banner_image"/>
                                    @error('banner_image') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($targetblog->image != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ asset('Blogs/'.$targetblog->image) }}" id="blogImage" class="img-fluid" alt="img">
                                        </figure>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label">Article Image</label>
                                    <p class="small text-danger mb-2">Size must be less than 200kb</p>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                                    @error('image') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($targetblog->image2 != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ asset('Blogs/'.$targetblog->image2) }}" id="blogImage" class="img-fluid" alt="img">
                                        </figure>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label">Article Image2</label>
                                    <input class="form-control @error('image2') is-invalid @enderror" type="file" id="image2" name="image2"/>
                                    @error('image2') {{ $message }} @enderror
                                </div>
                            </div>
                        </div>-->
                    </div>
                    <h3 class="tile-title">Edit Sticky Content</h3>
                    <div class="article-radio-option-wrap d-flex align-items-center">
                        <label class="inner-wrapper ml-3" for="articleRadioInput2">
                            <input type="radio" name="type" id="articleRadioInput2" value="1"{{ (1 == $targetblog->type) ? 'checked' : '' }}>
                            <span>Half Image</span>
                        </label>
                        <label class="inner-wrapper" for="articleRadioInput1">
                            <input type="radio" name="type" id="articleRadioInput1" value="2"{{ (2 == $targetblog->type) ? 'checked' : '' }}>
                            <span>Full Image</span>
                        </label>
                    </div>
                    <br>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="heading">Article Sticky Heading<span class="m-l-5 text-danger"> *</span></label>
                             <input class="form-control @error('heading') is-invalid @enderror" type="text" name="heading" id="heading" value="{{ old('heading', $targetblog->heading) }}"/>
                             <input type="hidden" name="id" value="{{ $targetblog->id }}">
                             @error('heading') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="sticky_content">Article Sticky Content <span class="m-l-5 text-danger"> *</span></label>
                             <textarea class="form-control @error('sticky_content') is-invalid @enderror" type="text" name="sticky_content" id="summernote_sticky_content">{{ old('sticky_content', $targetblog->sticky_content) }}</textarea>
                             <input type="hidden" name="id" value="{{ $targetblog->id }}">
                             @error('sticky_content') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="btn_text">Article Sticky button Text <span class="m-l-5 text-danger"> *</span></label>
                             <input class="form-control @error('btn_text') is-invalid @enderror" type="text" name="btn_text" id="btn_text" value="{{ old('btn_text', $targetblog->btn_text) }}"/>
                             <input type="hidden" name="id" value="{{ $targetblog->id }}">
                             @error('btn_text') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="btn_link">Article Sticky button Link <span class="m-l-5 text-danger"> *</span></label>
                             <input class="form-control @error('btn_link') is-invalid @enderror" type="text" name="btn_link" id="btn_link" value="{{ old('btn_link', $targetblog->btn_link) }}"/>
                             <input type="hidden" name="id" value="{{ $targetblog->id }}">
                             @error('btn_link') {{ $message }} @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                @if ($targetblog->sticky_image != null)
                                    <figure class="mt-2" style="width: 80px; height: auto;">
                                        <img src="{{ asset('Blogs/'.$targetblog->sticky_image) }}" id="blogImage" class="img-fluid" alt="img">
                                    </figure>
                                    @else
                                    <figure class="mt-2" style="width: 80px; height: auto;">
                                        <img src="{{asset('front/img/aside.png')}}" id="blogImage" class="img-fluid" alt="img">
                                    </figure>
                                @endif
                            </div>
                            <div class="col-md-10">
                                <label class="control-label">Article Sticky Image</label>
                                <p class="small text-danger mb-2">Size must be less than 200kb</p>
                                <input class="form-control @error('sticky_image') is-invalid @enderror" type="file" id="sticky_image" name="sticky_image"/>
                                @error('sticky_image') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>

                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Article</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.blog.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
        <!--<div class="row">
            <div class="col-md-8 mx-auto">
                <div class="tile">
                  <h3 class="tile-title">Article Faq</h3>
                  <span class="top-form-btn">
                    <a type="button" class="btn btn-primary" href="#" data-toggle="modal" data-target="#widgetModal">
                       Add New
                    </a>
                  </span><br><br>
                    <div class="tile">
                        <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th> Title </th>
                                <th> Description </th>
                                <th> Button Text </th>
                                <th> Button Link </th>
                                <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($widget as $key => $blog)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                   <td>{{ $blog->widget_heading }}</td>
                                    <td>@php
                                        $desc = strip_tags($blog['widget_content']);
                                        $length = strlen($desc);
                                        if($length>50)
                                        {
                                            $desc = substr($desc,0,50)."...";
                                        }else{
                                            $desc = substr($desc,0,50);
                                        }
                                    @endphp
                                    {!! $desc !!}</td>
                                    <td>{{$blog->widget_btn_text }}</td>
                                    <td>{{ $blog->widget_btn_link  }}</td>
                                    <td class="text-center">
                                       <div class="btn-group" role="group" aria-label="Second group">
                                        <a href="javascript: void(0)" class="btn btn-sm btn-primary edit-btn" data-toggle="modal" data-target="#editWidgetModal-<?php echo $blog['id']; ?>"><i class="fa fa-edit"></i></a>
                                        <a href="#" data-id="{{$blog['id']}}" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a>
                                        </div>
                                   </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                </div>
                </div>
            </div>
        </div>-->

        <hr>

        <div class="row mt-5">
            <div class="col-md-8 mx-auto">
            <div class="row mx-0 align-items-center justify-content-between">
                <div class="col-6">
                    <h2>Article FAQ</h2>
                </div>
                <div class="col-6">
                    <div class="col-md-9 text-right">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#featureModal">
                            Add New
                        </button>
                    </div>
                </div>
                    {{--<ul>
                         @php
                            $activeCount = $inactiveCount = 0;
                            foreach ($data as $catKey => $catVal) {
                                if ($catVal->status == 1) $activeCount++;
                                else $inactiveCount++;
                            }
                        @endphp
                        <li><a href="{{ route('admin.blogfaq.index', ['status' => 'active'])}}">Active <span class="count">({{$activeCount}})</span></a></li>
                        <li><a href="{{ route('admin.blogfaq.index', ['status' => 'inactive'])}}">Inactive <span class="count">({{$inactiveCount}})</span></a></li>
                    </ul> --}}
                </div>
                {{--  <div class="col-auto">
                    <form action="{{ route('admin.blogfaq.index', $blogs['id']) }}">
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                        <input type="search" name="term" id="term" class="form-control" placeholder="Search here.." value="{{app('request')->input('term')}}" autocomplete="off">
                        </div>
                        <div class="col-auto">
                        <button type="submit" class="btn btn-outline-danger btn-sm">Search Article</button>
                        </div>
                    </div>
                    </form>
                </div>--}}
            </div>
            <div class="col-md-8 mx-auto">
                <div class="tile p-0">
                    <div class="tile-body">

                        <table class="table table-hover custom-data-table-style table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th> Question </th>
                                    <th> Answer </th>
                                    <th> Status </th>
                                    <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($blogfaq as $key => $blog)
                                    <tr>
                                        <td>{{ $key+1 }}</td>
                                        <td>{!! $blog->question ?? '' !!}</td>
                                        <td>{!! $blog->answer ?? '' !!}</td>

                                        <td class="text-center">
                                        <div class="toggle-button-cover margin-auto">
                                            <div class="button-cover">
                                                <div class="button-togglr b2" id="button-11">
                                                    <input id="toggle-block" type="checkbox" name="status" class="checkbox" data-blogfaq_id="{{ $blog['id'] }}" {{ $blog['status'] == 1 ? 'checked' : '' }}>
                                                    <div class="knobs"><span>Inactive</span></div>
                                                    <div class="layer"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group" role="group" aria-label="Second group">
                                            <a href="{{ route('admin.blogfaq.edit', $blog['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('admin.blogfaq.details', $blog['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                            {{-- <a href="#" data-id="{{$blog['id']}}" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a> --}}
                                            <a href="{{ route('admin.blogfaq.delete', $blog['id']) }}"  class="btn btn-sm btn-primary edit-btn"><i class="fa fa-trash"></i></a>

                                        </div>
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $blogfaq->links() !!}
                    </div>
                </div>
            </div>

        </div>
    </div>
             <!--<div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="tile">
                    <h3 class="tile-title">Add Article Features</h3>
                    <span class="top-form-btn">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#featureModal">
                           Add New
                          </button>
                    </span><br><br>
                    <div class="tile">
                        <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center"><i class="fi fi-br-picture"></i> Image</th>
                                <th> Title </th>
                                <th> Highlights </th>
                                <th> Description </th>
                                <th> Button Text </th>
                                <th> Button Link </th>
                                <th> Features </th>
                                <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($feature as $key => $blog)
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>
                                        @if($blog->image!='')
                                        <img style="width: 100px;height: 100px;" src="{{URL::to('/').'/Blogs/'}}{{$blog->image}}">
                                        @endif
                                    </td>
                                   <td>{{ $blog->heading }}</td>
                                   <td>{{ $blog->highlights }}</td>
                                    <td>@php
                                        $desc = strip_tags($blog['content']);
                                        $length = strlen($desc);
                                        if($length>50)
                                        {
                                            $desc = substr($desc,0,50)."...";
                                        }else{
                                            $desc = substr($desc,0,50);
                                        }
                                    @endphp
                                    {!! $desc !!}</td>
                                    <td>{{$blog->btn_text }}</td>
                                    <td>{{ $blog->btn_link  }}</td>
                                    <td>{{ $blog->features  }}</td>
                                    <td class="text-center">
                                       <div class="btn-group" role="group" aria-label="Second group">
                                        <a href="javascript: void(0)" class="btn btn-sm btn-primary edit-btn" data-toggle="modal" data-target="#editFeatureModal-<?php echo $blog['id']; ?>"><i class="fa fa-edit"></i></a>
                                        <a href="#" data-id="{{$blog['id']}}" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a>
                                        </div>
                                   </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>

    <div class="modal fade" id="widgetModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Widget Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.blogwidget.store')}}" method="post">
                    @csrf
                    {{-- <input type="hidden" name="product_id" value="{{$id}}"> --}}
                    <input type="hidden" name="blog_id" value="{{ $targetblog->id }}">
                    <div class="form-group">
                        <label class="control-label" for="widget_heading">Widget Heading </label>
                         <input class="form-control @error('widget_heading') is-invalid @enderror" type="text" name="widget_heading" id="widget_heading" value="{{ old('widget_heading') }}"/>
                         @error('widget_heading') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="widget_content">Widget Content </label>
                        <textarea class="form-control @error('widget_content') is-invalid @enderror" type="text" name="widget_content" id="widget_content" >{{ old('widget_content') }}</textarea>
                         @error('widget_content') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="widget_btn_text">Widget button Text </label>
                         <input class="form-control @error('widget_btn_text') is-invalid @enderror" type="text" name="widget_btn_text" id="widget_btn_text" value="{{ old('widget_btn_text') }}"/>
                         @error('widget_btn_text') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="widget_btn_link">Widget button Link </label>
                         <input class="form-control @error('widget_btn_link') is-invalid @enderror" type="text" name="widget_btn_link" id="widget_btn_link" value="{{ old('widget_btn_link') }}"/>
                         @error('widget_btn_link') {{ $message }} @enderror
                    </div>

                <div class="modal-footer">
                   <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
      </div>
    </div>
      <!--<div class="modal fade" id="featureModal" tabindex="-1" aria-labelledby="featureModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Feature Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.blogfeature.store')}}" method="post">@csrf

                    <input type="hidden" name="blog_id" value="{{ $targetblog->id }}">
                    <div class="form-group">
                        <label class="control-label" for="heading">Feature Heading </label>
                         <input class="form-control @error('heading') is-invalid @enderror" type="text" name="heading" id="heading	" value="{{ old('heading') }}"/>
                         @error('heading') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="highlights">Feature Highlights </label>
                         <input class="form-control @error('highlights') is-invalid @enderror" type="text" name="highlights" id="highlights" value="{{ old('highlights') }}"/>
                         @error('highlights') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="content">Feature Content </label>
                         <textarea class="form-control @error('content') is-invalid @enderror" type="text" name="content" id="content" >{{ old('content') }}</textarea>
                         @error('content') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="btn_text">Feature button Text </label>
                         <input class="form-control @error('btn_text') is-invalid @enderror" type="text" name="btn_text" id="btn_text" value="{{ old('btn_text') }}"/>
                         @error('btn_text') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="btn_link">Feature button Link </label>
                         <input class="form-control @error('btn_link') is-invalid @enderror" type="text" name="btn_link" id="btn_link" value="{{ old('btn_link') }}"/>
                         @error('btn_link') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="features">Features </label>
                         <input class="form-control @error('features') is-invalid @enderror" type="text" name="features" id="features" value="{{ old('features') }}"/>
                         @error('features') {{ $message }} @enderror
                    </div>
                    {{--  <div class="form-group">
                        <div class="row">
                            <div class="col-md-10">
                                <label class="control-label"> Image</label>
                                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                                @error('image') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>--}}

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
          </div>
        </div>
      </div>
    </div>


      @foreach($widget as $key => $blog)
      <div class="modal fade" id="editWidgetModal-<?php echo $blog['id']; ?>" tabindex="-1" aria-labelledby="editWidgetLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editWidgetLabel-<?php echo $blog['id']; ?>">Edit Widget</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.blogwidget.update',$blog->id)}}" method="post">@csrf
                    {{-- <input type="hidden" name="product_id" value="{{$id}}"> --}}
                    <input type="hidden" name="blog_id" value="{{ $targetblog->id }}">
                    <div class="form-group">
                        <label class="control-label" for="widget_heading">Widget Heading </label>
                         <input class="form-control @error('widget_heading') is-invalid @enderror" type="text" name="widget_heading" id="widget_heading" value="{{ old('widget_heading', $blog->widget_heading) }}"/>
                         <input type="hidden" name="id" value="{{ $blog->id }}">
                         @error('widget_heading') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="widget_content">Widget Content </label>
                        <textarea class="form-control @error('widget_content') is-invalid @enderror" type="text" name="widget_content" id="widget_content" >{{ old('widget_content', $blog->widget_content) }}</textarea>
                        <input type="hidden" name="id" value="{{ $blog->id }}">
                         @error('widget_content') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="widget_btn_text">Widget button Text </label>
                         <input class="form-control @error('widget_btn_text') is-invalid @enderror" type="text" name="widget_btn_text" id="widget_btn_text" value="{{ old('widget_btn_text', $blog->widget_btn_text) }}"/>
                         <input type="hidden" name="id" value="{{ $blog->id }}">
                         @error('widget_btn_text') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="widget_btn_link">Widget button Link </label>
                         <input class="form-control @error('widget_btn_link') is-invalid @enderror" type="text" name="widget_btn_link" id="widget_btn_link" value="{{ old('widget_btn_link', $blog->widget_btn_link) }}"/>
                         <input type="hidden" name="id" value="{{ $blog->id }}">
                         @error('widget_btn_link') {{ $message }} @enderror
                    </div>

            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
            </form>
          </div>
        </div>
      </div>
    </div>
      @endforeach

        @foreach($feature as $key => $blog)
        <div class="modal fade" id="editFeatureModal-<?php echo $blog['id']; ?>" tabindex="-1" aria-labelledby="editFeatureLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                  <h5 class="modal-title" id="editFeatureLabel-<?php echo $blog['id']; ?>">Edit Widget</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <form action="{{route('admin.blogfeature.update',$blog->id)}}" method="post">@csrf
                      {{-- <input type="hidden" name="product_id" value="{{$id}}"> --}}
                      <input type="hidden" name="blog_id" value="{{ $targetblog->id }}">
                      <div class="form-group">
                          <label class="control-label" for="heading"> Heading </label>
                           <input class="form-control @error('heading') is-invalid @enderror" type="text" name="heading" id="widget_heading" value="{{ old('heading', $blog->heading) }}"/>
                           <input type="hidden" name="id" value="{{ $blog->id }}">
                           @error('heading') {{ $message }} @enderror
                      </div>
                      <div class="form-group">
                        <label class="control-label" for="highlights"> Highlights </label>
                         <input class="form-control @error('highlights') is-invalid @enderror" type="text" name="highlights" id="highlights" value="{{ old('highlights', $blog->highlights) }}"/>
                         <input type="hidden" name="id" value="{{ $blog->id }}">
                         @error('highlights') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="features"> Features </label>
                         <input class="form-control @error('features') is-invalid @enderror" type="text" name="features" id="features" value="{{ old('features', $blog->features) }}"/>
                         <input type="hidden" name="id" value="{{ $blog->id }}">
                         @error('features') {{ $message }} @enderror
                    </div>
                      <div class="form-group">
                          <label class="control-label" for="content"> Content </label>
                          <textarea class="form-control @error('content') is-invalid @enderror" type="text" name="content" id="content" >{{ old('content', $blog->content) }}</textarea>
                          <input type="hidden" name="id" value="{{ $blog->id }}">
                           @error('content') {{ $message }} @enderror
                      </div>
                      <div class="form-group">
                          <label class="control-label" for="btn_text"> button Text </label>
                           <input class="form-control @error('btn_text') is-invalid @enderror" type="text" name="btn_text" id="btn_text" value="{{ old('btn_text', $blog->btn_text) }}"/>
                           <input type="hidden" name="id" value="{{ $blog->id }}">
                           @error('btn_text') {{ $message }} @enderror
                      </div>
                      <div class="form-group">
                          <label class="control-label" for="btn_link"> button Link </label>
                           <input class="form-control @error('btn_link') is-invalid @enderror" type="text" name="btn_link" id="btn_link" value="{{ old('btn_link', $blog->btn_link) }}"/>
                           <input type="hidden" name="id" value="{{ $blog->id }}">
                           @error('btn_link') {{ $message }} @enderror
                      </div>
                      {{-- <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                @if ($blog->image != null)
                                    <figure class="mt-2" style="width: 80px; height: auto;">
                                        <img src="{{ asset('Blogs/'.$blog->image) }}" id="blogImage" class="img-fluid" alt="img">
                                    </figure>
                                @endif
                            </div>
                            <div class="col-md-10">
                                <label class="control-label">Article Image</label>
                                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                                @error('image') {{ $message }} @enderror
                            </div>
                        </div>
                    </div> --}}
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
        @endforeach-->

        <div class="modal fade" id="featureModal" tabindex="-1" aria-labelledby="featureModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Faq Details</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.blogfaq.store')}}" method="post">@csrf

                     <input type="hidden" name="blog_id" value="{{ $targetblog->id }}">
                     <input type="hidden" name="blog_slug" value="{{ $targetblog->slug }}">
                    <!--<div class="form-group">
                        <label class="control-label" for="heading">Category </label>
                        <select class="form-control" name="category_id">
                            <option hidden selected>Select Category...</option>
                            @foreach ($blogcat as $index => $item)
                            <option value="{{$item->id}}">{{ $item->title }}</option>
                        @endforeach
                        </select>
                         @error('heading') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="highlights">Subcategory </label>
                        <select class="form-control" name="sub_category_id">
                            <option hidden selected>Select Category...</option>
                            @foreach ($blogsubcat as $index => $item)
                            <option value="{{$item->id}}">{{ $item->title }}</option>
                        @endforeach
                        </select>
                    </div>-->
                    <div class="form-group">
                        <label class="control-label" for="question">Question </label>
                         <textarea class="form-control @error('question') is-invalid @enderror" type="text" name="question" id="question" >{{ old('question') }}</textarea>
                         @error('question') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="answer">Answer </label>
                        <textarea  class="form-control @error('answer') is-invalid @enderror" type="text" name="answer" id="answer" >{{ old('answer') }}</textarea>
                         @error('answer') {{ $message }} @enderror
                    </div>



            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
          </div>
        </div>
      </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});</script>
     {{-- New Add --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script type="text/javascript">
    $('.sa-remove').on("click",function(){
        var id = $(this).data('id');
        swal({
          title: "Are you sure?",
          text: "Your will not be able to recover the record!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: false
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = "http://demo91.co.in/localtales-prelaunch/public/admin/blogwidget/"+id+"/delete";
            } else {
              swal("Cancelled", "Record is safe", "error");
            }
        });
    });
    </script>
    <script type="text/javascript">
    /*
        $('input[id="toggle-block"]').change(function() {
            var blog_id = $(this).data('blog_id');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var check_status = 0;
          if($(this).is(":checked")){
              check_status = 1;
          }else{
            check_status = 0;
          }
          $.ajax({
                type:'POST',
                dataType:'JSON',
                url:"{{route('admin.blog.updateStatus')}}",
                data:{ _token: CSRF_TOKEN, id:blog_id, check_status:check_status},
                success:function(response)
                {
                  swal("Success!", response.message, "success");
                },
                error: function(response)
                {

                  swal("Error!", response.message, "error");
                }
              });
        });
    */
    </script>
    <script type="text/javascript">
    $('.sa-remove').on("click",function(){
        var id = $(this).data('id');
        swal({
          title: "Are you sure?",
          text: "Your will not be able to recover the record!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: false
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = "http://demo91.co.in/localtales-prelaunch/public/admin/blogfeature/"+id+"/delete";
            } else {
              swal("Cancelled", "Record is safe", "error");
            }
        });
    });
    </script>
    @if (session('csv'))
        <script>
            swal("Success!", "{{ session('csv') }}", "success");
        </script>
    @endif

    <script>
		$('select[name="blog_category_id[]"]').on('change', (event) => {
			var value = $('select[name="blog_category_id[]"]').val();

			$.ajax({
				url: '{{url("/")}}/api/subcategory/'+value,
                method: 'GET',
                success: function(result) {
					var content = '';
					var slectTag = 'select[name="blog_sub_category_id"]';
					var displayCollection = (result.data.cat_name == "all") ? "All Subcategory" : " Select ";

					content += '<option value="" selected>'+displayCollection+'</option>';
					$.each(result.data.subcategory, (key, value) => {
						content += '<option value="'+value.subcategory_id+'">'+value.subcategory_title+'</option>';
					});
					$(slectTag).html(content).attr('disabled', false);
                }
			});
		});

        $('select[name="blog_sub_category_id"]').on('change', (event) => {
			var value = $('select[name="blog_sub_category_id"]').val();

			$.ajax({
				url: '{{url("/")}}/api/tertiarycategory/'+value,
                method: 'GET',
                success: function(result) {
					var content = '';
					var slectTag = 'select[name="blog_tertiary_category_id"]';
					var displayCollection = (result.data.cat_name == "all") ? "All Subcategory" : " Select";

					content += '<option value="" selected>'+displayCollection+'</option>';
					$.each(result.data.tertiarycategory, (key, value) => {
						content += '<option value="'+value.tertiarycategory_id+'">'+value.tertiarycategory_title+'</option>';
					});
					$(slectTag).html(content).attr('disabled', false);
                }
			});
		});

        $('select[name="pincode"]').on('change', (event) => {
			var value = $('select[name="pincode"]').val();

			$.ajax({
				url: '{{url("/")}}/api/postcode-suburb/'+value,
                method: 'GET',
                success: function(result) {
					var content = '';
					var slectTag = 'select[name="suburb_id"]';
					var displayCollection = (result.data.postcode == "all") ? "All postcode" : " Select";

					content += '<option value="" selected>'+displayCollection+'</option>';
					$.each(result.data.suburb, (key, value) => {
						content += '<option value="'+value.suburb_id+'">'+value.suburb_title+'</option>';
					});
					$(slectTag).html(content).attr('disabled', false);
                }
			});
		});
    </script>

<script type="text/javascript">
    $('.sa-remove').on("click",function(){
        var id = $(this).data('id');
        swal({
          title: "Are you sure?",
          text: "Your will not be able to recover the record!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: false
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = "http://demo91.co.in/localtales-prelaunch/public/admin/blogfaq/"+id+"/delete";
            } else {
              swal("Cancelled", "Record is safe", "error");
            }
        });
    });
    </script>
    <script type="text/javascript">
        $('input[id="toggle-block"]').change(function() {
            var blogfaq_id = $(this).data('blogfaq_id');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var check_status = 0;
          if($(this).is(":checked")){
              check_status = 1;
          }else{
            check_status = 0;
          }
          $.ajax({
                type:'POST',
                dataType:'JSON',
                url:"{{route('admin.blogfaq.updateStatus')}}",
                data:{ _token: CSRF_TOKEN, id:blogfaq_id, check_status:check_status},
                success:function(response)
                {
                  swal("Success!", response.message, "success");
                },
                error: function(response)
                {

                  swal("Error!", response.message, "error");
                }
              });
        });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script type="text/javascript">
        $('#summernote_content').summernote({
            height: 400
        });
        $('#summernote_meta_description').summernote({
            height: 400
        });
        $('#summernote_sticky_content').summernote({
            height: 400
        });
        $('#question').summernote({
            height: 400
        });
        $('#answer').summernote({
            height: 400
        });
    </script>
@endpush
