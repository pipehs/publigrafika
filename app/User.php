<?php namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use DB;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'usuarios';

	protected $fillable = ['rut','nombre','correo','telefono','pass'];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */

	public static function listVendedores()
	{
		return DB::table('usuarios')
					->lists('nombre','id');

	}

}
