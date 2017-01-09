<div class="form-group">
  {!!Form::label('Nombre (tipo)',null,['class'=>'col-sm-4 control-label'])!!}
  <div class="col-sm-4">
    {!!Form::text('nombre',null,['id'=>'nombre','class'=>'form-control','required'=>'true'])!!}
  </div>
</div>

<div class="form-group">
  {!!Form::label('Descripci&oacute;n',null,['class'=>'col-sm-4 control-label'])!!}
  <div class="col-sm-4">
    {!!Form::textarea('descripcion',null,['id'=>'descripcion','class'=>'form-control','rows'=>'3','cols'=>'4'])!!}
  </div>
</div>

  <div class="form-actions">
    {!!Form::submit('Guardar', ['class'=>'btn btn-success'])!!}
  </div>

  <div class="form-actions">
    {!! link_to('', $title = 'Volver', $attributes = ['class'=>'btn btn-danger', 'onclick' => 'history.back()'])!!}
  </div>