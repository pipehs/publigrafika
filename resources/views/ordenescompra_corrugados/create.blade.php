@extends('master')

@section('title', 'Órdenes de compra corrugado')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

A continuación podrá agregar y/o modificar la informaci&oacute;n ingresada a trav&eacute;s de la solicitud de cotizaci&oacute;n.
<hr>
{!!Form::model($cotizacion,['route'=>['ordenescompra_corrugado.store',$cotizacion->id],'method'=>'POST','class'=>'form-horizontal'])!!}
	@include('ordenescompra_corrugados.form')
{!!Form::close()!!}
@stop