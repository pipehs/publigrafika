@extends('master')

@section('title', '&Oacute;rdenes de compra payloaders')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<h3 class="title">&Oacute;rdenes de compra payloaders</h3>
    <br /><br />
<h4><b>&Oacute;rdenes de compra</b></h4>
@if (!empty($ordenes))
  <table class="table table-bordered table-striped indice">
    <thead>
      <th>Fecha de solicitud</th>
      <th>Estimaci&oacute;n de entrega</th>
      <th>Nombre payloader</th>
      <th>Descripci&oacute;n</th>
      <th>Agregados</th>
      <th>Cliente</th>
      <th>Cantidad</th>
      <th>Valor cotizaci&oacute;n</th>
      <th>Glosa</th>
      <th>PDF Cotizaci&oacute;n</th>
      <th>Acción</th>
    </thead>

  @foreach ($ordenes as $orden)
  <tr>
      <td>{{ $orden['created_at'] }}</td>
      <td>{{ $orden['fecha_entrega'] }}</td>
      <td>{{ $orden['nombre'] }}</td>
      <td>{{ $orden['descripcion'] }}</td>
      <td><ul>
      @foreach ($orden['agregados'] as $a)
          <li>{{ $a->nombre }}</li>
      @endforeach
      </ul></td>
      <td>{{ $orden['cliente'] }}</td>
      <td>{{ $orden['cantidad'] }}</td>
      <td>{{ $orden['precio'] }}</td>
      <td>{{ $orden['comentarios'] }}</td>
      <td>
      @if ($orden['estado_origin'] == 2)
        <a href="ordenescompra_payloaders.pdf.{{$orden['id']}}" target="_blank"><img src="img/pdf2.png" width="30" height="30" /></a></td>
      @else
        Debe terminar la orden para poder generar PDF
      @endif
      </td>
      <td>
      @if ($orden['estado_origin'] == 1)
        {!! link_to_route('ordenescompra_payloaders.edit', $title = 'Editar Orden', $parameters = $orden['id'], $attributes = ['class'=>'btn btn-success']) !!}
      @else
        Orden de compra terminada
      @endif</td>
  </tr>
  @endforeach
  </table>
@else
  <hr>
  <center><b><p>Aun no se han generado &oacute;rdenes de compra de payloaders</p></b></center>
  <hr>
@endif
<br/><br/>
<h4><b>Cotizaciones sin orden generada</b></h4>
@if (!empty($cotizaciones))
  <table class="table table-bordered table-striped indice">
  	<thead>
  		<th>Fecha de solicitud</th>
      <th>Estimaci&oacute;n de entrega</th>
      <th>Nombre payloader</th>
      <th>Descripci&oacute;n</th>
      <th>Agregados</th>
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
      <td>{{ $cotizacion['descripcion'] }}</td>
      <td><ul>
      @foreach ($cotizacion['agregados'] as $a)
          <li>{{ $a->nombre }}</li>
      @endforeach
      </ul></td>
      <td>{{ $cotizacion['cliente'] }}</td>
      <td>{{ $cotizacion['cantidad'] }}</td>
      <td>{{ $cotizacion['precio'] }}</td>
      <td>{{ $cotizacion['comentarios'] }}</td>
      <td><a href="cotizaciones_payloaders.pdf.{{$cotizacion['id']}}" target="_blank"><img src="img/pdf2.png" width="30" height="30" /></a></td>
      <td>{!! link_to_route('ordenescompra_payloaders.create', $title = 'Generar Orden', $parameters = $cotizacion['id'], $attributes = ['class'=>'btn btn-primary']) !!}</td>
  </tr>
  @endforeach
  </table>
@else
  <hr>
  <center><b><p>Aun no se han agregado cotizaciones de payloaders</p></b></center>
  <hr>
@endif
@stop


