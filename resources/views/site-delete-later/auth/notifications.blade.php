@extends('site.appprofile')
@section('title') Dashboard @endsection
@section('content')

	<div class="row">
		<div class="col-12">
			<ul class="search_list_items search_list_items-mod">
	  			@foreach($notifications as $notification)
	  			<li>
					<div class="w-100">
					  	<h4>{{$notification->title}}</h4>
						<h4> {!! html_entity_decode($notification->description) !!}</h4>
					</div>
	  			</li>
	  			@endforeach
	  		</ul>
		</div>
	</div>
@endsection