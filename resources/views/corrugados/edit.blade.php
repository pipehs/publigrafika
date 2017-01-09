@extends('master')

@section('title', 'Corrugados')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<h3>Editar Corrugado</h3>
<br/>
Ingrese la informaci&oacute;n que desee editar el corrugado.
<hr>
{!!Form::model($corrugado,['route'=>['corrugados.update',$corrugado->id],'method'=>'PUT','class'=>'form-horizontal'])!!}
					@include('corrugados.form')
{!!Form::close()!!}


@stop



