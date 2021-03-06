@extends('admin.layout')


@section('title','Dashboard')


@section('content')


 <div class="row">
                <div class="col-sm-12">
                    <section class="panel">
                        <header class="panel-heading">
                            Question Management
                            <button class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#myModal">
                              <i class="fa fa-plus"></i> Add New Question
                            </button>

                            <!-- Modal -->
                            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="myModalLabel"> Add Question </h4>
                                  </div>
                                  <div class="modal-body">
                                    <form method="post" action="{{URL::to('admin/question/add')}}">
                                        <div class="row form-group">
                                            <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
                                              <input type="text" name="question" class="form-control" placeholder="Question" required="required">
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
                                              <input type="text" name="text" class="form-control" placeholder="Some description about the question" required="required">
                                            </div>
                                        </div>
                                        <div class="row text-center">
                                            <div class="col-md-8 col-md-offset-2 col-sm-8 col-sm-offset-2 col-xs-8 col-xs-offset-2">
                                              <button type="submit" class="btn btn-primary" style="width:100%;"> Add Question </button>
                                            </div>
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
                                    <th>Question</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @if($questions->count())
                                @foreach($questions as $question)
                                <tr>

                                    <td>{{$question->id}}</td>
                                    <td><a href="">{{$question->question}}</td>
                                    <td>
                                        <a href="{{URL::route('adminQuestionView',array('id' => $question->id))}}" class="btn btn-xs btn-warning"> <i class="fa fa-eye"></i> View/edit </a>
                                        @if($question->active)
                                            <a href="{{URL::to('admin/question/disable').'/'.$question->id}}" class="btn btn-xs btn-danger"> <i class="fa fa-ban"></i> Disable </a>
                                        @else
                                            <a href="{{URL::to('admin/question/enable').'/'.$question->id}}" class="btn btn-xs btn-success"> <i class="fa fa-check"></i> Enable </a>
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

