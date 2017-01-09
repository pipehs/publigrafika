@if (!$cantidades->isEmpty())
  @foreach($cantidades as $c)
    <div class="form-group">
      {!!Form::label('Cantidad en kg',null,['class'=>'col-sm-4 control-label'])!!}
      <div class="col-sm-2">
        <input type="number" class="form-control" required name="cantidad_{{$c->id}}" value="{{$c->cantidad}}">
      </div>
    </div>
  @endforeach
@endif
<hr>
    <div class="form-group">
      {!!Form::label('Cantidad en kg 1',null,['class'=>'col-sm-4 control-label'])!!}
      <div class="col-sm-2">
        <input type="number" class="form-control" required name="newcantidad_1">
      </div>
    </div>

    <div id="mascantidades"></div>

    <div class="form-group">
         <div class="col-sm-2"></div>
         <div class="col-sm-4">
        <button type="button" class="btn btn-primary" onclick='masCantidades()'>Más cantidades</button>
        </div>
    </div>

    <div class="form-actions">
      {!!Form::submit('Guardar', ['class'=>'btn btn-success'])!!}
    </div>

  <div class="form-actions">
    {!! link_to('', $title = 'Volver', $attributes = ['class'=>'btn btn-danger', 'onclick' => 'history.back()'])!!}
  </div>
