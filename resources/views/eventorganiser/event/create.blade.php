@extends('eventorganiser.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
<style>
    #ifYes {
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
    #yes{
        display: none;
    }
</style>
    <div class="app-title">
        <div>
            <h1><i class="fa fa-tags"></i> {{ $pageTitle }}</h1>
        </div>
    </div>
    {{-- @include('eventorganiser.partials.flash') --}}
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">{{ $subTitle }}
                    <span class="top-form-btn">
                        <a class="btn btn-secondary" href="{{ route('eventorganiser.event.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </span>
                </h3>
                <hr>
                <form action="{{ route('eventorganiser.event.store') }}" method="POST" role="form" enctype="multipart/form-data">
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
                        <div class="form-group">
                            <label class="control-label"> Directory <span class="m-l-5 text-danger">
                                    *</span></label>
                            <div id="show_checkboxes" class="row">
                            </div>
                            <input type="search" class="form-control dropdown-toggle" id="searchName" value=""
                                placeholder="Search Directory name" data-toggle="dropdown">
                            <div class="respDrop" style="position: relative;"></div>
                            @error('directory_id')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title') }}"/>
                            @error('title') <p class="small text-danger">{{ $message ?? '' }} </p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="short_description">Short Description <span class="m-l-5 text-muted">(optional)</span></label>
                            <textarea class="form-control" rows="4" name="short_description" id="">{{ old('short_description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Description <span class="m-l-5 text-muted">(optional)</span></label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ old('description') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="host">Host <span class="m-l-5 text-danger">
                            *</span></label><br>
                            @error('host') <p class="small text-danger">{{ $message }}</p> @enderror
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="host" onClick="hostCheck();" id="yesCheck" value="Local tales" {{ old('host') ? (( old('host') == "Local tales" ) ? 'checked' : '') : 'checked' }}>
                                        <label class="form-check-label" for="yesCheck">
                                            Local Tales
                                        </label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="host" onClick="hostCheck();" id="noCheck" value="Other" {{ old('host') ? (( old('host') != "Local tales" ) ? 'checked' : '') : '' }}>
                                        <label class="form-check-label" for="noCheck">
                                            Other
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="ifYes">
                            <div class="form-group">
                                <input id="no" name="other_host_name" rows="3" placeholder="Host Name"
                                class="form-control h-auto" value="{{ old('other_host_name') }}">
                                @error('other_host_name') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="type">Type <span class="m-l-5 text-danger">
                            *</span></label>
                            <br>@error('type') <p class="small text-danger">{{ $message }}</p> @enderror
                            
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" onClick="eventtypeCheck();" id="online" name="type" value="online" {{ old('type') ? (( old('type') == "online" ) ? 'checked' : '') : 'checked' }}>
                                        <label class="form-check-label" for="online">
                                            Online
                                        </label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" onClick="eventtypeCheck();" id="person" name="type" value="in person" {{ old('type') ? (( old('type') != "online" ) ? 'checked' : '') : '' }}>
                                        <label class="form-check-label" for="person">
                                            In-Person
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="typePerson">
                            <div class="form-group">
                                <label class="control-label" for="name">Address <span class="m-l-5 text-muted">(optional)</span></label>
                                <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" id="address" value="{{ old('address') }}"/>
                            </div>
                            <div class="form-group">
                                <label class="mb-1">State <span class="m-l-5 text-muted"> (optional)</span></label>
                                <select class="form-control" name="state">
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
                            <div class="form-group">
                                <label class="control-label" for="name">Postcode <span class="m-l-5 text-muted"> (optional)</span></label>
                                <select class="form-control" name="pin" disabled>
                                    <option value="">Select State first</option>
                                </select>
    
                                @error('pin')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="mb-1">Suburb <span class="m-l-5 text-muted"> (optional)</span></label>
                                <select class="form-control" name="suburb" disabled>
                                    <option value="" selected disabled>Select Postcode first</option>
                                </select>
                                @error('suburb')
                                    <p class="small text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                            {{-- <div class="form-group">
                                <label class="control-label" for="name">Latitude </label>
                                <input class="form-control @error('lat') is-invalid @enderror" type="text" name="lat" id="lat" value="{{ old('lat') }}"/>
                            </div>
                            <div class="form-group">
                                <label class="control-label" for="name">Longitude </label>
                                <input class="form-control @error('lon') is-invalid @enderror" type="text" name="lon" id="lon" value="{{ old('lon') }}"/>
                            </div> --}}
                        </div>
                        <div id="typeOnline">
                            <div class="form-group">
                                <label class="control-label" for="link">Event Link <span class="m-l-5 text-muted">(optional)</span></label>
                                <input class="form-control @error('link') is-invalid @enderror" type="text"
                                    name="link" id="link" value="{{ old('link') }}" placeholder="eg: https://zoom.us/j/5551112222" />
                                    @error('link') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Start Date <span
                                            class="m-l-5 text-danger">
                                            *</span></label>
                                    <input class="form-control @error('start_date') is-invalid @enderror" type="date"
                                        name="start_date" id="start_date" value="{{ old('start_date') }}" />
                                        @error('start_date') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">Start Time <span
                                            class="m-l-5 text-danger">
                                            *</span></label>
                                    <input class="form-control @error('start_time') is-invalid @enderror" type="time"
                                        name="start_time" id="start_time" value="{{ old('start_time') }}" />
                                        @error('start_time') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">End Date <span class="m-l-5 text-danger">
                                            *</span></label>
                                    <input class="form-control @error('end_date') is-invalid @enderror" type="date"
                                        name="end_date" id="end_date" value="{{ old('end_date') }}" />
                                        @error('end_date') <p class="small text-danger">{{ $message }}</p> @enderror
                                    </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="control-label" for="name">End Time <span class="m-l-5 text-danger">
                                            *</span></label>
                                    <input class="form-control @error('end_time') is-invalid @enderror" type="time"
                                        name="end_time" id="end_time" value="{{ old('end_time') }}" />
                                        @error('end_time') <p class="small text-danger">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                      
                        <div class="form-group">
                            <label class="control-label" for="name">Cost <span class="m-l-5 text-danger">*</span></label>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" onClick="CostCheck();" id="free" name="is_paid" value="0" {{ old('is_paid') ? (( old('is_paid') == "0" ) ? 'checked' : '') : 'checked' }}>
                                        <label class="form-check-label" for="free">
                                            Free
                                        </label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" onClick="CostCheck();" id="premium" name="is_paid" value="1" {{ old('is_paid') ? (( old('is_paid') != "0" ) ? 'checked' : '') : '' }}>
                                        <label class="form-check-label" for="premium">
                                            Paid
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="cost">
                            <div class="form-group">
                                <input class="form-control @error('price') is-invalid @enderror" type="number"
                                name="price" id="event_cost" value="{{ old('price') }}"
                                placeholder="Enter Cost" />
                                @error('price') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="recurring">Recurring Event <span class="m-l-5 text-muted"> (optional)</span></label>
                            <div class="row">
                                <div class="col-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" onClick="recurringCheck();"
                                        id="recurring" name="recurring" value="yes" {{ old('recurring') ? (( old('recurring') == "yes" ) ? 'checked' : '') : '' }}>
                                        <label class="form-check-label" for="recurring">
                                            Yes
                                        </label>
                                    </div>
                                </div>
                                <div class="col-8">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" onClick="recurringCheck();"
                                        id="norecurr" name="recurring" value="no" {{ old('recurring') ? (( old('recurring') != "yes" ) ? 'checked' : '') : 'checked' }}>
                                        <label class="form-check-label" for="norecurr">
                                            No
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <div id="yes">
                                <div class="form-group">
                                    <select name="recurring" id="skim"
                                        class="form-control @error('skim') is-invalid @enderror">
                                        <option value="">Select an option</option>
                                        <option value="daily" {{ old('recurring') == "daily" ? 'checked' : '' }}>Daily</option>
                                        <option value="weekly" {{ old('recurring') == "daily" ? 'weekly' : '' }}>Weekly</option>
                                        <option value="monthly" {{ old('recurring') == "monthly" ? 'checked' : '' }}>Monthly</option>
                                        <option value="yearly" {{ old('recurring') == "yearly" ? 'checked' : '' }}>Yearly</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Website <span class="m-l-5 text-muted"> (optional)</span></label>
                            <input class="form-control @error('website') is-invalid @enderror" type="text" name="website" id="website" value="{{ old('website') }}" placeholder="eg: https://www.google.com/"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Contact Email Id <span class="m-l-5 text-muted"> (optional)</span></label>
                            <input class="form-control @error('contact_email') is-invalid @enderror" type="text" name="contact_email" id="contact_email" value="{{ old('contact_email') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Contact Phone No <span class="m-l-5 text-muted"> (optional)</span></label>
                            <input class="form-control @error('contact_phone') is-invalid @enderror" type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone') }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label">Main Image<span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                            @error('image') <p class="small text-danger">{{ $message }} </p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">First Image<span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('image1') is-invalid @enderror" type="file" id="image1" name="image1"/>
                            @error('image1') <p class="small text-danger"> {{ $message }} </p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Second Image <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('image2') is-invalid @enderror" type="file" id="image2" name="image2"/>
                            @error('image2') <p class="small text-danger"> {{ $message }} </p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label">Third Image<span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('image3') is-invalid @enderror" type="file" id="image3" name="image3"/>
                            @error('image3') <p class="small text-danger"> {{ $message }} </p>@enderror
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save Event</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('eventorganiser.event.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
    // state, suburb, postcode data fetch
    $('#search').on('keyup', function() {
        $value = $(this).val();
        $.ajax({
            type: 'get',
            url: '{{ URL::to('admin/collectiondirectory') }}',
            data: {
                'search': $value
            },
            success: function(data) {
                $('input').html(data);
            }
        });
    })
</script>

<script>
    // store name search
    $('#searchName').on('keyup', function() {
        var $this = '#searchName'

        if ($($this).val().length > 0) {
            $.ajax({
                url: '{{ route('directory.search') }}',
                method: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    name: $($this).val(),

                },
                success: function(result) {
                    var content = '';
                    if (result.error === false) {
                        content +=
                            `<div class="dropdown-menu row show w-100 postcode-dropdown" style="display: flex; position: absolute; top: 0px;" aria-labelledby="dropdownMenuButton">`;

                        $.each(result.data, (key, value) => {
                            value.name = value.name.split("'").join("");
                            if ($('#directory_' + value.id).length > 0) {
                                content +=
                                    `<label class="d-flex m-3" style="flex-direction: row-reverse; align-items: center;">${value.name}<input onClick="setDirectory('${value.name}','${value.id}', this)" type="checkbox" checked value="${value.id}"></label>`
                            } else {
                                content +=
                                    `<label class="d-flex m-3" style="flex-direction: row-reverse; align-items: center;">${value.name}<input onClick="setDirectory('${value.name}','${value.id}', this)" type="checkbox" value="${value.id}"></label>`
                            }
                        })
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

    function setDirectory(x, y, z) {
        if (z.checked == true) {
            if ($('#directory_' + y).length <= 0) {
                $('#show_checkboxes').append(
                    `<label id="directory_${y}" class="d-flex m-3" style="flex-direction: row-reverse; align-items: center;">${x}<input checked type="checkbox" name="directory_id[]" onClick="removeCheckbox('${y}')" value="${y}"></label>`
                )
            } else {
                $('#directory_' + y).remove();
            }
        } else {
            $('#directory_' + y).remove();
        }
        $('#searchName').val('');
        $('.respDrop').html('');
        $('#searchName').focus();
    }

    function removeCheckbox(x) {
        $('#directory_' + x).remove();
    }
</script>
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
<script>
    @if(old('host')) hostCheck(); @endif
        function hostCheck() {
            if (document.getElementById('noCheck').checked) {
                document.getElementById('ifYes').style.display = 'block';
            } else document.getElementById('ifYes').style.display = 'none';

        }

        eventtypeCheck();
        function eventtypeCheck() {
            if (document.getElementById('online').checked) {
                document.getElementById('typeOnline').style.display = 'block';
                document.getElementById('typePerson').style.display = 'none';
            } else {
                document.getElementById('typeOnline').style.display = 'none';
                document.getElementById('typePerson').style.display = 'block';
            }
        }

        @if(old('is_paid')) CostCheck(); @endif
        function CostCheck() {
            if (document.getElementById('premium').checked) {
                document.getElementById('cost').style.display = 'block';
                document.getElementById('event_cost').setAttribute('value', '');
            } else {
                document.getElementById('cost').style.display = 'none';
                document.getElementById('event_cost').setAttribute('value', 0);
            }
        }

        recurringCheck();
        function recurringCheck() {
            if (document.getElementById('recurring').checked) {
                document.getElementById('yes').style.display = 'block';
            } else document.getElementById('yes').style.display = 'none';

        }
</script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $('#description').summernote({
        height: 400
    });
    $('#paragraph1').summernote({
        height: 400
    });
    $('#paragraph2').summernote({
        height: 400
    });
    $('#paragraph3').summernote({
        height: 400
    });
    $('#summernote-meta_description').summernote({
        height: 400
    });
</script>
@endpush