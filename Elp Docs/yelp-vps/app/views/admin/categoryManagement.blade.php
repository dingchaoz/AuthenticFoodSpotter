@extends('admin.layout')


@section('title','Dashboard')


@section('content')


 <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Category Management
                            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#myModal">
                              <i class="fa fa-plus"></i> Add New category
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel"> Add Category </h4>
                                  </div>
                                  <div class="modal-body">
                                    <form method="post" action="{{URL::to('admin/category/add')}}">
                                        <div class="input-group m-bot15">
                                        <input type="text" name="category" class="form-control" placeholder="Category">
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
                                    <th>Category Name</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($categories->count())
                                @foreach($categories as $category)
                                <tr>

                                    <td>{{$category->id}}</td>
                                    <td><a href="">{{$category->category_name}}</td>
                                    <td>
                                        <a href="{{URL::route('adminCategoryView',array('id' => $category->id))}}" class="btn btn-xs btn-warning"> <i class="fa fa-eye"></i> View </a>
                                        @if($category->active)
                                            <a href="{{URL::to('admin/category/disable').'/'.$category->id}}" class="btn btn-xs btn-danger"> <i class="fa fa-ban"></i> Disable </a>
                                        @else
                                            <a href="{{URL::to('admin/category/enable').'/'.$category->id}}" class="btn btn-xs btn-success"> <i class="fa fa-check"></i> Enable </a>
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

