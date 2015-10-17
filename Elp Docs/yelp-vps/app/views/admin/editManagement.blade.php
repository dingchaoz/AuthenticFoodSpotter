@extends('admin.layout')


@section('title','Edit Management')


@section('content')


 <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Edit Management

                            
                        </header>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Edited Business</th>
                                    <th>Edited By</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($edit_logs->count())
                                @foreach($edit_logs as $edit_log)
                                <tr>

                                    <td>{{$edit_log->id}}</td>
                                    <td><a href="{{URL::route('viewBusiness',array('id'=>$edit_log->business->id))}}">{{$edit_log->business->name}}</td>
                                    <td><a href="">{{ucfirst($edit_log->user->first_name)}} {{$edit_log->user->last_name}} ({{$edit_log->user->email}})</td>
                                    <td>
                                        <a href="{{URL::route('adminViewEdit',array('id'=>$edit_log->id))}}" class="btn btn-warning btn-xs"> View edit </a>
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

