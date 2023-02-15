@extends('site.app')

@section('title'){{seoManagement('homepage')->title}}@endsection
@section('description'){{seoManagement('homepage')->meta_desc}}@endsection

@section('content')
<div class="banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-xl-8">
                @foreach($data as  $key => $blog)
                <h4>Welcome to</h4>
                <h1>Local Tales</h1>
                <h3 class="mb-4">Propel your Local Business to Your Community</h3>

                <div class="banner_counter">
                    <div class="banner_counter_item">
                        <h3>{{ number_format($postcode)}}</h3>
                        <h5>Postcode</h5>
                    </div>
                    <div class="banner_counter_item">
                        <h3>{{number_format($directory)}}</h3>
                        <h5>Directory</h5>
                    </div>
                    <div class="banner_counter_item">
                        <h3>{{number_format($collection)}}</h3>
                        <h5>Collections</h5>
                    </div>
                </div>
                <form action="" method="get" class="banner_form">
                    @csrf
                    <div class="row">
                        <div class="col-5 col-sm-4 pr-sm-0">
                            <div class="banner-form-group">
                                <input type="text" name="name" id="inputSearchTextFilter" class="form-control" placeholder="Your Business Name">
                                <label>Your Business Name</label>
                            </div>
                        </div>
                        <div class="col-5 col-sm-4 pr-sm-0">
                            <div class="banner-form-group">
                                <input type="email" name="email" class="form-control" placeholder="Email">
                                <label>Email</label>
                            </div>
                        </div>
                        <div class="col-2 col-sm-4">
                            <input type="hidden" name="website" value="">
                            <input type="hidden" name="email" value="">
                            <input type="hidden" name="address" value="">
                            <input type="hidden" name="mobile" value="">
                            <button type="submit" class="btn main-btn"><span>Join Us</span> <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg></button>
                        </div>
                    </div>
                </form>
                @endforeach
            </div>
        </div>
    </div>
</div>

<section class="play-section">
    <div class="container">
        <div class="row align-items-center">
            @foreach($data as $key => $blog)
            <div class="col-lg-6 mb-4">
                <figure>
                    @if($blog->image!='')
                        <div class="video-container" id="video-container">
                            <div class="playback-animation" id="playback-animation">
                                <svg class="playback-icons">
                                <use class="hidden" href="#play-icon"></use>
                                <use href="#pause"></use>
                                </svg>
                            </div>

                            <video controls class="video" id="video" preload="metadata" poster="{{ asset('front/img/Local-Tales.jpg') }}">
                                <source src="{{URL::to('/').'/Extra/'}}{{$blog->image}}" type="video/mp4">
                            </video>

                            <div class="video-controls hidden" id="video-controls">
                                <div class="video-progress">
                                <progress id="progress-bar" value="0" min="0"></progress>
                                <input class="seek" id="seek" value="0" min="0" type="range" step="1">
                                <div class="seek-tooltip" id="seek-tooltip">00:00</div>
                                </div>

                                <div class="bottom-controls">
                                <div class="left-controls">
                                    <button data-title="Play (k)" id="play">
                                    <svg class="playback-icons">
                                        <use href="#play-icon"></use>
                                        <use class="hidden" href="#pause"></use>
                                    </svg>
                                    </button>

                                    <div class="volume-controls">
                                    <button data-title="Mute (m)" class="volume-button" id="volume-button">
                                        <svg>
                                        <use class="hidden" href="#volume-mute"></use>
                                        <use class="hidden" href="#volume-low"></use>
                                        <use href="#volume-high"></use>
                                        </svg>
                                    </button>

                                    <input class="volume" id="volume" value="1"
                                    data-mute="0.5" type="range" max="1" min="0" step="0.01">
                                    </div>

                                    <div class="time">
                                    <time id="time-elapsed">00:00</time>
                                    <span> / </span>
                                    <time id="duration">00:00</time>
                                    </div>
                                </div>

                                <div class="right-controls">
                                    <button data-title="PIP (p)" class="pip-button" id="pip-button">
                                    <svg>
                                        <use href="#pip"></use>
                                    </svg>
                                    </button>
                                    <button data-title="Full screen (f)" class="fullscreen-button" id="fullscreen-button">
                                    <svg>
                                        <use href="#fullscreen"></use>
                                        <use href="#fullscreen-exit" class="hidden"></use>
                                    </svg>
                                    </button>
                                </div>
                                </div>
                            </div>
                        </div>

                        <svg style="display: none">
                            <defs>
                            <symbol id="pause" viewBox="0 0 24 24">
                                <path d="M14.016 5.016h3.984v13.969h-3.984v-13.969zM6 18.984v-13.969h3.984v13.969h-3.984z"></path>
                            </symbol>

                            <symbol id="play-icon" viewBox="0 0 24 24">
                                <path d="M8.016 5.016l10.969 6.984-10.969 6.984v-13.969z"></path>
                            </symbol>

                            <symbol id="volume-high" viewBox="0 0 24 24">
                            <path d="M14.016 3.234q3.047 0.656 5.016 3.117t1.969 5.648-1.969 5.648-5.016 3.117v-2.063q2.203-0.656 3.586-2.484t1.383-4.219-1.383-4.219-3.586-2.484v-2.063zM16.5 12q0 2.813-2.484 4.031v-8.063q1.031 0.516 1.758 1.688t0.727 2.344zM3 9h3.984l5.016-5.016v16.031l-5.016-5.016h-3.984v-6z"></path>
                            </symbol>

                            <symbol id="volume-low" viewBox="0 0 24 24">
                            <path d="M5.016 9h3.984l5.016-5.016v16.031l-5.016-5.016h-3.984v-6zM18.516 12q0 2.766-2.531 4.031v-8.063q1.031 0.516 1.781 1.711t0.75 2.32z"></path>
                            </symbol>

                            <symbol id="volume-mute" viewBox="0 0 24 24">
                            <path d="M12 3.984v4.219l-2.109-2.109zM4.266 3l16.734 16.734-1.266 1.266-2.063-2.063q-1.547 1.313-3.656 1.828v-2.063q1.172-0.328 2.25-1.172l-4.266-4.266v6.75l-5.016-5.016h-3.984v-6h4.734l-4.734-4.734zM18.984 12q0-2.391-1.383-4.219t-3.586-2.484v-2.063q3.047 0.656 5.016 3.117t1.969 5.648q0 2.203-1.031 4.172l-1.5-1.547q0.516-1.266 0.516-2.625zM16.5 12q0 0.422-0.047 0.609l-2.438-2.438v-2.203q1.031 0.516 1.758 1.688t0.727 2.344z"></path>
                            </symbol>

                            <symbol id="fullscreen" viewBox="0 0 24 24">
                            <path d="M14.016 5.016h4.969v4.969h-1.969v-3h-3v-1.969zM17.016 17.016v-3h1.969v4.969h-4.969v-1.969h3zM5.016 9.984v-4.969h4.969v1.969h-3v3h-1.969zM6.984 14.016v3h3v1.969h-4.969v-4.969h1.969z"></path>
                            </symbol>

                            <symbol id="fullscreen-exit" viewBox="0 0 24 24">
                            <path d="M15.984 8.016h3v1.969h-4.969v-4.969h1.969v3zM14.016 18.984v-4.969h4.969v1.969h-3v3h-1.969zM8.016 8.016v-3h1.969v4.969h-4.969v-1.969h3zM5.016 15.984v-1.969h4.969v4.969h-1.969v-3h-3z"></path>
                            </symbol>

                            <symbol id="pip" viewBox="0 0 24 24">
                            <path d="M21 19.031v-14.063h-18v14.063h18zM23.016 18.984q0 0.797-0.609 1.406t-1.406 0.609h-18q-0.797 0-1.406-0.609t-0.609-1.406v-14.016q0-0.797 0.609-1.383t1.406-0.586h18q0.797 0 1.406 0.586t0.609 1.383v14.016zM18.984 11.016v6h-7.969v-6h7.969z"></path>
                            </symbol>
                            </defs>
                        </svg>
                    @endif
                </figure>
            </div>
            <div class="col-lg-5 offset-lg-1 page-title">
                {!! $blog->content1 !!}
                <a href="{{url('/')}}/postcode" class="btn main-btn">Postcode</a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="available-section">
        <div class="container">
            <div class="row align-items-center">
                @foreach($data as  $key => $blog)
                <div class="col-7 col-lg-5 page-title order-2 order-lg-1">
                    <span class="app-tag">Available for all platforms.</span>

                    {!! $blog->content2 !!}

                    <a href="javascript:void(0)" class="mt-3" style="font-size:30px;color:#ff6355;">
                        <span>Coming Soon</span>
                        {{-- <img src="{{  asset('front/img/play_store.png') }}" alt=""> --}}
                    </a>
                </div>
                <div class="col-5 p-0 col-lg-7 mb-0 mb-sm-4 mb-lg-0 order-1 order-lg-2">
                    @if($blog->image2!='')
                    <img class="w-100"  src="{{URL::to('/').'/Splash/'}}{{$blog->image2}}">
                @endif
                </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script src="https://maps.googleapis.com/maps/api/js?key=&libraries=places"></script>

    <script>
        google.maps.event.addDomListener(window,'load',initialize);
        function initialize(){
            var autocomplete= new google.maps.places.Autocomplete(document.getElementById('inputSearchTextFilter'));
            autocomplete.setComponentRestrictions({'country': ['au']});
            google.maps.event.addListener(autocomplete, 'place_changed', function(){
                var places = autocomplete.getPlace();
                console.log(places);
                addressObj = places.address_components;
                addressObjLength = places.address_components.length;
                for (let index = 0; index < addressObjLength; index++) {
                    if(index = addressObjLength-1) {
                        var pinCode = addressObj[index].long_name;
                        console.log(pinCode);
                        $("#pin").val(pinCode)
                    }
                }
                $('#inputSearchTextFilter').val(places.name);
                $('#website').val(places.website);
                $('#email').val(places.email);
                $('#address').val(places.formatted_address);

                if(places.formatted_phone_number){
                    function phpneNumberFormatted(phNum){
                        var i,newValue='';
                        for(i = 0; i < phNum.length; i++){
                            if($.isNumeric(phNum[i])){
                                newValue+=phNum[i];
                            }
                        }
                        return newValue;
                    }
                    var phNum = phpneNumberFormatted(places.formatted_phone_number);

                    $('#mobile').val(phNum);
                } else {
                    $('#mobile').val('');
                }

                $('#selectedLongitude').val(places.geometry.location.lng());
                $('#selectedLatitude').val(places.geometry.location.lat());

                window.location = "{{URL::to('/')}}/business-signup?name="+places.name+"&website="+places.website+"&email="+places.email+"&address="+places.formatted_address+"&mobile="+phNum+"&pin="+pinCode;
            });
        }

        function getLocation() {
            if (navigator.geolocation) {
                const geolocation = navigator.geolocation.getCurrentPosition(showLOcation);
            } else {
                console.log("failed");
            }
        }

        getLocation()

        function showLOcation(position) {
            console.log("position", position);
            if (position.coords?.latitude && position.coords?.longitude) {
                $.ajax({
                   url: `https://maps.googleapis.com/maps/api/geocode/json?latlng=${position.coords?.latitude},${position.coords?.longitude}&key=AIzaSyDegpPMIh4JJgSPtZwE6cfTjXSQiSYOdc4`,
                   //  url: `https://maps.googleapis.com/maps/api/geocode/json?latlng=-33.878844,151.210072&key=AIzaSyDegpPMIh4JJgSPtZwE6cfTjXSQiSYOdc4`,
                    method: 'get',
                    data: {},
                    success: function(result) {
                        console.log("location", result);
                        let address = result?.results[0]?.address_components;
                        console.log("address", address);
                        const postcode = address.filter(e => e.types.includes("postal_code"))
                        console.log("postcode", postcode);
                        localStorage.setItem("postcode", postcode[0].long_name)
                        document.cookie = 'postcode=' + postcode[0].long_name;
                        console.log(localStorage.getItem("postcode")+"here");


                    }
                })
            }
        }
    </script>
@endpush

