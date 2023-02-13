@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection

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
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <form action="{{ route('admin.directory.update') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label class="control-label" for="name">Owner Name <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('name') is-invalid @enderror" type="text" name="name" id="name" value="{{ old('name', $targetdirectory->name) }}"/>
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>
                    {{-- <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                @if ($targetdirectory->banner_image != null)
                                    <figure class="mt-2" style="width: 80px; height: auto;">
                                        <img src="{{ asset('Blogs/'.$targetdirectory->banner_image) }}" id="banner_image" class="img-fluid" alt="img">
                                    </figure>
                                @endif
                            </div>
                            <div class="col-md-10">
                                <label class="control-label">Blog Banner Image</label>
                                <p class="small text-danger mb-2">Size must be less than 200kb</p>
                                <input class="form-control @error('banner_image') is-invalid @enderror" type="file" id="banner_image" name="banner_image"/>
                                @error('banner_image') {{ $message }} @enderror
                            </div>
                        </div>
                    </div> --}}
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                @if ($targetdirectory->image != null)
                                    <figure class="mt-2" style="width: 80px; height: auto;">
                                        <img src="{{ asset('Directory/'.$targetdirectory->image) }}" id="blogImage" class="img-fluid" alt="img">
                                    </figure>
                                @endif
                            </div>
                            <div class="col-md-10">
                                <label class="control-label">Directory Image</label>
                                <p class="small text-danger mb-2">Size must be less than 200kb</p>
                                <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                                @error('image') {{ $message }} @enderror
                            </div>
                        </div>
                    </div>

                    {{-- <div class="form-group">
                        <div class="row">
                            <div class="col-md-2">
                                @if ($targetdirectory->image2 != null)
                                    <figure class="mt-2" style="width: 80px; height: auto;">
                                        <img src="{{ asset('Blogs/'.$targetdirectory->image2) }}" id="blogImage" class="img-fluid" alt="img">
                                    </figure>
                                @endif
                            </div>
                            <div class="col-md-10">
                                <label class="control-label">Blog Image2</label>
                                <input class="form-control @error('image2') is-invalid @enderror" type="file" id="image2" name="image2"/>
                                @error('image2') {{ $message }} @enderror
                            </div>
                        </div>
                    </div> --}}


                    <div class="form-group">
                        <label class="control-label" for="name">Email Id <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('email') is-invalid @enderror" type="text" name="email" id="email" value="{{ old('email', $targetdirectory->email) }}"/>
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('email') {{ $message }} @enderror
                    </div>

                    {{-- <div class="form-group">
                        <label class="control-label" for="name">Password <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" id="password" value="{{ old('password', $targetdirectory->password) }}"/>
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('password') {{ $message }} @enderror
                    </div> --}}

                    <div class="form-group">
                        <label class="control-label" for="name">Mobile No <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('mobile') is-invalid @enderror" type="text" name="mobile" id="mobile" value="{{ old('mobile', $targetdirectory->mobile) }}"/>
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('mobile') {{ $message }} @enderror
                    </div>

                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="pin"> Category: <br> {{ directoryCategoryStr($targetdirectory->category_id) }} <span class="m-l-5 text-danger"> *</span></label>

                            <div class="category-container mb-3">
                            @php
                                if(!empty($targetdirectory->category_id)) {
                                    $cat = substr($targetdirectory->category_id, 0, -1);
                                    $displayCategoryName = '';
                                    foreach(explode(',', $cat) as $catKey => $catVal) {
                                        $catDetails = \App\Models\DirectoryCategory::where('id', $catVal)->where('status', 1)->first();

                                        if(!empty($catDetails->child_category)) {
                                            // $route = route('admin.directory.category.delete', $targetdirectory->id, $catVal);
                                            // $route = 'admin/directory/'.$targetdirectory->id.'/category/'.$catVal.'/delete';

                                            // dd($route);
                                            $confirmText = "return confirm('Are you sure ?')";

                                            $displayCategoryName .= '
                                            <div class="badge badge-primary">
                                                '.$catDetails->child_category.'
                                                <a href="'.URL::to('admin/directory/'.$targetdirectory->id.'/category/'.$catVal.'/delete').'" onclick="'.$confirmText.'">&times;</a>
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


                            {{-- <select class="form-control" name="category_id">
                                <option hidden disabled selected>Select Category...</option>
                                @foreach ($directory as $index => $item)
                                    <option value="{{$item->id}}" {{ ($item->id == $targetdirectory->category_id) ? 'selected' : '' }}>{{ $item->title }}</option>
                                @endforeach
                            </select>
                            @error('category_id') <p class="small text-danger">{{ $message }}</p> @enderror --}}
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="establish_year">Establish Year<span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('establish_year') is-invalid @enderror" type="text" name="establish_year" id="establish_year" value="{{ old('establish_year', $targetdirectory->establish_year) }}"/>
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('establish_year') {{ $message }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">ABN <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('ABN') is-invalid @enderror" type="text" name="ABN" id="ABN" value="{{ old('ABN', $targetdirectory->ABN) }}"/>
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="monday">Monday <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('monday') is-invalid @enderror" type="text" name="monday" id="monday" value="{{ old('monday', $targetdirectory->monday) }}"/>
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">TuesDay <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('tuesday') is-invalid @enderror" type="text" name="tuesday" id="tuesday" value="{{ old('tuesday', $targetdirectory->tuesday) }}"/>
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">Wednesday <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('wednesday') is-invalid @enderror" type="text" name="wednesday" id="wednesday" value="{{ old('wednesday', $targetdirectory->wednesday) }}"/>
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">Thursday <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('thursday') is-invalid @enderror" type="text" name="thursday" id="thursday" value="{{ old('thursday', $targetdirectory->thursday) }}"/>
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">Friday <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('friday') is-invalid @enderror" type="text" name="friday" id="friday" value="{{ old('friday', $targetdirectory->friday) }}"/>
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">Saturday<span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('saturday') is-invalid @enderror" type="text" name="saturday" id="saturday" value="{{ old('saturday', $targetdirectory->saturday) }}"/>
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">Sunday <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('sunday') is-invalid @enderror" type="text" name="sunday" id="sunday" value="{{ old('sunday', $targetdirectory->sunday) }}"/>
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">Public Holiday <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('public_holiday') is-invalid @enderror" type="text" name="public_holiday" id="public_holiday" value="{{ old('public_holiday', $targetdirectory->public_holiday) }}"/>
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="name">Category Tree<span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('category_tree') is-invalid @enderror" type="text" name="category_tree" id="category_tree" value="{{ old('category_tree', $targetdirectory->category_tree) }}"/>
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="description">Description</label>
                        <textarea class="form-control" rows="4" name="description" id="summernote-description" value="{{ old('description', $targetdirectory->description) }}"></textarea>
                            <input type="hidden" name="id" value="{{ $targetdirectory->id }}">

                    </div>
                    <div class="form-group">
                        <label class="control-label" for="service_description">Service Description</label>
                        <textarea class="form-control" rows="4" name="service_description" id="summernote-service_description" value="{{ $targetdirectory->service_description }}"></textarea>
                            <input type="hidden" name="id" value="{{ $targetdirectory->id }}">

                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Address <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" id="address" value="{{ $targetdirectory->address }}">
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Pin Code <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('pin') is-invalid @enderror" type="text" name="pin" id="pin" value="{{ $targetdirectory->pin }}">
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Latitude <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('lat') is-invalid @enderror" type="text" name="lat" id="lat" value="{{ $targetdirectory->lat }}">
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Longitude <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('lon') is-invalid @enderror" type="text" name="lon" id="lon" value="{{ $targetdirectory->lon }}">
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Opening Hours <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('opening_hour') is-invalid @enderror" type="text" name="opening_hour" id="opening_hour" value="{{ $targetdirectory->opening_hour }}">
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Website <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('website') is-invalid @enderror" type="text" name="website" id="website" value="{{ $targetdirectory->website }}">
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Facebook Link <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('facebook_link') is-invalid @enderror" type="text" name="facebook_link" id="facebook_link" value="{{ $targetdirectory->facebook_link }}">
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Twitter Link <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('twitter_link') is-invalid @enderror" type="text" name="twitter_link" id="twitter_link" value="{{ $targetdirectory->twitter_link }}">
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="name">Instagram Link <span class="m-l-5 text-danger"> *</span></label>
                        <input class="form-control @error('instagram_link') is-invalid @enderror" type="text" name="instagram_link" id="instagram_link" value="{{ $targetdirectory->instagram_link }}">
                        <input type="hidden" name="id" value="{{ $targetdirectory->id }}">
                        @error('name') {{ $message }} @enderror
                    </div>
                </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Directory</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.directory.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="newCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add category in {{$targetdirectory->name}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <label for="childCatSearch">Search by category name</label>
                    <input type="search" name="childCatSearch" id="childCatSearch" class="form-control" onkeyup="findChildCat(this.value)">

                    <hr>

                    <form action="{{route('admin.directory.category.store')}}" method="POST">@csrf
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
                        <input type="hidden" name="dirId" value="{{$targetdirectory->id}}">
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

    {{-- <div class="modal fade" id="#newCategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              ...
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Save changes</button>
            </div>
          </div>
        </div>
      </div> --}}
@endsection

@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script type="text/javascript">
        $('#summernote-description').summernote({
            height: 400
        });

        $('#summernote-service_description').summernote({
            height: 400
        });

        function findChildCat(val) {
            // alert(val);
            $.ajax({
                type: 'POST',
                url: "{{route('admin.directory.category.search')}}",
                data:{ _token: '{{csrf_token()}}', val: val},
                success:function(response) {
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
