@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection

@section('content')
    <div class="app-title">
        <div class="row w-100">
            <div class="col-md-6">
                <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
                <p></p>
            </div>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="row">
        <div class="col-md-12">

            <div class="row align-items-center justify-content-between">
                <div class="col">
                    <ul>
                        {{-- <li class="active">Total Number of Directory <span class="count">({{$directory->total()}})</span></li> --}}
                    </ul>
                </div>
                <div class="col-auto">
                    <form action="">
                        <div class="row">
                            <div class="col">
                                <input type="search" name="keyword" id="keyword" class="form-control" placeholder="Search here.." value="{{app('request')->input('keyword')}}" autocomplete="off">
                            </div>
                            <div class="col">
                                <button type="submit" class="btn btn-outline-danger btn-sm">Search Directory </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Link</th>
                                <th>CSV category</th>
                                <th>Current category</th>
                                <th>Google category</th>
                                <th>Address</th>
                                {{-- <th>Place ID</th> --}}
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($data as $key => $directory)
                                <tr>
                                    <td class="small text-muted">
                                        {{ $directory->id }}
                                    </td>
                                    <td class="small text-muted">
                                        {{ $directory->name }}
                                        {!! ($directory->place_id) ? '' : '<i class="fa fa-info-circle text-danger"></i>' !!}
                                    </td>
                                    <td class="small text-muted">
                                        <a href="{{ url('/directory/'.$directory->slug) }}" target="_blank">{{ url('/directory/'.$directory->slug) }}</a>
                                    </td>
                                    <td class="small text-dark">
                                        {{ csvdirectoryCategoryStr($directory->category_id) }}
                                    </td>
                                    <td class="small text-dark">
                                        {{ directoryCategoryStr($directory->category_id) }}
                                    </td>
                                    <td class="small text-dark">
                                        {{ $directory->google_category_display }}
                                    </td>
                                    <td class="small text-muted">
                                        {{ $directory->address }}
                                    </td>
                                    {{-- <td class="small text-muted">
                                        {!! ($directory->place_id) ? $directory->place_id : '<i class="fa fa-info-circle text-danger"></i>' !!}
                                    </td> --}}
                                    <td>
                                        <a href="{{ url('/admin/directory/'.$directory->id.'/edit') }}" target="_blank">Edit</a>
                                        <a href="#detailModal{{$key}}" data-toggle="modal">Details</a>
                                    </td>
                                </tr>

                                <div class="modal fade" id="detailModal{{$key}}">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-title">
                                                <h5>{{ $directory->name }}</h5>
                                            </div>
                                            <div class="modal-body">
                                                @php
                                                    $array = json_decode($directory->google_api_detail_fetch, true);
                                                    print '<pre>';
                                                    print_r($array);
                                                    print '</pre>';
                                                @endphp
                                            </div>
                                            <div class="modal-footer"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>

                    {!! $data->appends($_GET)->links() !!}

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush

