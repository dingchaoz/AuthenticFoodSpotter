@extends('layout')

@section('title','user')

@section('content')
<div class="container full-content">
	<div class="row messages-header">
		<div class="col-md-10 col-sm-8 col-xs-6">
				<h3 style="margin-top:5px;">Inbox</h3>
		</div>
		<div class="col-md-2 col-sm-4 col-xs-6">
			<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#myModal"> Compose New </a>
		</div>
	</div>
	<div class="row messages-message">
		@foreach($conversations as $conversation)
			<?php $image = ($conversation->sender->picture)?$conversation->sender->picture:Config::get('database.default_profile_pic'); ?>
			<div class="col-md-12" style="padding:10px; border-bottom: 1px solid #ccc;">
				<a href="{{URL::route('viewConversation',array('id'=>$conversation->id))}}">
					<img src="{{ asset(Image::path('/uploads/'.$image , 'resizeCrop', 64, 64)) }}">
						<span class="messages-message-info" style="color:#3b65a7;margin-right:50px;">
							{{$conversation->sender->first_name}}
						</span>

						{{$conversation->subject}}

						<span class="right hidden-xs" style="padding-top:20px;">{{$conversation->time_since}}</span>
				</a>
			</div>
		@endforeach
	</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title" id="myModalLabel">Compose New message</h4>
      </div>
      <form method="post" action="{{URL::route('sendMessage')}}">
	      <div class="modal-body">
	       <label> To : </label>
	       <input type="text" class="form-control" name="to">

	       <label> Subject : </label>
	       <input type="text" class="form-control" name="subject">

	       <label> Message : </label>
	       <textarea name="message" class="form-control"> </textarea>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
	        <button type="submit" class="btn btn-primary">Send</button>
	      </div>
      </form>
    </div>
  </div>
</div>
@stop

@section('script')


@stop