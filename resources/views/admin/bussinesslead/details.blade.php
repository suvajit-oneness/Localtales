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
                        <td>{{ empty($business['bussiness_name'])? null:$business['bussiness_name'] }}</td>
                    </tr>
                    <tr>
                        <td>Category</td>
                        <td>{{ empty($business['category']) ? null : $business->categoryDetails->title }}</td>
                    </tr>
                    <tr>
                        <td>Service description</td>
                        <td>{!! empty($business['service_description'])? null:$business['service_description'] !!}</td>
                    </tr>
                    <tr>
                        <td>Description</td>
                        <td>{!! empty($business['description'])? null:$business['description'] !!}</td>
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td>{!! empty($business['email'])? null:$business['email'] !!}</td>
                    </tr>
                    <tr>
                        <td>Mobile number (Primary)</td>
                        <td>{{ empty($business['mobile_no'])? null:$business['mobile_no'] }}</td>
                    </tr>
                    <tr>
                        <td>Mobile number (Alternate)</td>
                        <td>{{ empty($business['alt_mobile_no'])? null:$business['alt_mobile_no'] }}</td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td>{{ empty($business['bussiness_address'])? null:$business['bussiness_address'] }}</td>
                    </tr>
                    <tr>
                        <td colspan="100%" class="text-primary">Social links</td>
                    </tr>
                    <tr>
                        <td>Facebook link</td>
                        <td>{{ empty($business['facebook_link'])? null:$business['facebook_link'] }}</td>
                    </tr>
                    <tr>
                        <td>Twitter link</td>
                        <td>{{ empty($business['twitter_link'])? null:$business['twitter_link'] }}</td>
                    </tr>
                    <tr>
                        <td>Instagram link</td>
                        <td>{{ empty($business['instagram_link'])? null:$business['instagram_link'] }}</td>
                    </tr>
                    <tr>
                        <td>Linkedin link</td>
                        <td>{{ empty($business['linkedin_link'])? null:$business['linkedin_link'] }}</td>
                    </tr>
                    <tr>
                        <td>Youtube link</td>
                        <td>{{ empty($business['youtube_link'])? null:$business['youtube_link'] }}</td>
                    </tr>
                    <tr>
                        <td colspan="100%" class="text-primary">Opening Hours</td>
                    </tr>
                    <tr>
                        <td>Monday</td>
                        <td>{{ empty($business['monday_opening_hour'])? null:$business['monday_opening_hour'] }}</td>
                    </tr>
                    <tr>
                        <td>Tuesday</td>
                        <td>{{ empty($business['tuesday_opening_hour'])? null:$business['tuesday_opening_hour'] }}</td>
                    </tr>
                    <tr>
                        <td>Wednesday</td>
                        <td>{{ empty($business['wednesday_opening_hour'])? null:$business['wednesday_opening_hour'] }}</td>
                    </tr>
                    <tr>
                        <td>Thursday</td>
                        <td>{{ empty($business['thursday_opening_hour'])? null:$business['thursday_opening_hour'] }}</td>
                    </tr>
                    <tr>
                        <td>Friday</td>
                        <td>{{ empty($business['friday_opening_hour'])? null:$business['friday_opening_hour'] }}</td>
                    </tr>
                    <tr>
                        <td>Saturday</td>
                        <td>{{ empty($business['saturday_opening_hour'])? null:$business['saturday_opening_hour'] }}</td>
                    </tr>
                    <tr>
                        <td>Sunday</td>
                        <td>{{ empty($business['sunday_opening_hour'])? null:$business['sunday_opening_hour'] }}</td>
                    </tr>
                </tbody>
            </table>
            <a class="btn btn-primary" href="{{ route('admin.bussinesslead.index') }}">Back</a>
        </div>
    </div>
</div>
@endsection
