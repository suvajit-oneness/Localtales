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
                            <td> Name</td>
                            <td>{{ empty($directory['name'])? null:$directory['name'] }}</td>
                        </tr>
                        <tr>
                            <td>Image</td>
                            <td>@if ($directory->image == 'placeholder-image.png')
                                <img style="width: 150px;height: 100px;" src="{{URL::to('/').'/Directory/'}}{{$directory->image}}">
                                @else
                                                <img style="width: 100px;height: 100px;" src="{{ $directory->image }}">
                                            @endif</td>
                        </tr>
                        <tr>
                            <td>Email Id</td>
                            <td>{{ empty($directory['email'])? null:$directory['email'] }}</td>
                        </tr>
                        <tr>
                            <td>Phone No</td>
                            <td>{{ empty($directory['mobile'])? null:$directory['mobile'] }}</td>
                        </tr>
                        <tr>
                            <td>Password</td>
                            <td>{{ empty($directory['password'])? null:$directory['password'] }}</td>
                        </tr>
                        <tr>
                            <td>Category</td>
                            <td>
                             
                                 {{ empty($directory->category->title)? null:$directory->category->title}} 
                            </td>
                        </tr>
                        <tr>
                            <td>Establish Year</td>
                            <td>{{ empty($directory['establish_year'])? null:$directory['establish_year'] }}</td>
                        </tr> <tr>
                            <td>ABN</td>
                            <td>{{ empty($directory['ABN'])? null:$directory['ABN'] }}</td>
                        </tr> <tr>
                            <td>Monday</td>
                            <td>{{ empty($directory['monday'])? null:$directory['monday'] }}</td>
                        </tr> <tr>
                            <td>Tuesday</td>
                            <td>{{ empty($directory['tuesday'])? null:$directory['tuesday'] }}</td>
                        </tr> <tr>
                            <td>Wednesday</td>
                            <td>{{ empty($directory['wednesday'])? null:$directory['wednesday'] }}</td>
                        </tr> <tr>
                            <td>Thursday</td>
                            <td>{{ empty($directory['thursday'])? null:$directory['thursday'] }}</td>
                        </tr> <tr>
                            <td>Friday</td>
                            <td>{{ empty($directory['friday'])? null:$directory['friday'] }}</td>
                        </tr> <tr>
                            <td>Saturday</td>
                            <td>{{ empty($directory['saturday'])? null:$directory['saturday'] }}</td>
                        </tr> <tr>
                            <td>Sunday</td>
                            <td>{{ empty($directory['sunday'])? null:$directory['sunday'] }}</td>
                        </tr> <tr>
                            <td>Public Holiday</td>
                            <td>{{ empty($directory['public_holiday'])? null:$directory['public_holiday'] }}</td>
                        </tr> <tr>
                            <td>Category Tree</td>
                            <td>{{ empty($directory['category_tree'])? null:$directory['category_tree'] }}</td>
                        </tr>
                        <tr>
                            <td>Address</td>
                            <td>{{ empty($directory['address'])? null:($directory['address']) }}</td>
                        </tr>
                        <tr>
                            <td>PinCode</td>
                            <td>{{ empty($directory['pin'])? null:($directory['pin']) }}</td>
                        </tr>
                        <tr>
                            <td>Latitude</td>
                            <td>{{ empty($directory['lat'])? null:($directory['lat']) }}</td>
                        </tr>
                        <tr>
                            <td>Longitude</td>
                            <td>{{ empty($directory['lon'])? null:($directory['lon']) }}</td>
                        </tr>
                        <tr>
                            <td>Description</td>
                            <td>{!! empty($business['description'])? null:($business['description']) !!}</td>
                        </tr>
                        <tr>
                            <td>Service Description</td>
                            <td>{!! empty($directory['service_description'])? null:($directory['service_description']) !!}</td>
                        </tr>
                        <tr>
                            <td>Opening Hour</td>
                            <td>{{ empty($directory['opening_hour'])? null:($directory['opening_hour']) }}</td>
                        </tr>
                        <tr>
                            <td>Website</td>
                            <td>{{ empty($directory['website'])? null:($directory['website']) }}</td>
                        </tr>
                        <tr>
                            <td>Facebook Link</td>
                            <td>{{ empty($directory['facebook_link'])? null:($directory['facebook_link']) }}</td>
                        </tr>
                        <tr>
                            <td>Instagram Link</td>
                            <td>{{ empty($directory['instagram_link'])? null:($directory['instagram_link']) }}</td>
                        </tr>
                        <tr>
                            <td>Twitter Link</td>
                            <td>{{ empty($directory['twitter_link'])? null:($directory['twitter_link']) }}</td>
                        </tr>
                    </tbody>
                </table>
                <a class="btn btn-primary" href="{{ route('admin.directory.index') }}">Back</a>
            </div>
        </div>
    </div>

@endsection
