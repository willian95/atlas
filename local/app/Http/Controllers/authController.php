<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

use Illuminate\Http\Request;

class authController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function login(Request $request)
	{	
		$data = $request->only('email', 'password');

		if(\Auth::attempt($data)){
		
			return redirect()->to('/bienes');

		}

		else{
			$alert = "Usuario no encontrado";
			return redirect()->to('/')->with('alert', $alert);
		}
	}

	public function logout(){
		\Auth::logout();
		return  redirect()->to('/');
	}

}
