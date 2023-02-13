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
                        <li class="active">Total Form Submitted <span class="count">({{$contact->total()}})</span></a></li>
                        {{-- @php
                            $activeCount = $inactiveCount = 0;
                            foreach ($data as $catKey => $catVal) {
                                if ($catVal->status == 1) $activeCount++;
                                else $inactiveCount++;
                            }
                        @endphp
                        <li><a href="{{ route('admin.directory.index', ['status' => 'active'])}}">Active <span class="count">({{$activeCount}})</span></a></li>
                        <li><a href="{{ route('admin.directory.index', ['status' => 'inactive'])}}">Inactive <span class="count">({{$inactiveCount}})</span></a></li> --}}
                    </ul>
                </div>

            </div>

            <div class="tile">
                <div class="tile-body">
                    @if(isset($contact))
                    <table class="table table-hover custom-data-table-style table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th> Name </th>
                                <th> Email </th>
                                <th> Mobile </th>
                                <th> Comment </th>
                                <th> Date </th>
                                <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($contact as $key => $item)
                                <tr>
                                    <td>{{ ($contact->firstItem()) + $key }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->mobile }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td><div class="dateBox">
                                        <span class="date">
                                            {{ date('d', strtotime($item->created_at)) }}
                                        </span>
                                        <span class="month">
                                            {{ date('M', strtotime($item->created_at)) }}
                                        </span>
                                        <span class="year">
                                            {{ date('Y', strtotime($item->created_at)) }}
                                        </span>
                                       </div></td>

                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Second group">

                                        <a href="{{ route('admin.contact-form.detail', $item['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                    </div>
                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $contact->render() !!}@endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('backend/js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('backend/js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({"ordering": false});</script>
     {{-- New Add --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-sweetalert/1.0.1/sweetalert.js"></script>
    <script>
        $(document).ready(function(){
            $('#checkUncheckAll').click(function(){
                if($(this).prop("checked") == true){
                    $('.tap-to-delete').attr('checked','checked');
                } else if($(this).prop("checked") == false){
                    $('.tap-to-delete').removeAttr('checked');
                }
            });
        });
        </script>
@endpush
