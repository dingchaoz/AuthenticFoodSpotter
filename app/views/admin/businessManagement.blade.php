@extends('admin.layout')


@section('title','Dashboard')


@section('content')


 <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Business Management
                            
                        </header>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Business Name</th>
                                    <th>Claimed By</th>
                                    <th>Ratings</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($businesses->count())
                                @foreach($businesses as $business)
                                <tr>
                                    <td>{{$business->id}}</td>
                                    <td><a href="{{URL::route('viewBusiness',array('id'=>$business->id))}}">{{$business->name}}</a></td>
                                    <td>{{($business->user_id!=0)?$business->user->email:''}}</td>
                                    <td>
                                        {{$business->rating}}
                                    </td>
                                    <td>
                                        <a href="{{URL::route('deleteBusiness',array('id'=>$business->id))}}" class="btn btn-danger btn-xs"> <i class="fa fa-trash-o"></i> Delete </a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif

                                </tbody>
                            </table>
                        </div>
                        <center>
                        {{$businesses->links()}}
                        </center>
                    </section>
                </div>
            </div>

@stop