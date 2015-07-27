@extends('admin.layout')


@section('title',Config::get('settings.title')." Settings")

@section('content')

<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <section class="panel">
            <header class="panel-heading">
                Settings
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                </span>
            </header>
            <div class="panel-body">
                            <form class="form-horizontal" role="form" action="{{URL::route('updateSettings')}}" method="post">
                            <div class="form-group">
                                <label for="title" class="col-lg-3 col-sm-3 control-label">Site Title</label>
                                <div class="col-lg-9">
                                    <input name="title" type="text" class="form-control" id="title" placeholder="" value="{{Config::get('settings.title')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="keywords" class="col-lg-3 col-sm-3 control-label">Meta Keywords</label>
                                <div class="col-lg-9">
                                    <textarea name="keywords" class="form-control" placeholder="Seperate all keywords with comma">{{Config::get('settings.keywords')}}</textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-lg-3 col-sm-3 control-label">Email to send mails through</label>
                                <div class="col-lg-9">
                                    <input name="email" type="email" class="form-control" value="{{Config::get('settings.email')}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="footer" class="col-lg-3 col-sm-3 control-label">Footer Text</label>
                                <div class="col-lg-9">
                                    <input name="footer" type="text" class="form-control" value="{{Config::get('settings.footer')}}">
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