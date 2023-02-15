@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    @foreach($about as  $key => $blog)
        @php
            $demoImage = DB::table('demo_images')->where('title', '=', 'privacy')->get();
            $demo = $demoImage[0]->image;
        @endphp 
        <section class="inner_banner" style="background: url({{URL::to('/').'/Demo/' .$demo}})">
            <div class="container position-relative">
                <h1 class="mb-4">Privacy Policy</h1>
            </div>
        </section>
    @endforeach

    @foreach($privacy as  $key => $blog)
        <section class="py-4 py-lg-5">
            <div class="container">
                <div class="row mb-4 mb-lg-5">
                    <div class="col-12 privacy-policy">
                    {!! html_entity_decode($blog->content) !!}
                    </div>
                </div>
            </div>
        </section>
    @endforeach
@endsection
