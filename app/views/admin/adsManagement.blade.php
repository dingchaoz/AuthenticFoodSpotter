@extends('admin.layout')


@section('title','Ads Management')


@section('content')


<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <section class="panel">
            <header class="panel-heading">
               Advertisement Management
            </header>
            <div class="panel-body">
                <form method="post" action="{{URL::route('updateAds')}}">
                    <div class="row">
                        <label class="col-sm-2"> Banner 1 : </label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="banner1">{{Config::get('settings.banner1')}}</textarea> 
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label class="col-sm-2"> Featured Ad cost : </label>
                        <div class="col-sm-10">
                            <div class="input-group m-bot15">
                                <span class="input-group-addon btn-warning">$</span>
                                <input type="text" class="form-control" name="featuredAdCost" value="{{Config::get('settings.featuredAdCost')}}">
                                <span class="input-group-addon btn-warning">/month</span>
                            </div>
                        </div>
                    </div>
                    <br>
                    <input type="submit" value="Save Changes" class="pull-right btn btn-primary">
                </form>
            </div>
        </section>
        <section class="panel">
            <header class="panel-heading">
               Purchase History
            </header>
            <div class="panel-body">
                <table class="table">
                    <tr>
                        <th> Transaction Id </th>
                        <th> User </th>
                        <th> Business </th>
                        <th> Amount </th>
                        <th> Timestamp </th>
                    </tr>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td> {{$transaction->id}} </td>
                        <td> {{$transaction->user->first_name}} </td>
                        @if(isset($transaction->business))
                        <td> {{$transaction->business->name}} </td>
                        @else
                        <td> Business Removed </td>
                        @endif
                        <td> {{$transaction->amount}} </td>
                        <td> {{$transaction->created_at}} </td>
                    </tr>
                    @endforeach
                </table>

                <center>
                    {{$transactions->links()}}
                </center>
            </div>
        </section>
    </div>
</div>

@stop

