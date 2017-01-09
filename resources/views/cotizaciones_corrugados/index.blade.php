@extends('master')

@section('title', 'Cotizaciones corrugado')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<h3 class="title">Cotizaciones corrugados</h3>
<div>
	<a class="btn btn-success" href="cotizaciones_corrugado.create">Agregar Solicitud de cotización</a>
</div>
    <br /><br />
@if (!empty($cotizaciones))
  <table class="table table-bordered table-striped indice">
  	<thead>
  		<th>Fecha de solicitud</th>
      <th>Estimaci&oacute;n de Entrega</th>
      <th>Tipo corrugado</th>
      <th>Cliente</th>
  		<th>Cantidad</th>
      <th>Valor cotizaci&oacute;n</th>
      <th>Comentarios</th>
      <th>PDF Cotizaci&oacute;n</th>
      <th>Acción</th>
  	</thead>

  @foreach ($cotizaciones as $cotizacion)
  <tr>
      <td>{{ $cotizacion['created_at'] }}</td>
      <td>{{ $cotizacion['fecha_entrega'] }}</td>
      <td>{{ $cotizacion['nombre'] }}</td>
      <td>{{ $cotizacion['cliente'] }}</td>
      <td>{{ $cotizacion['cantidad'] }}</td>
      <td>{{ $cotizacion['precio'] }}</td>
      <td>{{ $cotizacion['comentarios'] }}</td>
      <td><a href="cotizaciones_corrugado.pdf.{{$cotizacion['id']}}" target="_blank"><img src="img/pdf2.png" width="30" height="30" /></a></td>
      <td>{!! link_to_route('cotizaciones_corrugado.edit', $title = 'Editar', $parameters = $cotizacion['id'], $attributes = ['class'=>'btn btn-primary']) !!}</td>
  </tr>
  @endforeach
  </table>
@else
  <hr>
  <center><b><p>Aun no se han agregado cotizaciones de corrugados</p></b></center>
  <hr>
@endif
@stop


