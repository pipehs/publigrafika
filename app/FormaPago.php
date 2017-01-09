<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class FormaPago extends Model {

	protected $table = 'formas_pago';

	public static function listFormas()
	{
		return DB::table('formas_pago')
					->lists('forma_pago','id');
	}

}
