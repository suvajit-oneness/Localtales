@extends('business.app')
@section('title') Dashboard @endsection

@section('content')
    @php
        $deals = App\Models\Deal::where('created_by',Auth::guard('business')->user()->id)->get();
    @endphp

    <div class="app-title">
        <div>
            <h1><i class="fa fa-file"></i> Dashboard</h1>
        </div>
    </div>

    <div class="row section-mg row-md-body no-nav">
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                    <a class="dash-tooltip" data-tooltip="Edit Your Profile" href="{{ route('business.profile') }}"><h4>Edit Profile</h4></a>
                </div>
            </div>
        </div>
         <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-key fa-3x"></i>
                <div class="info">
                    <a class="dash-tooltip" data-tooltip="Change Your Password" href="{!! URL::to('business/change/password') !!}"><h4>Change Password</h4></a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-briefcase fa-3x"></i>
                <div class="info">
                    <a class="dash-tooltip" data-tooltip="See the Rating & Review" href="{{ route('business.review') }}"><h4>Rating & Review</h4></a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-tag fa-3x"></i>
                <div class="info">
                    <h4>Active Deals</h4>
                    <a class="dash-tooltip" data-tooltip="Deals" href="{{ route('business.deal.index') }}"><h4>{{count($deals)}} </h4></a>
                </div>
            </div>
        </div>

        {{--<div class="col-md-6 col-lg-3">
            <div class="widget-small warning coloured-icon">
                <i class="icon fa fa-folder-open fa-3x"></i>
                <div class="info">
                    <h4>Active Events</h4>
                    <p><b>{{count($events)}} </b></p>
                </div>
            </div>
        </div>
       
        <div class="col-md-6 col-lg-3">
            <div class="widget-small info coloured-icon">
                <i class="icon fa fa-map fa-3x"></i>
                <div class="info">
                    <h4>Registered Properties</h4>
                    <p><b>{{count($properties)}} </b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small warning coloured-icon">
                <i class="icon fa fa-list fa-3x"></i>
                <div class="info">
                    <h4>Active Categories</h4>
                    <p><b>{{count($categories)}} </b></p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3">
            <div class="widget-small primary coloured-icon">
                <i class="icon fa fa-users fa-3x"></i>
                <div class="info">
                    <h4>Active Loops</h4>
                    <p><b> {{count($loops)}} </b></p>
                </div>
            </div>
        </div>--}}
    </div>




    {{--<section>
        <div class="row">
            <div class="col-xl-6">
                <div class="card mb-4">
                    <h5 class="px-4 py-3 mb-0">Latest Review</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-center"><i class="fi fi-br-picture"></i></th>
                                <th>Name</th>
                                <th>Style</th>
                                <th>Category</th>
                                <th>Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($review as $productKey => $product)
                                @php if($productKey == 5) break;  @endphp
                                <tr>
                                    <td class="text-center column-thumb">
                                        <img src="{{asset($product->image)}}">
                                    </td>
                                    <td>
                                        <p style="height: 42px;overflow: hidden;text-overflow: ellipsis;margin-bottom: 0;">{{$product->name}}</p>
                                        <div class="row__action">
                                            <a href="{{ route('business.market-product.edit', $product->id) }}">Edit</a>
                                            <a href="">View</a>
                                        </div>
                                    </td>
                                    <td>{{$product->style_no}}</td>
                                    <td></td>
                                    <td>Rs. {{$product->offer_price}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="card mb-4">
                    <h5 class="px-4 py-3 mb-0">Latest order listing</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order as $order)
                                @php
                                    switch($order->status) {
                                        case 1:$status = 'New';break;
                                        case 2:$status = 'Confirmed';break;
                                        case 3:$status = 'Shipped';break;
                                        case 4:$status = 'Delivered';break;
                                        case 5:$status = 'Cancelled';break;
                                    }
                                @endphp
                                <tr>
                                    <td><a href="">#{{$order->order_no}}</a></td>
                                    <td>{{date('j M Y g:i A', strtotime($order->created_at))}}</td>
                                    <td>Rs {{$order->final_amount}}</td>
                                    <td><span class="badge bg-info">{{ $status }}</span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="col-xl-12">
                <div class="card">
                    <h5 class="px-4 py-3 mb-0">Latest trade requests</h5>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Date</th>
                                <th>Postcode</th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($localtrade as $order)

                                <tr>
                                    <td><a href="">#{{$order->id}}</a></td>
                                    <td>{{date('j M Y g:i A', strtotime($order->created_at))}}</td>
                                    <td>{{$order->postcode}}</td>
                                    <td><span class="badge bg-info"></span></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </section> --}}
@endsection


