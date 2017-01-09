<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Redirect;
use DateTime;
use DB;
use Auth;

use Illuminate\Http\Request;

class AgregadosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$agregados1 = \App\Agregado::all();

		foreach ($agregados1 as $agregado)
		{
			//obtenemos precios de agregados según cantidad
		}
		return view('agregados.index',['agregados' => $agregados1]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//obtenemos todos los payloaders con sus cantidades
		$payloaders1 = \App\Payloader::all();
		$payloaders = array();
		$i = 0;
		foreach ($payloaders1 as $p)
		{
			$cantidades = \App\PrecioBaseCantidad::getCantidadesMinMax($p->id);

			$payloaders[$i] = [
				'id' => $p->id,
				'nombre' => $p->nombre,
				'descripcion' => $p->descripcion,
				'largo' => $p->largo,
				'ancho' => $p->ancho,
				'bandejas' => $p->bandejas,
				'cantidades' => $cantidades,
			];

			$i += 1;
		}

		return view('agregados.create',['payloaders' => $payloaders]);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//print_r($_POST);

		DB::transaction(function() {
			//primero que todo generamos el agregado
			$agregado = \App\Agregado::create([
					'nombre' => $_POST['nombre'],
				]);

			//ahora agregamos cada uno de los precios
			//primero que todo, obtenemos todos los id de cantidades
			$cantidades_id = \App\PrecioBaseCantidad::all()->values('id');

			//ingresamos cada id en la tabla pubagregadopayloader
			foreach ($cantidades_id as $c)
			{
				\App\AgregadoPayloader::create([
						'precio' => $_POST['precio_'.$c->id],
						'agregado_id' => $agregado->id,
						'preciobasecantidad_id' => $c->id,
					]);
			}

			Session::flash('message','Agregado creado correctamente');
		});
		
		return Redirect::to('agregados');
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
		$agregado = \App\Agregado::find($id);

		//obtenemos todos los payloaders con sus cantidades
		$payloaders1 = \App\Payloader::all();
		$payloaders = array();
		$i = 0;
		foreach ($payloaders1 as $p)
		{
			$cantidades = \App\PrecioBaseCantidad::getCantidadesMinMax($p->id);

			$payloaders[$i] = [
				'id' => $p->id,
				'nombre' => $p->nombre,
				'descripcion' => $p->descripcion,
				'largo' => $p->largo,
				'ancho' => $p->ancho,
				'bandejas' => $p->bandejas,
				'cantidades' => $cantidades,
			];

			$i += 1;
		}

		//obtenemos precios agregados del agregado
		$precios = \App\AgregadoPayloader::where('agregado_id',$agregado->id)->get();

		return view('agregados.edit',['payloaders' => $payloaders,'agregado' => $agregado,'precios' => $precios]);
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
		DB::transaction(function() {
			//primero que todo generamos el agregado
			$agregado = \App\Agregado::find($GLOBALS['id1']);
			$agregado->nombre = $_POST['nombre'];
			$agregado->save();
			//ahora agregamos cada uno de los precios
			//obtenemos ids de agregadopayloader donde agregado_id sea $agregado->id
			$agregadopayloader = \App\AgregadoPayloader::where('agregado_id',$agregado->id)->get();

			//ingresamos cada id en la tabla pubagregadopayloader
			foreach ($agregadopayloader as $add)
			{
				$add->precio = $_POST['precio_'.$add->preciobasecantidad_id];
				$add->save();
			}

			Session::flash('message','Agregado actualizado correctamente');
		});
		
		return Redirect::to('agregados');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
 		\App\Agregado::deleteAgregado($id);          
            
        return 0;        
	}

}
