@extends('master')

@section('title', 'Precios de Corrugado')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<h3>Corrugado: {{$corrugado['nombre']}}</h3>
<br/>
Ingrese o modifique los precios para las cantidades ingresadas previamente.
<hr>
{!!Form::open(['route'=>'corrugados.store_precio','method'=>'POST','class'=>'form-horizontal'])!!}

 
  @foreach($cantidades as $c)
     <?php $ver = 0; //verificador si existe precio ?>
    <div class="form-group">
      <label for="precio_{{$c->id}}" class="col-sm-4 control-label"> Precio para {{$c->cantidad}} kg.</label>
      <div class="col-sm-2">
        
        @foreach ($precio_corrugado as $p)
          @if ($p->cantidad_id == $c->id)
            <input type="number" class="form-control" name="cantidad_{{$c->id}}" value="{{$p->precio}}">
            <?php $ver += 1; break; ?>
          @endif
        @endforeach
        @if ($ver == 0)
            <input type="number" class="form-control" name="cantidad_{{$c->id}}" required>
        @endif
      </div>
    </div>
  @endforeach

<hr>
  
    {!!Form::hidden('corrugado_id',$corrugado['id'])!!}
    <div class="form-actions">
      {!!Form::submit('Guardar', ['class'=>'btn btn-success'])!!}
    </div>

  <div class="form-actions">
    {!! link_to('', $title = 'Volver', $attributes = ['class'=>'btn btn-danger', 'onclick' => 'history.back()'])!!}
  </div>

{!!Form::close()!!}

@stop
