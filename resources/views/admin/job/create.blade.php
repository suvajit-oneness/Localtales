@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
<style>
    #salary {
        display: none;
    }

    #cost {
        display: none;
    }

    #typeOnline {
        display: none;
    }

    #typePerson {
        display: none;
    }

    #yes {
        display: none;
    }
</style>
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}
                    <span class="top-form-btn">
                        <a class="btn btn-secondary" href="{{ route('admin.job.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('admin.job.store') }}" method="POST" role="form" enctype="multipart/form-data">
                    @csrf
                    <div class="tile-body">
                            <div class="form-group">
                                <div class="select-floating-admin">
                                    <label class="control-label" for="category_id">Category <span class="m-l-5 text-danger">*</span></label>
                                    <select name="category_id" id="category_id"
                                        class="filter_select form-control @error('category_id') is-invalid @enderror">
                                        <option value="" hidden selected>Select a Category</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}"
                                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                                {{ ucwords($category->title) }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <p class="small text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Title <span class="m-l-5 text-danger">*</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title"
                                id="title" value="{{ old('title') }}" />
                            @error('title')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="short_description">Short Description <span class="m-l-5 text-danger">*</span></label>
                            <textarea class="form-control" rows="4" name="short_description" id="short_description">{{ old('short_description') }}</textarea>
                            @error('short_description')<p class="small text-danger">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Description <span class="m-l-5 text-danger">*</span></label>
                            <textarea class="form-control summernote" rows="4" name="description" id="description">{{ old('description') }}</textarea>
                            @error('description')<p class="small text-danger">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <div class="select-floating-admin">
                                <label class="control-label" for="employment_type">Employment Type <span class="m-l-5 text-danger">*</span></label><br>

                                <select name="employment_type" id="category"
                                        class="filter_select form-control @error('employment_type') is-invalid @enderror">
                                        <option value="" hidden selected>Select</option>
                                        @foreach ($type as $data)
                                            <option value="{{ $data->title }}"
                                                {{ old('employment_type') == $data->title ? 'selected' : '' }}>
                                                {{ ucwords($data->title) }}</option>
                                        @endforeach
                                </select>
                                @error('employment_type')
                                        <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        {{-- <div id="employment" style="{{old('employment_type') == 'other' ? 'display:block;' : 'display:none;'}}">
                            <div class="form-group">
                                <input class="form-control @error('other_employment_type') is-invalid @enderror" type="text"
                                    name="other_employment_type" id="employment_type" value="{{ old('other_employment_type') }}"
                                    placeholder="Write Employment type" />
                                @error('other_employment_type')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div> --}}
                        <div class="form-group">
                            <label class="control-label" for="skill">Skill<span class="m-l-5 text-danger">*</span></label>
                            </label>
                            
                        <div class="multi-ext-links">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control"  aria-label="Username" name="skill[]" id="skill">
                                <a href="javascript: void(0)" class="input-group-text add-ext-link" id="basic-addon1">
                                    <i class="fa fa-plus"></i>
                                </a>
                            </div>
                        </div>
                        

                        <div id="other-skill"></div>
                            @error('skill')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="responsibility"> Responsibilities <span class="m-l-5 text-danger">*</span></label>
                                <div class="multi-ext-links">
                                    <div class="input-group mb-3">
                                        <input class="form-control @error('responsibility') is-invalid @enderror" type="text" name="responsibility[]"
                                            id="responsibility">
                                        <a href="javascript: void(0)" class="input-group-text add-responsibility-link" id="basic-addon2">
                                            <i class="fa fa-plus"></i>
                                        </a>
                                    </div>
                                </div>
                                        <div id="other-responsibility"></div>
                                    @error('responsibility')
                                        <p class="small text-danger">{{ $message }}</p>
                                    @enderror
                        </div>
                                
                        <div class="form-group">
                            <label class="control-label" for="benifits">Perks And Benifits <span class="m-l-5 text-danger">*</span>(Comma separated)</label>
                            <div class="multi-ext-links">
                                <div class="input-group mb-3">
                                    <input class="form-control @error('benifits') is-invalid @enderror" type="text" name="benifits[]"
                                        id="benifits" >
                                    <a href="javascript: void(0)" class="input-group-text add-benifits-link" id="basic-addon3">
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </div>
                                <div id="other-benifits"></div>
                            @error('benifits')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="experience">Required Experience<span
                                    class="m-l-5 text-danger">*</span>
                                (eg: 1-2 years/ 6 months minimum)
                            </label>
                            <input class="form-control @error('experience') is-invalid @enderror" type="text"
                                name="experience" id="experience" value="{{ old('experience') }}" />
                            @error('experience')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="notice_period">Notice Period (optional, e.g 1 month/immediate joinee, etc)
                            </label>
                            <input class="form-control @error('notice_period') is-invalid @enderror" type="text"
                                name="notice_period" id="notice_period" value="{{ old('notice_period') }}" />
                            @error('notice_period')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="scope">Scope (optional)</label>
                            <input class="form-control @error('scope') is-invalid @enderror" type="text" name="scope"
                                id="scope" value="{{ old('scope') }}" />
                            @error('scope')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="control-label" for="address">Address <span
                                            class="m-l-5 text-danger">*</span>
                                    </label>
                                    <input class="form-control @error('address') is-invalid @enderror" type="text"
                                        name="address" id="address" value="{{ old('address') }}" />
                                    @error('address')
                                        <p class="small text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <div class="select-floating-admin">
                                        <label class="control-label" for="state">State <span class="m-l-5 text-danger">*</span>
                                        </label>
                                        <select class="filter_select form-control" name="state">
                                            <option value="" hidden selected>Select</option>
                                            @foreach ($state as $index => $item)
                                                <option
                                                    value="{{ $item->short_code }}"{{ $item->name == old('state') ? 'selected' : '' }}>
                                                    {{ $item->name }}({{ $item->short_code }})</option>
                                            @endforeach
                                        </select>
        
                                        @error('state')
                                            <p class="small text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="select-floating-admin">
                                        <label class="control-label" for="postcode">Postcode <span class="m-l-5 text-danger">*</span>
                                        </label>
                                        <select class="filter_select form-control" name="postcode" disabled>
                                            <option value=""{{ old('postcode') ? 'selected' : '' }}>Select State first</option>
                                        </select>
                                        @error('postcode')
                                            <p class="small text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="select-floating-admin">
                                        <label class="control-label" for="suburb">Suburb <span class="m-l-5 text-danger">*</span>
                                        </label>
                                        <select class="filter_select form-control" name="suburb" disabled>
                                            <option value="" selected disabled>Select Postcode first</option>
                                        </select>
                                        @error('suburb')
                                            <p class="small text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="select-floating-admin">
                                <label class="control-label" for="state">Country <span
                                        class="m-l-5 text-danger">*</span>
                                </label>
                                <select class="filter_select form-control" name="country">
                                    <option value="">Select Country</option>
                                    @foreach ($country as $index => $item)
                                        <option value="{{ $item->country_name }}">
                                            {{ $item->country_name }}</option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label" for="name">Start Date <span
                                            class="m-l-5 text-danger">
                                            *</span></label>
                                    <input class="form-control @error('start_date') is-invalid @enderror" type="date"
                                        name="start_date" id="start_date" value="{{ old('start_date') }}" />
                                    @error('start_date')
                                        <p class="small text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label" for="name">End Date <span class="m-l-5 text-danger">
                                            *</span></label>
                                    <input class="form-control @error('end_date') is-invalid @enderror" type="date"
                                        name="end_date" id="end_date" value="{{ old('end_date') }}" />
                                    @error('end_date')
                                        <p class="small text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="control-label" for="source">Source (Comma seperated, Optional)</label>
                                    <input class="form-control @error('source') is-invalid @enderror" type="text"
                                        name="source" id="source" value="{{ old('source') }}" />
                                    @error('source')
                                        <p class="small text-danger">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <div class="select-floating-admin">
                                        <label class="control-label" for="salary">Salary Per (Optional)</label>
                                        <select class="filter_select form-control" name="salary" id="yesCheck">
                                            <option value="">Select an option</option>
                                            <option value="year" {{ old('salary') == 'year' ? 'selected' : '' }}>Year
                                            </option>
                                            <option value="month" {{ old('salary') == 'month' ? 'selected' : '' }}>Month
                                            </option>
                                            <option value="hour" {{ old('salary') == 'hour' ? 'selected' : '' }}>Hour
                                            </option>
                                            <option value="article" {{ old('salary') == 'article' ? 'selected' : '' }}>
                                                Article
                                            </option>
                                            <option value="word" {{ old('salary') == 'word' ? 'selected' : '' }}> Word
                                            </option>
                                        </select>
                                        @error('salary')
                                            <p class="small text-danger">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="salary">
                            <div class="form-group">
                                <label class="control-label" for="payment">Amount (optional,in '$')</label>
                                <input class="form-control @error('payment') is-invalid @enderror" type="text"
                                    name="payment" value="{{ old('payment') }}" placeholder="eg :10 - 20"/>
                                @error('payment')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        
                        <div class="form-group">
                            <label class="control-label" for="schedule">Schedule (optional, Comma seperated)</label>
                            <input class="form-control @error('schedule') is-invalid @enderror" type="text"
                                name="schedule" value="{{ old('schedule') }}" />
                            @error('schedule')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="company_name">Company Name <span
                                    class="m-l-5 text-danger">*</span></label>
                            <input class="form-control @error('company_name') is-invalid @enderror" type="text" name="company_name"
                                id="company_name" value="{{ old('company_name') }}" />
                            @error('company_name')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="contact_number">Company contact number<span
                                    class="m-l-5 text-danger"></span>(Optional)</label>
                            <input class="form-control @error('contact_number') is-invalid @enderror" type="text" name="contact_number"
                                id="contact_number" value="{{ old('contact_number') }}" />
                            @error('contact_number')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="contact_information">Company contact information <span
                                    class="m-l-5 text-danger"></span>(Optional)</label>
                            <input class="form-control @error('contact_information') is-invalid @enderror" type="text" name="contact_information"
                                id="contact_information" value="{{ old('contact_information') }}" />
                            @error('contact_information')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="company_website">Company website link<span
                                    class="m-l-5 text-danger">*</span></label>
                            <input class="form-control @error('company_website') is-invalid @enderror" type="text" name="company_website"
                                id="company_website" value="{{ old('company_website') }}" />
                            @error('company_website')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="company_desc">Company Description <span
                                    class="m-l-5 text-danger">*</span></label>
                            <textarea class="form-control @error('company_desc') is-invalid @enderror" type="text" name="company_desc"
                                id="company_desc">{{ old('company_desc') }}</textarea>
                            @error('company_desc')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit"><i
                                    class="fa fa-fw fa-lg fa-check-circle"></i>Save Job</button>
                            <a class="btn btn-secondary" href="{{ route('admin.job.index') }}"><i
                                    class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
            {{-- <div class="tile-footer">
                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save
                    job</button>
                &nbsp;&nbsp;&nbsp;
                <a class="btn btn-secondary" href="{{ route('admin.job.index') }}"><i
                        class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
            </div> --}}
        </div>
    </div>
    </div>
@endsection
@push('scripts')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script type="text/javascript">
        $('#description').summernote({
            height: 400
        });
    </script>
    <script>
        $(".help-box").hide();
        $("#item").click(function() {
            if ($(this).is(":checked")) {
                $(".help-box").show();
            } else {
                $(".help-box").hide();
            }
        });
        $(function() {
            $('#salary').hide();
            $('#yesCheck').change(function() {
                if ($('#yesCheck').val() != '') {
                    $('#salary').show();
                } else {
                    $('#salary').hide();
                }
            });
        });
        $(function() {
            $('#employment_type').change(function() {
                if ($('#employment_type').val() == 'other') {
                    $('#employment').show();
                } else {
                    $('#employment').hide();
                }
            });
        });
    </script>
    <script>
        $('.add-ext-link').on('click', function() {
            var content = `
            <div class="multi-ext-links">
                <div class="input-group mb-3">
                    <input type="text" class="form-control"  name="skill[]">
                    <a href="javascript: void(0)" class="input-group-text remove-ext-link" id="basic-addon1">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            `;

            $('#other-skill').append(content);
        });

        $(document).on('click', '.remove-ext-link', function() {
            $(this).closest(".multi-ext-links").remove();
        });
    </script>
     <script>
        $('.add-responsibility-link').on('click', function() {
            var content = `
            <div class="multi-responsibility-links">
                <div class="input-group mb-3">
                    <input type="text" class="form-control"  name="responsibility[]">
                    <a href="javascript: void(0)" class="input-group-text remove-responsibility-link" id="basic-addon2">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            `;

            $('#other-responsibility').append(content);
        });

        $(document).on('click', '.remove-responsibility-link', function() {
            $(this).closest(".multi-responsibility-links").remove();
        });
    </script>
    <script>
        $('.add-benifits-link').on('click', function() {
            var content = `
            <div class="multi-benifits-links">
                <div class="input-group mb-3">
                    <input type="text" class="form-control"  name="benifits[]">
                    <a href="javascript: void(0)" class="input-group-text remove-benifits-link" id="basic-addon3">
                        <i class="fa fa-times"></i>
                    </a>
                </div>
            </div>
            `;

            $('#other-benifits').append(content);
        });

        $(document).on('click', '.remove-benifits-link', function() {
            $(this).closest(".multi-benifits-links").remove();
        });
    </script>
       <script>
        $('select[name="state"]').on('change', (event) => {
            var value = $('select[name="state"]').val();

            $.ajax({
                url: '{{ url('/') }}/api/state/postcode/' + value,
                method: 'GET',
                success: function(result) {
                    var content = '';
                    var slectTag = 'select[name="postcode"]';
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

        $('select[name="postcode"]').on('change', (event) => {
            var value = $('select[name="postcode"]').val();

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
@endpush
