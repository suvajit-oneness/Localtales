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
                       
                        
                            
                        <!--<tr>
                            <td>Article Category</td>
                            <td>{{$blog->category ? $blog->category->title : '' }}</td>
                        </tr>
                        <tr>
                            <td>Article Sub Category</td>
                            <td>{{ $blog->subcategory ? $blog->subcategory->title : '' }}</td>
                        </tr>-->
                        
                        {{-- <tr>
                            <td>Pincode</td>
                            <td>{{$blog->pincode ? $blog->pincode->pin : '' }}</td>
                        </tr> --}}
                       
                        <tr>
                            <td>Question</td>
                            <td>{{ empty($blog['question'])? null:$blog['question'] }}</td>
                        </tr>
                        <tr>
                            <td>Answer</td>
                            <td>{{ empty($blog['answer'])? null:$blog['answer'] }}</td>
                        </tr>
                       

                    </tbody>
                </table>
                <a class="btn btn-primary" href="{{ route('admin.blog.index') }}">Cancel</a>
            </div>


        </div>
    </div>
@endsection
