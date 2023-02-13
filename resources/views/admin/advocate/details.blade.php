@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p></p>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-sm-8">
            <div class="card">
                <div class="card-body">
                    <div class="row">

                        <div class="col-md-10">
                            <p>Name : {{ $advocate->name ?? ''}}</p>
                            <p>Email : {{ $advocate->email ?? ''}}</p>
                            <p>Postcode : {!! $advocate->postcode !!}</p>
                            <p>Suburb : {!! $advocate->suburb !!}</p>
                            <p>Platform Used : {!! $advocate->platform !!}</p>
                            <p>Date of Registration :
                                <div class="dateBox">
                                <span class="date">
                                    {{ date('d', strtotime($advocate->created_at)) }}
                                </span>
                                <span class="month">
                                    {{ date('M', strtotime($advocate->created_at)) }}
                                </span>
                                <span class="year">
                                    {{ date('Y', strtotime($advocate->created_at)) }}
                                </span>
                               </div>
                             </p>
                        </div>
                    </div>
                </div>
            </div><br>
            <a class="btn btn-primary" href="{{ route('admin.advocate.index') }}">Back</a>
        </div>
@endsection
