@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <div class="app-title">
        <div>
            <h1> {{ $collection->title }}</h1>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="tile">
                <h3 class="tile-title">Directory List
                   
                </h3>
                <hr>
                <form action="{{ route('admin.collection.directory-save') }}" method="POST" role="form"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="collection_id" value="{{$collection->id}}">
                     <div class="tile">
                <div class="tile-body">
                    <table class="table table-hover custom-data-table-style table-striped">
                        <thead>
                            <tr>
                                <th></th>
                                <th>SR No</th>
                                <th> Name </th>
                                <th> Address </th>
                                <th> Category </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($directory as $key => $blog)
                                <tr>
                                <td>
                                <input  class="tap-to-delete" type="checkbox"  value="{{$blog->id}}" name="directory_id[]" checked>
                                 </td>
                                    <td>{{ $key+1 }}</td>
                                    <td>{{ $blog->name }}</td>
                                    <td>
                                    {{ $blog->address }}</td>
                                    <td>{{$blog->category_tree ? $blog->category_tree : '' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
                    <div class="tile-footer">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Save
                            Directory</button>
                        &nbsp;&nbsp;&nbsp;
                        <a class="btn btn-secondary" href="{{ route('admin.collection.index') }}"><i
                                class="fa fa-fw fa-lg fa-times-circle"></i>Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection


