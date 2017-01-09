@extends('master')

@section('title', 'Corrugados')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<h3>Tabla de precios Corrugados</h3>

    <br />
@if (!$corrugados->isEmpty() && !$cantidades->isEmpty())
  <table class="table table-bordered table-striped indice">
  	<thead>
      <th>Corrugado / Cantidad</th>
      @foreach ($cantidades as $c)
    		<th>{{$c->cantidad}} kgs.</th>
      @endforeach 
  	</thead>

  @foreach ($corrugados as $corrugado)
  <tr>
      <td>{{$corrugado->nombre}}</td>

      @foreach ($cantidades as $c)
        @foreach ($precios_corrugado as $p)

          @if ($p['cantidad_id'] == $c->id && $p['corrugado_id'] == $corrugado->id)
            <td>{{ $p['precio']}}</td>
          @endif
        @endforeach
      @endforeach
  </tr>
  @endforeach
  </table>
@else
  <hr>
  <center><b><p>Aun no se han agregado corrugados o sus precios.</p></b></center>
  <hr>
@endif

<center>
    {!! link_to('', $title = 'Volver', $attributes = ['class'=>'btn btn-danger', 'onclick' => 'history.back()'])!!}
</center>
@stop


