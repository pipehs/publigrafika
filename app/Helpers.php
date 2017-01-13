<?php

function corrugadoPdf($element,$element_name,$id,$is_orden)
{
	if ($element->vendedor_id == NULL)
			{
				$vendedor = new stdClass();

				$vendedor->nombre = '';
				$vendedor->correo = '';
			}
			else
			{
				$vendedor = \App\User::find($element->vendedor_id); 
			}

			if ($element->cliente_id == NULL)
			{
				$dir = '';
				$comuna = '';
				$ciudad = '';
			}

			else
			{
				$cliente = \App\Cliente::find($element->cliente_id); 

				if ($cliente->direccion == '' || $cliente->direccion == NULL)
				{
					$dir = 'Sin dirección';
				}
				else
				{
					$dir = $cliente->direccion;
				}

				$c = DB::table('comuna')->where('id','=',$cliente->id_comuna)->first();
				$comuna = $c->nombre;
				$ci = DB::table('ciudades')->where('id','=',$cliente->id_ciudad)->first();
				$ciudad = $ci->nombre;
			}

			if ($is_orden == 1)
			{
				$cantidad = $element->cantidad;
				$precio = $element->precio;
			}
			else
			{
				$cantidad = \App\Cantidad::find($element->cantidad_id);
				$cantidad = $cantidad->cantidad;
				$precio = \App\Corrugado::getPrecio($cantidad->id,$corrugado->id);
			}
				
			$corrugado = \App\Corrugado::find($element->corrugado_id);
	        
	        if ($element->forma_pago_id == NULL)
	        {
	        	$forma_pago = '';
	        }
	        else
	        {
	        	$f = \App\FormaPago::find($element->forma_pago_id);
	        	$forma_pago = $f->forma_pago;
	        }

	        //configuramos plazo fecha entrega
	        if ($element->fecha_entrega == NULL)
	        {
	        	$plazo = 'No definido los';
	        }
	        else
	        {
	        	$fecha = $element->fecha_entrega;
				$segundos=strtotime($fecha) - strtotime(date('Y-m-d'));
				$plazo = intval($segundos/60/60/24);
	        }
	        
	        $cuerpo='<!doctype html>
	            			<html> 
	                        <head>
	                        <meta charset="utf-8" />
	                        
	            <style type="text/css">
	                .tabla
	                {
	                     border: #000000; border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; width: 720px;
	                }
	            </style>
	                        </head>
	            			<body>';
	                     
	                $cuerpo.='<table style="width: 1050px;">';
	                $cuerpo.='
	                <tr>
	                    <td style="text-align: center;"><h1>Publigrafika Ltda.</h1></td>
	                </tr>';        
	        $cuerpo.='    <tr>
	                    <td colspan="3">
	                        RUT 79.897.500-5
	                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	                        <span style="text-decoration:underline;">PRESUPUESTO</span> N° '.$id.'
	                    </td>
	                </tr>';   
	                 $cuerpo.='    <tr>
	                    <td colspan="3">
	                        SEÑORES
	                        <br />
	                        '.$cliente->razon_social.'
	                    </td>
	                </tr>'; 
	                $cuerpo.='    <tr>
	                    <td colspan="3">
	                         &nbsp;
	                    </td>
	                </tr>';    
	                 $cuerpo.='    <tr>
	                    <td colspan="3">
	                         '.$dir.', '.$comuna.', '.$ciudad.'
	                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	                          Rut : '.$cliente->rut.'
	                    </td>
	                </tr>';     
	                $cuerpo.='    <tr>
	                    <td colspan="3">
	                         FONO : '.$cliente->telefono.'
	                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	                          AT :
	                    </td>
	                </tr>';    
	                 $cuerpo.='    <tr>
	                    <td colspan="3">
	                         <br />
	                         DE NUESTRA CONSIDERACIÓN:
	                         <br / >
	                         Tenemos el agrado, de acuerdo a las condiciones estipuladas a continuación, cotizarle lo siguiente:
	                    </td>
	                </tr>';     
	              	$cuerpo.='</table>';
	                $cuerpo.='<table class="tabla">';
	                 $cuerpo.='    <tr>
	                    <td style="width: 150px;">
	                        UNIDADES
	                    </td>
	                    <td style="width: 400px;">
	                    DETALLE
	                    </td>
	                    <td style="width: 150px;">
	                    VALOR UNITARIO
	                    </td>
	                </tr>';     
	                $cuerpo.='<tr>
	                    <td colspan="3"><hr /></td></tr>';
	                 $cuerpo.='    <tr>
	                    <td style="width: 150px;">
	                        '.$cantidad.'
	                    </td>
	                    <td style="width: 400px;">
	                        Corrugado '.$corrugado->nombre.'
	                    </td>
	                    <td style="width: 150px;">
	                    '.$precio.'
	                    </td>
	                </tr>'; 
	                $cuerpo.='<tr>
	                    <td colspan="3">
	                        <br /><br /><br /><br /><br /><br />
	                    </td>
	                    </tr>'; 
	                    $cuerpo.='</table>';
	                    $cuerpo.='<table class="tabla">';
	                 $cuerpo.='<tr>
	                    <td colspan="3"><hr /></td></tr>';
	                $cuerpo.='    <tr>
	                    <td>
	                        <span style="text-decoration:underline;; font-weight: bold;">CONDICIONES DE VENTA</spaN>
	                    </td>
	                    <td>
	                    &nbsp;
	                    </td>
	                    <td>
	                    &nbsp;
	                    </td>
	                </tr>'; 
	                $cuerpo.='<tr>
	                    <td colspan="3"><hr /></td></tr>   
	                    <tr>
	                    <td>
	                        - PRECIOS NETOS MÁS I.V.A
	                        <br />
	                        - FORMA DE PAGO : '.$forma_pago.'
	                        <br />
	                        - VARIACIONES DE CANTIDADES +-10%
	                    </td>
	                    <td>
	                    &nbsp;
	                    </td>
	                    <td>
	                    - FORMA DE ENTREGA : 
	                        <br />
	                        - PLAZO DE ENTREGA : '.$plazo.' Días
	                        <br />
	                        - VALIDEZ DE PRESUPUESTO : 30 Días
	                        <br / >
	                        - PUESTO EN SANTIAGO
	                    </td>
	                </tr>';   
	                  
	                $cuerpo.='</table>';

	                 $cuerpo.='<table class="tabla">';
	                $cuerpo.='    <tr>
	                    <td><br />
	                        <span style="text-decoration:underline;; font-weight: bold;">COMENTARIOS ESPECIALES</spaN>
	                    </td>
	                    <td>
	                    &nbsp;
	                    </td>
	                    <td>
	                    &nbsp;
	                    </td>
	                </tr>'; 
	                $cuerpo.='  
	                    <tr>
	                    <td colspan="3">
	                       '.$element->comentarios.'
	                    </td>
	                </tr>';   
	                  
	                $cuerpo.='</table>';
	                
	                $cuerpo.='<table style="width: 800px;">';
	                 $cuerpo.='<tr>
	                    <td style=" text-align: left;"><br />
	                        <strong>En espera de una favorable acogida a la presente, atentamente</strong>
	                    </td>
	                    </tr>'; 
	                $cuerpo.='</table>';
	                
	                $cuerpo.='<table style="width:720px;">';
	                 $cuerpo.='<tr>
	                    <td colspan="3">
	                        <hr />
	                        <br /><br /><br /><br />
	                    </td>
	                    </tr>'; 
	                $cuerpo.='    <tr>
	                    <td style=" text-align: center;">
	                        '.strtoupper ($vendedor->nombre).'
	                        <br />
	                        _____________________________
	                        <br />
	                        <center><span style="font-style: oblique; font-weight: bold;">EJECUTIVO COMERCIAL</span></center>
	                    </td>
	                     <td style=" text-align: center;">
	                        &nbsp;
	                        <br />
	                        _____________________________
	                        <br />
	                        <center><span style="font-style: oblique; font-weight: bold;">ACEPTADO</span></center>
	                    </td>
	                     <td style=" text-align: center;">
	                      JUAN TAPIA ESKER
	                        <br />
	                        _____________________________
	                        <br />
	                       <center> <span style="font-style: oblique; font-weight: bold;">GERENTE COMERCIAL</span></center>
	                    </td>
	                </tr>'; 
	                $cuerpo.='<tr>
	                    <td colspan="3">
	                        <br /><br />
	                    </td>
	                    </tr>'; 
	                    $cuerpo.='<tr>
	                    <td colspan="3" style=" text-align: center; ">
	                        JUAN FCO. RIVAS 9435 FONOS : 495 95 00 FAX 495 95 10
	                        <br />
	                        LA CISTERNA - SANTIAGO
	                    </td>
	                    </tr>'; 
	                
	                $cuerpo.='</table>';
	                
	                  $cuerpo.='</body></html>';

	            return $cuerpo;
}

