<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;

class UsuarioMovilController extends Controller
{

    public function create()
    {
    	return view('seguridad.u_movil');
    }

    public function listar(Request $request)
    {
        $data = DB::select("exec [SP_AlertBus_listUsuarioMovil]");
        return response()->json(['data' => $data]);
    }

    public function store(Request $request)
    {
    	if ($request->get('id') > 0) {
            $id =$request->get('id');
            $accion = 3;
        }
        else {
            $id = 0;
            $accion = 1 ;
        }

        $usuario = $request->get('usuario');
        $password = $request->get('password');
        $conductor = $request->get('idConductor');

        $insert = DB::select('exec [SP_AlertBus_CRUD_UsuarioMovil] ?, ?, ?, ?, ?, ?', [$accion, $id, $conductor, $usuario, $password, Auth::user()->usuario]);

        return response()->json(['message' => substr($insert[0]->exito, 2), 'success' => substr($insert[0]->exito, 0, 1)]);
    }

    public function delete(Request $request)
    {
    	$id = $request->get('id');

    	$insert = DB::select('exec [SP_AlertBus_CRUD_UsuarioMovil] ?, ?, ?, ?, ?, ?', [5, $id, '', '', '', Auth::user()->usuario]);

        return response()->json(['message' => substr($insert[0]->exito, 2), 'success' => substr($insert[0]->exito, 0, 1)]);
    }

    public function restaurar(Request $request)
    {
        $id = $request->get('id');

        $insert = DB::select('exec [SP_AlertBus_CRUD_UsuarioMovil] ?, ?, ?, ?, ?, ?', [5, $id, '', '', '', Auth::user()->usuario]);

        return response()->json(['message' => substr($insert[0]->exito, 2), 'success' => substr($insert[0]->exito, 0, 1)]);
    }
}
