@extends('admin.app')
@section('title')
    {{ $pageTitle }}
@endsection
@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> {{ $pageTitle }}</h1>
            <p>{{ $subTitle }}</p>
        </div>
    </div>
    @include('admin.partials.flash')
    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <table class="table table-hover custom-data-table-style table-striped table-col-width" id="sampleTable">
                    <tbody>
                        <tr>
                            <td> Keyword</td>
                            <td>{{ empty($collection['meta_key']) ? null : $collection['meta_key'] }}</td>
                        </tr>
                        <tr>
                            <td> Collection Name</td>
                            <td>{{ empty($collection['title']) ? null : $collection['title'] }}</td>
                        </tr>
                        <tr>
                            <td>Suburb</td>
                            <td>{{ $collection->suburb ? $collection->suburb : '' }}</td>
                        </tr>
                        <tr>
                            <td>Category</td>
                            <td>{{ $collection->category ? $collection->category : '' }}</td>
                        </tr>
                        <tr>
                            <td>Collection Description</td>
                            <td>{{ empty($collection['short_description']) ? null : $collection['short_description'] }}</td>
                        </tr>
                        <tr>
                            <td>Meta Title</td>
                            <td>{{ empty($collection['meta_title']) ? null : $collection['meta_title'] }}</td>
                        </tr>
                        <tr>
                            <td>Meta Description</td>
                            <td>{{ empty($collection['meta_description']) ? null : $collection['meta_description'] }}</td>
                        </tr>

                        <tr>
                            <td>Paragraph1 Heading</td>
                            <td>{{ empty($collection['paragraph1_heading']) ? null : $collection['paragraph1_heading'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>Paragraph</td>
                            <td>{{ empty($collection['paragraph1_heading']) ? null : $collection['paragraph1'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>Paragraph2 Heading</td>
                            <td>{{ empty($collection['paragraph2_heading']) ? null : $collection['paragraph2_heading'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>Paragraph2</td>
                            <td>{{ empty($collection['paragraph2']) ? null : $collection['paragraph2'] }}</td>
                        </tr>
                        <tr>
                            <td>Paragraph3 Heading</td>
                            <td>{{ empty($collection['paragraph3_heading']) ? null : $collection['paragraph3_heading'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>Paragraph3</td>
                            <td>{{ empty($collection['paragraph3']) ? null : $collection['paragraph3'] }}</td>
                        </tr>
                        <tr>

                            <td> Google Doc</td>
                            <td>{!! empty($collection['google_doc']) ? null : $collection['google_doc'] !!}</td>
                        </tr>
                        <td>Completion</td>
                        <td>{{ empty($collection['completion']) ? null : $collection['completion'] }}</td>
                        </tr>
                        <tr>
                            <td>Who</td>
                            <td>{{ empty($collection['who']) ? null : $collection['who'] }}</td>
                        </tr>
                        <tr>
                            <td>Quality Checked</td>
                            <td>{{ empty($collection['quality_check']) ? null : $collection['quality_check'] }}</td>
                        </tr>

                    </tbody>
                </table>
                <hr>
                @php
                    $blogs = \App\Models\CollectionDirectory::where('collection_id', $collection->id)
                        ->with('directory')
                        ->get();
                    $item = $blogs->count();
                @endphp
                <div class="app-title">
                    <div class="row w-100">
                        <div class="col-md-6">
                            <h2>List of Directories in this Collection</h2>
                            <p></p>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ route('admin.collectiondir.edit',$collection->id) }}"
                                class="btn btn-primary"><i class="fa fa-plus"></i> Edit Directories</a>

                        </div>
                    </div>
                </div>


                <table class="table table-hover custom-data-table-style table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th> Name </th>
                            <th> Email</th>
                            <th> Mobile </th>
                            <th> Address </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($blogs as $key => $blog)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $blog->directory->name }}</td>
                                <td>{{ $blog->directory->email }}</td>
                                <td>{{ $blog->directory->mobile }}</td>
                                <td>{{ $blog->directory->address }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <a class="btn btn-primary" href="{{ route('admin.collection.index') }}">Back</a>
            </div>


        </div>
    </div>
@endsection
