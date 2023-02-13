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
                            <p>Name : {{ $contact->name ?? ''}}</p>
                            <p>Email : {{ $contact->email ?? ''}}</p>
                            <p>Mobile : {!! $contact->mobile !!}</p>
                            <p>Comment : {!! $contact->description !!}</p>

                            <p>Date :
                                <div class="dateBox">
                                <span class="date">
                                    {{ date('d', strtotime($contact->created_at)) }}
                                </span>
                                <span class="month">
                                    {{ date('M', strtotime($contact->created_at)) }}
                                </span>
                                <span class="year">
                                    {{ date('Y', strtotime($contact->created_at)) }}
                                </span>
                               </div>
                             </p>
                        </div>
                    </div>
                </div>
            </div><br>
            <a class="btn btn-primary" href="{{ route('admin.contact-form.index') }}">Back</a>
        </div>
@endsection
