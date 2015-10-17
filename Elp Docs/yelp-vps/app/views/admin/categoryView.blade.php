@extends('admin.layout')


@section('title','Dashboard')


@section('content')


 <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            {{ $category->category_name }}
                            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#myModal">
                              <i class="fa fa-plus"></i> Add New sub category
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel"> Add Sub Category under {{$category->category_name}} </h4>
                                  </div>
                                  <div class="modal-body">
                                    <form method="post" action="{{URL::to('admin/sub_category/add').'/'.$category->id}}">
                                        <div class="input-group m-bot15">
                                        <input type="text" name="sub_category" class="form-control" placeholder="Category">
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
                                    <th>Sub Category Name</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($sub_categories->count())
                                @foreach($sub_categories as $subCategory)
                                <tr>

                                    <td>{{$subCategory->id}}</td>
                                    <td><a href="">{{$subCategory->sub_category}}</td>
                                    <td>
                                        @if($subCategory->active)
                                            <a href="{{URL::to('admin/sub_category/disable').'/'.$subCategory->id}}" class="btn btn-xs btn-danger"> Disable </a>
                                        @else
                                            <a href="{{URL::to('admin/sub_category/enable').'/'.$subCategory->id}}" class="btn btn-xs btn-success"> Enable </a>
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

