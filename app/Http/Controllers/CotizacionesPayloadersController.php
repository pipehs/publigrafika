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

        return Redirect::to('cotizaciones_payloaders');
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

		
             
	}

}
