@extends('business.app')
@section('title')
    Edit Profile
@endsection
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

    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> Edit Profile</h1>
        </div>
    </div>
    @php
        $state = App\Models\State::orderby('name')->get();
        $dircategory = App\Models\DirectoryCategory::orderby('parent_category')
            ->groupby('parent_category')
            ->distinct()
            ->get();
        $string = Auth::guard('business')->user()->address;
        //dd($string);
        //$last_word_start = strrpos($string, ' ') + 1;
        //dd($last_word_start);
       // $txt = explode(',', $string);
        //dd($txt);
       // $length = count($txt);
       // $suburb = $txt[$length - 3];
        //$pin = $txt[$length - 1];
        //$stateWord = trim($txt[$length - 2]);
        
       // $address = implode(',', array_slice($txt, 0, $length - 3));
        
    @endphp
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <span class="top-form-btn">
                    <a class="btn btn-secondary" href="{{ route('business.dashboard') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
                </span>
                <h3 class="tile-title">Edit Profile

                </h3>
                <hr>
                <form action="{{ route('business.profile.update') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
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
                        
                        {{--  --}}
                        <div class="form-group">
                            <label class="mb-1">
                                <h6 class="mb-0 text-sm text-dark">Address</h6>
                            </label>
                            {{-- @php
                                    $txt = Auth::guard('business')->user()->address;
                                    $pieces = explode(' ', $txt);
                                    dd($pieces);
                                    $str= preg_replace('/\W\w+\s*(\W*)$/', '$1', $txt);
                                    $string=preg_replace('/\W\w+\s*(\W*)$/', '$1', $str);
                                    $address=preg_replace('/\W\w+\s*(\W*)$/', '$1', $string);
                                    $addressItem=substr($address,0,-3);
                                    //$last_word_state = strrpos($txt, ' ') + 1; // +1 so we don't include the space in our result
                                    $last_word_state = substr($txt,-9);
                                    $stateWord=preg_replace('/\W\w+\s*(\W*)$/', '$1', $last_word_state);
                                    $word=str_replace(",", '',$stateWord);

                                @endphp --}}
                            <input class="form-control" type="text" name="address" id="address"
                                value="{{ Auth::guard('business')->user()->address }}" />
                            @error('category_id')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        {{-- <div class="form-group">
                            <div class="select-floating-admin">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">State</h6>
                                </label>
                                <select class="filter_select form-control" name="state">
                                    <option hidden selected></option>
                                    @foreach ($state as $index => $item)
                                        <option
                                            value="{{ $item->short_code }}">
                                            {{ $item->name }}({{ $item->short_code }})</option>
                                    @endforeach
                                </select>

                                @error('state')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                           
                            <div class="select-floating-admin">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">Postcode <span
                                            class="m-l-5 text-danger"> *</span></h6>
                                </label>

                                <select class="filter_select form-control" name="pin" disabled>
                                    <option value="">Select State first</option>
                                </select>

                                @error('pin')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <div class="select-floating-admin">
                                    <label class="mb-1">
                                        <h6 class="mb-0 text-sm text-dark">Suburb <span
                                                class="m-l-5 text-danger"> *</span></h6>
                                    </label>
                                    <select class="filter_select form-control" name="suburb" disabled>
                                        <option value="" selected disabled>Select Postcode first</option>
                                    </select>
                                    @error('suburb')
                                        <p class="small text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <label class="mb-1">
                                    <h6 class="control-label" for="pin"> Category: <br>
                                        {{ directoryCategoryStr(Auth::guard('business')->user()->category_id) }} <span
                                            class="m-l-5 text-danger"> *</span></h6>
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
                                                    // $route = route('admin.directory.category.delete', $targetdirectory->id, $catVal);
                                                    // $route = 'admin/directory/'.$targetdirectory->id.'/category/'.$catVal.'/delete';
                                        
                                                    // dd($route);
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
                                <a href="#newCategoryModal" data-toggle="modal" class="btn btn-sm btn-primary">Add
                                    category</a>

                                @error('category_id')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>

                            {{-- <div class="form-group">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">Category tree</h6>
                                </label>
                                <input class="form-control" type="text" name="category_tree" id="category_tree"
                                    value="{{ Auth::guard('business')->user()->category_tree }}" />
                                @error('category_id')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div> --}}
                            <div class="form-group">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">Service Description</h6>
                                </label>
                                <textarea class="form-control" type="text" name="service_description" id="service_description"
                                    value="{{ Auth::guard('business')->user()->service_description }}"></textarea>
                                @error('service_description')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="mb-1">
                                    <h6 class="mb-0 text-sm text-dark">Description</h6>
                                </label>
                                <textarea class="form-control" type="text" name="description" id="description"
                                    value="{{ Auth::guard('business')->user()->description }}"></textarea>
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
                    <input type="search" name="childCatSearch" id="childCatSearch" class="form-control"
                        onkeyup="findChildCat(this.value)">

                    <hr>

                    <form action="{{ route('business.category.store') }}" method="POST">@csrf
                        {{-- @php
                                $top10Categories = \App\Models\DirectoryCategory::select('id', 'child_category', 'title')->limit(20)->get()->toArray();
    
                                $sortedCats = [];
                                foreach($top10Categories as $topCat) {
                                    $sortedCats[] = [
                                        'id' => $topCat->id,
                                        'child_category' => $topCat->child_category,
                                        'title' => $topCat->title,
                                    ];
                                }
    
                                dd($sortedCats);
                            @endphp --}}

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
    </script>
@endpush
