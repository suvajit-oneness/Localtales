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
                            <td>Event Title</td>
                            <td>{{ empty($event['title'])? null:$event['title'] }}</td>
                        </tr>
                        <tr>
                            <td>Event Image</td>
                            <td>@if($event->image!='')
                                <img style="width: 150px;height: 100px;" src="{{URL::to('/').'/events/'}}{{$event->image}}">
                                @endif</td>
                        </tr>
                        <tr>
                            <td>Category</td>
                            <td>{{ empty($event->category['title'])? null:($event->category['title']) }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ empty($event['address'])? null:($event['address']) }}</td>
                        </tr>
                        <tr>
                            <td>Latitude</td>
                            <td>{{ empty($event['lat'])? null:($event['lat']) }}</td>
                        </tr>
                        <tr>
                            <td>Longitude</td>
                            <td>{{ empty($event['lon'])? null:($event['lon']) }}</td>
                        </tr>
                        <tr>
                            <td>Start Date</td>
                            <td>{{ empty($event['start_date'])? null:(date("d-M-Y",strtotime($event['start_date']))) }}</td>
                        </tr>
                        <tr>
                            <td>End Date</td>
                            <td>{{ empty($event['end_date'])? null:(date("d-M-Y",strtotime($event['end_date']))) }}</td>
                        </tr>
                        <tr>
                            <td>Start Time</td>
                            <td>{{ empty($event['start_time'])? null:($event['start_time']) }}</td>
                        </tr>
                        <tr>
                            <td>End Time</td>
                            <td>{{ empty($event['end_time'])? null:($event['end_time']) }}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{!! empty($event['description'])? null:($event['description']) !!}</td>
                        </tr>
                        <tr>
                            <td>Contact Email</td>
                            <td>{{ empty($event['contact_email'])? null:($event['contact_email']) }}</td>
                        </tr>
                        <tr>
                            <td>Contact Phone</td>
                            <td>{{ empty($event['contact_phone'])? null:($event['contact_phone']) }}</td>
                        </tr>
                        <tr>
                            <td>Website</td>
                            <td>{{ empty($event['website'])? null:($event['website']) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection