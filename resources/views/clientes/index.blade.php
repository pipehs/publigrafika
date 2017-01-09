@extends('master')

@section('title', 'Clientes')

@section('content')


@if(Session::has('message'))
  <div class="alert alert-success alert-dismissible" role="alert">
  {{ Session::get('message') }}
  </div>
@endif

<h3>Clientes</h3>

<div style="text-align: right;">
 <div class="control-group">
    <label class="control-label" for="usuario">Filtrar</label>
    <div class="controls">
      <select name="perfil" onchange="enviaSelect('clientes',this.value);">
                <option value="0">Seleccione.....</option>
                  <option value="1">Todos</option>
                  <option value="2">Activos</option>
                  <option value="3">No Activos</option>
            </select>
    </div>
  </div>
</div>

div>
  <a class="btn btn-success pull-left" href="clientes.create">Agregar Cliente</a>
    <br /><br />
  <!-- Buscador -->
    <div class="pull-right">
  <?php // form_open(base_url()."clientes/search", array('class' => 'form-search pull-right')); ?>
      <form>
    <input type="text" class="input-medium search-query" name="buscar" placeholder="Buscar" />
    <button type="submit" class="btn">Buscar</button>
    
      </form>
    </div>
    <!-- /Buscador -->

<table class="table table-bordered table-striped indice">
  <thead>
      <th>RUT</th>
      <th>E-Mail</th>
      <th>Vendedor</th>
      <th>Razón Social</th>
      <th>Nombre Fantasía</th>
      <th>Cupo Máximo</th>
      <th>Contactos</th>
      <th>Estado</th>
      <th>Fast Track</th>
      <th>Fecha Última Actualización</th>
        
  </thead>


</table>
@stop
