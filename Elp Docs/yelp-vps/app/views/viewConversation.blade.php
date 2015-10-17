@extends('layout')

@section('title')
	{{$conversation->subject}}
@stop

@section('content')
<div class="container full-content">


<h3> {{$conversation->subject}} </h3>
<hr/>

@foreach($messages as $message)
	<div class="row conversation-message">
		<div class="col-md-1 col-sm-1 col-xs-3 received-message-name">
			<p>{{$message->sender->first_name}}</p>
		</div>
		<div class="col-md-11 col-sm-11 col-xs-9">
			<div class="received-message"> {{nl2br($message->message)}}</div>
		</div>
	</div>
@endforeach


<form method="post" action="{{URL::route('replyToConversation',array('id'=>$conversation->id))}}">
	<textarea name="message" class="form-control"> </textarea>
	<br/>
	<input type="submit" class="btn btn-primary" value="Reply">
</form>

</div>
@stop

@section('script')


@stop