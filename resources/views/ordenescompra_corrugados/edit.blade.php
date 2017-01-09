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
{!!Form::model($cotizacion,['route'=>['ordenescompra_corrugado.update',$cotizacion->id],'method'=>'PUT','class'=>'form-horizontal'])!!}
	@include('ordenescompra_corrugados.form')
{!!Form::close()!!}
@stop