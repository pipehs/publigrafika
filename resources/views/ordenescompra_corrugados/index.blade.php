@extends('master')

@section('title', 'Órdenes de compra corrugado')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<h3 class="title">&Oacute;rdenes de compra corrugados</h3>

A continuaci&oacute;n podr&aacute; observar una lista con todas las ordenes de compra y cotizaciones generadas en el sistema. A trav&eacute;s de &eacute;stas, podr&aacute; generar, editar o ver las &oacute;rdenes de compra generadas.
    <br /><br />

<h4><b>&Oacute;rdenes de compra</b></h4>
@if (!empty($ordenes))
  <table class="table table-bordered table-striped indice">
    <thead>
      <th>Fecha de solicitud</th>
      <th>Estimaci&oacute;n de Entrega</th>
      <th>Tipo corrugado</th>
      <th>Cliente</th>
      <th>Cantidad</th>
      <th>Valor orden</th>
      <th>Comentarios</th>
      <th>PDF orden</th>
      <th>Acción</th>
    </thead>

  @foreach ($ordenes as $orden)
  <tr>
      <td>{{ $orden['created_at'] }}</td>
      <td>{{ $orden['fecha_entrega'] }}</td>
      <td>{{ $orden['nombre'] }}</td>
      <td>{{ $orden['cliente'] }}</td>
      <td>{{ $orden['cantidad'] }}</td>
      <td>{{ $orden['precio'] }}</td>
      <td>{{ $orden['comentarios'] }}</td>
      <td>
      @if ($orden['estado_origin'] == 2)
        <a href="cotizaciones_corrugado.pdf.{{$orden['id']}}" target="_blank"><img src="img/pdf2.png" width="30" height="30" /></a></td>
      @else
        Debe terminar la orden para poder generar PDF
      @endif
      <td>
      @if ($orden['estado_origin'] == 1)
        {!! link_to_route('ordenescompra_corrugado.edit', $title = 'Editar orden', $parameters = $orden['id'], $attributes = ['class'=>'btn btn-success']) !!}
      @else
        Orden de compra terminada
      @endif
      </td>
  </tr>
  @endforeach
  </table>
@else
  <hr>
  <center><b><p>No existen cotizaciones sin orden de compra generada, o aun no se crea ninguna cotizaci&oacute;n</p></b></center>
  <hr>
@endif
<br/><br/>
<h4><b>Cotizaciones sin orden generada</b></h4>
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
      <td>{!! link_to_route('ordenescompra_corrugado.create', $title = 'Generar orden', $parameters = $cotizacion['id'], $attributes = ['class'=>'btn btn-primary']) !!}
      </td>
  </tr>
  @endforeach
  </table>
@else
  <hr>
  <center><b><p>No existen cotizaciones sin orden de compra generada, o aun no se crea ninguna cotizaci&oacute;n</p></b></center>
  <hr>
@endif
@stop


