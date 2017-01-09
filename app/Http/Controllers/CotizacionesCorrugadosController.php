<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Redirect;
use DateTime;
use DB;
use Auth;
use stdClass;
use Illuminate\Http\Request;

class CotizacionesCorrugadosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$cotizaciones = \App\CotizacionesCorrugado::all();

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

			//obtenemos precio segun cantidad
			$precio = \App\Corrugado::getPrecio($c['cantidad_id'],$c['corrugado_id']);

			//obtenemos cantidad
			$cant = \App\Cantidad::getCantidad($c['cantidad_id']);

			//obtenemos nombre
			$nombre = \App\Corrugado::getName($c['corrugado_id']);

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
				'nombre' => $nombre,
				'cantidad' => $cant,
				'cliente' => $client,
				'precio' => $precio,
				'comentarios' => $c['comentarios'],
				'estado' => $estado
			];

			$i += 1;
		}
		return view('cotizaciones_corrugados.index',['cotizaciones' => $cotizaciones1]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$clientes = \App\Cliente::listClientes();

		$corrugados = \App\Corrugado::listCorrugados();

		$cantidades = \App\Cantidad::listCantidades();

		$vendedores = \App\User::listVendedores();

		$formas_pago = \App\FormaPago::listFormas();

		return view('cotizaciones_corrugados.create',['clientes'=>$clientes,'corrugados'=>$corrugados,'cantidades'=>$cantidades,'formas_pago' => $formas_pago, 'vendedores' => $vendedores]);
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
			
			\App\CotizacionesCorrugado::create([
	                    'cliente_id' => $_POST['cliente_id'],
	                    'corrugado_id' => $_POST['corrugado_id'],
	                    'cantidad_id' => $_POST['cantidad_id'],
	                    'vendedor_id' => $_POST['vendedor_id'],
	                    'forma_pago_id' => $_POST['forma_pago_id'],
	                    'fecha_entrega' => $_POST['fecha_entrega'],
	                    'estado' => 1,
	                    'comentarios' => $comentarios,
	                ]);

			Session::flash('message','Cotizaci&oacute;n generada correctamente');
		});

		return Redirect::to('cotizaciones_corrugado');
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
		$cotizacion = \App\CotizacionesCorrugado::find($id);

        $clientes = \App\Cliente::listClientes();

        $corrugados = \App\Corrugado::listCorrugados();

        $cantidades = \App\Cantidad::listCantidades();

        $vendedores = \App\User::listVendedores();

        $formas_pago = \App\FormaPago::listFormas();

        return view('cotizaciones_corrugados.edit',['cotizacion'=>$cotizacion,'clientes'=>$clientes,'corrugados'=>$corrugados,'cantidades'=>$cantidades,'formas_pago' => $formas_pago, 'vendedores' => $vendedores]);
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

            $cotizacion = \App\CotizacionesCorrugado::find($GLOBALS['id1']);

            if (isset($_POST['comentarios']) && $_POST['comentarios'] != '')
            {
                $cotizacion->comentarios = $_POST['comentarios'];
            }

            $cotizacion->cliente_id = $_POST['cliente_id'];
            $cotizacion->vendedor_id = $_POST['vendedor_id'];
            $cotizacion->corrugado_id = $_POST['corrugado_id'];
            $cotizacion->cantidad_id = $_POST['cantidad_id'];
            $cotizacion->forma_pago_id = $_POST['forma_pago_id'];

            if (isset($_POST['fecha_entrega']) && $_POST['fecha_entrega'] != '')
            {
                $cotizacion->fecha_entrega = $_POST['fecha_entrega'];
            }

            $cotizacion->save();
            
            Session::flash('message','Cotización de corrugado actualizado correctamente');
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
		$cotizacion = \App\CotizacionesCorrugado::find($id);

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

		$cantidad = \App\Cantidad::find($cotizacion->cantidad_id);
		$corrugado = \App\Corrugado::find($cotizacion->corrugado_id);

		$precio = \App\Corrugado::getPrecio($cantidad->id,$corrugado->id);
        
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
                        '.$cantidad->cantidad.'
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
