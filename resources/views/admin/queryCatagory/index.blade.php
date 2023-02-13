@extends('admin.app')

@section('title')
    {{ 'Query Catagories' }}
@endsection

@section('content')
    <div class="app-title">

        <div class="row w-100">

            <div class="col-md-6">

                <h1><i class="fa fa-file"></i> {{ 'Query Catagories' }}</h1>

            </div>

            <div class="col-md-6 text-right">

                <a href="{{ route('admin.query.catagory.create') }}" class="btn btn-primary pull-right">+ Create New

                    Catagory</a>

            </div>

        </div>

    </div>

    @include('admin.partials.flash')

    <div class="row">

        <div class="col-md-12">

            <div class="tile">

                <div class="tile-body">

                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">

                        <thead>

                            <tr>

                                <th>#</th>

                                <th> Name </th>

                                <th> Status </th>

                                <th style="width:100px; min-width:100px;" class="text-center">Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($data as $key => $blog)
                                <tr>



                                    <td>{{ $key + 1 }}</td>



                                    <td>{{ $blog->name }}</td>

                                    <td class="text-center">

                                        <div class="toggle-button-cover margin-auto">

                                            <div class="button-cover">

                                                <div class="button-togglr b2" id="button-11">

                                                    <input id="toggle-block" type="checkbox"
                                                        onclick="changeStatus('{{ $blog['id'] }}',this)" name="status"
                                                        class="checkbox" data-id="{{ $blog['id'] }}"
                                                        {{ $blog['status'] == 1 ? 'checked' : '' }}>

                                                    <div class="knobs"><span>Inactive</span></div>

                                                    <div class="layer"></div>

                                                </div>

                                            </div>

                                        </div>

                                    </td>

                                    <td class="text-center">

                                        <div class="btn-group" role="group" aria-label="Second group">

                                            {{-- <a href="{{ route('admin.collectiondir.edit', $blog['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-edit"></i></a> --}}

                                            {{-- <a href="{{ route('admin.query.detail', $blog['id']) }}"
                                                class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a> --}}

                                            <a href="javascipt:void(0)" onclick="deleteRow('{{ $blog['id'] }}')"
                                                class="sa-remove btn btn-sm btn-danger edit-btn"><i
                                                    class="fa fa-trash"></i></a>

                                        </div>

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

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

    <script type="text/javascript">
        function deleteRow(x) {
            swal({
                    title: "Are you sure?",
                    text: "Your will not be able to recover the record!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                },
                function(isConfirm) {
                    if (isConfirm) {
                        // window.location.href = "{{ route('admin.query.catagory.delete', ' + x + ') }}"
                        window.location.href = "catagory/delete/" + x;
                    } else {
                        swal("Cancelled", "Record is safe", "error");
                    }
                });
        };
    </script>

    <script type="text/javascript">
        function changeStatus(x, y) {

            var id = x;

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            var check_status = 0;

            if ($(y).is(":checked")) {

                check_status = 1;

            } else {

                check_status = 0;

            }

            $.ajax({

                type: 'POST',

                dataType: 'JSON',

                url: "{{ route('admin.query.catagory.updateStatus') }}",

                data: {

                    _token: CSRF_TOKEN,

                    id: id,

                    check_status: check_status

                },

                success: function(response) {

                    swal("Success!", response.message, "success");

                },

                error: function(response) {



                    swal("Error!", response.message, "error");

                }

            });

        };
    </script>
@endpush
