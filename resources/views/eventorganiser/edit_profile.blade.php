@extends('business.app')
@section('title')
    Edit Profile
@endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> Edit Profile</h1>
        </div>
    </div>
    @php
        $state = App\Models\State::orderby('name')->get();
        
    @endphp
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <span class="top-form-btn">
                </span>
                <h3 class="tile-title">Edit Profile

                </h3>
                <hr>
                <form action="{{ route('eventorganiser.profile.update') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Name<span class="m-l-5 text-danger">
                                        *</span></h6>
                            </label>
                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                id="name" value="{{ Auth::guard('eventorganiser')->user()->name }}" />
                            @error('name')
                                {{ $message ?? '' }}
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Email</h6>
                            </label>
                            <input class="form-control @error('email') is-invalid @enderror" type="text" name="email"
                                id="email" value="{{ Auth::guard('eventorganiser')->user()->email }}" />
                            @error('email')
                                {{ $message ?? '' }}
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Mobile No</h6>
                            </label>
                            <input class="form-control @error('mobile') is-invalid @enderror" type="text" name="mobile"
                                id="mobile" value="{{ Auth::guard('eventorganiser')->user()->mobile }}" />
                            @error('mobile')
                                {{ $message ?? '' }}
                            @enderror
                        </div>
                        
                        
                        
                        {{--  --}}
                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Address</h6>
                            </label>
                            
                            <input class="form-control" type="text" name="address" id="address"
                                value="" />
                            @error('address')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">State</h6>
                            </label>
                            <select class="form-control" name="state">
                                <option hidden selected></option>
                                @foreach ($state as $index => $item)
                                    <option
                                        value="{{ $item->short_code }}"{{ $item->short_code == $word ? 'selected' : '' }}>
                                        {{ $item->name }}({{ $item->short_code }})</option>
                                @endforeach
                            </select>

                            @error('state')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">ZipCode</h6>
                            </label>
                           
                            <select class="form-control" name="pin" disabled>
                                <option value="">Select State first</option>
                            </select>

                            @error('pin')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Suburb</h6>
                            </label>
                            <select class="form-control" name="suburb" disabled>
                                <option value="" selected disabled>Select Postcode first</option>
                            </select>
                            @error('suburb')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                       
                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Website</h6>
                            </label>
                            <input class="form-control" type="text" name="website" id="website"
                                value="{{ Auth::guard('eventorganiser')->user()->website }}" />
                            @error('website')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Facebook Link</h6>
                            </label>
                            <input class="form-control" type="text" name="facebook_link" id="facebook_link"
                                value="{{ Auth::guard('eventorganiser')->user()->facebook_link }}" />
                            @error('facebook_link')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Twitter Link</h6>
                            </label>
                            <input class="form-control" type="text" name="twitter_link" id="twitter_link"
                                value="{{ Auth::guard('eventorganiser')->user()->twitter_link }}" />
                            @error('twitter_link')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Instagram Link</h6>
                            </label>
                            <input class="form-control" type="text" name="instagram_link" id="instagram_link"
                                value="{{ Auth::guard('eventorganiser')->user()->instagram_link }}" />
                            @error('instagram_link')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        
                    </div>
                    {{-- <div class="col-sm-12">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">Country</h6>
                                </label>
                                <input class="form-control" type="text" name="country" id="country"
                                    value="{{ Auth::user()->country }}" />
                            </div> --}}
                    <div class="tile-footer">
                        <button type="submit" class="btn btn-primary"><i
                                class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                    </div>
            </div>
            </form>
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
    </script>
@endpush
