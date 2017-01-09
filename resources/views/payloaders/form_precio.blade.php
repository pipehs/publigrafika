<div class="form-group">
  {!!Form::label('Cantidad mínima',null,['class'=>'col-sm-4 control-label'])!!}
  <div class="col-sm-2">
    {!!Form::number('cantidad_min',null,['id'=>'cantidad_min','min'=>'1','class'=>'form-control','required'=>'true'])!!}
  </div>
</div>

<div class="form-group">
  {!!Form::label('Cantidad máxima',null,['class'=>'col-sm-4 control-label'])!!}
  <div class="col-sm-2">
    {!!Form::number('cantidad_max',null,['id'=>'cantidad_max','class'=>'form-control','required'=>'true'])!!}
  </div>
</div>

<div class="form-group">
  {!!Form::label('Precio',null,['class'=>'col-sm-4 control-label'])!!}
  <div class="col-sm-2">
    {!!Form::number('precio',null,['id'=>'precio','class'=>'form-control','required'=>'true'])!!}
  </div>
</div>
  
{!!Form::hidden('payloader_id',$id)!!}

  <div class="form-actions">
    {!!Form::submit('Guardar', ['class'=>'btn btn-success'])!!}
  </div>

  <div class="form-actions">
    {!! link_to('', $title = 'Volver', $attributes = ['class'=>'btn btn-danger', 'onclick' => 'history.back()'])!!}
  </div>