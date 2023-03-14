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
                            <td>Property Title</td>
                            <td>{{ empty($property['title'])? null:$property['title'] }}</td>
                        </tr>
                        <tr>
                            <td>Property Image</td>
                            <td>@if($property->image!='')
                                <img style="width: 150px;height: 100px;" src="{{asset($property->image)}}">
                                @endif</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ $property->street_address.', '.$property->suburb.', '.$property->state.', '.$property->postcode }}</td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td>{{ empty($property['type'])? null:($property['type']) }}</td>
                        </tr>
                        <tr>
                            <td>Price</td>
                            <td>{{ empty($property['price'])? null:($property['price']) }}</td>
                        </tr>
                        <tr>
                            <td>Bedroom</td>
                            <td>{!! empty($property['bedroom'])? null:($property['bedroom']) !!}</td>
                        </tr>
                        <tr>
                            <td>Bathroom</td>
                            <td>{!! empty($property['bathroom'])? null:($property['bathroom']) !!}</td>
                        </tr>
                        <tr>
                            <td>Overview</td>
                            <td>{!! empty($property['description'])? null:($property['description']) !!}</td>
                        </tr>
                        
                        
                    </tbody>
                </table>
            </div>

        
        </div>
    </div>
@endsection