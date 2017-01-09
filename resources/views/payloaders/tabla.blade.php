@extends('master')

@section('title', 'Corrugados')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<h3>Tabla de precios Payloaders</h3>

    <br />
@if (!$payloaders->isEmpty())

  @foreach ($payloaders as $p)
      <h4><b>{{ $p->nombre.' '.$p->largo.'x'.$p->ancho.' '.$p->bandejas.' bandejas.' }}</b></h4>
      <table class="table table-bordered table-striped indice">
      	<thead>
          <th>Cantidad</th>
          <th>Sin gráfica</th>
          @foreach ($agregados as $a)
        		<th>{{$a->nombre}}</th>
          @endforeach 
      	</thead>

      @foreach ($preciobasecantidad as $preciobase)
      <tr>
        @if ($preciobase->payloader_id == $p->id)
          <td>{{$preciobase->cantidad_min}}-{{$preciobase->cantidad_max}}</td>
          <td>$ {{$preciobase->precio }}</td>

          @foreach ($agregadopayloader as $a)
            @if ($preciobase->id == $a->preciobasecantidad_id)
              <td>$ {{$a->precio}}</td>
            @endif
          @endforeach
        @endif
      </tr>
      @endforeach
      </table>
  @endforeach
@else
  <hr>
  <center><b><p>Aun no se han agregado payloaders</p></b></center>
  <hr>
@endif

<center>
    {!! link_to('', $title = 'Volver', $attributes = ['class'=>'btn btn-danger', 'onclick' => 'history.back()'])!!}
</center>
@stop


