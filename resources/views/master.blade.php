<!DOCTYPE html>
<html lang="es">
	<head>
		<title>..:: Control de Gestión - Industrias Grau ::..  - @yield('title') {{ date('Y') }}</title>
		<meta charset="utf-8" />
      	<link rel="shortcut icon" href="img/favicon.ico" />
      	<meta name="language" content="Spanish" />
		<meta name="copyright" content="Industrias Grau" />
     	<meta name="designer" content="Felipe Herrera Seguel" />
    	<meta name="author" content="Felipe Herrera Seguel" />
		
		{!!Html::style('css/bootstrap-cerulean.min.css')!!}
		{!!Html::style('css/tablebootstrap/dist/bootstrap-table.css')!!}
		{!!Html::style('css/admin.css')!!}
		{!!Html::style('css/app.css')!!}
		{!!Html::style('css/estilos.css')!!}
		{!!Html::style('css/bootstrap.css')!!}
		{!!Html::style('css/chosen.css')!!}
		{!!Html::style('css/chosen.min.css')!!}
		{!!Html::style('plugins/sweetalert-master/dist/sweetalert.css')!!}

		{!!Html::script('js/jquery-1.8.3.min.js')!!}
		{!!Html::script('js/reloj.js')!!}
		{!!Html::script('js/bootstrap.min.js')!!}
		{!!Html::script('css/tablebootstrap/dist/bootstrap-table.js')!!}
		{!!Html::script('js/funciones.js')!!}
		{!!Html::script('js/scripts.js')!!}
		{!!Html::script('plugins/sweetalert-master/dist/sweetalert.min.js')!!}
		{!!Html::script('js/chosen.jquery.js')!!}
		{!!Html::script('js/chosen.jquery.min.js')!!}
		{!!Html::script('js/chosen.proto.js')!!}
		{!!Html::script('js/chosen.proto.min.js')!!}

	
        
	</head>
        
<body>
<div class="container" id="contenedor">

@include('header')


<div id="contenidos">      
	@yield('content')
</div>

@include('footer')
</div>

@yield('scripts2')