<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Payloader extends Model {

	protected $table = 'pubpayloaders';
	protected $fillable = ['nombre','descripcion','ancho','largo','bandejas'];

	//guardare aqui momentaneamente key antigua
	//APP_KEY=rJ857UsT6qux7gCNqu2hyIUmTVIaF1Uw

	public static function deletePayloader($id)
	{
		//Eliminamos, primero de los datos no únicos
        $p1 = DB::table('pubpreciobasecantidad')
            ->where('payloader_id','=',$id)
            ->get(['id']);

        foreach ($p1 as $p)
        {
            DB::table('pubagregadopayloader')
            ->join('')
            ->where('preciobasecantidad_id','=',$p->id)
            ->delete();
        }
        
        DB::table('pubpreciobasecantidad')
        	->where('payloader_id','=',$id)
        	->delete();

        DB::table('pubpayloaders')
            ->where('id','=',$id)
            ->delete();

        return 0;
	}
	
}