function payloaderPdf($element,$element_name,$id,$is_orden)
{
	if ($element->vendedor_id == NULL)
		{
			$vendedor = new stdClass();

			$vendedor->nombre = '';
			$vendedor->correo = '';
		}
		else
		{
			$vendedor = \App\User::find($element->vendedor_id); 
		}

		if ($element->cliente_id == NULL)
		{
			$dir = '';
			$comuna = '';
			$ciudad = '';
		}

		else
		{
			$cliente = \App\Cliente::find($element->cliente_id); 

			if ($cliente->direccion == '' || $cliente->direccion == NULL)
			{
				$dir = 'Sin dirección';
			}
			else
			{
				$dir = $cliente->direccion;
			}

			$c = DB::table('comuna')->where('id','=',$cliente->id_comuna)->first();
			$comuna = $c->nombre;
			$ci = DB::table('ciudades')->where('id','=',$cliente->id_ciudad)->first();
			$ciudad = $ci->nombre;
		}

		

		if ($is_orden == 1)
		{
			$precio = $element['precio'];
			$agregados = \App\OrdenesCompraPayloader::getAgregados($element['id']);
		}
		else
		{
			//obtenemos precio base segun cantidad, y agregados
			$precio = \App\CotizacionesPayloader::getPrecio($element['cantidad'],$element['payloader_id'],$agregados);
			//obtenemos agregados y sus precios
			$agregados = \App\CotizacionesPayloader::getAgregados($element['id']);
		}

		$payloader = \App\Payloader::find($element['payloader_id']);
        
        if ($element->forma_pago_id == NULL)
        {
        	$forma_pago = '';
        }
        else
        {
        	$f = \App\FormaPago::find($element->forma_pago_id);
        	$forma_pago = $f->forma_pago;
        }

        //configuramos plazo fecha entrega
        if ($element->fecha_entrega == NULL)
        {
        	$plazo = 'No definido los';
        }
        else
        {
        	$fecha = $element->fecha_entrega;
			$segundos=strtotime($fecha) - strtotime(date('Y-m-d'));
			$plazo = intval($segundos/60/60/24);
        }

        $adds = '';
        foreach ($agregados as $a)
        {
            $adds .= '<li>'.$a->nombre.'</li>';
        }
        
        $cuerpo='<!doctype html>
            			<html> 
                        <head>
                        <meta charset="utf-8" />
                        
            <style type="text/css">
                .tabla
                {
                     border: #000000; border-style: solid; border-top-width: 1px; border-right-width: 1px; border-bottom-width: 1px; border-left-width: 1px; width: 720px;
                }
            </style>
                        </head>
            			<body>';
                     
                $cuerpo.='<table style="width: 1050px;">';
                $cuerpo.='
                <tr>
                    <td style="text-align: center;"><h1>Publigrafika Ltda.</h1></td>
                </tr>';        
        $cuerpo.='    <tr>
                    <td colspan="3">
                        RUT 79.897.500-5
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

        if ($is_orden == 1)
        {
        	$cuerpo .= '<span style="text-decoration:underline;">ORDEN DE COMPRA </span> N° '.$id.'';
        }
        else
        {
        	$cuerpo .= '<span style="text-decoration:underline;">PRESUPUESTO</span> N° '.$id.'';
        }
        
        $cuerpo .= '                
                    </td>
                </tr>';   
                 $cuerpo.='    <tr>
                    <td colspan="3">
                        SEÑORES
                        <br />
                        '.$cliente->razon_social.'
                    </td>
                </tr>'; 
                $cuerpo.='    <tr>
                    <td colspan="3">
                         &nbsp;
                    </td>
                </tr>';    
                 $cuerpo.='    <tr>
                    <td colspan="3">
                         '.$dir.', '.$comuna.', '.$ciudad.'
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          Rut : '.$cliente->rut.'
                    </td>
                </tr>';     
                $cuerpo.='    <tr>
                    <td colspan="3">
                         FONO : '.$cliente->telefono.'
                          &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                          AT :
                    </td>
                </tr>';    
                 $cuerpo.='    <tr>
                    <td colspan="3">
                         <br />
                         DE NUESTRA CONSIDERACIÓN:
                         <br / >
                         Tenemos el agrado, de acuerdo a las condiciones estipuladas a continuación, cotizarle lo siguiente:
                    </td>
                </tr>';     
              	$cuerpo.='</table>';
                $cuerpo.='<table class="tabla">';
                 $cuerpo.='    <tr>
                    <td style="width: 150px;">
                        UNIDADES
                    </td>
                    <td style="width: 400px;">
                    DETALLE
                    </td>
                    <td style="width: 150px;">
                    VALOR UNITARIO
                    </td>
                </tr>';     
                $cuerpo.='<tr>
                    <td colspan="3"><hr /></td></tr>';
                 $cuerpo.='    <tr>
                    <td style="width: 150px; vertical-align:top;">
                        '.$element->cantidad.'
                    </td>
                    <td style="width: 400px;">'.$payloader->nombre.' '.$payloader->ancho.'x'.$payloader->largo.' '.$payloader->bandejas.' Bandejas.
                    <br/><u><b>Agregados:</b></u> '.$adds.'
                    </td>
                    <td style="width: 150px; vertical-align:top;">
                    '.$precio.'
                    </td>
                </tr>'; 
                $cuerpo.='<tr>
                    <td colspan="3">
                        <br /><br />
                    </td>
                    </tr>'; 
                    $cuerpo.='</table>';
                    $cuerpo.='<table class="tabla">';
                 $cuerpo.='<tr>
                    <td colspan="3"><hr /></td></tr>';
                $cuerpo.='    <tr>
                    <td>
                        <span style="text-decoration:underline;; font-weight: bold;">CONDICIONES DE VENTA</spaN>
                    </td>
                    <td>
                    &nbsp;
                    </td>
                    <td>
                    &nbsp;
                    </td>
                </tr>'; 
                $cuerpo.='<tr>
                    <td colspan="3"><hr /></td></tr>   
                    <tr>
                    <td>
                        - PRECIOS NETOS MÁS I.V.A
                        <br />
                        - FORMA DE PAGO : '.$forma_pago.'
                        <br />
                        - VARIACIONES DE CANTIDADES +-10%
                    </td>
                    <td>
                    &nbsp;
                    </td>
                    <td>
                    - FORMA DE ENTREGA : 
                        <br />
                        - PLAZO DE ENTREGA : '.$plazo.' Días
                        <br />
                        - VALIDEZ DE PRESUPUESTO : 30 Días
                        <br / >
                        - PUESTO EN SANTIAGO
                    </td>
                </tr>';   
                  
                $cuerpo.='</table>';

                 $cuerpo.='<table class="tabla">';
                $cuerpo.='    <tr>
                    <td><br />
                        <span style="text-decoration:underline;; font-weight: bold;">COMENTARIOS ESPECIALES</spaN>
                    </td>
                    <td>
                    &nbsp;
                    </td>
                    <td>
                    &nbsp;
                    </td>
                </tr>'; 
                $cuerpo.='  
                    <tr>
                    <td colspan="3">
                       '.$element->comentarios.'
                    </td>
                </tr>';   
                  
                $cuerpo.='</table>';
                
                $cuerpo.='<table style="width: 800px;">';
                 $cuerpo.='<tr>
                    <td style=" text-align: left;"><br />
                        <strong>En espera de una favorable acogida a la presente, atentamente</strong>
                    </td>
                    </tr>'; 
                $cuerpo.='</table>';
                
                $cuerpo.='<table style="width:720px;">';
                 $cuerpo.='<tr>
                    <td colspan="3">
                        <hr />
                        <br /><br /><br /><br /><br />
                    </td>
                    </tr>'; 
                $cuerpo.='    <tr>
                    <td style=" text-align: center;">
                        '.strtoupper ($vendedor->nombre).'
                        <br />
                        _____________________________
                        <br />
                        <center><span style="font-style: oblique; font-weight: bold;">EJECUTIVO COMERCIAL</span></center>
                    </td>
                     <td style=" text-align: center;">
                        &nbsp;
                        <br />
                        _____________________________
                        <br />
                        <center><span style="font-style: oblique; font-weight: bold;">ACEPTADO</span></center>
                    </td>
                     <td style=" text-align: center;">
                      JUAN TAPIA ESKER
                        <br />
                        _____________________________
                        <br />
                       <center> <span style="font-style: oblique; font-weight: bold;">GERENTE COMERCIAL</span></center>
                    </td>
                </tr>'; 
                $cuerpo.='<tr>
                    <td colspan="3">
                        <br /><br />
                    </td>
                    </tr>'; 
                    $cuerpo.='<tr>
                    <td colspan="3" style=" text-align: center; ">
                        JUAN FCO. RIVAS 9435 FONOS : 495 95 00 FAX 495 95 10
                        <br />
                        LA CISTERNA - SANTIAGO
                    </td>
                    </tr>'; 
                
                $cuerpo.='</table>';
                
                  $cuerpo.='</body></html>';

            return $cuerpo;
}

?>