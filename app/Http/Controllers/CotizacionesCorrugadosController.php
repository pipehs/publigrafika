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

		$cuerpo = corrugadoPdf($cotizacion,'Cotización',$id,0);
        
        $pdf = \App::make('dompdf.wrapper');
        $nombre = "Cotización de Cliente ".$id." ".date("Y-m-d H:i:s").".pdf";
        $pdf->loadHTML($cuerpo);
        return $pdf->stream();
	}


}
