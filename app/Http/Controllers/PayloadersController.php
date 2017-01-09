<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Session;
use Redirect;
use DateTime;
use DB;
use Auth;

use Illuminate\Http\Request;

class PayloadersController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$payloaders = array();

		$payloaders = \App\Payloader::all();

		return view('payloaders.index',['payloaders' => $payloaders]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('payloaders.create');
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
			
			\App\Payloader::create([
	                    'nombre' => $_POST['nombre'],
	                    'descripcion' => $descripcion,
	                    'bandejas' => $_POST['bandejas'],
	                    'largo' => $_POST['largo'],
	                    'ancho' => $_POST['ancho'],
	                ]);

			Session::flash('message','Payloader generado correctamente');
		});

		return Redirect::to('payloaders');
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
		$payloader = \App\Payloader::find($id);

		return view('payloaders.edit',['payloader' => $payloader]);
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
            $payloader = \App\Payloader::find($GLOBALS['id1']);
         	if (isset($_POST['descripcion']) && $_POST['descripcion'] != '')
			{
				$descripcion = $_POST['descripcion'];
			}
			else
			{
				$descripcion = NULL;
			}       

			$payloader->nombre = $_POST['nombre'];
			$payloader->descripcion = $descripcion;
			$payloader->bandejas = $_POST['bandejas'];
			$payloader->largo = $_POST['largo'];
			$payloader->ancho = $_POST['ancho'];

            $payloader->save();
            
            Session::flash('message','Payloader actualizado correctamente');
            
        });

        return Redirect::to('payloaders');
	}

	public function precios($id)
	{
		$payloader = \App\Payloader::find($id);

		$rows = \App\PrecioBaseCantidad::where('payloader_id',$payloader->id)->get();

		return view('payloaders.precios',['payloader' => $payloader,'rows' => $rows]);
	}

	//agregar un nuevo precio para el payloader de id = $id
	public function createPrecio($id)
	{
		return view('payloaders.create_precio',['id' => $id]);
	}

	public function storePrecio()
	{
		//verificamos que las cantidades ingresadas sean correctas (para este payloader)
		$error = $this->verificadorCantidades($_POST['cantidad_min'],$_POST['cantidad_max'],NULL,$_POST['payloader_id']);

		if ($error == 1)
		{
			Session::flash('error','La cantidad ingresada máxima es menor a la mínima');
			return Redirect::to('payloaders.create_precio.'.$_POST['payloader_id'])->withInput();
		}
		else if ($error == 2)
		{
			Session::flash('error','Las cantidades ingresadas son incongruentes con cantidades ingresadas previamente');
			return Redirect::to('payloaders.create_precio.'.$_POST['payloader_id'])->withInput();
		}
		else
		{
			$payloader = \App\Payloader::find($_POST['payloader_id']);
			$rows = \App\PrecioBaseCantidad::where('payloader_id',$payloader->id)->get();
			DB::transaction (function() {
				\App\PrecioBaseCantidad::create([
		                    'cantidad_min' => $_POST['cantidad_min'],
		                    'cantidad_max' => $_POST['cantidad_max'],
		                    'precio' => $_POST['precio'],
		                    'payloader_id' => $_POST['payloader_id']
		                ]);

				Session::flash('message','Precio agregado correctamente');
			});

			return Redirect::to('payloaders.precios.'.$payloader->id)->with(['rows'=>$rows]);
		}
	}

	public function editPrecio($id)
	{
		$PrecioBaseCantidad = \App\PrecioBaseCantidad::find($id);

		$payloader_id = $PrecioBaseCantidad->payloader_id;
		return view('payloaders.edit_precio',['preciobasecantidad' => $PrecioBaseCantidad,'id'=>$payloader_id]);
	}

	public function updatePrecio($id)
	{
		$error = $this->verificadorCantidades($_POST['cantidad_min'],$_POST['cantidad_max'],$id,$_POST['payloader_id']);
		if ($error == 1)
		{
			Session::flash('error','La cantidad ingresada máxima es menor a la mínima');
			return Redirect::to('payloaders.edit_precio.'.$id)->withInput();
		}
		else if ($error == 2)
		{
			Session::flash('error','Las cantidades ingresadas son incongruentes con cantidades ingresadas previamente');
			return Redirect::to('payloaders.edit_precio.'.$id)->withInput();
		}
		else
		{
			global $id1;
	        $id1 = $id;

	        $rows = \App\PrecioBaseCantidad::where('payloader_id',$_POST['payloader_id'])->get();
	         DB::transaction(function()
	       	{
	            $precio_cant = \App\PrecioBaseCantidad::find($GLOBALS['id1']);

				$precio_cant->cantidad_min = $_POST['cantidad_min'];
				$precio_cant->cantidad_max = $_POST['cantidad_max'];
				$precio_cant->precio = $_POST['precio'];

	            $precio_cant->save();
	            
	            Session::flash('message','Precio según cantidad de payloader actualizado correctamente');
	            
	        });

	        return Redirect::to('payloaders.precios.'.$_POST['payloader_id'])->with(['rows'=>$rows]);
		}
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
        $rev = \App\CotizacionesPayloader::getCotizaciones($id);

        if (empty($rev))
        {
 			\App\Payloader::deletePayloader($id);          
            
            return 0;        
        }    
        else
        {
            return 1;
        }
	}

	public function tablaPrecios()
	{
		$payloaders = \App\Payloader::all();

		$agregados = \App\Agregado::all();

		$preciobasecantidad = \App\PrecioBaseCantidad::all();

		$agregadopayloader = \App\AgregadoPayloader::all();

		return view('payloaders.tabla',['payloaders' => $payloaders,'agregados' => $agregados, 'preciobasecantidad' => $preciobasecantidad, 'agregadopayloader' => $agregadopayloader]);
	}


	public function verificadorCantidades($min,$max,$id,$payloader)
	{
		//id es sólo por si se está editando
		//verificamos que las cantidades ingresadas sean correctas
		if ($min < $max)
		{
			$error = 0; //en caso de que no hayan cantidades se asigna a 0 inmediatamente si la cant min es menor a la max
			//obtenemos todas las cantidades min y max existentes para ver que se ingrese una correcta
			$cants = \App\PrecioBaseCantidad::getCantidadesMinMax($payloader);

			foreach ($cants as $cant)
			{
				if ($id != $cant['id'])
				{
					if ($min > $cant['cantidad_max'] || $max < $cant['cantidad_min'])
					{
						$error = 0;
					}
					else 
					{
						$error = 2;
						break;
					}
				}
			}
		}
		else
		{
			$error = 1;
		}

		return $error;
	}
}
