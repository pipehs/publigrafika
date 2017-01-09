<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Agregado extends Model {

	protected $table = 'pubagregados';

	protected $fillable = ['nombre'];

    public static function getAgregados()
    {
        return DB::table('pubagregados')
            ->select('id','nombre')
            ->get();
    }
	public static function deleteAgregado($id)
	{
		//Eliminamos, primero de los datos no únicos
        DB::table('pubagregadopayloader')
            ->where('agregado_id','=',$id)
            ->delete();

        DB::table('pubagregados')
            ->where('id','=',$id)
            ->delete();

        return 0;
	}

}
