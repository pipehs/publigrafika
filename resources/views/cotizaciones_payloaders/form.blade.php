<div class="form-group">
	{!!Form::label('Cliente',null,['class'=>'col-sm-4 control-label'])!!}
	<div class="col-sm-5">
		<select style="width:100%;" name="cliente_id" class="chosen-select" required>
		<option value="" selected disabled>- Seleccione -</option>
		@foreach ($clientes as $id=>$name)
			@if (strstr($_SERVER["REQUEST_URI"],'edit'))
				@if ($cotizacion->cliente_id == $id)
					<option value="{{ $id }}" selected>{{ $name }}</option>
				@else
					<option value="{{ $id }}">{{ $name }}</option>
				@endif
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
			@if (strstr($_SERVER["REQUEST_URI"],'edit'))
				@if ($cotizacion->vendedor_id == $id)
					<option value="{{ $id }}" selected>{{ $name }}</option>
				@else
					<option value="{{ $id }}">{{ $name }}</option>
				@endif
			@else
				<option value="{{ $id }}">{{ $name }}</option>
			@endif
		@endforeach
		</select>
	</div>
</div>

<div class="form-group">
	{!!Form::label('Payloader',null,['class'=>'col-sm-4 control-label'])!!}
	<div class="col-sm-5">
		<select style="width:100%;" name="payloader_id" required>
		<option value="" selected disabled>- Seleccione -</option>
		@foreach ($payloaders as $p)
			@if (strstr($_SERVER["REQUEST_URI"],'edit'))
				@if ($cotizacion->payloader_id == $p->id)
					<option value="{{ $p->id }}" selected>{{ $p->nombre }} {{ $p->ancho }}x{{ $p->largo }} {{ $p->bandejas }} bandejas</option>
				@else
					<option value="{{ $p->id }}">{{ $p->nombre }} {{ $p->ancho }}x{{ $p->largo }} {{ $p->bandejas }} bandejas</option>
				@endif
			@else
				<option value="{{ $p->id }}">{{ $p->nombre }} {{ $p->ancho }}x{{ $p->largo }} {{ $p->bandejas }} bandejas</option>
			@endif
		@endforeach
		</select>
	</div>
</div>

<div class="form-group">
  {!!Form::label('Cantidad',null,['class'=>'col-sm-4 control-label'])!!}
  <div class="col-sm-5">
    {!!Form::number('cantidad',null,['id'=>'nombre','class'=>'form-control','required'=>'true','min'=>'1'])!!}
  </div>
</div>

<div class="form-group">
	{!!Form::label('Comentarios',null,['class'=>'col-sm-4 control-label'])!!}
	<div class="col-sm-5">
		{!!Form::textarea('glosa',null,['id'=>'glosa','class'=>'form-control','rows'=>'3','cols'=>'4'])!!}
	</div>
</div>

<h5><b><center>Opcionalmente seleccione los agregados que desee</center></b></h5>

@foreach ($agregados as $add)
<?php $cont = 0; ?>
<div class="form-group">
		<label for="agregados" class="col-sm-4 control-label">{{ $add->nombre }}</label>
		<div class="col-sm-5">
		@if (strstr($_SERVER["REQUEST_URI"],'edit'))
			@foreach ($agregados_cotizacion as $add2)
				@if ($add2->id == $add->id)
					<?php $cont = 1; ?>
				@endif
			@endforeach
			@if ($cont == 1)
				<input type="checkbox" id="{{ $add->id }}" name="agregados[]" value="{{ $add->id }}" checked>
			@else
				<input type="checkbox" id="{{ $add->id }}" name="agregados[]" value="{{ $add->id }}">
			@endif
		@else
			<input type="checkbox" id="{{ $add->id }}" name="agregados[]" value="{{ $add->id }}">
		@endif 
		</div>
</div>
@endforeach

<div class="form-group">
	{!!Form::label('Forma de pago',null,['class'=>'col-sm-4 control-label'])!!}
	<div class="col-sm-5">
		<select style="width:100%;" name="forma_pago_id" required>
		<option value="" selected disabled>- Seleccione -</option>
		@foreach ($formas_pago as $id=>$name)
			@if (strstr($_SERVER["REQUEST_URI"],'edit'))
				@if ($cotizacion->forma_pago_id == $id)
					<option value="{{ $id }}" selected>{{ $name }}</option>
				@else
					<option value="{{ $id }}">{{ $name }}</option>
				@endif
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

 <div class="form-actions">
    {!!Form::submit('Guardar', ['class'=>'btn btn-success'])!!}
  </div>

  <div class="form-actions">
    {!! link_to('', $title = 'Volver', $attributes = ['class'=>'btn btn-danger', 'onclick' => 'history.back()'])!!}
  </div>