@extends('admin.layout')


@section('title','Pages Management')


@section('head')


@stop

@section('content')


<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <section class="panel">
            <header class="panel-heading">
               {{$page->label}} | Page Management
            </header>
            <div class="panel-body">
                <form method="post" action="{{URL::route('adminPageUpdate',array('id'=>$page->id))}}">
                    <div class="row">
                        <label class="col-sm-2"> Page Label : </label>
                        <div class="col-sm-10">
                            <div class="input">
                                <input type="text" class="form-control" name="label" value="{{$page->label}}">
                            </div>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <label class="col-sm-2"> Content : </label>
                        <div class="col-sm-10">
                            <textarea id="summernote" class="form-control" name="text" style="height: 400px;">{{$page->text}}</textarea> 
                        </div>
                    </div>
                    
                    <br>
                    <input type="submit" value="Save Changes" class="pull-right btn btn-primary">
                </form>
            </div>
        </section>
    </div>
</div>

@stop

@section('script')


<script type="text/javascript" src="{{asset('js/summernote.js')}}"></script>

<link rel="stylesheet" href="{{asset('css/summernote.css')}}">

<script>

    $('#summernote').summernote({
       height: 300,
     airPopover: [
       ['color', ['color']],
      ['font', ['bold', 'underline', 'clear']],
       ['para', ['ul', 'paragraph']],
       ['table', ['']],
       ['insert', ['link', 'picture']]
     ]
    });




</script>
@stop