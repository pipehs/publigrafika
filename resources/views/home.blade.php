@extends('master')

@section('title', 'Inicio')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<center><h1 class="title">Control de Gesti&oacute;n Empresas Grau</h1></center>
<center><h2 class="title">Publigrafika</h2></center>

@stop


