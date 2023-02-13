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

                            <p>Email : {{ $subscription->email ?? ''}}</p>


                            <p>Date :
                                <div class="dateBox">
                                <span class="date">
                                    {{ date('d', strtotime($subscription->created_at)) }}
                                </span>
                                <span class="month">
                                    {{ date('M', strtotime($subscription->created_at)) }}
                                </span>
                                <span class="year">
                                    {{ date('Y', strtotime($subscription->created_at)) }}
                                </span>
                               </div>
                             </p>
                        </div>
                    </div>
                </div>
            </div><br>
            <a class="btn btn-primary" href="{{ route('admin.email-subscription.index') }}">Back</a>
        </div>
@endsection
