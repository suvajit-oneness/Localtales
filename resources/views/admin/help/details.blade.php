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
                            <td>Article Content</td>
                            <td>@php
                                $desc = strip_tags($blog['description']);
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
                            <td>{{$blog->category ? $blog->category->title : '' }}</td>
                        </tr>
                        <tr>
                            <td>Article Sub Category</td>
                            <td>{{ $blog->subcategory ? $blog->subcategory->title : '' }}</td>
                        </tr>
                        {{-- <tr>
                            <td>Pincode</td>
                            <td>{{$blog->pincode ? $blog->pincode->pin : '' }}</td>
                        </tr> --}}
                       
                      

                    </tbody>
                </table>
                <a class="btn btn-primary" href="{{ route('admin.userhelp.index') }}">Cancel</a>
            </div>


        </div>
    </div>
@endsection
