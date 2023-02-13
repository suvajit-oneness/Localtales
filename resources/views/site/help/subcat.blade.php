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
       <div class="page-search-block filterSearchBoxWraper">
            <form action="" id="checkout-form">
                <div class="filterSearchBox">
                    <div class="row">
                        <div class="col-10 col-md fcontrol position-relative">
                            <div class="form-floating">
                                 <input type="search" name="term" id="term" class="form-control" placeholder="Search here.." value="{{app('request')->input('term')}}" autocomplete="off">
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
        </div>
    </div>
</section>

<section class="help_details">
    <div class="container">
    <ul class="breadcumb_list mb-2 mb-sm-4">
                        <li><a href="{!! URL::to('help') !!}">Localtales Help</a></li>
                        <li>/</li>
                        <li class="active"><a href=""> {{$categories[0]->title}}</a></li>
                    </ul>
        <div class="row">
            <div class="col-12 col-lg-9 col-md-9 help_right">

                <h1>
                   {{$categories[0]->title ?? ''}}
                    <span> {{$categories[0]->description ?? ''}}</span>
                </h1>
                 <ul class="left_navdet text-center">
                @foreach($subcategories as $key => $category)

                <li><a  href="{!! URL::to('help/article/'.$category->slug) !!}"><span> {{$category->title}}</span></a></li>
                @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
	<script type="text/javascript">
        $(document).on("click", "#btnFilter", function() {
            $('#checkout-form').submit();
        });
    </script>
@endpush
