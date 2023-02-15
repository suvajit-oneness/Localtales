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

        <h1 class="mb-4">Help</h1>
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

<section class="help_body">
    <div class="container">
        <div class="row mb-4">
        <a type="button" class="btn btn-login ml-auto" href="{{ route('user.raise.query') }}">Submit a query!</a>
        </div>
        <div class="row">
            <ul class="help_list">
                @foreach($categories as $key => $category)
                <li>
                    <a href="{!! URL::to('help/category/'.$category->slug) !!}">
                        {{ $category->title }}
                        <span>{{ $category->description }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        <div class="row">
            <div class="page-title best_deal mt-4">
                <h2>Promoted articles</h2>
            </div>
            <ul class="help_list2">
                @foreach($subcategories as $key => $subcategory)
                <li>
                    <a href="{!! URL::to('help/article/'.$subcategory->slug) !!}">
                        {{ $subcategory->title }}
                    </a>
                </li>
                @endforeach
            </ul>
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
