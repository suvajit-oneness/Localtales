@extends('site.app')
@section('title') {{ $pageTitle }} @endsection

@section('content')
    {{-- BLOG SEARCH --}}


    {{-- BLOG SEARCH RESULT --}}

    {{-- CATEGORY WISE BLOGS --}}

    {{-- <section class="py-4 py-lg-5 bg-light">
        <div class="container">
            <div class="row m-0 mb-4 mb-lg-5 justify-content-between best_deal">


            </div>
            <div class="row m-0">
                <div class="col-md-12">
                    <div class="swiper Bestdeals">
                        <div class="swiper-wrapper">
                        @foreach($categories  as $key => $blogProductValue)
                            <div class="swiper-slide">
                                <div class="card border-0">
                                    <div class="bst_dimg">
                                        <img src="{{URL::to('/').'/Directory/'}}{{$blogProductValue->image}}" class="card-img-top" alt="ltItem">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title m-0"> <a href="{!! URL::to('directory-details/'.$blogProductValue->id.'/'.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $blogProductValue->name))) !!}" class="location_btn">{{ $blogProductValue->name }}</h5></a>
                                        <p>{!! $blogProductValue->description !!}</p>

                                        {{-- <a href="#">Read More...</a> --}}
                                        {{-- <a href="{!! URL::to('blog-details/'.$blogProductValue->id.'/'.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $blogProductValue->title))) !!}" class="location_btn">Read More <img src="{{asset('site/images/right-arrow.png')}}"></a> --}}
                                    {{-- </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}


    <section class="py-4 py-lg-5 bg-light">
        <div class="container">
            <div class="row m-0 mb-4 mb-lg-5 justify-content-between best_deal">
          <h4>Directory List</h4>

            </div>
            <div class="row m-0">
                <div class="col-md-12">
                    <div class="swiper Bestdeals">
                        <div class="swiper-wrapper">
                        @foreach($categories as $key => $directory)
                        <div class="swiper-slide">
                                <div class="card border-0">
                                    <div class="bst_dimg">
                                        <img src="{{URL::to('/').'/Directory/'}}{{$directory->directory->image}}" class="card-img-top" alt="">
                                    </div>
                                    <div class="card-body">
                                        <h5 class="card-title m-0"><a href="{!! URL::to('directory-details/'.$directory->directory->id.'/'.strtolower(preg_replace("/[^a-zA-Z0-9]+/", "-", $directory->directory->name))) !!}" class="location_btn">{{ $directory->directory->name }}</a></h5>
                                        <p>{!! $directory->directory->address !!}</p>

                                        {{-- <a href="#">Read More...</a> --}}

                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </div>
                        <div class="swiper-button-next"></div>
                        <div class="swiper-button-prev"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
<script type="text/javascript">
	@php
	$locations = array();
	foreach($categories as $deal){
		$data = array($deal->title,floatval($deal->lat),floatval($deal->lon));
		array_push($locations,$data);
	}
	@endphp

    // $(document).ready(function(){
    // 	$('#btnFilter').on("click",function(){
    // 		$('#checskout-form').submit();
    // 	})
    // });

    $(document).on("click", "#btnFilter", function() {
        $('#checkout-form').submit();
    });
</script>
@endpush
