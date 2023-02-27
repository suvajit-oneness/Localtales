<!-- ========== Subscribe ========== -->
<section class="py-4 subscribe">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h6>Our newsletter is coming soon</h6>
                <p class="mb-0">Register for future updates</p>
            </div>
            <div class="col-md-6">
                <form action="{{ route('emailSubscription.store') }}" method="POST" role="form" enctype="multipart/form-data">@csrf
                    <div class="form-group position-relative m-0">
                        <input type="email" name="email" class="form-control" placeholder="Enter your email">
                        @error('email') <p class="text-danger">{{ $message ?? '' }}</p> @enderror
                        <button type="submit" class="subscribe-btn">
                            <i class="fa fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<footer class="footerinner">
    <div class="container">
        <div class="row m-0 justify-content-between">
            <div class="col-12 col-lg-4 mb-4 mb-lg-0">
                <div class="f-menu">
                    <img src="{{ asset('front/img/footer-logo.png')}}" alt="Local Tales" width="180px" height="36px" class="mb-3">
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
                    <ul class="social-icons d-flex mt-0 mb-4">
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
                    <p>At LocalTales, we’re on a mission to empower community members.
                    We want locals to be better-informed about their neighbourhood.
                    We want to create a one-stop shop for locals to go and find everything they need to know about their local area. </p>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-lg-3">
                <div class="f-menu">
                    <h6>Menu</h6>
                    <ul class="f-menu p-0">
                        <li><a href="{!! URL::to('/') !!}">Home</a></li>
                        <li><a href="{!! URL::to('postcode') !!}">Postcode</a></li>
                        <li><a href="{!! URL::to('suburb') !!}">Suburb</a></li>
                        <li><a href="{!! URL::to('directory') !!}">Directory</a></li>
                        <li><a href="{!! URL::to('collection') !!}">Collection</a></li>
                        <li><a href="{!! URL::to('category') !!}">Category</a></li>
                        <li><a href="{!! URL::to('article') !!}">Article</a></li>
                        {{-- <li><a href="{!! URL::to('event') !!}">Events</a></li> --}}
                    </ul>
                </div>
            </div>
            <div class="col-6 col-sm-6 col-lg-3">
                <div class="f-menu">
                    <h6>Other</h6>
                    <ul class="f-menu p-0">
                        <li><a href="{!! URL::to('terms') !!}">Terms</a></li>
                        <li><a href="{!! URL::to('privacy') !!}">Privacy</a></li>
                        <li><a href="{!! URL::to('about-us') !!}">About Us</a></li>
                        <li><a href="{!! URL::to('contact-us') !!}">Contact Us</a></li>
                        <li><a href="{!! URL::to('help') !!}">Help</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center copy_sec">
        <p class="mt-2"><small>Copyrights © 2022 All Rights Reserved by LocalTales</small></p>
    </div>
</footer>