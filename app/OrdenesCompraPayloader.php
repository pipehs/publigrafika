<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class OrdenesCompraPayloader extends Model {

	protected $table = 'pubordenescompra_payloader';

	protected $fillable = ['cotizacion_id','cliente_id','payloader_id','vendedor_id','cantidad','comentarios','usuario_id','forma_pago_id','estado','forma_pago_id','fecha_entrega','precio'];

	public static function getOrdenes($id)
	{
		return DB::table('pubordenescompra_payloader')
                ->where('payloader_id','=',$id)
                ->select('id')
                ->get();
	}

	public static function getAgregados($id)
	{
		return DB::table('pubagregado_orden_payloader')
			->join('pubagregados','pubagregados.id','=','pubagregado_orden_payloader.agregado_id')
			->where('pubagregado_orden_payloader.ordencompra_id','=',$id)
			->select('pubagregados.id','pubagregados.nombre')
			->groupBy('pubagregados.id')
			->get();
	}
	public static function insertAgregado($agregado,$id)
	{
		DB::table('pubagregado_orden_payloader')
			->insert([
				'ordencompra_id' => $id,
				'agregado_id' => $agregado
				]);
	}
	public static function deleteAgregado($id)
	{
		DB::table('pubagregado_orden_payloader')
			->where('ordencompra_id','=',$id)
			->delete();
	}

}
