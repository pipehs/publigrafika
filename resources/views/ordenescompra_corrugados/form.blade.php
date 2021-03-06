<div class="form-group">
	{!!Form::label('Cliente',null,['class'=>'col-sm-4 control-label'])!!}
	<div class="col-sm-5">
		<select style="width:100%;" name="cliente_id" class="chosen-select" required>
		<option value="" selected disabled>- Seleccione -</option>
		@foreach ($clientes as $id=>$name)
				@if ($cotizacion->cliente_id == $id)
					<option value="{{ $id }}" selected>{{ $name }}</option>
				@else
					<option value="{{ $id }}">{{ $name }}</option>
				@endif
		@endforeach
		</select>
	</div>
</div>

<div class="form-group">
	{!!Form::label('Vendedor',null,['class'=>'col-sm-4 control-label'])!!}
	<div class="col-sm-5">
		<select style="width:100%;" name="vendedor_id" required>
		<option value="" selected disabled>- Seleccione -</option>
		@foreach ($vendedores as $id=>$name)
				@if ($cotizacion->vendedor_id == $id)
					<option value="{{ $id }}" selected>{{ $name }}</option>
				@else
					<option value="{{ $id }}">{{ $name }}</option>
				@endif
		@endforeach
		</select>
	</div>
</div>

<div class="form-group">
	{!!Form::label('Corrugado',null,['class'=>'col-sm-4 control-label'])!!}
	<div class="col-sm-5">
		<select style="width:100%;" name="corrugado_id" required>
		<option value="" selected disabled>- Seleccione -</option>
		@foreach ($corrugados as $id=>$name)
				@if ($cotizacion->corrugado_id == $id)
					<option value="{{ $id }}" selected>{{ $name }}</option>
				@else
					<option value="{{ $id }}">{{ $name }}</option>
				@endif
		@endforeach
		</select>
	</div>
</div>

<div class="form-group">
	{!!Form::label('Cantidad',null,['class'=>'col-sm-4 control-label'])!!}
	<div class="col-sm-5">
		<input type="number" style="width:100%;" value="{{$cotizacion->cantidad}}" name="cantidad" min="1" required>
	</div>
</div>

<div class="form-group">
	{!!Form::label('Precio',null,['class'=>'col-sm-4 control-label'])!!}
	<div class="col-sm-5">
		<input type="number" style="width:100%;" value="{{$cotizacion->precio}}" name="precio" min="1" required>
	</div>
</div>

<div class="form-group">
	{!!Form::label('Forma de pago',null,['class'=>'col-sm-4 control-label'])!!}
	<div class="col-sm-5">
		<select style="width:100%;" name="forma_pago_id" required>
		<option value="" selected disabled>- Seleccione -</option>
		@foreach ($formas_pago as $id=>$name)
				@if ($cotizacion->forma_pago_id == $id)
					<option value="{{ $id }}" selected>{{ $name }}</option>
				@else
					<option value="{{ $id }}">{{ $name }}</option>
				@endif
		@endforeach
		</select>
	</div>
</div>

<div id="ver_date" class="form-group">
	{!!Form::label('Fecha entrega',null,['class'=>'col-sm-4 control-label'])!!}
	<div class="col-sm-5">
		{!!Form::date('fecha_entrega',null,['class'=>'form-control','onblur'=>'validarFechaMayorActual(this.value)'])!!}
	</div>
</div>	

<div class="form-group">
	{!!Form::label('Comentarios',null,['class'=>'col-sm-4 control-label'])!!}
	<div class="col-sm-5">
		{!!Form::textarea('comentarios',null,['id'=>'comentarios','class'=>'form-control','rows'=>'3','cols'=>'4'])!!}
	</div>
</div>

 <div class="form-actions">
    {!!Form::submit('Guardar', ['class'=>'btn btn-primary','id' => 'submit', 'name' => 'submit'])!!}

    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

    {!!Form::submit('Terminar orden', ['class'=>'btn btn-success','id' => 'submit2','name' => 'submit2'])!!}
  </div>

  <div class="form-actions">
    {!! link_to('', $title = 'Volver', $attributes = ['class'=>'btn btn-danger', 'onclick' => 'history.back()'])!!}
  </div>