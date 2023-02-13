@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection

@section('content')
    <div class="app-title">
        <div class="row w-100">
            <div class="col-md-6">
                <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            </div>
        </div>
    </div>

    @include('admin.partials.flash')

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    @if (isset($data))
                        <table class="table table-hover custom-data-table-style table-striped">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th style="width:100px; min-width:100px;" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($directory as $key => $blog)
                                    <tr>
                                        <td>
                                            @if ($blog->image == 'placeholder-image.png')
                                                <img style="width: 100px;height: 100px;"
                                                    src="{{ URL::to('/') . '/Directory/' }}{{ $blog->image }}">
                                            @else
                                                <img style="width: 100px;height: 100px;" src="{{ $blog->image }}">
                                            @endif
                            <!--                @if($blog->image)<img style="width: 100px;height: 100px;" src="https://maps.googleapis.com/maps/api/streetview?size=640x640&location={{$blog->latitude}},{{$blog->longitude}}&fov=120&heading=0&key=AIzaSyDPuZ9AcP4PHUBgbUsT6PdCRUUkyczJ66I">-->
                            <!--@else-->
                            <!--<img style="width: 100px;height: 100px;" src="{{asset('Directory/placeholder-image.png')}}" class="card-img-top" alt="">-->
                            <!--  @endif-->
                                        </td>
                                        <td>{{ $blog->name }}</td>
                                        <td>{{ $blog->email }}</td>
                                        <td>{{ $blog->mobile }}</td>
                                        <td>{{ $blog->address }}</td>
                                        <td class="text-center">
                                            <div class="toggle-button-cover margin-auto">
                                                <div class="button-cover">
                                                    <div class="button-togglr b2" id="button-11">
                                                        <input id="toggle-block" type="checkbox" name="status"
                                                            class="checkbox" data-id="{{ $blog['id'] }}"
                                                            {{ $blog['status'] == 1 ? 'checked' : '' }}>
                                                        <div class="knobs"><span>Inactive</span></div>
                                                        <div class="layer"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center"></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {!! $data->render() !!}
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPuZ9AcP4PHUBgbUsT6PdCRUUkyczJ66I&libraries=places"></script> --}}

    <script>
        // $.ajaxSetup({
        //     headers: {
        //         'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        //     }
        // });

        @foreach ($directory as $data)
            $.ajax({
                // url: 'https://maps.googleapis.com/maps/api/place/textsearch/json?query={{ $data->name }}&key=AIzaSyDPuZ9AcP4PHUBgbUsT6PdCRUUkyczJ66I',
                url: 'http://demo91.co.in/localtales-prelaunch/public/admin/directory/test',
                type: 'GET',
                data: {
                    'query': '{{ $data->name }}',
                    'phone': '{{ $data->mobile }}',
                    'id': '{{ $data->id }}',
                    'add': '{{ $data->address }}'
                },
                success: function(result) {
                    // const res = JSON.parse(result);
                    console.log(result);
                    // if (res.status == 'OK') {
                    //     console.log(res.results[0].rating);
                    // } else {
                    //     console.log("No Rating!");
                    // }
                    // console.log(result);

                    // $.ajax({
                    //     url: '{{ route('admin.directory.data.fix.rating') }}',
                    //     type: 'POST',
                    //     data:
                    // });
                }
            });
        @endforeach
    </script>
@endpush
