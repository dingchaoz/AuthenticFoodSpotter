@extends('admin.layout')


@section('title','Dashboard')


@section('content')


 <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Review Management
                            
                        </header>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Business</th>
                                    <th>Reviewed By</th>
                                    <th>Review</th>
                                    <th>Score</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($reviews->count())
                                @foreach($reviews as $review)
                                <tr>
                                    <td>{{$review->id}}</td>
@if(isset($review->business->id))
                                    <td><a href="{{URL::route('viewBusiness',array('id'=>$review->business->id))}}">{{$review->business->name}}</a></td>
@else
<td> Business Removed </td>
@endif
                                    <td>{{$review->user->email}}</td>
                                    <td>{{$review->review}}</td>
                                    <td>
                                        {{$review->score}}
                                    </td>
                                    <td>
                                        @if(Config::get('settings.reviewOfTheDay')!=$review->id)
                                         <a href="{{URL::route('featureReview',array('id'=>$review->id))}}" class="btn btn-success btn-xs"> <i class="fa fa-star"></i> Feature </a>   
                                         <a href="{{URL::route('deleteReview',array('id'=>$review->id))}}" class="btn btn-danger btn-xs"> <i class="fa fa-trash-o"></i> Delete </a>
                                        @else
                                            <div class="btn btn-xs btn-warning"><i class="fa fa-star"></i> Review of the Day </div>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @endif

                                </tbody>
                            </table>
                        </div>
                        <center>
                        {{$reviews->links()}}
                        </center>
                    </section>
                </div>
            </div>

@stop
