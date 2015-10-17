@extends('admin.layout')


@section('title','Dashboard')


@section('content')


 <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Pages Management
                            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#myModal">
                              <i class="fa fa-plus"></i> Add New Page
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel"> Add New Page </h4>
                                  </div>
                                  <div class="modal-body">
                                    <form method="post" action="{{URL::to('admin/page/add')}}">
                                        <div class="input-group m-bot15">
                                        <input type="text" name="page_label" class="form-control" placeholder="Page Label (eg. Contact Us, Privacy)">
                                                      <span class="input-group-btn">
                                                        <button class="btn btn-success" type="submit"> Add </button>
                                                      </span>
                                        </div>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>
                        </header>
                        <div class="panel-body">
                            <table class="table table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Page</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($pages->count())
                                @foreach($pages as $page)
                                <tr>

                                    <td>{{$page->id}}</td>
                                    <td><a href="">{{$page->label}}</td>
                                    <td>
                                        <a href="{{URL::route('adminPageEdit',array('id' => $page->id))}}" class="btn btn-xs btn-warning"> <i class="fa fa-eye"></i> Edit </a>
                                        <a href="{{URL::route('adminPageDelete',array('id' => $page->id))}}" class="btn btn-xs btn-danger"> <i class="fa fa-trash-o"></i> Delete </a>
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

