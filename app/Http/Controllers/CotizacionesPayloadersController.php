<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Redirect;
use DateTime;
use DB;
use Auth;
use Illuminate\Http\Request;

class CotizacionesPayloadersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$cotizaciones = \App\CotizacionesPayloader::all();

		$cotizaciones1 = array();
		$i = 0;
		foreach ($cotizaciones as $c)
		{
			$created = date_format($c['created_at'],"d-m-Y");
			if ($c['fecha_entrega'] == NULL)
			{
				$entrega = 'No definido';
			}
			else
			{
				$fec = new DateTime($c['fecha_entrega']);
				$entrega = date_format($fec,"d-m-Y");
			}

			//obtenemos nombre de cliente
			$client = \App\Cliente::getClient($c['cliente_id']);

			//obtenemos agregados y sus precios
			$agregados = \App\CotizacionesPayloader::getAgregados($c['id']);

			//obtenemos precio base segun cantidad, y agregados
			$precio = \App\CotizacionesPayloader::getPrecio($c['cantidad'],$c['payloader_id'],$agregados);

			//obtenemos nombre y descripción
			$p = \App\Payloader::find($c['payloader_id']);

			if ($c['estado'] == NULL)
			{
				$estado = 'Pendiente';
			} 
			else if ($c['estado'] == 1)
			{
				$estado = 'Pendiente';
			}
			else
			{
				$estado = 'Aprobada';
			}

			$cotizaciones1[$i] = [
				'id' => $c['id'],
				'created_at' => $created,
				'fecha_entrega' => $entrega,
				'nombre' => $p->nombre,
				'descripcion' => $p->descripcion, 
				'cantidad' => $c['cantidad'],
				'cliente' => $client,
				'precio' => $precio,
				'agregados' => $agregados,
				'comentarios' => $c['comentarios']
			];

			$i += 1;
		}
		return view('cotizaciones_payloaders.index',['cotizaciones' => $cotizaciones1]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$clientes = \App\Cliente::listClientes();

		$payloaders = \App\Payloader::all();

		$agregados = \App\Agregado::getAgregados();

		$vendedores = \App\User::listVendedores();

		$formas_pago = \App\FormaPago::listFormas();

		return view('cotizaciones_payloaders.create',['clientes'=>$clientes,'payloaders'=>$payloaders,'agregados'=>$agregados,'vendedores' => $vendedores, 'formas_pago' => $formas_pago]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		DB::transaction (function() {
			if (isset($_POST['comentarios']) && $_POST['comentarios'] != '')
			{
				$comentarios = $_POST['comentarios'];
			}
			else
			{
				$comentarios = NULL;
			}
			
			$cotizacion = \App\CotizacionesPayloader::create([
		                    'cliente_id' => $_POST['cliente_id'],
		                    'payloader_id' => $_POST['payloader_id'],
		                    'cantidad' => $_POST['cantidad'],
		                    'vendedor_id' => $_POST['vendedor_id'],
		                    'forma_pago_id' => $_POST['forma_pago_id'],
		                    'fecha_entrega' => $_POST['fecha_entrega'],
		                    'estado' => 1,
		                    'comentarios' => $comentarios,
		                ]);

			//agregamos agregados
			if (isset($_POST['agregados']))
			{
				foreach ($_POST['agregados'] as $agregado)
				{
					\App\CotizacionesPayloader::insertAgregado($agregado,$cotizacion->id);
				}
			}
			Session::flash('message','Cotizaci&oacute;n generada correctamente');
		});

		return Redirect::to('cotizaciones_payloaders');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        $cotizacion = \App\CotizacionesPayloader::find($id);

        $agregados_cotizacion = \App\CotizacionesPayloader::getAgregados($id);

		$clientes = \App\Cliente::listClientes();

        $payloaders = \App\Payloader::all();

        $agregados = \App\Agregado::getAgregados();

        $vendedores = \App\User::listVendedores();

        $formas_pago = \App\FormaPago::listFormas();

        return view('cotizaciones_payloaders.edit',['cotizacion'=>$cotizacion,'agregados_cotizacion'=>$agregados_cotizacion,'clientes'=>$clientes,'payloaders'=>$payloaders,'agregados'=>$agregados,'formas_pago' => $formas_pago, 'vendedores' => $vendedores]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		global $id1;
        $id1 = $id;
        DB::transaction (function() {

            $cotizacion = \App\CotizacionesPayloader::find($GLOBALS['id1']);

            if (isset($_POST['comentarios']) && $_POST['comentarios'] != '')
            {
                $cotizacion->comentarios = $_POST['comentarios'];
            }

            $cotizacion->cliente_id = $_POST['cliente_id'];
            $cotizacion->vendedor_id = $_POST['vendedor_id'];
            $cotizacion->payloader_id = $_POST['payloader_id'];
            $cotizacion->cantidad = $_POST['cantidad'];
            $cotizacion->forma_pago_id = $_POST['forma_pago_id'];

            if (isset($_POST['fecha_entrega']) && $_POST['fecha_entrega'] != '')
            {
                $cotizacion->fecha_entrega = $_POST['fecha_entrega'];
            }

            if (isset($_POST['agregados']))
            {
                //primero eliminamos los agregados de la cotización
                \App\CotizacionesPayloader::deleteAgregado($cotizacion->id);

                //insertamos "nuevos" agregados
                foreach ($_POST['agregados'] as $add)
                {
                    \App\CotizacionesPayloader::insertAgregado($add,$cotizacion->id);
                }
            }

            $cotizacion->save();
            
            Session::flash('message','Cotización de payloader actualizado correctamente');
        });

        return Redirect::to('cotizaciones_corrugado');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

	public function getPdf($id)
	{
		$cotizacion = \App\CotizacionesPayloader::find($id);

		if ($cotizacion->vendedor_id == NULL)
		{
			$vendedor = new stdClass();

			$vendedor->nombre = '';
			$vendedor->correo = '';
		}
		else
		{
			$vendedor = \App\User::find($cotizacion->vendedor_id); 
		}

		if ($cotizacion->cliente_id == NULL)
		{
			$dir = '';
			$comuna = '';
			$ciudad = '';
		}

		else
		{
			$cliente = \App\Cliente::find($cotizacion->cliente_id); 

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

		//obtenemos agregados y sus precios
		$agregados = \App\CotizacionesPayloader::getAgregados($cotizacion['id']);

		//obtenemos precio base segun cantidad, y agregados
		$precio = \App\CotizacionesPayloader::getPrecio($cotizacion['cantidad'],$cotizacion['payloader_id'],$agregados);

		$payloader = \App\Payloader::find($cotizacion['payloader_id']);
        
        if ($cotizacion->forma_pago_id == NULL)
        {
        	$forma_pago = '';
        }
        else
        {
        	$f = \App\FormaPago::find($cotizacion->forma_pago_id);
        	$forma_pago = $f->forma_pago;
        }

        //configuramos plazo fecha entrega
        if ($cotizacion->fecha_entrega == NULL)
        {
        	$plazo = 'No definido los';
        }
        else
        {
        	$fecha = $cotizacion->fecha_entrega;
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
                    <td style="width: 150px; vertical-align:top;">
                        '.$cotizacion->cantidad.'
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
                       '.$cotizacion->comentarios.'
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

            $pdf = \App::make('dompdf.wrapper');
           	$nombre="Cotización de Cliente ".$id." ".date("Y-m-d H:i:s").".pdf";
            $pdf->loadHTML($cuerpo);
            return $pdf->stream();
             
	}

}
