<div class="form-group">
  {!!Form::label('Nombre agregado',null,['class'=>'col-sm-4 control-label'])!!}
  <div class="col-sm-4">
    {!!Form::text('nombre',null,['id'=>'nombre','class'=>'form-control','required'=>'true'])!!}
  </div>
</div>

<p style="padding-left: 7%;">Ahora deber&aacute; ingresar el precio del agregado para cada uno de los payloaders.</p>
<hr>
@foreach ($payloaders as $p)
    <h4 style="padding-left: 7%;"><b><u>{{ $p['nombre'].' '.$p['largo'].'x'.$p['ancho'].' '.$p['bandejas'].' bandejas' }}</u></b></h4>

    @foreach ($p['cantidades'] as $c)
      @if (isset($precios))
        @foreach ($precios as $p)
          @if ($p->preciobasecantidad_id == $c->id)
              <div class="form-group">
                <label for="precio" class="col-sm-4 control-label">Precio de {{ $c->cantidad_min }} a {{ $c->cantidad_max }}</label>
                <div class="col-sm-4">
                  <input type="number" class="form-control" required name="precio_{{$c->id}}" value="{{$p->precio}}">
                </div>
              </div>
          @endif
        @endforeach
      @else
        <div class="form-group">
          <label for="precio" class="col-sm-4 control-label">Precio de {{ $c->cantidad_min }} a {{ $c->cantidad_max }}</label>
          <div class="col-sm-4">
            <input type="number" class="form-control" required name="precio_{{$c->id}}">
          </div>
        </div>
      @endif
    @endforeach
    <hr>
@endforeach


    

  <div class="form-actions">
    {!!Form::submit('Guardar', ['class'=>'btn btn-success'])!!}
  </div>

  <div class="form-actions">
    {!! link_to('', $title = 'Volver', $attributes = ['class'=>'btn btn-danger', 'onclick' => 'history.back()'])!!}
  </div>