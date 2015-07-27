@extends('admin.layout')


@section('title',Config::get('settings.title')." Settings")

@section('content')

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <section class="panel">
            <header class="panel-heading">
                View/Edit Question
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                </span>
            </header>
            <div class="panel-body">
                <form class="form-horizontal" role="form" action="{{URL::route('adminQuestionUpdate',array('id'=>$question->id))}}" method="post">
                    <div class="form-group">
                        <label for="question" class="col-lg-3 col-sm-3 control-label"> Question </label>
                        <div class="col-lg-9">
                            <input name="question" type="text" class="form-control" placeholder="" value="{{$question->question}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="text" class="col-lg-3 col-sm-3 control-label">Description</label>
                        <div class="col-lg-9">
                            <input name="text" type="text" class="form-control" placeholder="" value="{{$question->text}}">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-lg-offset-3 col-lg-9">
                            <button type="submit" class="btn btn-danger">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>


@stop