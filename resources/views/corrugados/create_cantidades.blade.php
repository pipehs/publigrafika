@extends('master')

@section('title', 'Cantidades de Corrugado')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<h3>Agregar Cantidad de Corrugados</h3>
<br/>
Ingrese o modifique todas las cantidades que desee.
<hr>
{!!Form::open(['route'=>'cantidades.store','method'=>'POST','class'=>'form-horizontal'])!!}

@include('corrugados.form_cantidades')

{!!Form::close()!!}

@stop

@section('scripts2')
	{!!Html::script('js/masCantidadesCorr.js')!!}
@stop