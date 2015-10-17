@extends('admin.loggedoutlayout')

@section('title','Install')

@section('content')

<section class="wrapper">
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <section class="panel">
            <header class="panel-heading">
                Installation
                <span class="tools pull-right">
                    <a href="javascript:;" class="fa fa-chevron-down"></a>
                 </span>
            </header>
            <div class="panel-body">
                            <form class="form-horizontal" role="form" action="{{URL::to('admin/install')}}" method="post">
                            <div class="form-group">
                                <label for="title" class="col-lg-3 col-sm-3 control-label">Site Title</label>
                                <div class="col-lg-9">
                                    <input name="title" type="text" class="form-control" id="title" placeholder="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="keywords" class="col-lg-3 col-sm-3 control-label">Meta Keywords</label>
                                <div class="col-lg-9">
                                    <textarea name="keywords" class="form-control" placeholder="Seperate all keywords with comma"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail1" class="col-lg-3 col-sm-3 control-label">Admin Email</label>
                                <div class="col-lg-9">
                                    <input name="email" type="email" class="form-control" id="inputEmail1" placeholder="Email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword1" class="col-lg-3 col-sm-3 control-label">Admin Password</label>
                                <div class="col-lg-9">
                                    <input name="password" type="password" class="form-control" id="inputPassword1" placeholder="Password">
                                </div>
                            </div> 
                            <div class="form-group">
                                <label for="footer" class="col-lg-3 col-sm-3 control-label">Footer Text</label>
                                <div class="col-lg-9">
                                    <input name="footer" type="text" class="form-control" value="Powered by Provenlogic">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-9">
                                    <button type="submit" class="btn btn-danger">Install</button>
                                </div>
                            </div>
                        </form>
            </div>
        </section>
    </div>
</div>
</section>

@stop