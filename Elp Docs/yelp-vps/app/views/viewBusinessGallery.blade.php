@extends('layout')

@section('head')
	<link rel="stylesheet" type="text/css" href="{{asset('css/blueimp-gallery.min.css')}}">
@stop
@section('content')

<div class="container">
	<a href="{{URL::route('viewBusiness',array('id'=>$business->id))}}">
	<h1> {{$business->name}} </h1>
	</a>
</div>

<!-- Modal Starts -->
<div id="blueimp-gallery" class="blueimp-gallery">
    <!-- The container for the modal slides -->
    <div class="slides"></div>
    <!-- Controls for the borderless lightbox -->
    <h3 class="title"></h3>
    <a class="prev">‹</a>
    <a class="next">›</a>
    <a class="close">×</a>
    <a class="play-pause"></a>
    <ol class="indicator"></ol>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->
    <div class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"></h4>
                </div>
                <div class="modal-body next"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left prev">
                        <i class="icon-backward"></i>
                        Previous
                    </button>
                    <button type="button" class="btn btn-primary next">
                        Next
                        <i class="icon-forward"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal Ends -->
<!-- Main Content Starts -->
<div class="container full-content">
	<div class="row">
		<div id="links">
		<?php $i = 0; ?>
			@foreach($photos as $photo)
			<div class="col-md-2">
                @if(Sentry::check())
                    @if($photo->user_id==$user->id||$user->admin)
                    <a href="{{URL::route('deletePhoto',array('id'=>$photo->id))}}" class="close" data-dismiss="modal" aria-hidden="true" style="position: absolute; right: 20px;">&times;</a>
                    @endif
                @endif
			    <a href="{{asset('/uploads/'.$photo->picture)}}" title="{{$photo->title}}" data-gallery>
			        <img src="{{asset(Image::path('/uploads/'.$photo->picture , 'resizeCrop', 160, 160) )}}" alt="{{$photo->title}}">
			    </a>

			    <div class="thumb-desc">
			    	From <a href="{{URL::route('viewProfile',array('id'=>$photo->user->id))}}">{{$photo->user->first_name}} {{$photo->user->last_name}}</a>
			    	<p>{{$photo->title}}</p>
			    </div>

		    </div>
		    @endforeach
		</div>
	</div>
</div>
<!-- Main Content Ends -->
@stop

@section('script')
<script type="text/javascript" src="{{asset('js/jquery.blueimp-gallery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-img-gallery.js')}}"></script>

@stop