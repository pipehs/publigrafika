@extends('master')

@section('title', 'Payloaders')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<h3>Editar Payloader</h3>
<br/>
Ingrese la informaci&oacute;n que desee editar el payloader.
<hr>
{!!Form::model($payloader,['route'=>['payloaders.update',$payloader->id],'method'=>'PUT','class'=>'form-horizontal'])!!}
					@include('payloaders.form')
{!!Form::close()!!}

@stop



