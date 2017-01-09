@extends('master')

@section('title', 'Agregados de Payloader')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<h3>Editar Agregado de Payloader</h3>
<br/>
Modifique los datos que desee del agregado
<hr>
{!!Form::model($agregado,['route'=>['agregados.update',$agregado->id],'method'=>'PUT','class'=>'form-horizontal'])!!}
					@include('agregados.form')
{!!Form::close()!!}

@stop