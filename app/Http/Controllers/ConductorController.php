<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;

class ConductorController extends Controller
{
    public function search_by_string($string)
    {
    	$conductores = DB::select("exec SP_AlertBus_Get_Conductor_By_Nombre ?", [$string]);

    	return response()->json(['conductores' => $conductores]);
    }

    public function index()
    {
        $transportistas = DB::select("EXEC [SP_AlertBus_listTransportistas]");
        return view('Mantenimiento.conductores', ['transportistas' => $transportistas]);
    }

    public function listar(Request $request)
    {
        $id = $request->get('idProveedor');
        return response()->json(['data' => DB::select("exec SP_AlertBus_listConductores ?", [$id])]);
    }

    public function store(Request $request)
    {
        if ($request->get('id') > 0) {
            $conductor = $request->get('id');
            $accion = 3;
        }
        else {
            $conductor = 0;
            $accion = 1;
        }

        $codigo = $request->get('codigo');
        $nroDocumento = $request->get('nroDocumento');
        $apPaterno = $request->get('apPaterno');
        $apMaterno = $request->get('apMaterno');
        $nombres = $request->get('nombres');
        $transportista = $request->get('transportista');

        $insert = DB::select('exec [SP_AlertBus_CRUD_conductor] ?, ?, ?, ?, ?, ?, ?, ?', [$accion, $conductor, $transportista, $nroDocumento, $apPaterno, $apMaterno, $nombres, Auth::user()->usuario]);

        return response()->json(['message' => substr($insert[0]->exito, 2), 'success' => substr($insert[0]->exito, 0, 1)]);
    }

    public function delete(Request $request)
    {
        $conductor = $request->get('id');

        $delete = DB::select('exec [SP_AlertBus_CRUD_conductor] ?, ?, ?, ?, ?, ?, ?, ?', [4, $conductor, 0, '', '',  '',  '',  Auth::user()->usuario]);

        return response()->json(['message' => substr($delete[0]->exito, 2), 'success' => substr($delete[0]->exito, 0, 1)]);
    }

    public function show(Request $request)
    {
        $id = $request->get('idConductor');
        $conductor = DB::select('exec [SP_AlertBus_CRUD_conductor] ?, ?, ?, ?, ?, ?, ?, ?', [2, $id, 0, '',  '', '', '',  '',  Auth::user()->usuario]);
        return response()->json(['data' => $conductor[0]]);   
    }

}
