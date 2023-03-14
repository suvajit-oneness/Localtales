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
                            <td> Title</td>
                            <td>{{ empty($data['title'])? null:$data['title'] }}</td>
                        </tr>
                        <tr>
                            <td> Image</td>
                            <td>@if($data->image!='')
                                <img style="width: 150px;height: 100px;" src="{{asset($data->image)}}">
                                @endif</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ $data->suburb.', '.$data->state.', '.$data->postcode }}</td>
                        </tr>
                       
                        <tr>
                            <td>Overview</td>
                            <td>{!! empty($data['description'])? null:($data['description']) !!}</td>
                        </tr>
                        
                        
                    </tbody>
                </table>
            </div>
            <a class="btn btn-secondary" href="{{ route('admin.news.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
        
        </div>
    </div>
@endsection