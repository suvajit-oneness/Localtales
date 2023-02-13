@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection

@section('content')
    <style>
        .send-mail {
            position: sticky;
            bottom: 0;
            background: #fff;
            padding: 20px 0;
            border-top: 1px solid #f1f1f1;
        }
    </style>

    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p></p>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="row justify-content-center">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header text-right">
                    <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark"> <i class="fa fa-chevron-left"></i> Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <form action="">
                               
                                <div class="row">
                                    <div class="col-md-4">
                                        <label for="Keyword" class="small text-muted">Keyword</label>
                                        <input type="text" id="keywordfloting" class="form-control pl-3" name="Keyword" id="Keyword" placeholder="Keyword" value="{{ request()->input('Keyword') }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label for="Keyword" class="small text-muted">Email send</label>
                                        <select class=" form-control" name="mail_send">
                                            <option value="" hidden selected>Select...</option>
                                            <option value="1"
                                                {{ request()->input('mail_send') == 1 ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                            <option value="0"
                                                {{ request()->input('mail_send') == 0 ? 'selected' : '' }}>
                                                No
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="Keyword" class="small text-muted">Detail update</label>
                                        <select class=" form-control" name="updated">
                                            <option value="" hidden selected>Select...</option>
                                            <option value="1" {{ request()->input('updated') == 1 ? 'selected' : '' }}>
                                                Yes
                                            </option>
                                            <option value="0" {{ request()->input('updated') == 0 ? 'selected' : '' }}>
                                                No
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mt-3 text-right">
                                    <div class="col-md-12 col-sm-12">
                                        <button type="submit" class="btn btn-outline-danger btn-sm">Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-12">
                            <form action="{{ route('admin.directory.email.send') }}" method="POST" role="form" enctype="multipart/form-data">@csrf

                                <input class="tap-to-delete" type="hidden" value="{{ $category->parent_category_email_template }}" name="body">

                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="tile p-0">
                                            <label class="control-label">Directory list</label>
                                            <div class="mt-3">
                                                <div class="tile-body">
                                                    <table class="table table-hover custom-data-table-style table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th><input type="checkbox" id="checkUncheckAll" checked></th>
                                                                <th>SR No</th>
                                                                <th> Name </th>
                                                                <th> Email </th>
                                                                <th> Email Send</th>
                                                                <th> Business Signup </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach ($directoryList as $key => $dir)
                                                                <tr>
                                                                    <td>
                                                                        @if ($dir->email == 'NA')
                                                                            <input class="tap-to-delete" type="checkbox"
                                                                                value="{{ $dir->id }}" name="directory_id[]">
                                                                        @elseif ($dir->email == '')
                                                                            <input class="tap-to-delete" type="checkbox"
                                                                                value="{{ $dir->id }}" name="directory_id[]">
                                                                        @else
                                                                            <input class="tap-to-delete" type="checkbox"
                                                                                value="{{ $dir->id }}" name="directory_id[]"
                                                                                checked>
                                                                        @endif
        
                                                                        <input class="tap-to-delete" type="hidden"
                                                                            value="{{ $dir->email }}" name="email[]">
                                                                        <input class="tap-to-delete" type="hidden"
                                                                            value="{{ $dir->slug }}" name="slug[]">
                                                                    </td>
                                                                    <td>{{ $key + 1 }}</td>
                                                                    <td>{{ $dir->name }}</td>
                                                                    <td>{{ $dir->email }}</td>
                                                                    <td>
        
                                                                        <i
                                                                            class="{{ $dir->business_mail_sent == 1 ? 'fa fa-check-circle text-success' : 'fa fa-times-circle text-danger' }}"></i>
                                                                    </td>
                                                                    <td>
                                                                        <i
                                                                            class="{{ $dir->mail_redirect_update == 1 ? 'fa fa-check-circle text-success' : 'fa fa-times-circle text-danger' }}"></i>
                                                                    </td>
        
        
        
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-12 mb-3">
                                    <div class="tile-body">
                                        <div class="form-group">
                                            <label class="control-label" for="body">Body</label>
                                            <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="summernote" cols="30" rows="10">{{ old('body') ? old('body') : $category->parent_category_email_template }}</textarea>
                                            @error('body') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                                        </div>
                                    </div>
                                </div> --}}

                                <div class="send-mail">
                                    <div class="row">
                                        <div class="col-12 mb-3">
                                            <div class="tile-body">
                                                <div class="form-group">
                                                    <label class="control-label" for="subject">Subject</label>
                                                    <input class="form-control @error('subject') is-invalid @enderror" name="subject"
                                                        id="summernote-long" value="Welcome to LocalTales">
                                                    @error('subject')
                                                        <p class="text-danger">{{ $message ?? '' }}</p>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="tile-footer">
                                                <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Send Email</button>

                                                <a class="btn btn-secondary" href="{{ route('admin.dircategory.index') }}"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancel
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#checkUncheckAll').click(function() {
                if ($(this).prop("checked") == true) {
                    $('.tap-to-delete').attr('checked', 'checked');
                } else if ($(this).prop("checked") == false) {
                    $('.tap-to-delete').removeAttr('checked');
                }
            });
        });
    </script>
@endpush

