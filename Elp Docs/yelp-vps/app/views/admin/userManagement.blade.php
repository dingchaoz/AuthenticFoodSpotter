@extends('admin.layout')


@section('title','Dashboard')


@section('content')


 <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            User Management
                        </header>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Email-ID</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($users->count())
                                @foreach($users as $user)
                                <tr>

                                	<?php

                                	$throttle = Sentry::findThrottlerByUserId($user->id);



                                	?>
                                    <td>{{$user->id}}</td>
                                    <td><a href="">{{$user->first_name}} {{$user->last_name}}</td>
                                    <td>
                                    	@if($throttle->isBanned())
                                    		<button type="button" class="btn btn-danger btn-xs">Banned</button>
                                    	@elseif($throttle->isSuspended())
                                    		<button type="button" class="btn btn-danger btn-xs">Suspended</button>
                                    	@elseif($user->isActivated())
                                    		 <button type="button" class="btn btn-success btn-xs">Activated</button>
                                    	@else
                                    		<button type="button" class="btn btn-danger btn-xs">Not Activated</button>
                                    	@endif

                                    	

                                    	



                                    </td>
                                    <td>{{$user->email}}</td>
                                    <td>

                                        <a href="{{URL::to('admin/delete').'/'.$user->id}}" class="btn btn-warning btn-xs"><i class="fa fa-trash-o"></i> Delete</a>

                                        @if($throttle->isSuspended())
                                    		<a href="{{URL::to('admin/unsuspend').'/'.$user->id}}" class="btn btn-success btn-xs"><i class="fa fa-minus-circle"></i> unsuspend</a>
                                    	@else
                                    		<a href="{{URL::to('admin/suspend').'/'.$user->id}}" class="btn btn-default btn-xs"><i class="fa fa-minus-circle"></i> Suspend</a>
                                    	@endif

                                    	@if($throttle->isBanned())
                                        	<a href="{{URL::to('admin/unban').'/'.$user->id}}" class="btn btn-success btn-xs"><i class="fa fa-ban"></i> Unban</a>
                                        @else
                                        	<a href="{{URL::to('admin/ban').'/'.$user->id}}" class="btn btn-danger btn-xs"><i class="fa fa-ban"></i> Ban</a>
                                        @endif

                                        @if(!$user->isActivated())
                                            <a href="{{URL::to('admin/activate').'/'.$user->id}}" class="btn btn-success btn-xs"><i class="fa fa-ok"></i> Activate</a>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endif

                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
            </div>

@stop

