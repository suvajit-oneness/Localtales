@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <tbody>
                        <tr>
                            <td>Article Title</td>
                            <td>{{ empty($blog['title'])? null:$blog['title'] }}</td>
                        </tr>
                        <tr>
                            <td>Article Slug</td>
                            <td>{{ empty($blog['slug'])? null:$blog['slug'] }}</td>
                        </tr>
                        <tr>
                            <td>Article Content</td>
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
                        </tr>
                        <tr>
                            <td>Article Category</td>
                            @php
                                                $cat = $blog->blog_category_id;
                                               // dd($cat);
                                                $displayCategoryName = '';
                                                foreach(explode(',', $cat) as $catKey => $catVal) {
                                                   //
                                                    $catDetails = DB::table('blog_categories')->where('id', $catVal)->first();
                                                   // dd($catDetails);
                                                   if($catDetails !=''){
                                                    $displayCategoryName .= $catDetails->title.' , ';
                                                    //dd($displayCategoryName);
                                                    }
                                                }
                                                
                            @endphp
                             <td>{{substr($displayCategoryName, 0, -2) ?? '' }}</td>
                        </tr>
                        <tr>
                            <td>Article Sub Category</td>
                            <td>{{ $blog->subcategory ? $blog->subcategory->title : '' }}</td>
                        </tr>
                        <tr>
                            <td>Article Tertiary Category</td>
                            <td>{{ $blog->subcategorylevel ? $blog->subcategorylevel->title : '' }}</td>
                        </tr>
                        {{-- <tr>
                            <td>Pincode</td>
                            <td>{{$blog->pincode ? $blog->pincode->pin : '' }}</td>
                        </tr> --}}
                        <tr>
                            <td>Suburb</td>
                            <td>{{ $blog->suburb ? $blog->suburb->name : '' }}</td>
                        </tr>
                        <tr>
                            <td>Article Meta Title</td>
                            <td>{{ empty($blog['meta_title'])? null:$blog['meta_title'] }}</td>
                        </tr>
                        <tr>
                            <td>Article Meta Key</td>
                            <td>{{ empty($blog['meta_key'])? null:$blog['meta_key'] }}</td>
                        </tr>
                        {{-- <tr>
                            <td>Article Tag</td>
                            <td>{{ empty($blog['tag'])? null:$blog['tag'] }}</td>
                        </tr> --}}
                        <tr>
                            <td>Article Image</td>
                            <td>@if($blog->image!='')
                                <img style="width: 150px;height: 100px;" src="{{URL::to('/').'/Blogs/'}}{{$blog->image}}">
                                @endif</td>
                        </tr>
                        <tr>
                            <td>Sticky Heading</td>
                            <td>{!! empty($blog['heading'])? null:($blog['heading']) !!}</td>
                        </tr>
                        <tr>
                            <td> Sticky Description</td>
                            <td>{!! empty($blog['sticky_content'])? null:($blog['sticky_content']) !!}</td>
                        </tr><tr>
                            <td>Sticky Button Text</td>
                            <td>{!! empty($blog['btn_text'])? null:($blog['btn_text']) !!}</td>
                        </tr>
                        <tr>
                            <td>Sticky Button Link</td>
                            <td>{!! empty($blog['btn_link'])? null:($blog['btn_link']) !!}</td>
                        </tr>
                        <tr>
                            <td>Sticky Image</td>
                            <td>@if($blog->sticky_image!='')
                                <img style="width: 150px;height: 100px;" src="{{URL::to('/').'/Blogs/'}}{{$blog->image}}">
                                @else
                                <img style="width: 150px;height: 100px;" src="{{asset('front/img/aside.png')}}">
                                @endif</td>
                        </tr>
                        <tr>
                            <td>Date of creation</td>
                            <td>{!! empty($blog['created_at'])? null:($blog['created_at']) !!}</td>
                        </tr>
                    </tbody>
                </table>
                <a class="btn btn-primary" href="{{ route('admin.blog.index') }}">Cancel</a>
            </div>


        </div>
    </div>
@endsection
