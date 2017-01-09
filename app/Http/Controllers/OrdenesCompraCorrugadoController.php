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

class OrdenesCompraCorrugadoController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//obtenemos cotizaciones sin ordenes
		$cotizaciones = \App\CotizacionesCorrugado::getCotizacionesSinOrden();

		$cotizaciones1 = array();
		$i = 0;
		foreach ($cotizaciones as $c)
		{
			$created = new DateTime($c->created_at);
			$created = date_format($created,"d-m-Y");
			if ($c->fecha_entrega == NULL)
			{
				$entrega = 'No definido';
			}
			else
			{
				$fec = new DateTime($c->fecha_entrega);
				$entrega = date_format($fec,"d-m-Y");
			}

			//obtenemos nombre de cliente
			$client = \App\Cliente::getClient($c->cliente_id);

			//obtenemos precio segun cantidad
			$precio = \App\Corrugado::getPrecio($c->cantidad_id,$c->corrugado_id);

			//obtenemos cantidad
			$cant = \App\Cantidad::getCantidad($c->cantidad_id);

			//obtenemos nombre
			$nombre = \App\Corrugado::getName($c->corrugado_id);

			if ($c->estado == NULL || $c->estado == 1)
			{
				$estado = 'Pendiente';
			} 
			else
			{
				$estado = 'Orden de compra generada';
			}

			$cotizaciones1[$i] = [
				'id' => $c->id,
				'created_at' => $created,
				'fecha_entrega' => $entrega,
				'nombre' => $nombre,
				'cantidad' => $cant,
				'cliente' => $client,
				'precio' => $precio,
				'comentarios' => $c->comentarios,
				'estado' => $estado,
			];

			$i += 1;
		}

		$ordenes = \App\OrdenesCompraCorrugado::all();

		$ordenes1 = array();
		$i = 0;
		foreach ($ordenes as $c)
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

			if ($c['estado'] == NULL || $c['estado'] == 1)
			{
				$estado = 'En proceso';
			} 
			else
			{
				$estado = 'Orden generada';
			}

			$ordenes1[$i] = [
				'id' => $c['id'],
				'created_at' => $created,
				'fecha_entrega' => $entrega,
				'nombre' => $nombre,
				'cantidad' => $cant,
				'cliente' => $client,
				'precio' => $precio,
				'comentarios' => $c['comentarios'],
				'estado' => $estado,
				'estado_origin' => $c['estado'],
			];

			$i += 1;
		}

		//ahora obtenemos ordenes de compra generadas
		return view('ordenescompra_corrugados.index',['cotizaciones' => $cotizaciones1,'ordenes' => $ordenes1]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
		$cotizacion = \App\CotizacionesCorrugado::find($id);

		$clientes = \App\Cliente::listClientes();

		$corrugados = \App\Corrugado::listCorrugados();

		$cantidades = \App\Cantidad::listCantidades();

		$vendedores = \App\User::listVendedores();

		$formas_pago = \App\FormaPago::listFormas();

		return view('ordenescompra_corrugados.create',['cotizacion' => $cotizacion, 'clientes'=>$clientes,'corrugados'=>$corrugados,'cantidades'=>$cantidades,'formas_pago' => $formas_pago, 'vendedores' => $vendedores]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($id)
	{
		//print_r($_POST);
		//buscamos si es que existe o no la orden creada para la cotización de id = $id
		//$orden = \App\OrdenesCompraCorrugado::getOrden($id);

		global $cotizacion_id;
		$cotizacion_id = $id;
		DB::transaction (function() {
				if (isset($_POST['comentarios']) && $_POST['comentarios'] != '')
				{
					$comentarios = $_POST['comentarios'];
				}
				else
				{
					$comentarios = NULL;
				}
				
				\App\OrdenesCompraCorrugado::create([
							'cotizacion_id' => $GLOBALS['cotizacion_id'],
		                    'cliente_id' => $_POST['cliente_id'],
		                    'corrugado_id' => $_POST['corrugado_id'],
		                    'cantidad_id' => $_POST['cantidad_id'],
		                    'vendedor_id' => $_POST['vendedor_id'],
		                    'forma_pago_id' => $_POST['forma_pago_id'],
		                    'fecha_entrega' => $_POST['fecha_entrega'],
		                    'estado' => 1,
		                    'comentarios' => $comentarios,
		                ]);

				Session::flash('message','Orden de compra guardada correctamente');
		});

		
		return Redirect::to('ordenescompra_corrugado');
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
		$orden = \App\OrdenesCompraCorrugado::find($id);

		$clientes = \App\Cliente::listClientes();

		$corrugados = \App\Corrugado::listCorrugados();

		$cantidades = \App\Cantidad::listCantidades();

		$vendedores = \App\User::listVendedores();

		$formas_pago = \App\FormaPago::listFormas();

		return view('ordenescompra_corrugados.edit',['cotizacion' => $orden, 'clientes'=>$clientes,'corrugados'=>$corrugados,'cantidades'=>$cantidades,'formas_pago' => $formas_pago, 'vendedores' => $vendedores]);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		global $orden_id;
		$orden_id = $id;

		DB::transaction (function() {

				$orden_act = \App\OrdenesCompraCorrugado::find($GLOBALS['orden_id']);

				if (isset($_POST['comentarios']) && $_POST['comentarios'] != '')
	            {
	                $orden_act->comentarios = $_POST['comentarios'];
	            }

	            $orden_act->cliente_id = $_POST['cliente_id'];
	            $orden_act->vendedor_id = $_POST['vendedor_id'];
	            $orden_act->corrugado_id = $_POST['corrugado_id'];
	            $orden_act->cantidad_id = $_POST['cantidad_id'];
	            $orden_act->forma_pago_id = $_POST['forma_pago_id'];

	            if (isset($_POST['fecha_entrega']) && $_POST['fecha_entrega'] != '')
	            {
	                $orden_act->fecha_entrega = $_POST['fecha_entrega'];
	            }

	            $orden_act->save();

	            Session::flash('message','Orden de compra guardada correctamente');
		});

		return Redirect::to('ordenescompra_corrugado');

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

}
