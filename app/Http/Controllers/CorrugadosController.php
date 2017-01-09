<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Redirect;
use DateTime;
use DB;
use Auth;
use Illuminate\Http\Request;

class CorrugadosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$corrugados = \App\Corrugado::all();

		return view('corrugados.index',['corrugados' => $corrugados]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('corrugados.create');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		DB::transaction (function() {
			if (isset($_POST['descripcion']) && $_POST['descripcion'] != '')
			{
				$descripcion = $_POST['descripcion'];
			}
			else
			{
				$descripcion = NULL;
			}
			
			\App\Corrugado::create([
	                    'nombre' => $_POST['nombre'],
	                    'descripcion' => $descripcion,
	                ]);

			Session::flash('message','Corrugado generado correctamente');
		});

		return Redirect::to('corrugados');
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
		$corrugado = \App\Corrugado::find($id);

		return view('corrugados.edit',['corrugado' => $corrugado]);
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
         DB::transaction(function()
       	{
            $corrugado = \App\Corrugado::find($GLOBALS['id1']);
         	if (isset($_POST['descripcion']) && $_POST['descripcion'] != '')
			{
				$descripcion = $_POST['descripcion'];
			}
			else
			{
				$descripcion = NULL;
			}       

			$corrugado->nombre = $_POST['nombre'];
			$corrugado->descripcion = $descripcion;
            $corrugado->save();
            
            Session::flash('message','Corrugado actualizado correctamente');
            
        });

        return Redirect::to('corrugados');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//vemos si tiene cotizaciones
        $rev = \App\CotizacionesCorrugado::getCotizaciones($id);

        if (empty($rev))
        {
 			\App\Corrugado::deleteCorrugado($id);          
            
            return 0;        
        }    
        else
        {
            return 1;
        }
	}

	public function cantidades()
	{
		$cantidades = \App\Cantidad::all();

		if ($cantidades->isEmpty())
		{
			return 1;
		}
		else
		{
			return 0;
		}
	}

	public function createCantidades()
	{
		$cantidades = \App\Cantidad::all();

		return view ('corrugados.create_cantidades',['cantidades' => $cantidades]);
	}

	public function storeCantidades()
	{
		//print_r($_POST);

		DB::transaction(function() {
			//obtenemos cantidades existentes
			$cantidades = \App\Cantidad::all();

			if (!$cantidades->isEmpty()) //hay cantidades editadas (quizas)
			{
				foreach ($cantidades as $c)
				{
					$cant = \App\Cantidad::find($c->id);
					$cant->cantidad = $_POST['cantidad_'.$c->id];
					$cant->save();
				}
			}

			//ahora agregamos nuevas cantidades
			$i = 1;
			while (isset($_POST['newcantidad_'.$i]))
			{
				if ($_POST['newcantidad_'.$i] != NULL && $_POST['newcantidad_'.$i] != '')
				{
					\App\Cantidad::create([
						'cantidad' => $_POST['newcantidad_'.$i]
						]);
				}

				$i += 1;
			}

			Session::flash('message','Cantidades de corrugado guardados correctamente');
		});

			return Redirect::to('corrugados');
		
	}

	public function precios($id)
	{
		$cantidades = \App\Cantidad::all();

		$corrugado = \App\Corrugado::find($id);

		//vemos si hay algunas cantidades con precio ingresado

		$precio_corrugado = DB::table('pubpreciocantidadcorrugado')
							->where('corrugado_id','=',$corrugado->id)
							->select('id','precio','cantidad_id')
							->get();

		return view ('corrugados.precios',['corrugado' => $corrugado,'cantidades' => $cantidades,'precio_corrugado' => $precio_corrugado]);
	}

	public function createPrecio($id)
	{

	}

	public function storePrecio()
	{
		//print_r($_POST);

		DB::transaction(function() {
			$i = 1;
			while(isset($_POST['cantidad_'.$i]))
			{
				if ($_POST['cantidad_'.$i] != '' && $_POST['cantidad_'.$i] != NULL)
				{
					//vemos si se está editando
					$existe = \App\PrecioCantidadCorrugado::where('corrugado_id','=',$_POST['corrugado_id'])->where('cantidad_id','=',$i)->first(['id','precio']);

					if (isset($existe->precio)) //se está editando
					{
						$precio = \App\PrecioCantidadCorrugado::find($existe->id);
						$precio->precio = $_POST['cantidad_'.$i];
						$precio->save();
					}
					else
					{
						\App\PrecioCantidadCorrugado::create([
							'corrugado_id' => $_POST['corrugado_id'],
							'cantidad_id' => $i,
							'precio' => $_POST['cantidad_'.$i],
							]);
					}
				}

				$i += 1;
				
			}

			Session::flash('message','Precios de corrugado guardados correctamente');
		});	
		return Redirect::to('corrugados');		
	}

	public function tablaPrecios()
	{
		$cantidades = \App\Cantidad::all();

		$corrugados = \App\Corrugado::all();
		$i = 0;
		
		$precios_corrugado = array();
		foreach ($cantidades as $c)
		{
			$pc = \App\PrecioCantidadCorrugado::where('cantidad_id',$c->id)->get();

			foreach ($pc as $p)
			{
				$precios_corrugado[$i] = ['cantidad_id' => $c->id,'corrugado_id' => $p->corrugado_id, 'precio' => $p->precio];

				$i += 1; 
			}
		}

		return view('corrugados.tabla',['precios_corrugado' => $precios_corrugado,'corrugados' => $corrugados, 'cantidades' => $cantidades]);
	}

}
