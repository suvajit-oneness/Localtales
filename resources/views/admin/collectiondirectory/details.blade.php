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
                            <td>Collection Name</td>
                            <td>{{ empty($directory->collection->title)? null:$directory->collection->title }}</td>
                        </tr>
                        <tr>
                            <td>Directory Name</td>
                            <td>{{ empty($directory->directory->name)? null:$directory->directory->name }}</td>
                        </tr>


                    </tbody>
                </table>
            </div>


        </div>
    </div>
@endsection
