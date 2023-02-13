@extends('admin.app')
@section('title') {{ $pageTitle }} @endsection
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
                            <td>Created By</td>
                            <td>{{ empty($loop->user['name'])? null:$loop->user['name'] }}</td>
                        </tr>
                        <tr>
                            <td>Content</td>
                            <td>{{ empty($loop['content'])? null:$loop['content'] }}</td>
                        </tr>
                        <tr>
                            <td>Created At</td>
                            <td>{{ empty($loop['created_at'])? null:$loop['created_at'] }}</td>
                        </tr>
                        <tr>
                            <td>No of Likes</td>
                            <td>{{ empty($loop['no_of_likes'])? null:$loop['no_of_likes'] }}</td>
                        </tr>
                        <tr>
                            <td>No of Dislikes</td>
                            <td>{{ empty($loop['no_of_dislikes'])? null:($loop['no_of_dislikes']) }}</td>
                        </tr>
                        <tr>
                            <td>No of comments</td>
                            <td>{{ empty($loop['no_of_comments'])? null:($loop['no_of_comments']) }}</td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tile">
                <div class="tile-body">
                    <p>Comment List</p>
                    <table class="table table-hover custom-data-table-style table-striped" id="sampleTable">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th> User </th>
                                <th> Comment </th>
                                <th> Created At </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($loop->comments as $key => $comment)
                                <tr>
                                    <td>{{ $comment->id }}</td>
                                    <td>{{ $comment->user->name }}</td>
                                    <td>{{$comment->comment}}</td>
                                    <td>{{ date("d-M-Y",strtotime($comment->created_at)) }}</td>
                                    
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection