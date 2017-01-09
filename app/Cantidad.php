<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Cantidad extends Model {

	//tabla de cantidades de corrugado
	protected $table = 'pubcantidades';

	protected $fillable = ['cantidad'];

	public static function getCantidad($id)
	{
		$cant = \App\Cantidad::find($id);

		return $cant->cantidad;
	}

	public static function listCantidades()
	{
		$c = DB::table('pubcantidades')->lists('cantidad','id');

		return $c;
	}
	
}
