<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Corrugado extends Model {

	protected $table = 'pubcorrugados';

	protected $fillable = ['nombre','descripcion'];

	public static function deleteCorrugado($id)
	{
		//Eliminamos, primero de los datos no únicos

        DB::table('pubpreciocantidadcorrugado')
        	->where('corrugado_id','=',$id)
        	->delete();

        DB::table('pubcorrugados')
            ->where('id','=',$id)
            ->delete();

        return 0;
	}

    public static function getPrecio($cant,$corr)
    {
        $precio = DB::table('pubpreciocantidadcorrugado')
                ->where('cantidad_id','=',$cant)
                ->where('corrugado_id','=',$corr)
                ->select('precio')
                ->first();

        return $precio->precio;
    }

    public static function getName($id)
    {
        $res = DB::table('pubcorrugados')->where('id',$id)->first(['nombre']);
        return $res->nombre;
    }

    public static function listCorrugados()
    {
        $c = DB::table('pubcorrugados')->lists('nombre','id');
        return $c;
    }

}
