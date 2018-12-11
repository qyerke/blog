<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class AuthController extends Controller
{
    public function registerForm()
    {
    	return view('pages.register');
    }

    public function register(Request $request)
    {
    	$this->validate($request, [
    		'name' => 'required',
    		'email' => 'required|email|unique:users',
    		'password' => 'required'
    	]);
    	$user = User::add($request->all());
    	//$user->generatePassword($request->get('password'));
    	return redirect()->route('login');
    }


    public function loginForm()
    {
    	return view('pages.login');
    }
    public function login(Request $request)
    {
    	$this->validate($request, [
    		'email' => 'required|email',
    		'password' => 'required'
    	]);
    	if(Auth::attempt([ //attempt - poprobovat zaloginit user
    		'email' => $request->get('email'),
    		'password' => $request->get('password'),
    	])) {
    		return redirect()->route('home');
    		};
    	return redirect()->back()->with('status', 'Not correct login or password');
    	
    	//Auth::check(); //user login ili net
    }
    public function logout()
    {
    	Auth::logout();
    	return redirect()->route('home');
    }
}
  