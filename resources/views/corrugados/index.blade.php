@extends('master')

@section('title', 'Corrugados')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<h3>Corrugados</h3>
<div>
	<a class="btn btn-success" href="corrugados.create">Agregar Corrugado</a>
  <a class="btn btn-info" href="cantidades.create">Agregar Cantidades</a> 
  <a class="btn btn-warning" href="corrugados.tabla">Tabla de precios</a> 
</div>
    <br /><br />
@if (!$corrugados->isEmpty())
  <table class="table table-bordered table-striped indice">
  	<thead>
  		<th>Nombre (tipo)</th>
      <th>Descripci&oacute;n</th>
  		<th>Acción</th>
      <th>Acción</th>
      <th>Acción</th>
  	</thead>

  @foreach ($corrugados as $corrugado)
  <tr>
  <td>{{ $corrugado['nombre'] }}</td>
  <td>
  @if ($corrugado['descripcion'] != NULL)
    {{ $corrugado['descripcion'] }}
  @else
    No se ha agregrado descripci&oacute;n
  @endif
<td>{!! link_to_route('corrugados.edit', $title = 'Editar', $parameters = $corrugado['id'], $attributes = ['class'=>'btn btn-warning']) !!}</td>
<td><button class="btn btn-primary" onclick="verCantidades({{ $corrugado['id'] }})">Precios</button></td>
<td><button class="btn btn-danger" onclick="eliminar2({{ $corrugado['id'] }},'{{ $corrugado['nombre'] }}','corrugados','El corrugado')">Eliminar</button></td>

  </tr>
  @endforeach
  </table>
@else
  <hr>
  <center><b><p>Aun no se han agregado corrugados</p></b></center>
  <hr>
@endif
@stop


