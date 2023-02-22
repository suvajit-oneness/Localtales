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
                        <li class="active">Total  <span class="count">({{$review->total()}})</span></a></li>
                    </ul>
                </div>
                <div class="col-auto">
                    <form action="" id="checkout-form">
                        <div class="filterSearchBox">
                            <div class="row">
                                <div class="col-12 col-sm mb-2 mb-sm-0">
                                    <div class="form-floating">
                                        <input id="postcodefloting" type="text" class="form-control pl-3"
                                            name="key_details" placeholder="Postcode/ State"
                                            value="{{ request()->input('key_details') }}" autocomplete="off">
                                        <input type="hidden" name="keyword" value="{{ request()->input('keyword') }}">
                                       
                                    </div>
                                    <div class="respDrop"></div>
                                </div>

                                <div class="col col-sm">
                                    <div class="form-floating">
                                        <input id="searchbykeyword" type="text" name="name" class="form-control pl-3"
                                            value="{{ request()->input('name') }}" placeholder="Search by keyword...">
                                        
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <select name="orderBy" id="orderBy" class="form-control form-control-sm">
                                        <option value="" hidden selected>Sort by</option>
                                        <option value="" disabled>Select</option>
                                        <option value="date_desc" {{ ($request->orderBy == "date_desc") ? 'selected' : '' }}>Latest review</option>
                                        <option value="rating_desc" {{ ($request->orderBy == "rating_desc") ? 'selected' : '' }}>Highest rating</option>
                                        <option value="rating_asc" {{ ($request->orderBy == "rating_asc") ? 'selected' : '' }}>Lowest rating</option>
                                    </select>
                                    {{-- <label for="searchbykeyword" placeholder="Nom">Sort by</label> --}}
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Search</button>
                                </div>
                                <a type="button" href="{{ url()->current() }}" class="btn btn-outline-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Remove filter">
                                    <i class="fa fa-times"></i>
                                  </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="tile">
                <div class="tile-body">
                    @if(isset($review))
                    <table class="table table-hover custom-data-table-style table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th> Directory </th>
                                <th> Author Name </th>
                                <th> Rating </th>
                                <th> Review </th>
                                <th> Date </th>
                                <th> Thumbs up </th>
                                <th> Thumbs down </th>
                                <th> Status </th>
                                <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($review as $key => $data)
                                <tr>
                                    <td>{{ ($review->firstItem()) + $key }}</td>
                                    <td>{{ $data->name  ?? ''}}</td>
                                    <td>{{ $data->author_name }}</td>
                                    <td>{{ $data->rating }}</td>
                                    @if($data->text!='')
                                    <td>{{ substr($data->text,0,200) }}... </td>
                                    @else
                                    <td></td>
                                    @endif
                                    <td>{{date('d/m/Y', strtotime($data->created_at)) }}</td>
                                    <td>{{ CountLikeReview($data->id)  }}</td>
                                    <td>{{ CountDisLikeReview($data->id)  }}</td>
                                    <td class="text-center">
                                        <div class="toggle-button-cover margin-auto">
                                            <div class="button-cover">
                                                <div class="button-togglr b2" id="button-11">
                                                    <input id="toggle-block" type="checkbox" name="status" class="checkbox" data-id="{{ $data->id }}" {{ $data->status == 1 ? 'checked' : '' }}>
                                                    <div class="knobs"><span>Inactive</span></div>
                                                    <div class="layer"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Second group">
                                        <a href="{{ route('admin.review.details', $data['id']) }}" class="btn btn-sm btn-primary edit-btn"><i class="fa fa-eye"></i></a>
                                        <a href="#" data-id="{{$data['id']}}" class="sa-remove btn btn-sm btn-danger edit-btn"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {!! $review->render() !!}@endif
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
    <script type="text/javascript">
    $('.sa-remove').on("click",function(){
        var categoryid = $(this).data('id');
        swal({
          title: "Are you sure?",
          text: "Your will not be able to recover the record!",
          type: "warning",
          showCancelButton: true,
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes, delete it!",
          closeOnConfirm: false
        },
        function(isConfirm){
          if (isConfirm) {
            window.location.href = "review/"+categoryid+"/delete";
            } else {
              swal("Cancelled", "Record is safe", "error");
            }
        });
    });
    </script>
     <script type="text/javascript">
        $('input[id="toggle-block"]').change(function() {
            var id = $(this).data('id');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var check_status = 0;
          if($(this).is(":checked")){
              check_status = 1;
          }else{
            check_status = 0;
          }
          $.ajax({
                type:'POST',
                dataType:'JSON',
                url:"{{route('admin.review.updateStatus')}}",
                data:{ _token: CSRF_TOKEN, id:id, check_status:check_status},
                success:function(response) {
                    swal("Success!", response.message, "success");
                },
                error: function(response) {
                    swal("Error!", response.message, "error");
                }
              });
        });
    </script>
     @if (session('csv'))
     <script>
         swal("Success!", "{{ session('csv') }}", "success");
     </script>
 @endif
 <script async src="https://static.addtoany.com/menu/page.js"></script>
 <script>
    $('body').on('click', function() {
        //code
        $('.postcode-dropdown').hide();
    });

    // state, suburb, postcode data fetch
    $('input[name="key_details"]').on('keyup', function() {
        var $this = 'input[name="key_details"]'

        if ($($this).val().length > 0) {
            $('input[name="keyword"]').val($($this).val())
            $.ajax({
                url: '{{ route('user.postcode') }}',
                method: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    code: $($this).val(),
                },
                success: function(result) {
                    var content = '';
                    if (result.error === false) {
                        content +=
                            `<div class="dropdown-menu show w-100 postcode-dropdown" aria-labelledby="dropdownMenuButton">`;

                        $.each(result.data, (key, value) => {
                            if (value.type == 'pin') {
                                content +=
                                    `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode(${value.pin}, '${value.pin}', '${value.type}')"><strong>${value.pin}</strong></a>`;
                            } else if (value.type == 'suburb') {
                                content +=
                                    `<a class="dropdown-item" href="javascript: void(0)" onclick="fetchCode('${value.suburb}', '${value.suburb}, ${value.short_state} ${value.pin}', '${value.type}')"><strong>${value.suburb}</strong>, ${value.short_state} ${value.pin}</a>`;
                            } else {
                                content += ``;
                            }
                        })

                        if (result.data.length == 1) {
                            content = '';
                        }

                        content += `</div>`;
                    } else {
                        content +=
                            `<div class="dropdown-menu show w-100 postcode-dropdown" aria-labelledby="dropdownMenuButton"><li class="dropdown-item">${result.message}</li></div>`;
                    }
                    $('.respDrop').html(content);
                }
            });
        } else {
            $('.respDrop').text('');
        }
    });

    function fetchCode(keyword, details, type) {
        $('.postcode-dropdown').hide()
        $('input[name="keyword"]').val(keyword)
        $('input[name="key_details"]').val(details)
    }
    $(document).on("click", "#btnFilter", function() {
        $('#checkout-form').submit();
    });
    $(document).keypress(function(event) {
        var keycode = (event.keyCode ? event.keyCode : event.which);
        if (keycode == '13') {
            $('#checkout-form').submit();
        }
    });
</script>
@endpush
