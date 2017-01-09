<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class PrecioCantidadCorrugado extends Model {

	protected $table = 'pubpreciocantidadcorrugado';

	protected $fillable = ['corrugado_id','cantidad_id','precio'];

	public $timestamps = false;

}
