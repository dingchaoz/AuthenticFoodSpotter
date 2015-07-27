@extends('admin.layout')

@section('title',Config::get('settings.title').' Admin Panel')

@section('content')

<div class="row">
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon orange"><i class="fa fa-user"></i></span>
            <div class="mini-stat-info">
                <span>{{$statistics['users']}}</span>
                Registered users
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon tar"><i class="fa fa-building-o"></i></span>
            <div class="mini-stat-info">
                <span>{{$statistics['businesses']}}</span>
                Businesses added
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon pink"><i class="fa fa-star"></i></span>
            <div class="mini-stat-info">
                <span>{{$statistics['reviews']}}</span>
                Reviews written
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="mini-stat clearfix">
            <span class="mini-stat-icon green"><i class="fa fa-money"></i></span>
            <div class="mini-stat-info">
                <span>$ {{$statistics['revenue']}}</span>
                Amount Received
            </div>
        </div>
    </div>
</div>

@stop