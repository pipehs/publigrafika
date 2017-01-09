<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class OrdenesCompraPayloader extends Model {

	protected $table = 'pubordenescompra_payloader';

	protected $fillable = ['cliente_id','payloader_id','vendedor_id','cantidad','glosa','usuario_id','forma_pago_id','estado','forma_pago_id','fecha_entrega'];

	public static function getCotizaciones($id)
	{
		return DB::table('pubordenescompra_payloader')
                ->where('payloader_id','=',$id)
                ->select('id')
                ->get();
	}

}
