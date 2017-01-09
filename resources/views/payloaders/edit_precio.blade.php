@extends('master')

@section('title', 'Payloaders')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

@if(Session::has('error'))
  <div class="alert alert-danger alert-dismissible" role="alert">
  {{ Session::get('error') }}
  </div>
@endif

<h3>Editar precio de Payloader</h3>
<br/>
Ingrese el nuevo precio del payloader seg&uacute;n la cantidad m&iacute;nima y m&aacute;xima de venta.
<hr>
{!!Form::model($preciobasecantidad,['route'=>['payloaders.update_precio',$preciobasecantidad->id],'method'=>'PUT','class'=>'form-horizontal'])!!}
@include('payloaders.form_precio')
{!!Form::close()!!}

@stop