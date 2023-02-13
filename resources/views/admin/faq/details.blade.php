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
            <div class="col-sm-8">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <p class="text-muted small mb-1">Category</p>
                                <p class="text-dark small">{{$faq->category}}</p>

                                <p class="text-muted small mb-1">Subcategory</p>
                                <p class="text-dark small">{{$faq->subcategory}}</p>
                                <p class="text-muted small mb-1">Question</p>
                            <p class="text-dark small">{!! $faq->question !!}</p>

                            <p class="text-muted small mb-1">Answer</p>
                            <p class="text-dark small">{!! $faq->answer !!}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <br>
                <a class="btn btn-primary" href="{{ route('admin.faq.index') }}">Back</a>
            </div>


        </div>
    </div>
@endsection
