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

class OrdenesCompraPayloaderController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//obtenemos cotizaciones sin ordenes
		$cotizaciones = \App\CotizacionesPayloader::getCotizacionesSinOrden();

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

			//obtenemos agregados y sus precios
			$agregados = \App\CotizacionesPayloader::getAgregados($c->id);

			//obtenemos precio base segun cantidad, y agregados
			$precio = \App\CotizacionesPayloader::getPrecio($c->cantidad,$c->payloader_id,$agregados);

			//obtenemos nombre y descripción
			$p = \App\Payloader::find($c->payloader_id);

			if ($c->estado == NULL)
			{
				$estado = 'Pendiente';
			} 
			else if ($c->estado == 1)
			{
				$estado = 'Pendiente';
			}
			else
			{
				$estado = 'Aprobada';
			}

			$cotizaciones1[$i] = [
				'id' => $c->id,
				'created_at' => $created,
				'fecha_entrega' => $entrega,
				'nombre' => $p->nombre,
				'descripcion' => $p->descripcion, 
				'cantidad' => $c->cantidad,
				'cliente' => $client,
				'precio' => $precio,
				'agregados' => $agregados,
				'comentarios' => $c->comentarios
			];

			$i += 1;
		}

		$ordenes = \App\OrdenesCompraPayloader::all();

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

			//obtenemos agregados y sus precios
			$agregados = \App\OrdenesCompraPayloader::getAgregados($c['id']);

			//obtenemos precio base segun cantidad, y agregados
			$precio = $c['precio'];

			//obtenemos nombre y descripción
			$p = \App\Payloader::find($c['payloader_id']);

			if ($c['estado'] == NULL)
			{
				$estado = 'En proceso';
			} 
			else if ($c['estado'] == 1)
			{
				$estado = 'En proceso';
			}
			else
			{
				$estado = 'Aprobada';
			}

			$ordenes1[$i] = [
				'id' => $c['id'],
				'created_at' => $created,
				'fecha_entrega' => $entrega,
				'nombre' => $p->nombre,
				'descripcion' => $p->descripcion, 
				'cantidad' => $c['cantidad'],
				'cliente' => $client,
				'precio' => $precio,
				'agregados' => $agregados,
				'comentarios' => $c['comentarios'],
				'estado_origin' => $c['estado']
			];

			$i += 1;
		}

		return view('ordenescompra_payloaders.index',['cotizaciones' => $cotizaciones1,'ordenes' => $ordenes1]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create($id)
	{
		$cotizacion = \App\CotizacionesPayloader::find($id);

		$agregados_cotizacion = \App\CotizacionesPayloader::getAgregados($id);

		$clientes = \App\Cliente::listClientes();

		$payloaders = \App\Payloader::all();

		$agregados = \App\Agregado::getAgregados();

		$vendedores = \App\User::listVendedores();

		$formas_pago = \App\FormaPago::listFormas();

		//obtenemos precio segun cantidad
		$cotizacion->precio = \App\CotizacionesPayloader::getPrecio($cotizacion->cantidad,$cotizacion->payloader_id,$agregados_cotizacion);

		return view('ordenescompra_payloaders.create',['cotizacion'=>$cotizacion,'agregados_cotizacion'=>$agregados_cotizacion,'clientes'=>$clientes,'payloaders'=>$payloaders,'agregados'=>$agregados,'vendedores' => $vendedores, 'formas_pago' => $formas_pago]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($id)
	{
		//print_r($_POST);
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
			
			if (isset($_POST['submit2']))
			{
				$orden = \App\OrdenesCompraPayloader::create([
							'cotizacion_id' => $GLOBALS['cotizacion_id'],
		                    'cliente_id' => $_POST['cliente_id'],
		                    'payloader_id' => $_POST['payloader_id'],
		                    'cantidad' => $_POST['cantidad'],
		                    'precio' => $_POST['precio'],
		                    'vendedor_id' => $_POST['vendedor_id'],
		                    'forma_pago_id' => $_POST['forma_pago_id'],
		                    'fecha_entrega' => $_POST['fecha_entrega'],
		                    'estado' => 2,
		                    'comentarios' => $comentarios,
		        ]);

				//obtenemos y cerramos cotización
	            $cotizacion = \App\CotizacionesPayloader::find($GLOBALS['cotizacion_id']);
	            $cotizacion->estado = 2;
	            $cotizacion->save();

		        Session::flash('message','Orden de compra guardada y cerrada correctamente');
			}
			else
			{
				Session::flash('message','Orden de compra guardada correctamente');
			}

			//agregamos agregados
			if (isset($_POST['agregados']))
			{
				foreach ($_POST['agregados'] as $agregado)
				{
					\App\OrdenesCompraPayloader::insertAgregado($agregado,$orden->id);
				}
			}
			
		});

		return Redirect::to('ordenescompra_payloaders');
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
		$orden= \App\OrdenesCompraPayloader::find($id);

        $agregados_orden = \App\OrdenesCompraPayloader::getAgregados($id);

		$clientes = \App\Cliente::listClientes();

        $payloaders = \App\Payloader::all();

        $agregados = \App\Agregado::getAgregados();

        $vendedores = \App\User::listVendedores();

        $formas_pago = \App\FormaPago::listFormas();

        //obtenemos cotización original para ver precio y cantidad
        $cotizacion = \App\CotizacionesPayloader::find($orden->cotizacion_id);
        $agregados_cotizacion = \App\CotizacionesPayloader::getAgregados($cotizacion->id);
        //obtenemos precio original
		$precio = \App\CotizacionesPayloader::getPrecio($cotizacion->id,$cotizacion->payloader_id,$agregados_cotizacion);
		$cantidad = $cotizacion->cantidad;

        return view('ordenescompra_payloaders.edit',['cotizacion'=>$orden,'agregados_cotizacion'=>$agregados_orden,'clientes'=>$clientes,'payloaders'=>$payloaders,'agregados'=>$agregados,'formas_pago' => $formas_pago, 'vendedores' => $vendedores,'precio' => $precio, 'cantidad' => $cantidad]);
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

            $orden = \App\OrdenesCompraPayloader::find($GLOBALS['id1']);

            if (isset($_POST['comentarios']) && $_POST['comentarios'] != '')
            {
                $orden->comentarios = $_POST['comentarios'];
            }

            $orden->cliente_id = $_POST['cliente_id'];
            $orden->vendedor_id = $_POST['vendedor_id'];
            $orden->payloader_id = $_POST['payloader_id'];
            $orden->cantidad = $_POST['cantidad'];
            $orden->precio = $_POST['precio'];
            $orden->forma_pago_id = $_POST['forma_pago_id'];

            if (isset($_POST['fecha_entrega']) && $_POST['fecha_entrega'] != '')
            {
                $orden->fecha_entrega = $_POST['fecha_entrega'];
            }

            if (isset($_POST['agregados']))
            {
                //primero eliminamos los agregados de la orden
                \App\OrdenesCompraPayloader::deleteAgregado($orden->id);

                //insertamos "nuevos" agregados
                foreach ($_POST['agregados'] as $add)
                {
                    \App\OrdenesCompraPayloader::insertAgregado($add,$orden->id);
                }
            }

            if (isset($_POST['submit2'])) //se está cerrando
            {
            	$orden->estado = 2;
            	//obtenemos y cerramos cotización
	            $cotizacion = \App\CotizacionesPayloader::find($orden->cotizacion_id);
	            $cotizacion->estado = 2;
	            $cotizacion->save();
            	Session::flash('message','Orden de compra de payloader guardada y cerrada correctamente');
            }
            else
            {
            	Session::flash('message','Orden de compra de payloader guardada correctamente');
            }

            $orden->save();
            
            
        });

        return Redirect::to('ordenescompra_payloaders');
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
		$orden = \App\OrdenesCompraPayloader::find($id);

		$cuerpo = payloaderPdf($orden,'Orden',$id,1);
        
        $pdf = \App::make('dompdf.wrapper');
        $nombre = "Orden de compra de Cliente ".$id." ".date("Y-m-d H:i:s").".pdf";
        $pdf->loadHTML($cuerpo);
        return $pdf->stream();
	}

}
