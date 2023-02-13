@extends('business.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('business.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}
                    <span class="top-form-btn">
                        <a class="btn btn-secondary" href="{{ route('business.deal.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Back</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('business.deal.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="category_id">Category<span class="m-l-5 text-danger"> *</span></label>
                            <select name="category_id[]" id="category_id" class="filter_select form-control @error('category_id') is-invalid @enderror" multiple>
                                {{-- <option value="" hidden selected>Select Categoy</option> --}}
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request()->input('category_id') == $category->id ? 'selected' : '' }}>{{ $category->parent_category }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                         {{-- <div class="form-group">
                            <label class="control-label" for="business_id">Business</label>
                            <select name="business_id" id="business_id" class="form-control @error('business_id') is-invalid @enderror">
                                <option value="">Select a Business</option>
                                @foreach($businesses as $business)
                                    <option value="{{ $business->id }}">{{ $business->bussiness_name }}</option>
                                @endforeach
                            </select>
                        </div> --}}
                        <div class="form-group">
                            <label class="control-label" for="name">Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}"/>
                            @error('title')  <p class="small text-danger">{{ $message ?? '' }} </p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Main Image <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                            @error('image') <p class="small text-danger"> {{ $message }} </p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">First Image <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('image1') is-invalid @enderror" type="file" id="image1" name="image1"/>
                            @error('image1') <p class="small text-danger"> {{ $message }} </p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Second Image <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('image2') is-invalid @enderror" type="file" id="image2" name="image2"/>
                            @error('image2') <p class="small text-danger"> {{ $message }} </p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Third Image <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('image3') is-invalid @enderror" type="file" id="image3" name="image3"/>
                            @error('image3') <p class="small text-danger"> {{ $message }} </p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="short_description">Short Description <span class="m-l-5 text-muted"> (optional)</span></label>
                            <textarea class="form-control" rows="4" name="short_description" id="short_description">{{ old('short_description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Description <span class="m-l-5 text-muted"> (optional)</span></label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Address <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" id="address" value="{{ old('address') }}"/>
                            @error('address')
                            <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="mb-1">State <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="state">
                                <option hidden selected></option>
                                @foreach ($state as $index => $item)
                                    <option
                                        value="{{ $item->short_code }}" {{old('state')}}>
                                        {{ $item->name }}({{ $item->short_code }})</option>
                                @endforeach
                            </select>

                            @error('state')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Postcode <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="pin" disabled>
                                <option value="">Select State first</option>
                            </select>

                            @error('pin')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="mb-1">Suburb <span class="m-l-5 text-danger"> *</span></label>
                            <select class="form-control" name="suburb" disabled>
                                <option value="" selected disabled>Select Postcode first</option>
                            </select>
                            @error('suburb')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Expiry Date <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('expiry_date') is-invalid @enderror" type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}"/>
                            @error('expiry_date')
                            <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Price <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('price') is-invalid @enderror" type="text" name="price" id="price" value="{{ old('price') }}"/>
                            @error('price')
                            <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="promo_code">Promo Code <span class="m-l-5 text-muted"> (optional)</span></label>
                            <input class="form-control @error('promo_code') is-invalid @enderror" type="text" name="promo_code" id="promo_code" value="{{ old('promo_code') }}"/>
                            @error('promo_code')
                            <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="form-group col-6">
                                <label class="control-label" for="discount_type">Deal discount type <span class="m-l-5 text-muted"> (optional)</span></label>
                                <select name="discount_type" class="form-control @error('discount_type') is-invalid @enderror" id="discount_type">
                                    <option value="percentage" {{old('discount_type') == 'percentage' ? 'selected' : ''}}>Percentage(%)</option>
                                    <option value="flat" {{old('discount_type') == 'flat' ? 'selected' : ''}}>Flat($)</option>
                                </select>
                                @error('discount_type')
                                <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group col-6">
                                <label class="control-label" for="discount_amount">Deal discount amount <span class="m-l-5 text-muted"> (optional)</span></label>
                                <input type="number" name="discount_amount" id="discount_amount" value="{{ old('discount_amount') }}" class="form-control">
                                @error('discount_amount')
                                <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="how_to_redeem">How To Redeem <span class="m-l-5 text-muted">(optional)</span></label>
                            <textarea class="form-control" rows="4" name="how_to_redeem" id="how_to_redeem">{{ old('how_to_redeem') }}</textarea>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Deal</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('business.deal.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
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
    $('#description').summernote({
        height: 400
    });
   
</script>
@endpush