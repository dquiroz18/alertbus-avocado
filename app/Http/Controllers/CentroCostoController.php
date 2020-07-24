<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;

class CentroCostoController extends Controller
{
    public function index()
    {
        $empresas = DB::select("EXEC [SP_AlertBus_listEmpresas]");
        return view('Mantenimiento.centrocostos', ['empresas' => $empresas]);
    }

    public function listar(Request $request)
    {
        $idEmpresa = $request->get('idEmpresa');
        return response()->json(['data' => DB::select("exec SP_AlertBus_listCentroCostos ?", [$idEmpresa])]);
    }

    public function store(Request $request)
    {
        if ($request->get('id') > 0) {
            $centrocosto = $request->get('id');
            $accion = 3;
        }
        else {
            $centrocosto = 0;
            $accion = 1;
        }

        $codigo = $request->get('codigo');
        $descripcion = $request->get('descripcion');
        $empresa = $request->get('idEmpresa');

        $insert = DB::select('exec [SP_AlertBus_CRUD_CentroCosto] ?, ?, ?, ?, ?, ?', [$accion, $centrocosto, $empresa, $codigo, $descripcion, Auth::user()->usuario]);

        return response()->json(['message' => substr($insert[0]->exito, 2), 'success' => substr($insert[0]->exito, 0, 1)]);
    }

    public function delete(Request $request)
    {
        $centrocosto = $request->get('id');

        $delete = DB::select('exec [SP_AlertBus_CRUD_CentroCosto] ?, ?, ?, ?, ?, ?', [4, $centrocosto, 0, '',  '', Auth::user()->usuario]);

        return response()->json(['message' => substr($delete[0]->exito, 2), 'success' => substr($delete[0]->exito, 0, 1)]);
    }

    public function show(Request $request)
    {
        $id = $request->get('idCentroCosto');
        $centrocosto = DB::select('exec [SP_AlertBus_CRUD_CentroCosto] ?, ?, ?, ?, ?, ?', [2, $id, 0, '',  '', Auth::user()->usuario]);
        return response()->json(['data' => $centrocosto[0]]);   
    }

}
