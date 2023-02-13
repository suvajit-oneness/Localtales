@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection

@section('content')
    <div class="app-title">
        <div class="row w-100">
            <div class="col-md-12">
                <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            </div>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.job.scrap.store') }}" method="post">@csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <select name="source" id="source" class="form-control" required>
                                        <option value="seek" selected>Seek</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <input type="text" name="location" id="location" placeholder="Eltham VIC 3095" class="form-control" autofocus required>
                                    <p class="small text-muted mb-3">Suburb State Postcode</p>
                                </div>
                            </div>

                            <div class="col-md-6 col-md-offset-6">
                                <button type="submit" name="submit" class="btn btn-primary">Get Jobs</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>

    </script>
@endpush