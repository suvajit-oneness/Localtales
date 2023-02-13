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
                                <img style="width: 150px;height: 100px;" src="{{URL::to('/').'/properties/'}}{{$property->image}}">
                                @endif</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ empty($property['address'])? null:($property['address']) }}</td>
                        </tr>
                        <tr>
                            <td>Latitude</td>
                            <td>{{ empty($property['lat'])? null:($property['lat']) }}</td>
                        </tr>
                        <tr>
                            <td>Longitude</td>
                            <td>{{ empty($property['lon'])? null:($property['lon']) }}</td>
                        </tr>
                        <tr>
                            <td>Overview</td>
                            <td>{!! empty($property['overview'])? null:($property['overview']) !!}</td>
                        </tr>
                        <tr>
                            <td>Amenities</td>
                            <td>{!! empty($property['amenities'])? null:($property['amenities']) !!}</td>
                        </tr>
                        <tr>
                            <td>Near By</td>
                            <td>{!! empty($property['near_by'])? null:($property['near_by']) !!}</td>
                        </tr>
                        <tr>
                            <td>Contact Person</td>
                            <td>{{ empty($property['contact_person'])? null:($property['contact_person']) }}</td>
                        </tr>
                        <tr>
                            <td>Contact Email</td>
                            <td>{{ empty($property['contact_email'])? null:($property['contact_email']) }}</td>
                        </tr>
                        <tr>
                            <td>Contact Phone</td>
                            <td>{{ empty($property['contact_phone'])? null:($property['contact_phone']) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="tile">
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <tbody>
                        <tr>
                            <td>Business Name</td>
                            <td>{{ empty($property->business['business_name'])? null:($property->business['business_name']) }}</td>
                        </tr>
                        <tr>
                            <td>Owner Name</td>
                            <td>{{ empty($property->business['name'])? null:($property->business['name']) }}</td>
                        </tr>
                        <tr>
                            <td>Email Id</td>
                            <td>{{ empty($property->business['email'])? null:($property->business['email']) }}</td>
                        </tr>
                        <tr>
                            <td>Phone</td>
                            <td>{{ empty($property->business['mobile'])? null:($property->business['mobile']) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection