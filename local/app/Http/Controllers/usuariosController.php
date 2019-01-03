<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class usuariosController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	function vista()
	{
		$usuarios = DB::table('usuarios')
						->join('roles', 'usuarios.role_id', '=', 'roles.id')
						->select('roles.descripcion', 'roles.id as role_id', 'usuarios.id', 'usuarios.nombre', 'usuarios.email')
						->get();
		$roles = DB::table('roles')->get();
		$gerencias = DB::table('gerencias')->get();

		return view('usuarios', ['usuarios' => $usuarios, 'roles' => $roles, 'gerencias' => $gerencias]);
	}

	function crear(Request $request){
		
		$nombre = $request->nombre;
		$email = $request->email;
		$rol_id = $request->rol;
		$unidad = $request->unidad;
		$clave = $request->clave;
		$clave2 = $request->clave2;

		if($clave != $clave2){
			return redirect()->back()->with('alert', 'Claves no coinciden');
		}
		else{

			$usuario = DB::table('usuarios')->where('email', $email)->get();

			if($usuario){
				return redirect()->back()->with('alert', 'Email ya existe');
			}
			else{

				if(!$unidad){
					$unidad = 0;
				}

				DB::table('usuarios')->insert(['nombre'  => $nombre, 'email' => $email, 'role_id' => $rol_id, 'password' => bcrypt($clave), 'unidad_id' => $unidad]);
				return redirect()->back()->with('alert', 'Usuario creado');
			}	
		}

	}

	function editar(Request $request, $id){
		$nombre = $request->nombre;
		$email = $request->email;
		$rol_id = $request->rol;
		DB::table('usuarios')->where('id', $id)->update(['nombre'  => $nombre, 'email' => $email, 'role_id' => $rol_id]);
		return redirect()->back()->with('alert', 'Usuario editado');
	}

	function eliminar($id){
		DB::table('usuarios')->where('id', $id)->delete();
		return redirect()->back()->with('alert', 'Usuario eliminado');
	}

}
