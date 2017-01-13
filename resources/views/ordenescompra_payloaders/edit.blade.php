@extends('master')

@section('title', 'Cotizaciones payloaders')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

Ingrese toda la informaci&oacute;n de la solicitud de cotizaci&oacute;n.
<hr>
<div class="row">
<div class="col-sm-8 col-m-6">
{!!Form::model($cotizacion,['route'=>['ordenescompra_payloaders.update',$cotizacion->id],'method'=>'PUT','class'=>'form-horizontal'])!!}
	@include('ordenescompra_payloaders.form')
{!!Form::close()!!}
</div>
<div class="col-sm-4 col-m-6">
	<b>Cantidad y precio de cotizaci&oacute;n original</b>
	<br/>
	<center>
	<small><b>Cantidad: </b> {{ $cantidad }}</small> <br/>
	<small><b>Precio: </b> {{ $precio }}</small> <br/>
	</center>
</div>
</div>
@stop