@extends('site.app')
@section('title'){{ $job[0]->title }}@endsection
@section('description')

@section('content')
    <section class="artiledetails_banner mb-3 mb-sm-4">
      
        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-12">
                    <div class="pt-4">
                        <ul class="breadcumb_list mb-2 mb-sm-4">
                            <li><a href="{!! URL::to('') !!}">Home</a></li>
                            <li>/</li>
                            <li><a href="{!! URL::to('news') !!}">News</a></li>
                            <li>/</li>
                            <li>{{ $news->title }}</li>
                        </ul>
                    </div>
                </div>

                {{-- {{dd($job[0])}} --}}

                <div class="col-12 col-md-6">
                    <div class="job__details pt-0">
                        <h1 class="">{{  $news->title }}</h1>
                        <div class="job-details-heading">
                            <div class="job-details-heading-left mb-2">
                                <h4 class="company-name">{{$job[0]->company_name}}</h4>

                                @if($job[0]->contact_number != '' && $job[0]->contact_information)
                                    <p><b>Contact Number: </b> <span class="jobsearch-JobDescription-phone-number"><a href="tel:{{$job[0]->contact_number}}">{{$job[0]->contact_number}}</a></span> ({{$job[0]->contact_information}})</p>
                                @endif

                                @if($job[0]->company_website != '')
                                    <p><b>Company Website: </b> <a href="{{$job[0]->company_website}}">{{$job[0]->company_website}}</a></p>
                                @endif

                                @if($job[0]->company_desc != '' )
                                    <div>{{$job[0]->company_desc}}</div>
                                @endif
                            </div>
                        </div>
                        <div class="row align-items-center">
                            {{-- <div class="col-auto">
                                <h3 class="category__title mb-0">                                    
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"    class="feather feather-map-pin">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                        <circle cx="12" cy="10" r="3"></circle>
                                    </svg>
                                    {{$job[0]->postcode ? $job[0]->postcode : ''}}{{$job[0]->suburb ? ', '.$job[0]->suburb : ''}}{{$job[0]->state ? ', '.$job[0]->state : ''}}
                                </h3>
                            </div> --}}
                            <div class="col-auto">
                                <ul class="articlecat">
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"    class="feather feather-map-pin">
                                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                            <circle cx="12" cy="10" r="3"></circle>
                                        </svg>
                                        {{$job[0]->postcode ? $job[0]->postcode : ''}}{{$job[0]->suburb ? ', '.$job[0]->suburb : ''}}{{$job[0]->state ? ', '.$job[0]->state : ''}}
                                    </li>
                                    <li>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar">
                                            <rect x="3" y="4" width="18" height="18" rx="2"
                                                ry="2"></rect>
                                            <line x1="16" y1="2" x2="16" y2="6"></line>
                                            <line x1="8" y1="2" x2="8" y2="6"></line>
                                            <line x1="3" y1="10" x2="21" y2="10"></line>
                                        </svg>
                                        {{ $job[0]->created_at->format('d M Y') }}
                                    </li>
                                    <li>
                                        <div class="share-btns ml-3">
                                            <div class="dropdown">
                                                <button class="share_button dropdown-toggle px-0" type="button"
                                                    id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                    aria-expanded="false">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                        viewBox="0 0 24 24" fill="none" stroke="#898989" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"
                                                        class="feather feather-share-2">
                                                        <circle cx="18" cy="5" r="3"></circle>
                                                        <circle cx="6" cy="12" r="3"></circle>
                                                        <circle cx="18" cy="19" r="3"></circle>
                                                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49">
                                                        </line>
                                                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49">
                                                        </line>
                                                    </svg>
                                                </button>
                                                <div class="dropdown-menu dropdown-menu-right"
                                                    aria-labelledby="dropdownMenuButton">
                                                    <div class="w-100 pl-2">
                                                        <div class="a2a_kit a2a_kit_size_32 a2a_default_style">
                                                            <a class="a2a_button_facebook"></a>
                                                            <a class="a2a_button_twitter"></a>
                                                            <a class="a2a_button_whatsapp"></a>
                                                            <a class="a2a_button_pinterest"></a>
                                                            <a class="a2a_button_linkedin"></a>
                                                            <a class="a2a_button_telegram"></a>
                                                            <a class="a2a_button_reddit"></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 text-right">
                    <div class="d-flex justify-content-end align-items-center">
                        <a href="javascript:void(0)" class="wishlist_button" onclick="jobBookmark({{ $job[0]->id }})">
                            @php
                                $ip = $_SERVER['REMOTE_ADDR'];
                                if (
                                    auth()
                                        ->guard('user')
                                        ->check()
                                ) {
                                    $collectionExistsCheck = \App\Models\JobUser::where('job_id', $job[0]->id)
                                        ->where('ip', $ip)
                                        ->orWhere(
                                            'user_id',
                                            auth()
                                                ->guard('user')
                                                ->user()->id,
                                        )
                                        ->first();
                                } else {
                                    // $collectionExistsCheck = \App\Models\JobUser::where('job_id', $job[0]->id)
                                    //     ->where(
                                    //         'user_id',
                                    //         auth()
                                    //             ->guard('user')
                                    //             ->user()->id,
                                    //     )
                                    //     ->first();
                                    $collectionExistsCheck = \App\Models\JobUser::where('job_id', $job[0]->id)
                                        ->where('ip', $ip)
                                        ->first();
                                }
                                if ($collectionExistsCheck != null) {
                                    // if found
                                    $heartColor = '#ffffff';
                                } else {
                                    // if not found
                                    $heartColor = 'none';
                                }
                            @endphp
                            <svg id="saveBtn_{{ $job[0]->id }}" xmlns="http://www.w3.org/2000/svg"
                                width="24" height="24" viewBox="0 0 24 24" fill="{{ $heartColor }}"
                                stroke="#ffffff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                class="feather feather-heart">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                </path>
                            </svg>
                        </a>
                        @if (!empty($jobApplied))
                            <div class="card mt-3">
                                <div class="card-body">
                                    <div class="text-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                            viewBox="0 0 24 24" fill="none" stroke="#95C800" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-check">
                                            <polyline points="20 6 9 17 4 12"></polyline>
                                        </svg>
                                    </div>

                                    <h5 class="text-center mb-2">Thanks for your application</h5>

                                    <p class="text-muted small" style="font-size: 13px;line-height: 20px;">You have successfully
                                        applied for this job. Please stay put till you hear from us.</p>
                                </div>
                            </div>
                        @else
                            <a href="https://www.seek.com.au/{{$job[0]->link}}" target="_blank" class="btn main-btn ml-3">Apply</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- for sticky image half or full -->
    <hr>
    <section class="py-2 py-sm-4 job-details-sec">
        <div class="container">
           <div class="row">
                <!-- <div class="col-md-7">
                    <div class="job-qualifications">
                        <h3 class="job-detail-heading">Requirements</h3>
                        <p>{!! $job[0]->skill !!}</p>
                    </div>
                </div> -->
                <div class="col-md-12">
                    <div class="job-details job_right_sidebar border-0 pl-0">
                        <h3 class="job-detail-heading">Job details</h3>

                        <ul class="job__types">
                            @if (!empty($job[0]->employment_type))
                                <li>
                                    <h4>Job type</h4>
                                    <p>{{$job[0]->employment_type}}</p>
                                </li>
                            @else
                                <li>
                                    <h4>Job type</h4>
                                    <p>NA</p>
                                </li>
                            @endif
                            @if(!empty($job[0]->skill))
                                <li>
                                    <h4>Requirements</h4>
                                    <p>@foreach (explode('||',$job[0]->skill) as $item)
                                        @if($item != '')
                                            <li> {{$item}}</li>
                                        @endif
                                        @endforeach
                                    </p>
                                </li>
                            @endif
                            @if(!empty($job[0]->responsibility))
                                <li>
                                    <h4>Responsibilities</h4>
                                    <p>@foreach (explode('||',$job[0]->responsibility) as $item)
                                        @if($item != '')
                                        <li>{{$item}}</li>
                                        @endif
                                        @endforeach
                                    </p>
                                </li>
                            @endif
                            @if(!empty($job[0]->benifits))
                            <li>
                                <h4>Benefits & Perks</h4>
                                <p>@foreach (explode('||',$job[0]->benifits) as $item)
                                    @if($item != '')
                                        <li>{{$item}}</li>
                                    @endif
                                    @endforeach
                                </p>
                            </li>
                            @endif
                            @if($job[0]->notice_period != '')
                                
                            <h4>Notice period</h4> <p>{{$job[0]->notice_period}}</p>
                            @endif

                            @if($job[0]->experience)
                                <h4>Experience Required</h4> 
                                <p>{{$job[0]->experience}}</p>
                            @endif
                            
                            @if($job[0]->payment != '' && $job[0]->salary != '')
                            <li>
                                <h4>Salary</h4>
                                <p>${{$job[0]->payment}} {{'per ' . $job[0]->salary}}</p>
                            </li>
                            @endif
                            {{-- <li>
                                <h4>Benefits & Perks</h4>
                                <p>{!!$job[0]->scope!!}</p>
                            </li> --}}
                        </ul>
                    </div>
                </div>
                <div class="col-12">
                    <hr>
                    <div class="full-job-desc">
                        <h3 class="job-desc-heading">Full Job Description</h3>
                        <p>{!! $job[0]->description ? $job[0]->description : 'NA' !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-2 py-sm-4 art-dtls">
        <div class="container">
            <div class="row">
                <!-- <div class="col-12">
                    <h2 class="company__name">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>{!! $job[0]->company_name !!}<h2>
                </div> -->
                <!-- <p class="col-12">{{ $job[0]->short_description }}
                    <hr class="w-100">
                <div class="col-lg-12 mb-4 mb-lg-0 article_content">
                    {!! $job[0]->description !!}
                </div> -->
                <!-- @if (!empty($jobApplied))
                    <div class="card mt-3">
                        <div class="card-body">
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50"
                                    viewBox="0 0 24 24" fill="none" stroke="#95C800" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-check">
                                    <polyline points="20 6 9 17 4 12"></polyline>
                                </svg>
                            </div>

                            <h5 class="text-center mb-2">Thanks for your application</h5>

                            <p class="text-muted small" style="font-size: 13px;line-height: 20px;">You have successfully
                                applied for this job. Please stay put till you hear from us.</p>
                        </div>
                    </div>
                @else
                    <div class="col-12">
                        <a href="{{ route('front.job.apply.index', $job[0]->slug) }}"
                            class="btn main-btn mt-4">Apply</a>
                    </div>
                @endif -->
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script async src="https://static.addtoany.com/menu/page.js"></script>
    <script>
        // job bookmark/ save/ wishlist
        function jobBookmark(jobId) {
            $.ajax({
                url: '{{ route('front.job.save') }}',
                method: 'post',
                data: {
                    '_token': '{{ csrf_token() }}',
                    id: jobId,
                },
                success: function(result) {
                    // alert(result);
                    if (result.type == 'add') {
                        // toastr.success(result.message);
                        toastFire("success", result.message);
                        $('#saveBtn_' + jobId).attr('fill', '#fff');
                    } else {
                        toastFire("warning", result.message);
                        // toastr.error(result.message);
                        $('#saveBtn_' + jobId).attr('fill', 'none');
                    }
                }
            });
        }
    </script>
@endpush
