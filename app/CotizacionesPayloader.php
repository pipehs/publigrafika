<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class CotizacionesPayloader extends Model {

	protected $table = 'pubcotizacionespayloader';
	protected $fillable = ['cliente_id','payloader_id','vendedor_id','cantidad','comentarios','usuario_id','forma_pago_id','estado','forma_pago_id','fecha_entrega'];

	public static function getCotizaciones($id)
	{
		return DB::table('pubcotizacionespayloader')
                ->where('payloader_id','=',$id)
                ->select('id')
                ->get();
	}

	public static function getAgregados($id)
	{
		return DB::table('pubagregado_cotizacion_payloader')
			->join('pubagregados','pubagregados.id','=','pubagregado_cotizacion_payloader.agregado_id')
			->where('pubagregado_cotizacion_payloader.cotizacionespayloader_id','=',$id)
			->select('pubagregados.id','pubagregados.nombre')
			->groupBy('pubagregados.id')
			->get();
	}

	public static function getPrecio($cant,$payloader_id,$agregados)
	{
		$precio = 0;

		//primero obtenemos todos los precios bases de payloader (para determinar cantidad)
		$preciobasecantidad = DB::table('pubpreciobasecantidad')
					->where('payloader_id','=',$payloader_id)
					->select('id','cantidad_min','cantidad_max','precio')
					->get();

		foreach ($preciobasecantidad as $p)
		{
			if ($cant >= $p->cantidad_min && $cant <= $p->cantidad_max)
			{
				$precio = $precio + $p->precio;

				//obtenemos precio de agregados
				foreach ($agregados as $agregado)
				{
					$pradd = DB::table('pubagregadopayloader')
						->where('agregado_id','=',$agregado->id)
						->where('preciobasecantidad_id','=',$p->id)
						->select('precio')
						->first();

					$precio = $precio + $pradd->precio;
				}
			}
		}

		return $precio;

	}

	public static function insertAgregado($agregado,$id)
	{
		DB::table('pubagregado_cotizacion_payloader')
			->insert([
				'cotizacionespayloader_id' => $id,
				'agregado_id' => $agregado
				]);
	}

	public static function getCotizacion($id)
	{
		return \App\CotizacionesPayloader::find($id);
	}

	public static function deleteAgregado($id)
	{
		DB::table('pubagregado_cotizacion_payloader')
			->where('cotizacionespayloader_id','=',$id)
			->delete();
	}

	public static function getCotizacionesSinOrden()
	{
		return DB::table('pubcotizacionespayloader')
				->leftJoin('pubordenescompra_payloader','pubordenescompra_payloader.cotizacion_id','=','pubcotizacionespayloader.id')
				->where('pubordenescompra_payloader.cotizacion_id','=',NULL)
				->select('pubcotizacionespayloader.*')
				->get();
	}
}
