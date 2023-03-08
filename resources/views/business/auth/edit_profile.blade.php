@extends('business.app')
@section('title')Edit Profile @endsection

@section('content')
    <style>
        .category-container {
            margin-top: 12px;
        }

        .category-container .badge {
            font-size: 15px;
            border-radius: 0;
            position: relative;
            padding-right: 40px;
            background: #ed6153;
            margin-bottom: 10px;
        }

        .category-container .badge a {
            color: #fff;
            margin-left: 7px;
            border: 1px solid #fff;
            padding: 0px;
            font-size: 20px;
            position: absolute;
            top: -2px;
            right: 0;
            background: #a14036;
            width: 26px;
            height: 26px;
        }

        .custom-checkbox input {
            accent-color: #ed6153;
        }
    </style>

    @php
        $state = App\Models\State::orderby('name')->get();
        $postcodes = App\Models\PinCode::orderby('pin', 'asc')->get();
        $dircategory = App\Models\DirectoryCategory::orderby('parent_category')
            ->groupby('parent_category')
            ->distinct()
            ->get();
        $string = Auth::guard('business')->user()->address;

        $notification = App\Models\Directory::where('id', Auth::guard('business')->user()->id)->first();
    @endphp

    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> Edit Profile</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <span class="top-form-btn">
                    <a class="btn btn-secondary" href="{{ route('business.dashboard') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
                </span>
                <h3 class="tile-title">Edit Profile</h3>

                <hr>

                <form action="{{ route('business.profile.update') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Two Factor authentication</h6>
                            </label>
                            <div class="toggle-button-cover margin-auto">
                                <div class="button-cover">
                                    <div class="button-togglr b2" id="button-11">
                                        <input id="toggle-block" type="checkbox" name="is_2fa_enable" class="checkbox" data-event_id="{{ $notification['id'] }}" {{ $notification['is_2fa_enable'] == 1 ? 'checked' : '' }}>
                                        <div class="knobs"><span>Inactive</span></div>
                                        <div class="layer"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Name<span class="m-l-5 text-danger">
                                        *</span></h6>
                            </label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                id="name" value="{{ Auth::guard('business')->user()->name }}" />
                            @error('name')
                                {{ $message ?? '' }}
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Trading Name</h6>
                            </label>
                            <input class="form-control @error('trading_name') is-invalid @enderror" type="text"
                                name="trading_name" id="trading_name"
                                value="{{ Auth::guard('business')->user()->trading_name }}" />
                            @error('trading_name')
                                {{ $message ?? '' }}
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Email</h6>
                            </label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email"
                                id="email" value="{{ Auth::guard('business')->user()->email }}" />
                            @error('email')
                                {{ $message ?? '' }}
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Mobile No</h6>
                            </label>
                            <input class="form-control @error('mobile') is-invalid @enderror" type="text" name="mobile"
                                id="mobile" value="{{ Auth::guard('business')->user()->mobile }}" />
                            @error('mobile')
                                {{ $message ?? '' }}
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Primary Name</h6>
                            </label>
                            <input class="form-control" type="text" name="primary_name" id="primary_name"
                                value="{{ Auth::guard('business')->user()->primary_name }}" />
                            @error('primary_name')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Primary Email</h6>
                            </label>
                            <input class="form-control" type="text" name="primary_email" id="primary_email"
                                value="{{ Auth::guard('business')->user()->primary_email }}" />
                            @error('primary_email')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Primary Phone</h6>
                            </label>
                            <input class="form-control" type="text" name="primary_phone" id="primary_phone"
                                value="{{ Auth::guard('business')->user()->primary_phone }}" />
                            @error('primary_phone')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            @php
                                // directory address breakups
                                $directoryStreetAddress = directoryAddressBreakup(Auth::guard('business')->user()->address)[0];
                                $directorySuburb = directoryAddressBreakup(Auth::guard('business')->user()->address)[1];
                                $directoryState = directoryAddressBreakup(Auth::guard('business')->user()->address)[2];
                                $directoryPostcode = directoryAddressBreakup(Auth::guard('business')->user()->address)[3];
                            @endphp

                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Address</h6>
                            </label>

                            <p class="small text-muted mb-0">Street address</p>
                            <input class="form-control" type="text" name="street_address" id="street_address" value="{{ $directoryStreetAddress }}" />
                            @error('street_address')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror

                            <div class="row mt-3">
                                <div class="col-md-4">
                                    <p class="small text-muted mb-0">Postcode</p>
                                    <select name="postcode" id="postcode" class="form-control">
                                        @foreach ($postcodes as $postcode)
                                            <option value="{{$postcode->pin}}" {{ ($postcode->pin == $directoryPostcode) ? 'selected' : '' }}>{{$postcode->pin}}</option>
                                        @endforeach
                                    </select>
                                    @error('postcode')<p class="small text-danger">{{ $message }}</p>@enderror
                                </div>

                                <div class="col-md-4">
                                    <p class="small text-muted mb-0">Suburb</p>
                                    {{-- <input class="form-control" type="text" name="suburb" id="suburb" value="{{ $directorySuburb }}" /> --}}
                                    <select name="suburb" id="suburb" class="form-control">
                                        <option value="" selected disabled>Select Postcode</option>
                                    </select>
                                    @error('suburb')<p class="small text-danger">{{ $message }}</p>@enderror
                                </div>

                                <div class="col-md-4">
                                    <p class="small text-muted mb-0">State</p>
                                    <input class="form-control" type="text" name="state" id="state" value="Select Postcode" />
                                    {{-- <input class="form-control" type="text" name="state" id="state" value="{{ $directoryState }}" /> --}}
                                    @error('state')<p class="small text-danger">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="control-label mb-0" for="pin">Category:</h6>
                            </label>
                            <div class="category-container mb-3">
                                @php
                                    if (!empty(Auth::guard('business')->user()->category_id)) {
                                        $cat = substr(Auth::guard('business')->user()->category_id, 0, -1);
                                        $displayCategoryName = '';
                                        foreach (explode(',', $cat) as $catKey => $catVal) {
                                            $catDetails = \App\Models\DirectoryCategory::where('id', $catVal)
                                                ->where('status', 1)
                                                ->first();

                                            if (!empty($catDetails->child_category)) {
                                                $confirmText = "return confirm('Are you sure ?')";
                                                $displayCategoryName .=
                                                    '
                                        <div class="badge badge-primary">
                                            ' .
                                                    $catDetails->child_category .
                                                    '
                                            <a href="' .
                                                    URL::to('business/' . Auth::guard('business')->user()->id . '/category/' . $catVal . '/delete') .
                                                    '" onclick="' .
                                                    $confirmText .
                                                    '">&times;</a>
                                        </div>
                                        ';
                                            }
                                        }
                                        $displayCategoryName = substr($displayCategoryName, 0, -2);
                                        echo $displayCategoryName;
                                    } else {
                                        echo '';
                                    }
                                @endphp
                            </div>
                            <a href="#newCategoryModal" data-toggle="modal" class="btn btn-sm btn-primary">Add category</a>

                            @error('category_id')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Service Description</h6>
                            </label>
                            <textarea class="form-control" type="text" name="service_description" id="service_description"
                                >{{ Auth::guard('business')->user()->service_description }}</textarea>
                            @error('service_description')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Description</h6>
                            </label>
                            <textarea class="form-control" type="text" name="description" id="description">{{ Auth::guard('business')->user()->description }}</textarea>
                            @error('description')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Website</h6>
                            </label>
                            <input class="form-control" type="text" name="website" id="website"
                                value="{{ Auth::guard('business')->user()->website }}" />
                            @error('website')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                            <div class="form-group">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">Facebook Link</h6>
                                </label>
                                <input class="form-control" type="text" name="facebook_link" id="facebook_link"
                                    value="{{ Auth::guard('business')->user()->facebook_link }}" />
                                @error('facebook_link')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">Twitter Link</h6>
                                </label>
                                <input class="form-control" type="text" name="twitter_link" id="twitter_link"
                                    value="{{ Auth::guard('business')->user()->twitter_link }}" />
                                @error('twitter_link')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">Instagram Link</h6>
                                </label>
                                <input class="form-control" type="text" name="instagram_link" id="instagram_link"
                                    value="{{ Auth::guard('business')->user()->instagram_link }}" />
                                @error('instagram_link')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="card-header">Opening Hour</div>

                            <div class="form-group">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">Monday</h6>
                                </label>
                                <input class="form-control" type="text" name="monday" id="monday"
                                    value="{{ Auth::guard('business')->user()->monday }}" />
                                @error('monday')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">Tuesday</h6>
                                </label>
                                <input class="form-control" type="text" name="tuesday" id="tuesday"
                                    value="{{ Auth::guard('business')->user()->tuesday }}" />
                                @error('tuesday')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">Wednesday</h6>
                                </label>
                                <input class="form-control" type="text" name="wednesday" id="wednesday"
                                    value="{{ Auth::guard('business')->user()->wednesday }}" />
                                @error('wednesday')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">Thursday</h6>
                                </label>
                                <input class="form-control" type="text" name="thursday" id="thursday"
                                    value="{{ Auth::guard('business')->user()->thursday }}" />
                                @error('thursday')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">Friday</h6>
                                </label>
                                <input class="form-control" type="text" name="friday" id="friday"
                                    value="{{ Auth::guard('business')->user()->friday }}" />
                                @error('friday')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">Saturday</h6>
                                </label>
                                <input class="form-control" type="text" name="saturday" id="saturday"
                                    value="{{ Auth::guard('business')->user()->saturday }}" />
                                @error('saturday')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">Sunday</h6>
                                </label>
                                <input class="form-control" type="text" name="sunday" id="sunday"
                                    value="{{ Auth::guard('business')->user()->sunday }}" />
                                @error('sunday')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">Public Holiday</h6>
                                </label>
                                <input class="form-control" type="text" name="public_holiday" id="public_holiday"
                                    value="{{ Auth::guard('business')->user()->public_holiday }}" />
                                @error('public_holiday')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">ABN</h6>
                                </label>
                                <input class="form-control" type="text" name="ABN" id="ABN"
                                    value="{{ Auth::guard('business')->user()->ABN }}" />
                                @error('ABN')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">Establish Year</h6>
                                </label>
                                <input class="form-control" type="text" name="establish_year" id="establish_year"
                                    value="{{ Auth::guard('business')->user()->establish_year }}" />
                                @error('establish_year')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="tile-footer">
                            <div class="d-flex justify-content-between">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>

                                <a href="jaavscript: void(0)" class="btn btn-primary" onclick="deleteAccount()">
                                    Delete your account
                                    <i class="fa fa-fw fa-lg fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add category in
                        {{ Auth::guard('business')->user()->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="childCatSearch">Search by category name</label>
                    <input type="search" name="childCatSearch" id="childCatSearch" class="form-control" onkeyup="findChildCat(this.value)">

                    <hr>

                    <form action="{{ route('business.category.store') }}" method="POST">@csrf
                        <label for="">Result</label>
                        <div id="result"></div>

                        {{-- <input type="radio" name="catId" value=""> --}}
                        <input type="hidden" name="dirId" value="{{ Auth::guard('business')->user()->id }}">
                        <button type="submit" class="btn btn-sm btn-primary mt-1">Save changes</button>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    {{-- <button type="button" class="btn btn-primary">Save changes</button> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $('select[name="state"]').on('change', (event) => {
            var value = $('select[name="state"]').val();

            $.ajax({
                url: '{{ url('/') }}/api/state/postcode/' + value,
                method: 'GET',
                success: function(result) {
                    var content = '';
                    var slectTag = 'select[name="pin"]';
                    var displayCollection = (result.data.state == "all") ? "All state" : " Select";

                    content += '<option value="" selected>' + displayCollection + '</option>';
                    $.each(result.data.postcode, (key, value) => {
                        content += '<option value="' + value.postcode_title + '">' + value
                            .postcode_title + '</option>';
                    });
                    $(slectTag).html(content).attr('disabled', false);
                }
            });
        });

        $('select[name="pin"]').on('change', (event) => {
            var value = $('select[name="pin"]').val();

            $.ajax({
                url: '{{ url('/') }}/api/postcode-suburb/' + value,
                method: 'GET',
                success: function(result) {
                    var content = '';
                    var slectTag = 'select[name="suburb"]';
                    var displayCollection = (result.data.postcode == "all") ? "All postcode" :
                    " Select";

                    content += '<option value="" selected>' + displayCollection + '</option>';
                    $.each(result.data.suburb, (key, value) => {
                        content += '<option value="' + value.suburb_title + '">' + value
                            .suburb_title + '</option>';
                    });
                    $(slectTag).html(content).attr('disabled', false);
                }
            });
        });
    </script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script type="text/javascript">
        $('#service_description').summernote({
            height: 400
        });

        $('#description').summernote({
            height: 400
        });

        function findChildCat(val) {
            // alert(val);
            $.ajax({
                type: 'POST',
                url: "{{ route('business.category.search') }}",
                data: {
                    _token: '{{ csrf_token() }}',
                    val: val
                },
                success: function(response) {
                    // console.log(response);
                    // swal("Success!", response.message, "success");

                    if (response.status == 200) {
                        var content = '';

                        $.each(response.data, (key, value) => {
                            content += `<div class="custom-checkbox">
                                <input type="checkbox" name="catId[]" id="catId${key}" value="${value.id}">
                                <label for="catId${key}">${value.child_category}</label>
                            </div>`;
                        });

                        $('#result').html(content);
                    }
                },
                error: function(response) {
                    // swal("Error!", response.message, "error");
                }
            });
        }

        // 2FA
        $('input[id="toggle-block"]').change(function() {
            var event_id = $(this).data('event_id');
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var check_status = 0;

            if($(this).is(":checked")){
                check_status = 1;
            } else {
                check_status = 0;
            }

            $.ajax({
                type:'POST',
                dataType:'JSON',
                url:"{{route('business.twoFacAuth.toggle')}}",
                data:{ _token: CSRF_TOKEN, id:event_id, check_status:check_status},
                success:function(response) {
                    toastFire("success", response.message);
                },
                error: function(response) {
                    toastFire("warning", response.message);
                }
            });
        });

        // postcode info fetch
        $('select[name="postcode"]').on('change', function() {
            postcodeInfoFetch();
        });

        function postcodeInfoFetch() {
            var val = $('select[name="postcode"] option:selected').val();
            
            $.ajax({
                url: '{{route("business.postcode.detail")}}',
                type: 'post',
                data: {
                    '_token': '{{csrf_token()}}',
                    'postcode': val
                },
                success: function(resp) {
                    if (resp.status == 200) {
                        // get state
                        let state = resp.data[0].short_state;
                        let currentSuburb = '{{$directorySuburb}}';

                        let suburbContent = ``;
                        let checked = ``;
                        $.each(resp.data, (key, val) => {
                            if(currentSuburb == val.name) checked = 'selected';
                            else checked = '';

                            suburbContent += `
                            <option value="${val.name}" ${checked}>${val.name}</option>
                            `;
                        });

                        // show state
                        $('input[name="state"]').val(state);
                        // show suburbs
                        $('select[name="suburb"]').html(suburbContent);
                    } else {
                        
                    }
                }
            });
        }

        postcodeInfoFetch();

        // delete account
        function deleteAccount() {
            Swal.fire({
                title: 'Are you sure you want to delete your account ?',
                showCancelButton: true,
                focusCancel: true,
                confirmButtonColor: '#ff6155',
                confirmButtonText: 'Yes, Delete my account',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location = '{{route("business.account.delete")}}';
                }
            });


            // $.ajax({
            //     url: '{{route("business.account.delete")}}',
            //     type: 'post',
            //     data: {
            //         '_token': '{{csrf_token()}}',
            //         'postcode': val
            //     },
            //     success: function(resp) {

            //     }
            // });
        }
    </script>
@endpush
