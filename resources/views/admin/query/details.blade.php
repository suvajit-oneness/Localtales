@extends('admin.app')
@section('title')
    {{ 'Query' }}
@endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ 'Query' }}</h1>
            <p>{{ 'Query detail' }}</p>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <tbody>
                        <tr>
                            <td>Ticket Id</td>
                            <td>{{ $data->ticked_id }}</td>
                        </tr>
                        <tr>
                            <td>Name</td>
                            <td>{{ $data->name }}</td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>{{ $data->email }}</td>
                        </tr>
                        <tr>
                            <td>Query Catagory</td>
                            @if($data->query_catagory =='other')
                                     <td>other</td>
                                     @else
                                    <td>{{ $data->catagory->name }}</td>
                                    @endif
                        </tr>
                        @if($data->query_catagory =='other')
                        <tr>
                            <td>Query Catagory</td>

                                    <td>{{ $data->other }}</td>

                        </tr>
                        @endif
                        <tr>
                            <td>Query</td>
                            <td>{{ $data->query }}<br>
                                @if($data->related_images)
                                @foreach (explode(',', $data->related_images) as $item)
                                    <img src="{{ asset($item) }}" height="400px" width="400px" class="m-3" alt="">
                                @endforeach
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>


        </div>
    </div>
@endsection
