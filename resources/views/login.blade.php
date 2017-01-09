<!DOCTYPE html>
<html lang="es">
	<head>
	@section('title', 'Ingreso al sistema')
		<meta charset="utf-8" />
        <link rel="shortcut icon" href="<?php echo base_url(); ?>public/backend/img/favicon.ico" />
       <meta name="language" content="Spanish" />
	<meta name="copyright" content="www.cesarcancino.com" />
      <meta name="designer" content="César Cancino Zapata" />
    <meta name="author" content="www.cesarcancino.com" />
		<link rel="shortcut icon" href="<?php echo base_url(); ?>public/backend/img/favicon.ico" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/bootstrap-cerulean.min.css" />
		<link rel="stylesheet" href="<?php echo base_url(); ?>public/backend/css/admin.css" />
		<script src="<?php echo base_url(); ?>public/backend/js/jquery-1.8.1.min.js"></script>
        <script src="<?php echo base_url(); ?>public/backend/js/jquery-ui-1.9.0.custom.min.js"></script>
		<script src="<?php echo base_url(); ?>public/backend/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>public/backend/js/funciones.js"></script>
		<!--[if IE 7]>
			<script src="<?php echo base_url(); ?>public/backend/js/backend/admin-ie7.js"></script>
		<![endif]-->		

	</head>
	<body>
		<div class="container" id="contenedor">
            
			<div class="page-header">
       <a class="logo" href="<?php echo base_url(); ?>" title="Empresas Grau"><img src="<?php echo base_url(); ?>public/backend/img/logo_grau.png" width="150" height="50" /></a>
      </div>
			
           <div class="navbar admin-menu">
	<div class="navbar-inner">
		<ul class="nav">

			
    <li class="dropdown <?php echo (in_array($this->router->class, array('usuarios')) ? 'active' : ''); ?>">
				<a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo  base_url(); ?>usuarios">
					Usuarios <b class="caret"></b>
				</a>
				<ul class="dropdown-menu">
					<li><a href="<?php echo  base_url(); ?>usuarios/login" id="dropdown_ususarios" title="Login">Login</a></li>
				</ul>
			</li>
    
            
           
		
<ul class="nav pull-right">
			<li class="divider-vertical pull-right"></li>
			<li class=""><a href="http://www.grauindus.cl/" title="Sitio Web">Sitio Web</a></li>
		</ul>
</ul>
	</div>
</div>

			
@section('content')

@stop
        <!--footer-->
  @include('footer')           
  <!--fin footer-->

	
		

	</body>
</html>