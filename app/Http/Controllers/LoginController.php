<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Auth;
use Session;
use Redirect;
use DB;
use Hash;
use DateTime;

class LoginController extends Controller
{
    public function store(LoginRequest $request)
    {
        if (Auth::attempt(['email'=>$request['email'], 'password' => $request['password']]))
        {
            //echo Auth::user()->id.'<br>'.Auth::user()->name;
            $id = Auth::user()->id;

        }

        Session::flash('message-error','Usuario y/o contraseña incorrecta! vuelva a intentarlo');
        return Redirect::to('/');
    }
}
