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
                            <td>Question</td>
                            <td>{!! empty($faq['question'])? null:$faq['question'] !!}</td>
                        </tr>
                        <tr>
                            <td>Answer</td>
                            <td>{!! empty($faq['answer'])? null:$faq['answer'] !!}</td>
                        </tr>


                    </tbody>
                </table>
                <a class="btn btn-primary" href="{{ route('admin.category.index') }}">Cancel</a>
            </div>


        </div>
    </div>
@endsection
