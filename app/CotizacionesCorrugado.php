<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class CotizacionesCorrugado extends Model {

	protected $table = 'pubcotizacionescorrugado';

	protected $fillable = ['cliente_id','cantidad_id','corrugado_id','comentarios','vendedor_id','usuario_id','forma_pago_id','estado','fecha_entrega'];

	public static function getCotizaciones($id)
	{
		return DB::table('pubcotizacionescorrugado')
                ->where('corrugado_id','=',$id)
                ->select('id')
                ->get();
	}

	public static function getCotizacionesSinOrden()
	{
		return DB::table('pubcotizacionescorrugado')
				->leftJoin('pubordenescompra_corrugado','pubordenescompra_corrugado.cotizacion_id','=','pubcotizacionescorrugado.id')
				->where('pubordenescompra_corrugado.cotizacion_id','=',NULL)
				->select('pubcotizacionescorrugado.*')
				->get();
	}

	public static function getCantidad($cotizacion_id)
	{
		return DB::table('pubcotizacionescorrugado')
				->where('id','=',$cotizacion_id)
				->select('cantidad_id')
				->first();
	}

}
