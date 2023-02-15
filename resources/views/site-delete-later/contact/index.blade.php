@extends('site.app')
@section('title') {{ $pageTitle }} @endsection
@section('content')
    <!-- ========== Inner Banner ========== -->
    @foreach($content as  $key => $blog)
    @php
$demoImage = DB::table('demo_images')->where('title', '=', 'contact')->get();
$demo = $demoImage[0]->image;
@endphp
<section class="inner_banner"
@if($content[0]->image)
            style="background: url({{URL::to('/').'/ContactusBanner/' .$content[0]->banner_image}})"
        @else
style="background: url({{URL::to('/').'/Demo/' .$demo}})"
@endif
                    >
                    <div class="container position-relative">

                        <h1 class="mb-4">Contact Us</h1>
                </div>
    </section>
  @endforeach
    <!-- ========== Contact ========== -->
    @foreach($content as  $key => $blog)
    <section class="py-4 py-lg-5 contact-sec">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 contact-text">
                    <div class="addresses d-flex flex-column align-items-center justify-content-center">
                        <img src="{{ asset('front/img/footer-logo.png')}}" height="50">
                        <ul class="contact-info mt-5">
                            {{--  <li>
                                <i class="fa fa-map-marker-alt"></i>
                                <p>
                                   {!! $blog->content1  !!}
                                </p>
                            </li>
                            <li class="mb-0">

                                <p>

                                    @php
                                    $cat = $blog->content;

                                    $displayCategoryName = '';
                                    foreach(explode(',', $cat) as $catKey => $catVal) {

                                        $catDetails = DB::table('settings')->where('id', $catVal)->first();
                                         if($catDetails !=''){
                                        //$displayCategoryName .= ''.$catVal.''.' ';
                                        $displayCategoryName .= ''.'<span class="d-block mb-3"><i class="fa fa-phone-alt"></i>'.$catVal.'</span>';
                                        }
                                    }
                                    echo $displayCategoryName;
                                @endphp

                                </p>
                            </li>--}}

                            <li>
                                <i class="fa fa-paper-plane"></i>
                                <p>
                                    {!! $blog->content2  !!}
                                </p>
                            </li>
                        </ul>
                        @php
                                // social link
                                $linkExists = Schema::hasTable('settings');
                                if ($linkExists) {
                                    $facebook = DB::table('settings')->where('key','=','social_facebook')->get();
                                    $facebookLink= strip_tags(preg_replace('/\s+/', '', $facebook[0]->content));
                                    $twitter = DB::table('settings')->where('key','=','social_twitter')->get();
                                    $twitterLink= strip_tags(preg_replace('/\s+/', '', $twitter[0]->content));
                                    $instagram = DB::table('settings')->where('key','=','social_instagram')->get();
                                    $instagramLink= strip_tags(preg_replace('/\s+/', '', $instagram[0]->content));
                                    $linkedin = DB::table('settings')->where('key','=','social_linkedin')->get();
                                    $linkedinLink= strip_tags(preg_replace('/\s+/', '', $linkedin[0]->content));

                                }
                            @endphp
                        <ul class="social-icons d-flex mt-4">
                            <li>
                                <a href="{{url($facebookLink)}}" target="_blank" class="mb-0"><i class="fab fa-facebook-f"></i></a>
                            </li>
                            <li>
                                <a href="{{url($twitterLink)}}" target="_blank" class="mb-0"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li class="align-items-center">
                                <a href="{{url($linkedinLink)}}" target="_blank" class="mb-0 d-flex"><i class="fab fa-linkedin-in"></i></a>
                            </li>
                            <li class="align-items-center">
                                <a href="{{url($instagramLink) }}" target="_blank" class="mb-0 d-flex"><i class="fab fa-instagram"></i></a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="form-sec border-0 shadow card p-4">
                        <h5>Let's Get In Touch With Us</h5>
                        <form action="{{ route('contactForm.store') }}" method="POST" role="form" enctype="multipart/form-data">@csrf
                            <div class="form-group">
                                <input type="text" class="form-control" name="name" placeholder="Name..." value="{{ old('name') }}">
                                @error('name') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                            </div>
                            <div class="form-group">
                                <input type="email" class="form-control" name="email" placeholder="Email..." value="{{ old('email') }}">
                                @error('email') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                            </div>
                            <div class="form-group">
                                <input type="number" class="form-control" name="mobile" placeholder="Phone no..." value="{{ old('mobile') }}">
                                @error('mobile') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="4" name="description" placeholder="What's inyour mind!">{{ old('description') }}</textarea>
                                @error('description') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                            </div>
                            <button type="submit" class="w-100 btn main-btn">Submit Now</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @endforeach

    <!-- ========== Inner Banner ========== -->
  @endsection
