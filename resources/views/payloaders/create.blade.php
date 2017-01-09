@extends('master')

@section('title', 'Payloaders')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<h3>Agregar Payloader</h3>
<br/>
Ingrese toda la informaci&oacute;n para agregar el payloader.
<hr>
{!!Form::open(['route'=>'payloaders.store','method'=>'POST','class'=>'form-horizontal'])!!}

@include('payloaders.form')

{!!Form::close()!!}

@stop