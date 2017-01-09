@extends('master')

@section('title', 'Agregados')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<h3>Agregados de Payloaders</h3>
<div>
  <a class="btn btn-info" href="agregados.create">Generar Agregado</a>  
</div>
  <br /><br />
@if (!$agregados->isEmpty())
    <table class="table table-bordered table-striped indice">
    	<thead>
    		<th>Nombre</th>
        <th>Acci&oacute;n</th>
        <th>Acci&oacute;n</th>
    	</thead>

    @foreach ($agregados as $agregado)
    <tr>
    <td>{{ $agregado['nombre'] }}</td>
    <td>{!! link_to_route('agregados.edit', $title = 'Editar', $parameters = $agregado['id'], $attributes = ['class'=>'btn btn-warning']) !!}</td>
    <td><button class="btn btn-danger" onclick="eliminar2({{ $agregado['id'] }},'{{ $agregado['nombre'] }}','agregados','El agregado')">Eliminar</button></td>

    </tr>
    @endforeach
    </table>
@else
  <hr>
  <center><b><p>Aun no se han agregado agregados</p></b></center>
  <hr>
@endif
@stop


