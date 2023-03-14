@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
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
                <h3 class="tile-title">{{ $subTitle }}</h3>
                <hr>
                <form action="{{ route('admin.school.update') }}" method="POST" role="form" enctype="multipart/form-data">
                	<input type="hidden" name="id" value="{{ $targetSchool->id }}">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="name">Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title', $targetSchool->title) }}"/>
                            @error('title') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Type <span class="m-l-5 text-muted">(optional)</span></label>
                            <input class="form-control @error('type') is-invalid @enderror" type="text" name="type" id="type" value="{{ old('type', $targetSchool->type) }}"/>
                        </div>

                        <div class="form-group">
                            <label class="control-label" for="name">Grade <span class="m-l-5 text-muted">(optional)</span></label>
                            <input class="form-control @error('grade') is-invalid @enderror" type="text" name="grade" id="grade" value="{{ old('grade', $targetSchool->grade) }}"/>
                        </div>
                       
                        <div class="form-group">
                            <label class="control-label" for="name">Street Address <span class="m-l-5 text-muted">(optional)</span></label>
                            <input class="form-control @error('street_address') is-invalid @enderror" type="text" name="street_address" id="street_address" value="{{ old('street_address', $targetSchool->street_address) }}"/>
                        </div>
                        <div class="form-group">
                            <div class="page-search-block filterSearchBoxWraper" style="bottom: -83px;">
                                <div class="filterSearchBox">
                                    <div class="row">
                                        <div class="mb-sm-0 col col-lg fcontrol position-relative filter_selectWrap filter_selectWrap2">
                                            <div class="select-floating-admin">
                                                <label class="control-label" for="state">  State<span class="m-l-5 text-muted">(optional)</span></label>
                                                <select class="filter_select form-control" name="state">
                                                    <option value="" hidden selected>Select State</option>
                                                    @foreach ($state as $index => $item)
                                                    <option value="{{$item->name}}" {{ ($item->name == $targetSchool->state) ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('state')
                                                    <p class="small text-danger">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="page-search-block filterSearchBoxWraper" style="bottom: -83px;">
                            <div class="filterSearchBox">
                                <div class="row">
                                    <div class="mb-sm-0 col col-lg fcontrol position-relative filter_selectWrap filter_selectWrap2">
                                        <div class="select-floating-admin">
                                            <label class="control-label" for="postcode"> Postcode<span class="m-l-5 text-muted">(optional)</span></label>
                                            <select class="filter_select form-control" name="postcode">
                                                <option value="" hidden selected>Select Postcode</option>
                                                @foreach ($pin as $index => $item)
                                                <option value="{{$item->pin}}" {{ ($item->pin == $targetSchool->postcode) ? 'selected' : '' }}>{{ $item->pin }}</option>
                                                @endforeach
                                            </select>
                                            @error('postcode')
                                                <p class="small text-danger">{{ $message }}</p>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tile-body">
                            <div class="form-group">
                                <div class="select-floating-admin">
                                    <label class="control-label" for="suburb"> Suburb<span class="m-l-5 text-muted">(optional)</span></label>
                                    <select class="form-control" name="suburb" disabled>
                                    <option value="">None</option>
                                    <option value="" {{ ($targetSchool->suburb) ? 'selected' : '' }}>{{$targetSchool->suburb ?? ''}}</option>
                                    </select>
                                </div>
                                @error('suburb') <p class="small text-danger">{{ $message }}</p> @enderror
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="contact">Contact <span class="m-l-5 text-muted">(optional)</span></label>
                            <input class="form-control @error('contact') is-invalid @enderror" type="text" name="contact" id="contact" value="{{ old('contact', $targetSchool->contact) }}"/>
                        </div>
                       
                        <div class="form-group">
                            <label class="control-label" for="overview">Overview<span class="m-l-5 text-muted">(optional)</span></label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ old('description', $targetSchool->description) }}</textarea>
                        </div>
                        {{-- <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">
                                    @if ($targetSchool->image != null)
                                        <figure class="mt-2" style="width: 80px; height: auto;">
                                            <img src="{{ $targetSchool->image }}" id="blogImage" class="img-fluid" alt="img">
                                        </figure>
                                    @endif
                                </div>
                                <div class="col-md-10">
                                    <label class="control-label">Image <span class="m-l-5 text-danger"> *</span></label>
                                    <p class="small text-danger mb-2">Size must be less than 200kb</p>
                                    <input class="form-control @error('image') is-invalid @enderror" type="file" id="image" name="image"/>
                                    @error('image') {{ $message }} @enderror
                                </div>
                            </div>
                        </div> --}}
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.school.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
	

        $('select[name="postcode"]').on('change', (event) => {
			var value = $('select[name="postcode"]').val();

			$.ajax({
				url: '{{url("/")}}/api/postcode-suburb/'+value,
                method: 'GET',
                success: function(result) {
					var content = '';
					var slectTag = 'select[name="suburb"]';
					var displayCollection = (result.data.postcode == "all") ? "All postcode" : " Select";

					content += '<option value="" selected>'+displayCollection+'</option>';
					$.each(result.data.suburb, (key, value) => {
						content += '<option value="'+value.suburb_title+'">'+value.suburb_title+'</option>';
					});
					$(slectTag).html(content).attr('disabled', false);
                }
			});
		});
    </script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
<script type="text/javascript">
    $('#summernote_content').summernote({
        height: 400
    });
    $('#summernote_meta_description').summernote({
        height: 400
    });
    $('#summernote_sticky_content').summernote({
        height: 400
    });
</script>

@endpush