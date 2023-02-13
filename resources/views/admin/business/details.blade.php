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
                            <td>Business Name</td>
                            <td>{{ empty($business['business_name'])? null:$business['business_name'] }}</td>
                        </tr>
                        <tr>
                            <td>Owner Name</td>
                            <td>{{ empty($business['name'])? null:$business['name'] }}</td>
                        </tr>
                        <tr>
                            <td>Image</td>
                            <td>@if($business->image!='')
                                <img style="width: 150px;height: 100px;" src="{{URL::to('/').'/businesses/'}}{{$business->image}}">
                                @endif</td>
                        </tr>
                        <tr>
                            <td>Category</td>
                            <td>{{ empty($business->category['title'])? null:($business->category['title']) }}</td>
                        </tr>
                        <tr>
                            <td>Email Id</td>
                            <td>{{ empty($business['email'])? null:$business['email'] }}</td>
                        </tr>
                        <tr>
                            <td>Phone No</td>
                            <td>{{ empty($business['mobile'])? null:$business['mobile'] }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ empty($business['address'])? null:($business['address']) }}</td>
                        </tr>
                        <tr>
                            <td>Latitude</td>
                            <td>{{ empty($business['lat'])? null:($business['lat']) }}</td>
                        </tr>
                        <tr>
                            <td>Longitude</td>
                            <td>{{ empty($business['lon'])? null:($business['lon']) }}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{!! empty($business['description'])? null:($business['description']) !!}</td>
                        </tr>
                        <tr>
                            <td>Service Description</td>
                            <td>{!! empty($business['service_description'])? null:($business['service_description']) !!}</td>
                        </tr>
                        <tr>
                            <td>Opening Hour</td>
                            <td>{{ empty($business['opening_hour'])? null:($business['opening_hour']) }}</td>
                        </tr>
                        <tr>
                            <td>Website</td>
                            <td>{{ empty($business['website'])? null:($business['website']) }}</td>
                        </tr>
                        <tr>
                            <td>Facebook Link</td>
                            <td>{{ empty($business['facebook_link'])? null:($business['facebook_link']) }}</td>
                        </tr>
                        <tr>
                            <td>Instagram Link</td>
                            <td>{{ empty($business['instagram_link'])? null:($business['instagram_link']) }}</td>
                        </tr>
                        <tr>
                            <td>Twitter Link</td>
                            <td>{{ empty($business['twitter_link'])? null:($business['twitter_link']) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <p>Deal List - {{ empty($business['business_name'])? null:$business['business_name'] }}</p>
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th> Title </th>
                                <th> Description </th>
                                <th> Image </th>
                                <th> Expiry Date </th>
                                <th> Price</th>
                                <th> Promo Code</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($business->deals as $key => $deal)
                                <tr>
                                    <td>{{ $deal->id }}</td>
                                    <td>{{ $deal->title }}</td>
                                    <td>
                                        @php 
                                            $desc = strip_tags($deal['description']);
                                            $length = strlen($desc);
                                            if($length>50)
                                            {
                                                $desc = substr($desc,0,50)."...";
                                            }else{
                                                $desc = substr($desc,0,50);
                                            }
                                        @endphp
                                        {!! $desc !!}
                                    </td>
                                    <td>
                                        @if($deal->image!='')
                                        <img style="width: 150px;height: 100px;" src="{{URL::to('/').'/deals/'}}{{$deal->image}}">
                                        @endif
                                    </td>
                                    <td>{{ date("d-M-Y",strtotime($deal->expiry_date)) }}</td>
                                    <td>${{ $deal->price }}</td>
                                    <td>{{$deal->promo_code}}</td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <p>Property List - {{ empty($business['business_name'])? null:$business['business_name'] }}</p>
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th> Title </th>
                                <th> Image </th>
                                <th> Address </th>
                                <th> Contact Details</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($business->properties as $key => $property)
                                <tr>
                                    <td>{{ $property->id }}</td>
                                    <td>{{ $property->title }}</td>
                                    <td>
                                        @if($property->image!='')
                                        <img style="width: 150px;height: 100px;" src="{{URL::to('/').'/properties/'}}{{$property->image}}">
                                        @endif
                                    </td>
                                    <td>{{ $property->address }}</td>
                                    <td>Person : {{ $property->contact_person }}<br> Email : {{$property->contact_email}}<br> Phone : {{$property->contact_phone}}</td>
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection