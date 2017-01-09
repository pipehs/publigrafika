<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class OrdenesCompraCorrugado extends Model {

	protected $table = 'pubordenescompra_corrugado';

	protected $fillable = ['cotizacion_id','cliente_id','cantidad_id','corrugado_id','glosa','vendedor_id','usuario_id','forma_pago_id','estado','fecha_entrega'];

	public static function getOrdenes($id)
	{
		return DB::table('pubordenescompra_corrugado')
                ->where('corrugado_id','=',$id)
                ->select('id')
                ->get();
	}

	public static function getOrden($cotizacion_id)
	{
		return DB::table('pubordenescompra_corrugado')
                ->where('cotizacion_id','=',$cotizacion_id)
                ->select('id','estado')
                ->first();
	}

}
