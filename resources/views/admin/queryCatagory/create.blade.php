@extends('admin.app')

@section('title')
    {{ 'Create New Catagory' }}
@endsection

@section('content')
    <div class="app-title">

        <div>

            <h1><i class="fa fa-tags"></i> {{ 'Create New Catagory' }}</h1>

        </div>

    </div>

    @include('admin.partials.flash')

    <div class="row">

        <div class="col-md-8 mx-auto">

            <div class="tile">

                <h3 class="tile-title">{{ 'Create New Catagory' }}

                    <span class="top-form-btn">



                        <a class="btn btn-secondary" href="{{ route('admin.query.catagory.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>

                    </span>

                </h3>

                <hr>

                <form action="" method="POST">

                    @csrf

                    <div class="tile-body">

                        <div class="form-group">

                            <label class="control-label" for="name">Query Catagory Name: (Create many catagory using
                                ',')<span class="m-l-5 text-danger">

                                    *</span></label>

                            <input class="form-control @error('name') is-invalid @enderror" type="text" name="name"
                                id="name" value="{{ old('name') }}" />

                            @error('name')
                                <p class="small text-danger">{{ $message }}</p>
                            @enderror

                        </div>

                    </div>

                    <div class="tile-footer">

                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save

                            Catagory</button>

                        &nbsp;&nbsp;&nbsp;

                        <a class="btn btn-secondary" href="{{ route('admin.query.catagory.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>

                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
