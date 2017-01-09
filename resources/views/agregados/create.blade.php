@extends('master')

@section('title', 'Agregados Payloaders')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<h3>Agregar Payloader</h3>
<br/>
Ingrese los datos del agregado, y además un precio para cada una de las cantidades ingresadas para cada payloader.
<hr>
{!!Form::open(['route'=>'agregados.store','method'=>'POST','class'=>'form-horizontal'])!!}

@include('agregados.form')

{!!Form::close()!!}

@stop