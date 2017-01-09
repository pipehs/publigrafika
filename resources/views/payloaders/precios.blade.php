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

<h3>Payloader: {{ $payloader['nombre'] }} {{ $payloader['largo'] }}x{{ $payloader['ancho']}} {{$payloader['bandejas'] }} bandejas</h3>
<br\>
<p>En esta secci&oacute;n podr&aacute; gestionar los precios para las distintas cantidades del payloader seleccionado.</p>
<div>
	<a class="btn btn-success pull-left" href="payloaders.create_precio.{{ $payloader['id'] }}">Agregar Nuevo precio</a>
    <br /><br />
</div>
<table class="table table-bordered table-striped indice">
	<thead>
		<th>Cantidad m&iacute;nima</th>
    <th>Cantidad m&aacute;xima</th>
    <th>Precio base</th>
    <th>Acción</th>
	</thead>

@foreach ($rows as $row)
<tr>
<td>{{ $row['cantidad_min'] }}</td>
<td>{{ $row['cantidad_max'] }}</td>
<td>{{ $row['precio'] }}</td>
<td>{!! link_to_route('payloaders.edit_precio', $title = 'Editar', $parameters = $row['id'], $attributes = ['class'=>'btn btn-warning']) !!}</td>


</tr>
@endforeach
</table>

<center>
  {!! link_to_route('payloaders.index', $title = 'Volver', $parameters = NULL, $attributes = ['class'=>'btn btn-danger'])!!}
</center>
@stop


