@extends('master')

@section('title', 'Órdenes de compra corrugado')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

A continuación podrá agregar y/o modificar la informaci&oacute;n ingresada a trav&eacute;s de la orden de compra, o cerrar la misma.
<hr>
<div class="row">
<div class="col-sm-8 col-m-6">
{!!Form::model($cotizacion,['route'=>['ordenescompra_corrugado.update',$cotizacion->id],'method'=>'PUT','class'=>'form-horizontal'])!!}
	@include('ordenescompra_corrugados.form')
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