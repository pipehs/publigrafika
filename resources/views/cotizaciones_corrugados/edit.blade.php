@extends('master')

@section('title', 'Cotizaciones corrugado')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

Ingrese toda la informaci&oacute;n de la solicitud de cotizaci&oacute;n.
<hr>
{!!Form::model($cotizacion,['route'=>['cotizaciones_corrugado.update',$cotizacion->id],'method'=>'PUT','class'=>'form-horizontal'])!!}
	@include('cotizaciones_corrugados.form')
{!!Form::close()!!}
@stop