@extends('admin.app')

@section('title')
    {{ 'All Queries' }}
@endsection

@section('content')
    <div class="app-title">

        <div class="row w-100">

            <div class="col-md-6">

                <h1><i class="fa fa-file"></i> {{ 'All Comments' }}</h1>

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
                                <th> Page </th>
                                <th> Page Url</th>
                                <th> User Name </th>

                                <th> User Email </th>
                                <th> Was this article helpful?  </th>

                                <th> Comment</th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($comment as $key => $item)
                             @php
                               $value= explode('article-details', $item->page)
                             @endphp  
                                <tr>

                                    <td>{{ $key+1 }}</td>
                                    
                                    <td>{{ $item->page }}</td>
                                    <td><a href="{{ $item->page }}">{{ $item->page }}</a></td>
                                    <td>{{ $item->user_name }}</td>

                                    <td><a
                                            href="https://mail.google.com/mail/?view=cm&fs=1&to={{ $item->email }}">{{ $item->user_email }}</a>

                                    </td>

                                    <td>{{ $item->type }}</td>

                                    <td>{{ $item->comment }}</td>

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
