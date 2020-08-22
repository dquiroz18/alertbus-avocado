<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;

class UsuarioWebController extends Controller
{
    public function create()
    {
        $empresas = DB::select("exec [SP_AlertBus_listEmpresas]");
    	$proveedores = DB::select("exec [SP_AlertBus_listTransportistas]");
    	return view('seguridad.u_web', ['proveedores' => $proveedores, 'empresas' => $empresas]);
    }

    public function listar(Request $request)
    {
        $data = DB::select("exec [SP_AlertBus_listUsuarioWeb]");
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
        if (strlen($password) > 0) {
            $password = bcrypt($password);
        }
        $tipo = $request->get('tipo');
        $idProveedor = $request->get('proveedor');
        $empresa = null;
        $arr_empresa = $request->get('empresa');
        if (count($arr_empresa) > 0) {
            $empresa = implode('-', $arr_empresa);
        }
        $insert = DB::select('exec [SP_AlertBus_CRUD_UsuarioWeb] ?, ?, ?, ?, ?, ?, ?, ?', [$accion, $id, $empresa, $idProveedor, $usuario, $password, $tipo, Auth::user()->usuario]);

        return response()->json(['message' => substr($insert[0]->exito, 2), 'success' => substr($insert[0]->exito, 0, 1)]);
    }

    public function delete(Request $request)
    {
    	$id = $request->get('id');

    	$insert = DB::select('exec [SP_AlertBus_CRUD_UsuarioWeb] ?, ?, ?, ?, ?, ?, ?, ?', [4, $id, '', '', '', '', '', Auth::user()->usuario]);

        return response()->json(['message' => substr($insert[0]->exito, 2), 'success' => substr($insert[0]->exito, 0, 1)]);
    }
}
