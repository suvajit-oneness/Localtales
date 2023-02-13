<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <title>Local Tales</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('front/css/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css?ver=5.9.3' />
        <link rel="icon" type="image/x-icon"  href="{{ asset('favicon.png') }}">

        <link rel="stylesheet" type="text/css" href="{{ asset('front/css/swiper-bundle.min.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('front/css/main.css')}}">
        <link rel="stylesheet" type="text/css" href="{{ asset('front/css/responsive.css')}}">
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDegpPMIh4JJgSPtZwE6cfTjXSQiSYOdc4&libraries=places"></script>
    </head>

    <body>

        <!-- ========== Header ========== -->
        <!-- <header class="header">
            <nav class="navbar navbar-expand-lg navbar-dark">
                <a class="navbar-brand" href="#"><img class="w-100" src="{{ asset('site/img/main-logo.png')}}" alt="Local Tales"></a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fas fa-bars"></i>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <ul class="navbar-nav m-auto">
                    <li class="nav-item active">
                      <a class="nav-link" href="#">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Local Directory</a>
                      </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Local Events</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" href="#">Local Deals</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Local Loop</a>
                      </li>
                  </ul>
                  <div class="form-inline my-2 my-lg-0">
                    <button type="button" class="btn btn-login"><img src="{{ asset('site/img/login.svg')}}"> Login</button>
                    <button type="button" class="btn btn-login btn_buseness"><img src="{{ asset('site/img/briefcase.svg')}}"> Business Login</button>
                  </div>
                </div>
            </nav>
        </header> -->

        <section class="inner_banner articles_inbanner">
            <div class="container">
                <div class="row m-0 justify-content-center">
                    <div class="col-12">
                        <h1> Registration</h1>
                    </div>
                </div>
            </div>
        </section>

        <section class="form_b_sec">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        {{-- <ul class="fb_wizard registerWizard">
                            <li class="active"><a href="javascript: void(0)">Business Contact</a></li>
                            <li><a href="javascript: void(0)">Primary Contact</a></li>
                            <li><a href="javascript: void(0)">Business Overview</a></li>
                        </ul> --}}
                    </div>
                </div>
                <div class="row justify-content-center py-4 py-lg-5">
                    <div class="col-lg-8">
                        <form action="{{ route('business.registration.store') }}" method="POST"   enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="longitude" id="selectedLongitude" value="">
                                <input type="hidden" name="latitude" id="selectedLatitude" value="">

                                <div class="div1" id="st1">
                                    <h6> Information:</h6>
                                    <div class="did-floating-label-content">
                                    <input type="text" id="council_name" name="council_name" onkeypress="return validateCouncilNumber(event)" onblur="validateInputCouncil(this.value)"  value="@php
                                        if (request()->input('council_name')) {
                                            if (request()->input('council_name') != 'undefined') {
                                                echo request()->input('council_name');
                                            }
                                        }
                                        @endphp"  class="did-floating-input" autofocus required>
                                    @error('council_name')
                                    {{ $message ?? '' }}
                                    @enderror
                                        <label class="did-floating-label">Council Name</label>
                                        <p class="small text-danger" id="businessNameErr"></p>
                                    </div>
                                    <div class="did-floating-label-content">
                                    <input class="did-floating-input @error('primary_contact') is-invalid @enderror" type="text" name="primary_contact" id="trading_name" onkeypress="return validateNumber(event)" onblur="validateInput(this.value)" value="@php
                                        if (request()->input('primary_contact')) {
                                            if (request()->input('primary_contact') != 'undefined') {
                                                echo request()->input('primary_contact');
                                            }
                                        }
                                        @endphp" >@error('primary_contact')
                                         {{ $message ?? '' }}
                                      @enderror
                                        <label class="did-floating-label">Primary Contact</label>
                                        <p class="small text-danger" id="tradingNameErr"></p>
                                    </div>
                                    <div class="did-floating-label-content">
                                    <input class="did-floating-input @error('email') is-invalid @enderror" type="text" onblur="ValidationOfBusinessEmail(this.value)" name="email" id="email" value="@php
                                                    if (request()->input('email')) {
                                                        if (request()->input('email') != 'undefined') {
                                                            echo request()->input('email');
                                                        }
                                                    }
                                                    @endphp" >
                                                    @error('email')
                                			{{ $message ?? '' }}
                            				@enderror
                                        <label class="did-floating-label"> Email</label>
                                        <p class="small text-danger" id="businessEmailErr"></p>
                                    </div>
                                    <div class="did-floating-label-content">
                                    <input class="did-floating-input @error('contact_no') is-invalid @enderror" type="text" name="contact_no" id="mobile" onblur="validatePhone(this.value)" value="@php
                                                    if (request()->input('contact_no')) {
                                                        if (request()->input('contact_no') != 'undefined') {
                                                            echo request()->input('contact_no');
                                                        }
                                                    }
                                                    @endphp" >
                                                    @error('contact_no')
                               			 {{ $message ?? '' }}
                           		             @enderror
                                        <label class="did-floating-label"> Contact Number</label>
                                        <p class="small text-danger" id="businessPhoneErr"></p>
                                    </div>
                                    <div class="d-flex justify-content-end mt-4 mb-4">
                                        <!-- <button id="pvst3" class="btn priview-btn mr-2">Preview</button> -->
                                        <button id="step2" type="submit" class="btn main-btn">Submit</button>
                                    </div>
                                </div>
                            </form>
                    </div>
                </div>
            </div>
        </section>

        <!-- <footer class="footerinner">
            <div class="container">
                <div class="row m-0 justify-content-between">
                    <div class="col-12 col-lg-4">
                        <div class="f-menu">
                            <img src="{{ asset('site/img/main-logo.png')}}" alt="Local Tales" width="180px" class="mb-3">
                            <p>
                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Laboriosam nobis id voluptatem reprehenderit, minima sit, nulla maxime a fuga, ut perferendis et.
                            </p>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="f-menu">
                            <h6>Products</h6>
                            <ul class="f-menu p-0">
                                <li><a href="">Home</a></li>
                                <li><a href="">About</a></li>
                                <li><a href="">Blog</a></li>
                                <li><a href="">Shop</a></li>
                                <li><a href="">Contacts</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="f-menu">
                            <h6>Other</h6>
                            <ul class="f-menu p-0">
                                <li><a href="">Home</a></li>
                                <li><a href="">About</a></li>
                                <li><a href="">Blog</a></li>
                                <li><a href="">Shop</a></li>
                                <li><a href="">Contacts</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center copy_sec">
                <p class="mt-2"><small>Copyrights © 2021 All Rights Reserved by XYZ</small></p>
            </div>
        </footer> -->
        <!--End_footer-->

        <script type="text/javascript" src="{{ asset('front/js/jquery-3.6.0.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('front/js/popper.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('front/js/bootstrap.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('front/js/swiper-bundle.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('front/js/custom.js')}}"></script>
        <script>

        </script>
        <script>
            $(document).ready(function(){
                $('#opening_hour').mdtimepicker(); //Initializes the time picker
                $('#closing_hour').mdtimepicker(); //Initializes the time picker
            });
            </script>

            <script>
            function display() {
               document.getElementById("council_name").style.wordSpacing = "25px";
            }
            function validateInputCouncil(val) {
                    console.log(val)
                    if (val.length <= 2) {
                        $("#businessNameErr").html('Value must be at least three letters');
                        $("#council_name").removeClass('mobile-valide');
                        $("#council_name").addClass('mobile-novalide');

                        console.log(val);
                    } else {
                        $("#businessNameErr").html('');
                        $("#council_name").addClass('mobile-valide');
                        $("#council_name").removeClass('mobile-novalide');
                    }


                }
                function validateCouncilNumber(e) {
                    console.log(e.charCode);
                    if (!(e.charCode > 65 && e.charCode < 90 ) || (e.charCode > 97 && e.charCode < 122 ) || e.charCode = 32) {
                        $("#businessNameErr").html('Value must be a letter');
                        $("#council_name").removeClass('mobile-valide');
                        $("#council_name").addClass('mobile-novalide');
                        return false
                    } else {
                        $("#businessNameErr").html('');
                        $("#council_name").addClass('mobile-valide');
                        $("#council_name").removeClass('mobile-novalide');
                    }
                }

                function validateInput(val) {
                    console.log(val)
                    if (val.length <= 2) {
                        $("#tradingNameErr").html('Value must be at least three letters');
                        $("#trading_name").removeClass('mobile-valide');
                        $("#trading_name").addClass('mobile-novalide');

                        console.log(val);
                    } else {
                        $("#tradingNameErr").html('');
                        $("#trading_name").addClass('mobile-valide');
                        $("#trading_name").removeClass('mobile-novalide');
                    }


                }
                function validateNumber(e) {
                    console.log(e.charCode);
                    if (!(e.charCode > 96 && e.charCode < 123)) {
                        $("#tradingNameErr").html('Value must be a letter');
                        $("#trading_name").removeClass('mobile-valide');
                        $("#trading_name").addClass('mobile-novalide');
                        return false
                    } else {
                        $("#tradingNameErr").html('');
                        $("#trading_name").addClass('mobile-valide');
                        $("#trading_name").removeClass('mobile-novalide');
                    }
                }

                function ValidationOfBusinessEmail(mail) {
                    console.log(mail);
                    let emailvalidation = String(mail)
                        .toLowerCase()
                        .match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)
                    if (emailvalidation === null) {
                        $("#businessEmailErr").html('You have entered an invalid email address!');
                        $("#email").removeClass('mobile-valide');
                        $("#email").addClass('mobile-novalide');
                    } else {
                        $("#businessEmailErr").html('')
                        $("#email").addClass('mobile-valide');
                        $("#email").removeClass('mobile-novalide');
                    }
                    console.log(emailvalidation);

                }

                function validatePhone(val) {
                    console.log(val);
                    if (val.length < 10) {
                        $("#businessPhoneErr").html('Value must be at least 10 digits');
                        $("#mobile").removeClass('mobile-valide');
                        $("#mobile").addClass('mobile-novalide');
                    }
                    else {
                        $("#businessPhoneErr").html('');
                        $("#mobile").addClass('mobile-valide');
                        $("#mobile").removeClass('mobile-novalide');
                    }

                }



                function validateAddress(val) {
                    console.log(val);
                    if (val.length <= 3) {
                        $("#businessAddressErr").html('Value must be at least three letters');
                        $("#address").removeClass('mobile-valide');
                        $("#address").addClass('mobile-novalide');
                    }
                 else {
                        $("#businessAddressErr").html('');
                        $("#address").addClass('mobile-valide');
                        $("#address").removeClass('mobile-novalide');
                    }

                }



                function validateWebsite(val) {
                    console.log(val);
                    if (val.length <= 3) {
                        $("#businessWebsiteErr").html('Value must be at least three letters');
                        $("#website").removeClass('mobile-valide');
                        $("#website").addClass('mobile-novalide');
                    }
                    else {
                        $("#businessWebsiteErr").html('');
                        $("#website").addClass('mobile-valide');
                        $("#website").removeClass('mobile-novalide');
                    }
                }



                function validateName(val) {
                    console.log(val);
                    if (val.length < 2) {
                        $("#NameErr").html('Value must be at least three letters');
                        $("#primary_name").removeClass('mobile-valide');
                        $("#primary_name").addClass('mobile-novalide');
                    }
                    else {
                        $("#NameErr").html('');
                        $("#primary_name").addClass('mobile-valide');
                        $("#primary_name").removeClass('mobile-novalide');
                    }
                }
                // }
                // function validateNumber(e) {
                //     console.log(e.charCode);
                //     if (!(e.charCode > 96 && e.charCode < 123)) {
                //         $("#NameErr").html('Value must be a letter');
                //     }
                //     else {
                //         $("#NameErr").html('');
                //     }
                // }


                function ValidationOfEmail(mail) {
                    console.log(mail);
                    let emailvalidation = String(mail)
                        .toLowerCase()
                        .match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)
                    if (emailvalidation === null) {
                        $("#EmailErr").html('You have entered an invalid email address!');
                        $("#primary_email").removeClass('mobile-valide');
                        $("#primary_email").addClass('mobile-novalide');
                    } else {
                        $("#EmailErr").html('')
                        $("#primary_email").addClass('mobile-valide');
                        $("#primary_email").removeClass('mobile-novalide');
                    }
                    console.log(emailvalidation);

                }


                function validatePersonPhone(val) {
                    console.log(val);
                    if (val.length < 10) {
                        $("#PhoneErr").html('Value must be at least ten digit');
                        $("#primary_phone").removeClass('mobile-valide');
                        $("#primary_phone").addClass('mobile-novalide');
                    } else {
                        $("#PhoneErr").html('')
                        $("#primary_phone").addClass('mobile-valide');
                        $("#primary_phone").removeClass('mobile-novalide');
                    }

                }



                function validateDes(val) {
                    console.log(val);
                    if (val.length < 20) {
                        $("#DescServiceErr").html('Your Description should be at least 20 characters');
                        $("#description").removeClass('mobile-valide');
                        $("#description").addClass('mobile-novalide');
                    } else {
                        $("#DescServiceErr").html('')
                        $("#description").addClass('mobile-valide');
                        $("#description").removeClass('mobile-novalide');
                    }

                }
                // function validateNumber(e) {
                //     console.log(e.charCode);
                //     if (!(e.charCode > 96 && e.charCode < 123)) {
                //         $("#DescServiceErr").html('Value must be a letter');
                //     }
                // }


                function validateSer(val) {
                    console.log(val);
                    if (val.length < 2) {
                        $("#ServiceErr").html('Value must be at least three letters');
                        $("#service_description").removeClass('mobile-valide');
                        $("#service_description").addClass('mobile-novalide');
                    } else {
                        $("#ServiceErr").html('')
                        $("#service_description").addClass('mobile-valide');
                        $("#service_description").removeClass('mobile-novalide');
                    }

                }
                function validateSoc(val) {
                    console.log(val);
                    if (val.length < 2) {
                        $("#twitter_link").html('Value must be at least three letters');
                        $("#twitter_link").removeClass('mobile-valide');
                        $("#twitter_link").addClass('mobile-novalide');
                    } else {
                        $("#twitter_link").html('')
                        $("#twitter_link").addClass('mobile-valide');
                        $("#twitter_link").removeClass('mobile-novalide');
                    }

                }
                // function validateNumber(e) {
                //     console.log(e.charCode);
                //     if (!(e.charCode > 96 && e.charCode < 123)) {
                //         $("#ServiceErr").html('Value must be a letter');
                //     }
                // }
            </script>
            <script>
                // AutoComplete Start

                google.maps.event.addDomListener(window,'load',initialize);

                function initialize(){

                    var autocomplete= new google.maps.places.Autocomplete(document.getElementById('inputSearchTextFilter'));

                    autocomplete.setComponentRestrictions({'country': ['au']});

                    google.maps.event.addListener(autocomplete, 'place_changed', function(){

                        var places = autocomplete.getPlace();
                        console.log(places);
                        // console.log(places.formatted_address);
                        // console.log(places.address_components.length);
                        addressObj = places.address_components;
                        // console.log(addressObj);
                        addressObjLength = places.address_components.length;
                        // console.log(addressObj.addressObjlength);
                        for (let index = 0; index < addressObjLength; index++) {
                            if(index = addressObjLength-1) {
                                const pinCode = addressObj[index].long_name;
                                // console.log(pinCode);
                                $("#pin").val(pinCode)
                            }
                        }
                        // console.log(places.website);
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
                            // console.log(phNum);

                            $('#mobile').val(phNum);
                        } else {
                            $('#mobile').val('');
                        }

                        $('#selectedLongitude').val(places.geometry.location.lng());

                        $('#selectedLatitude').val(places.geometry.location.lat());

                    });

                }

            </script>

            <script>
                $('.textbox').on('keyup keydown keypress change paste', function() {
                    if ($(this).val() == '') {
                        $(this).parent().removeClass('label_up');
                    } else {
                        $(this).parent().removeClass('label_up');
                    }
                });

                var input = document.getElementById('image');
                var infoArea = document.getElementById('file-upload-filename');

                input.addEventListener('change', showFileName);

                function showFileName(event) {

                    // the change event gives us the input it occurred in
                    var input = event.srcElement;

                    // the input has an array of files in the `files` property, each one has a name that you can use. We're just using the name here.
                    var fileName = input.files[0].name;

                    // use fileName however fits your app best, i.e. add it into a div
                    infoArea.textContent = 'File name: ' + fileName;
                }

                $(document).ready(function() {
                    // $("#course_butt").click(function() {
                    //             var business_search = $("#business_search").val();
                    //             if (business_search != '') {
                    //                 window.location = "/business_search/" + business_search;
                    //             }
                    //         });
                });
            </script>
            <script>
                function autocomplete(inp, arr) {
                    /*the autocomplete function takes two arguments,
                     the text field element and an array of possible autocompleted values:*/
                    var currentFocus;
                    /*execute a function when someone writes in the text field:*/
                    inp.addEventListener("input", function(e) {
                        var a, b, i, val = this.value;
                        //alert(val.length);
                        /*close any already open lists of autocompleted values*/
                        closeAllLists();
                        if (!val) {
                            return false;
                        }
                        if (val.length < 2) {
                            return false;
                        }
                        currentFocus = -1;
                        /*create a DIV element that will contain the items (values):*/
                        a = document.createElement("DIV");
                        a.setAttribute("id", this.id + "autocomplete-list");
                        a.setAttribute("class", "autocomplete-items");
                        // a.setAttribute("class", "");
                        /*append the DIV element as a child of the autocomplete container:*/
                        this.parentNode.appendChild(a);
                        /*for each item in the array...*/
                        for (i = 0; i < arr.length; i++) {
                            /*check if the item starts with the same letters as the text field value:*/
                            var arr_val = arr[i].toUpperCase();
                            var vall = val.toUpperCase();
                            var res = arr_val.match(vall);

                            if (res != null) {
                                var searched_item = arr[i];
                                var strong_val = "<span style='font-weight:bolder;color: #2579d3;' >" + val + "</span>"
                                var after_search = searched_item.replace(val, strong_val);

                                /*create a DIV element for each matching element:*/
                                b = document.createElement("DIV");

                                /*make the matching letters bold:*/
                                // b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
                                b.innerHTML = after_search;
                                /*insert a input field that will hold the current array item's value:*/
                                b.innerHTML += "<input type='hidden' value='" + arr[i] + "' >";
                                /*execute a function when someone clicks on the item value (DIV element):*/
                                b.addEventListener("click", function(e) {

                                    /*insert the value for the autocomplete text field:*/
                                    inp.value = this.getElementsByTagName("input")[0].value;
                                    /*close the list of autocompleted values,
                                     (or any other open lists of autocompleted values:*/
                                    closeAllLists();
                                    // window.location = "/business_search/" + inp.value;
                                });
                                a.appendChild(b);
                            }
                        }
                    });
                    /*execute a function presses a key on the keyboard:*/
                    inp.addEventListener("keydown", function(e) {
                        var x = document.getElementById(this.id + "autocomplete-list");
                        if (x)
                            x = x.getElementsByTagName("div");
                        if (e.keyCode == 40) {
                            /*If the arrow DOWN key is pressed,
                             increase the currentFocus variable:*/
                            currentFocus++;
                            /*and and make the current item more visible:*/
                            addActive(x);
                        } else if (e.keyCode == 38) { //up
                            /*If the arrow UP key is pressed,
                             decrease the currentFocus variable:*/
                            currentFocus--;
                            /*and and make the current item more visible:*/
                            addActive(x);
                        } else if (e.keyCode == 13) {
                            /*If the ENTER key is pressed, prevent the form from being submitted,*/
                            e.preventDefault();
                            if (currentFocus > -1) {
                                /*and simulate a click on the "active" item:*/
                                if (x)
                                    x[currentFocus].click();
                            }
                        }
                    });

                    function addActive(x) {
                        /*a function to classify an item as "active":*/
                        if (!x)
                            return false;
                        /*start by removing the "active" class on all items:*/
                        removeActive(x);
                        if (currentFocus >=document.getElementById('googlemapaddress') x.length)
                            currentFocus = 0;
                        if (currentFocus < 0)
                            currentFocus = (x.length - 1);
                        /*add class "autocomplete-active":*/
                        x[currentFocus].classList.add("autocomplete-active");
                    }

                    function removeActive(x) {
                        /*a function to remove the "active" class from all autocomplete items:*/
                        for (var i = 0; i < x.length; i++) {
                            x[i].classList.remove("autocomplete-active");
                        }
                    }

                    function closeAllLists(elmnt) {
                        /*close all autocomplete lists in the document,
                         except the one passed as an argument:*/
                        var x = document.getElementsByClassName("autocomplete-items");
                        for (var i = 0; i < x.length; i++) {
                            if (elmnt != x[i] && elmnt != inp) {
                                x[i].parentNode.removeChild(x[i]);
                            }
                        }
                    }
                    /*execute a function when someone clicks in the document:*/
                    document.addEventListener("click", function(e) {
                        closeAllLists(e.target);

                    });
                }
                var token = $("input[name='_token']").val();
                $.ajax({
                    url: "/business-signup/create",
                    type: "post",
                    data: {
                        '_token': token
                    },
                    success: function(response) {
                        autocomplete(document.getElementById("business_search"), response);

                    }
                });
            </script>
            <script>
                function isNumberKey(evt){
                    if(evt.charCode >= 48 && evt.charCode <= 57){
                        return true;
                    }
                    return false;
                }
            </script>
            <script>
                (function ($, window, Typist) {

    // Dropdown Menu Fade
    jQuery(document).ready(function () {
        $(".dropdown").hover(
            function () {
                $('.dropdown-menu', this).fadeIn("fast");
            },
            function () {
                $('.dropdown-menu', this).fadeOut("fast");
            });
    });

    /*-------active---------*/

    $(document).ready(function () {
        $(".nav-link").click(function () {
            $(".nav-link").removeClass("active");
            $(this).addClass("active");
        });
    });


    /*-------------headder_fixed-------------*/


    $(window).scroll(function () {
        var sticky = $('.header'),
            scroll = $(window).scrollTop();

        if (scroll >= 20) sticky.addClass('fixed');
        else sticky.removeClass('fixed');
    });

    /*------------slider-------------*/

    var swiper = new Swiper(".smplace", {
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            640: {
                slidesPerView: 1,
                spaceBetween: 0,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 0,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 0,
            },
        },
    });

    var swiper = new Swiper(".Bestdeals", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            640: {
                slidesPerView: 1,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30,
            },
        },
    });
    var swiper = new Swiper(".top_dect", {
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {
            640: {
                slidesPerView: 1,
                spaceBetween: 10,
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 10,
            },
            1024: {
                slidesPerView: 4,
                spaceBetween: 30,
            },
        },
    });

    $('.toggle').click(function (e) {
        e.preventDefault();

        var $this = $(this);

        if ($this.next().hasClass('show')) {
            $this.next().removeClass('show');
            $this.next().slideUp(350);
        } else {
            $this.parent().parent().find('li .inner').removeClass('show');
            $this.parent().parent().find('li .inner').slideUp(350);
            $this.next().toggleClass('show');
            $this.next().slideToggle(350);
        }
    });

    $('.toggle').click(function(e){
        var $child = $(this).find('.plus-sign');
        if($child.hasClass('fa-plus')){
            $child.removeClass('fa-plus');
            $child.addClass('fa-minus')
        }else if($child.hasClass('fa-minus')){
            $child.removeClass('fa-minus');
            $child.addClass('fa-plus');
        }
    })

    // email validation function
    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test( $email );
    }

    $("#step2").click(function(){
        // validation
        if($('#council_name').val() == "") {
            $('#businessNameErr').text('Please enter Council Name');
        } else if ($('#trading_name').val() == "") {
            $('#tradingNameErr').text('Please enter Primary Contact');
        } else if ($('#email').val() == "") {
            $('#businessEmailErr').text('Please enter Business email');
        } else if (!validateEmail($('#email').val())) {
            $('#businessEmailErr').text('Please enter a valid email address');
        } else if($('#mobile').val() == "") {
            $('#businessPhoneErr').text('Please enter Business Phone');
        } else if($('#mobile').val() == "") {
            $('#businessPhoneErr').text('Please enter Business Phone');
        } else if($('#address').val() == "") {
            $('#businessAddressErr').text('Please enter Business Address');
        } else if($('#website').val() == "") {
            $('#businessWebsiteErr').text('Please enter Business Website');
        } else {
            $("#st2").show();
            $('html, body').animate({
            scrollTop: $("#st2").offset().top - 50
            }, 1000);
            $(this).attr('disabled', true);
            $(".registerWizard li").removeClass("active");
            $(".registerWizard li:nth-child(2)").addClass("active");
        }
    })

    $("#step3").click(function(){
        if($('#primary_name').val() == "") {
            $('#NameErr').text('Please enter Name');
        } else if($('#primary_email').val() == "") {
            $('#EmailErr').text('Please enter Email address');
        } else if (!validateEmail($('#primary_email').val())) {
            $('#EmailErr').text('Please enter a valid email address');
        } else if($('#primary_phone').val() == "") {
            $('#PhoneErr').text('Please enter Phone number');
        // } else if($('#description').val() == "") {
        //     $('#DescServiceErr').text('Please enter Business Description');
        // } else if($('#service_description').val() == "") {
        //     $('#ServiceErr').text('Please enter Service Description');
        } else {
            $("#st3").show();
            $('html, body').animate({
            scrollTop: $("#st3").offset().top - 50
            }, 1000);
            $(this).attr('disabled', true);
            $(".registerWizard li").removeClass("active");
            $(".registerWizard li:last-child").addClass("active");
        }
    });

    // $("#pvst2").click(function(){
    //     $("#st1").show();
    //     $("#st2").hide();
    //     $(".registerWizard li").removeClass("active");
    //     $(".registerWizard li:first-child").addClass("active");
    // });
    // $("#pvst3").click(function(){
    //     $("#st3").hide();
    //     $("#st2").show();
    //     $(".registerWizard li").removeClass("active");
    //     $(".registerWizard li:nth-child(2)").addClass("active");
    // });

    })(jQuery, window);
    </script>
    </body>

    </html>
