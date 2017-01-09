<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class PrecioBaseCantidad extends Model {

	protected $table = 'pubpreciobasecantidad';

	protected $fillable = ['cantidad_min','cantidad_max','precio','payloader_id'];

	public static function getCantidadesMinMax($id)
	{
		$cantidades = \App\PrecioBaseCantidad::where('payloader_id',$id)->get(['id','cantidad_min','cantidad_max']);

		return $cantidades;
	}
}
