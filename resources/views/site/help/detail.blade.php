@extends('site.app')
@section('title') {{ $pageTitle }} @endsection

@section('content')
@php
$demoImage = DB::table('demo_images')->where('title', '=', 'help')->get();
$demo = $demoImage[0]->image;
@endphp
<section class="inner_banner"
style="background: url({{URL::to('/').'/Demo/' .$demo}})"
                    >
    <div class="container position-relative">
        <h1><span>Help Details</span></h1>
        {{-- <div class="page-search-block filterSearchBoxWraper">
            <form action="" id="checkout-form">
                <div class="filterSearchBox">
                    <div class="row">
                        <div class="col-10 col-md fcontrol position-relative">
                            <div class="form-floating">
                                <input type="search" name="keyword" class="form-control"
                                    placeholder="Search by keyword..." value="{{ request()->input('keyword') }}">
                                <label for="searchbykeyword" placeholder="Nom">Search by keyword</label>
                            </div>
                        </div>
                        <div class="col-2 col-sm-auto">
                            <a href="javascript:void(0);" id="btnFilter"
                                class="w-100 btn btn-blue filterBtnOrange text-center ml-auto"><img
                                    src="{{ asset('front/img/search.svg') }}"></a>
                        </div>
                    </div>
                </div>
            </form>
        </div> --}}
    </div>
</section>

<section class="help_details">
    <div class="container">
    <ul class="breadcumb_list mb-2 mb-sm-4">
                        <li><a href="{!! URL::to('help') !!}">Localtales Help</a></li>
                        <li>/</li>
                        <li><a href="{!! URL::to('help/category/'.$article->category->slug) !!}">{{ $article->category->title }} </a></li>
                        <li>/</li>
                        <li class="active">{{ $article->title }}</li>
                    </ul>
        <div class="row">

        <div class="row">
            <div class="col-12 col-lg-3 col-md-3 help_left">
                <div class="sticky-top">
                    <h6>Articles in this section</h6>
                    <ul class="left_navdet">
                        @foreach($relevantArticle as $key => $category)
                        <li><a href="{!! URL::to('help/article/'.$category->slug) !!}" class="active">{{$category->title ?? ''}}.</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-12 col-lg-9 col-md-9 help_right">
                <h1>
                    {{-- {{$category->subcategory->title}} --}}
                    {{-- <span>{{date('d M Y', strtotime($category->created_at))}}| Updated</span> --}}
                </h1>

                <h3>{{$article->title}}</h3>
                <p>{!! $article->description!!}</p>


                <a href="{{ route('user.raise.query') }}">Have more questions? Submit a query!</a>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
	<script>
	</script>
@endpush
