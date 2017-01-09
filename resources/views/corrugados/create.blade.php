@extends('master')

@section('title', 'Corrugados')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<h3>Agregar Corrugado</h3>
<br/>
Ingrese toda la informaci&oacute;n para agregar el corrugado.
<hr>
{!!Form::open(['route'=>'corrugados.store','method'=>'POST','class'=>'form-horizontal'])!!}

@include('corrugados.form')

{!!Form::close()!!}

@stop