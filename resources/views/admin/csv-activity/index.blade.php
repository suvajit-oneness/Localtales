@extends('admin.app')

@section('title')
    {{ 'CSV Activity' }}
@endsection

@section('content')
    <div class="app-title">

        <div class="row w-100">

            <div class="col-md-6">

                <h1><i class="fa fa-file"></i> {{ 'CSV Activity' }}</h1>

                <p></p>

            </div>

            <div class="col-md-6 text-right">

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
                                <th> Uploaded By </th>
                                <th> Total Entries</th>
                                <th> Success Count</th>
                                <th> Success Item </th>
                                <th> Failure Count  </th>
                                <th> Failure Item</th>
                                <th> CSV  Title</th>
                                <th> Date & Time</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($csv as $key => $item)
                             
                                <tr>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ Auth::guard('admin')->user()->name }}</td>
                                    <td>{{ $item->total_rows }}</td>
                                    <td>{{ $item->success_count }}</td>
                                    <td>{{ $item->success_array }}</td>
                                    <td>{{ $item->failure_count }}</td>
                                    <td>{{ $item->failure_array }}</td>
                                    <td>{{ $item->csv_type }}</td>
                                    <td>{{ $item->created_at }}</td>
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
                        window.location.href = "query/delete/" + x;
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

                url: "{{ route('admin.query.updateStatus') }}",

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
