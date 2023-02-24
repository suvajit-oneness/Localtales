@extends('business.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
    </div>
    {{-- @include('eventorganiser.partials.flash') --}}
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                @if ($event->end_date < \Carbon\Carbon::now() )
                    <h3 class="text-danger mt-3 fw-bold">EXPIRED</h3>
                {{-- @else
                    <h3 class="text-danger mt-3 fw-bold">ONGOING</h3> --}}
                @endif
                <span class="top-form-btn">
                    <a class="btn btn-primary" href="{{ route('business.event.edit',$event->id) }}">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                </span>
                <h3 class="tile-title"></h3>
                <br>
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <tbody>
                        <tr>
                            <td>Image</td>
                            <td>@if($event->image!='')
                                <img style="width: 150px;height: 100px;" src="{{URL::to('/').'/uploads/events/'}}{{$event->image}}">
                                @endif</td>
                        </tr>
                        <tr>
                            <td>Title</td>
                            <td>{{ empty($event['title'])? null:$event['title'] }}</td>
                        </tr>
                        <tr>
                            <td>Category</td>
                            <td>{!! eventCategory($event->category_id) !!}</td>
                        </tr>
                        <tr>
                            <td>Directory</td>
                            <td>{!! eventBusiness($event->directory_id) !!}</td>
                        </tr>
                        <tr>
                            <td>Host</td>
                            <td>{{ empty($event['host'])? null:($event['host']) }}</td>
                        </tr>
                        <tr>
                            <td>Type</td>
                            <td>{{ empty($event['type'])? null:($event['type']) }}
                            </td>
                        </tr>
                        @if($event->type =='online')
                        <tr>
                            <td>Link</td>
                            <td>{{ empty($event['link'])? null:($event['link']) }}</td>
                        </tr>
                        @else
                        <tr>
                            <td>Address</td>
                            <td>{{ empty($event['address'])? null:($event['address']) }}</td>
                        </tr>
                        <tr>
                            <td>Postcode</td>
                            <td>{{ empty($event['pin'])? null:($event['pin']) }}</td>
                        </tr>
                        <tr>
                            <td>Suburb</td>
                            <td>{{ empty($event['suburb'])? null:($event['suburb']) }}</td>
                        </tr>
                        <tr>
                            <td>State</td>
                            <td>{{ empty($event['state'])? null:($event['state']) }}</td>
                        </tr>
                        {{-- <tr>
                            <td>Latitude</td>
                            <td>{{ empty($event['lat'])? null:($event['lat']) }}</td>
                        </tr>
                        <tr>
                            <td>Longitude</td>
                            <td>{{ empty($event['lon'])? null:($event['lon']) }}</td>
                        </tr> --}}
                        @endif
                        <tr>
                            <td>Start Date</td>
                            <td>{{ empty($event['start_date'])? null:(date('j M, Y', strtotime($event['start_date']))) }}</td>
                        </tr>
                        <tr>
                            <td>End Date</td>
                            <td>{{ empty($event['end_date'])? null:(date('j M, Y', strtotime($event['end_date']))) }}</td>
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
                            <td>{!! empty($event['short_description'])? null:($event['short_description']) !!}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{!! empty($event['description'])? null:($event['description']) !!}</td>
                        </tr>
                        @if($event->is_paid == 0)
                        <tr>
                            <td>Cost</td>
                            <td>Free</td>
                        </tr>
                        @else
                        <tr>
                            <td>Cost</td>
                            <td>{{ empty($event['price'])? null:($event['price']) }}</td>
                        </tr>
                        @endif
                        @if($event->is_recurring==0)
                        <tr>
                            <td>Recurring</td>
                            <td>No</td>
                        </tr>
                        @else
                        <tr>
                            <td>Recurring</td>
                            <td>{{ empty($event['recurring'])? null:($event['recurring']) }}</td>
                        </tr>
                        @endif
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
        <a class="btn btn-secondary" href="{{ route('business.event.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
    </div>
@endsection