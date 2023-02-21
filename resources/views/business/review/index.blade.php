@extends('business.app')
@section('title') Review @endsection

@section('content')
    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> Review</h1>
            <p>List of all reviews</p>
        </div>
    </div>

    @include('business.partials.flash')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        @forelse ($review as $data)
                            <div class="col-6 col-md-3 mb-2 mb-sm-4 mb-lg-3">
                                <div class="card directory-single-review">
                                    <div class="card-body">
                                        <h5>{{ $data->author_name }}</h5>

                                        <div class="rating">
                                            @php
                                                $rating = number_format($data->rating,1);
                                                for ($i = 1; $i < 6; $i++) {
                                                    if ($rating >= $i) {
                                                        echo '<i class="fas fa-star"></i>';
                                                    } elseif (($rating < $i) && ($rating > $i-1)) {
                                                        echo '<i class="fas fa-star-half-alt"></i>';
                                                    } else {
                                                        echo '<i class="far fa-star"></i>';
                                                    }
                                                }
                                            @endphp
                                        </div>
                                        @if(!empty($data->time))
                                        <p>{{date('d/m/Y', $data->time) }}</p>
                                        @else
                                        <p>{{date('d/m/Y', strtotime($data->created_at)) }}</p>
                                        @endif
                                        <div class="desc">
                                            @if(strlen($data->text) > 200)
                                                <p>{{ substr($data->text,0,200) }}... <small class="text-underline text-primary showMore" style="cursor: pointer">Read more</small></p>

                                                <p style="display: none">{{$data->text}}<small class="text-underline text-primary showLess" style="cursor: pointer">Read less</small></p>
                                            @else
                                                <p>{{$data->text}}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-center text-muted">No reviews yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div><br>
@endsection

@push('scripts')
    <script>
        $('.showMore').click(function(){
            $(this).parent().hide();
            $(this).parent().next().show();
        })    
        $('.showLess').click(function(){
            $(this).parent().hide();
            $(this).parent().prev().show();
        })    
    </script>
@endpush