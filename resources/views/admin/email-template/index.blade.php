@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection

@section('content')
    <div class="app-title">
        <div class="row w-100 mx-0">
            <div class="col-md-3">
                <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            </div>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="row">
        <div class="col-md-12">
            <div class="row justify-content-between mx-0 mb-3">
                <div class="col">
                    <p>Total number of records: {{ $email->total() }}</a></li>
                </div>
                <div class="col-auto">
                    <form action="{{ route('admin.email.master.index') }}">
                        <div class="row g-3 align-items-center">
                            <div class="col-auto">
                                <input type="search" name="term" id="term" class="form-control" placeholder="Search here.." value="{{ app('request')->input('term') }}" autocomplete="off">
                            </div>
                            <div class="col-auto">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Search</button>
                                    <a href="{{ route('admin.email.master.index') }}" class="btn btn-danger btn-sm">Remove filter</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-12">
                <div class="tile p-0">
                    <div class="tile-body">
                        <table class="table table-hover custom-data-table-style table-striped">
                            <thead>
                                <tr>
                                    <th> #</th>
                                    <th> Module </th>
                                    <th> Subject </th>
                                    {{-- <th> Body </th> --}}
                                    <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($email as $key => $data)
                                {{-- {{ dd($category->child_category) }} --}}
                                    <tr>
                                        <td>{{ ($email->firstItem()) + $key }}</td>
                                        <td>{{ ucwords($data->type) }}</td>
                                        <td>{{ $data->subject }}</td>
                                        {{-- @if($data->is_image==1)
                                        <td><img style="width: 150px;height: 100px;" src="{{URL::to('/').'/email/'}}{{$data->body}}"></td>
                                        @else
                                        <td>{!! $data->body !!}</td>
                                        @endif
                                         --}}
                                        <td class="text-center">
                                            <div class="btn-group" role="group" aria-label="Second group">
                                                <a href="{{ route('admin.email.master.edit', $data['id']) }}"
                                                    class="btn btn-sm btn-primary edit-btn"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('admin.email.master.details', $data['id']) }}"
                                                    class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                                
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $email->appends($_GET)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">
        $('#sampleTable').DataTable({
            "ordering": false
        });
    </script>
    {{-- New Add --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
@endpush
