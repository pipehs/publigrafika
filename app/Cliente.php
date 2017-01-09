<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Cliente extends Model {

	protected $table = 'clientes';

	protected $fillable = ['rut','nombre_fantasia','razon_social','id_comuna','id_region','id_comuna'];

	public static function getClient($rut)
	{
		$client = \App\Cliente::where('id',$rut)->first(['nombre_fantasia']);
        
        return $client->nombre_fantasia;
	}

	public static function listClientes()
	{
		$clientes = DB::table('clientes')
					->lists('razon_social','id');

		return $clientes;
	}

}
