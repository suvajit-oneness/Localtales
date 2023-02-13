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
                <form action="{{ route('admin.event.update') }}" method="POST" role="form" enctype="multipart/form-data">
                	<input type="hidden" name="id" value="{{ $targetEvent->id }}">
                    @csrf
                    <div class="tile-body">
                        <div class="form-group">
                            <label class="control-label" for="category_id">Category</label>
                            <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                <option value="">Select a Category</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" @if($targetEvent->category_id==$category->id){{"selected"}}@endif >{{ $category->parent_category }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="business_id">Business</label>
                            <select name="business_id" id="business_id" class="form-control @error('business_id') is-invalid @enderror">
                                <option value="">Select a Business</option>
                                @foreach($businesses as $business)
                                    <option value="{{ $business->id }}" @if($targetEvent->business_id==$business->id){{"selected"}}@endif >{{ $business->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Title <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{ old('title', $targetEvent->title) }}"/>
                            @error('title') {{ $message ?? '' }} @enderror
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="description">Description</label>
                            <textarea class="form-control" rows="4" name="description" id="description">{{ old('description', $targetEvent->description) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Address <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('address') is-invalid @enderror" type="text" name="address" id="address" value="{{ old('address', $targetEvent->address) }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Latitude <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('lat') is-invalid @enderror" type="text" name="lat" id="lat" value="{{ old('lat', $targetEvent->lat) }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Longitude <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('lon') is-invalid @enderror" type="text" name="lon" id="lon" value="{{ old('lon', $targetEvent->lon) }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Pin Code <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('pin') is-invalid @enderror" type="text" name="pin" id="pin" value="{{ old('pin', $targetEvent->pin) }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Start Date <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('start_date') is-invalid @enderror" type="date" name="start_date" id="start_date" value="{{ old('start_date', $targetEvent->start_date) }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Start Time <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('start_time') is-invalid @enderror" type="text" name="start_time" id="start_time" value="{{ old('start_time', $targetEvent->start_time) }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">End Date <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('end_date') is-invalid @enderror" type="date" name="end_date" id="end_date" value="{{ old('end_date', $targetEvent->end_date) }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">End Time <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('end_time') is-invalid @enderror" type="text" name="end_time" id="end_time" value="{{ old('end_time', $targetEvent->end_time) }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="format_id">Format</label>
                            <select name="format_id" id="format_id" class="form-control @error('format_id') is-invalid @enderror">
                                <option value="">Select a format</option>
                                @foreach($eventformats as $eventformat)
                                    <option value="{{ $eventformat->id }}" @if($targetEvent->format_id==$eventformat->id){{"selected"}}@endif>{{ $eventformat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="language_id">Language</label>
                            <select name="language_id" id="language_id" class="form-control @error('language_id') is-invalid @enderror">
                                <option value="">Select a language</option>
                                @foreach($languages as $language)
                                    <option value="{{ $language->id }}" @if($targetEvent->language_id==$language->id){{"selected"}}@endif>{{ $language->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="is_paid">Paid Event?</label>
                            <select name="is_paid" id="is_paid" class="form-control @error('is_paid') is-invalid @enderror">
                                <option value="">Select an option</option>
                                <option value="1" @if($targetEvent->is_paid==1){{"selected"}}@endif>Yes</option>
                                <option value="0" @if($targetEvent->is_paid==0){{"selected"}}@endif>No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Price <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('price') is-invalid @enderror" type="text" name="price" id="price" value="{{ old('price', $targetEvent->price) }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="is_recurring">Recurring Event?</label>
                            <select name="is_recurring" id="is_recurring" class="form-control @error('is_recurring') is-invalid @enderror">
                                <option value="">Select an option</option>
                                <option value="1" @if($targetEvent->is_recurring==1){{"selected"}}@endif>Yes</option>
                                <option value="0" @if($targetEvent->is_recurring==0){{"selected"}}@endif>No</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Website <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('website') is-invalid @enderror" type="text" name="website" id="website" value="{{ old('website', $targetEvent->website) }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Contact Email Id <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('contact_email') is-invalid @enderror" type="text" name="contact_email" id="contact_email" value="{{ old('contact_email', $targetEvent->contact_email) }}"/>
                        </div>
                        <div class="form-group">
                            <label class="control-label" for="name">Contact Phone No <span class="m-l-5 text-danger"> *</span></label>
                            <input class="form-control @error('contact_phone') is-invalid @enderror" type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $targetEvent->contact_phone) }}"/>
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Update Event</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.event.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
