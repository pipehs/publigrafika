<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class AgregadoPayloader extends Model {

	protected $table = 'pubagregadopayloader';

	protected $fillable = ['agregado_id','precio','preciobasecantidad_id'];

	public $timestamps = false;

}
