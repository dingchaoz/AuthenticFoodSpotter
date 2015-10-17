@extends('admin.layout')


@section('title','Claim Requests')


@section('content')


 <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Claim Requests Management
                            
                        </header>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Business</th>
                                    <th>Claim Requested By</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($claimRequests->count())
                                @foreach($claimRequests as $claimRequest)
                                <tr>
                                    <td>{{$claimRequest->id}}</td>
@if(isset($claimRequest->business->id))
                                    <td><a href="{{URL::route('viewBusiness',array('id'=>$claimRequest->business->id))}}">{{$claimRequest->business->name}}</a></td>
@else
				<td> Business Removed </td>
@endif
@if(isset($claimRequest->user->id))
                                    <td>{{$claimRequest->user->email}}</td>
@else
				<td> User Deleted </td>
@endif
                                    <td>
                                        <a href="{{URL::route('approveClaim',array('id'=>$claimRequest->id))}}" class="btn btn-success btn-xs"> Approve </a>
                                        <a href="{{URL::route('rejectClaim',array('id'=>$claimRequest->id))}}" class="btn btn-danger btn-xs"> Reject </a>
                                    </td>
                                </tr>
                                @endforeach
                                @endif

                                </tbody>
                            </table>
                        </div>
                        <center>
                        {{$claimRequests->links()}}
                        </center>
                    </section>
                </div>
            </div>

@stop
