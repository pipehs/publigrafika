@extends('master')

@section('title', 'Payloaders')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<h3>Payloaders</h3>
<div>
	<a class="btn btn-success" href="payloaders.create">Agregar Payloader</a>
  <a class="btn btn-info" href="agregados.create">Generar Agregado</a>
  <a class="btn btn-warning" href="payloaders.tabla">Tabla de precios</a>   
</div>
  <br /><br />
@if (!$payloaders->isEmpty())
    <table class="table table-bordered table-striped indice">
    	<thead>
    		<th>Nombre</th>
        <th>Descripción</th>
        <th>Largo</th>
        <th>Ancho</th>
    		<th>Bandejas</th>
        <th>Acción</th>
        <th>Acción</th>
        <th>Acción</th>
    	</thead>

    @foreach ($payloaders as $payloader)
    <tr>
    <td>{{ $payloader['nombre'] }}</td>
    <td>
    @if ($payloader['descripcion'] == NULL)
        No se agregó descripción
    @else
        {{ $payloader['descripcion'] }}
    @endif
    </td>
    <td>{{ $payloader['largo'] }}</td>
    <td>{{ $payloader['ancho'] }}</td>
    <td>{{ $payloader['bandejas'] }}</td>
    <td>{!! link_to_route('payloaders.edit', $title = 'Editar', $parameters = $payloader['id'], $attributes = ['class'=>'btn btn-warning']) !!}</td>
    <td>{!! link_to_route('payloaders.precios', $title = 'Gestión de precios', $parameters = $payloader['id'], $attributes = ['class'=>'btn btn-primary']) !!}</td>
    <td><button class="btn btn-danger" onclick="eliminar2({{ $payloader['id'] }},'{{ $payloader['nombre'] }}','payloaders','El payloader')">Eliminar</button></td>

    </tr>
    @endforeach
    </table>
@else
  <hr>
  <center><b><p>Aun no se han agregado payloaders</p></b></center>
  <hr>
@endif
@stop


