	<div class="page-header">
      	<a class="logo" href="{{ $_SERVER['PHP_SELF'] }}" title="Empresas Grau"><img src="img/logo_grau.png" width="150" height="50" /></a>
      </div>
                 <p>
        <h5 style="text-align: right;">
        <span>{{ date('Y-m-d') }}</span> || <span id="spanreloj"></span> || 
                                Bienvenid@ <span class="label label-info"><?php //echo $this->session->userdata('nombre')?></span>
    
                                   
        </h5>
    </p>
  @include('menu')


