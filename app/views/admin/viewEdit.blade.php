@extends('admin.layout')

@section('content')

<div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Edits
                        </header>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th> Original </th>
                                    <th> New </th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($edit_log as $key => $value)
                                	<tr>
                                		<td> {{$key}} </td>
                                		<td> {{(is_object($business->$key))?$business->$key->label:$business->$key}} </td>
                                		<td> {{$value}} </td>
                                	</tr>
                                @endforeach
                                </tbody>
                            </table>

                            <a href="{{URL::route('adminApproveEdit',array('id'=>$id))}}" class="btn btn-lg btn-success"> Approve </a>
                            <a href="{{URL::route('adminRejectEdit',array('id'=>$id))}}" class="btn btn-lg btn-danger"> Reject </a>
                        </div>
                    </section>
                </div>
</div>

@stop