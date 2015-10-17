@extends('layout')


@section('title',$page->label)


@section('content')

<div class="container full-content">

{{$page->text}}


</div>

@stop