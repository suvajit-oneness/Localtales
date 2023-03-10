@extends('site.appprofile')
@section('title') Dashboard @endsection

@section('content')
    <div class="fixed-row">
        <div class="app-title">
            <div>
                <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
            </div>
        </div>
    </div>

    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-6 col-lg-3">
            <div class="card-body event-body">
                <a href="{{url('/saved-directory')}}">
                    <div class="widget-small primary coloured-icon">
                        <i class="icon fa fa-briefcase fa-3x"></i>
                        <div class="info">
                            <p><b> {{count($businesses)}} </b></p>
                            <h4>Favourite Directories</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="card-body event-body">
                <a href="{{url('/saved-collection')}}">
                    <div class="widget-small info coloured-icon">
                        <i class="icon fa fa-briefcase fa-3x"></i>
                        <div class="info">
                            <p><b> {{count($collection)}} </b></p>
                            <h4>Favourite Collections</h4>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
