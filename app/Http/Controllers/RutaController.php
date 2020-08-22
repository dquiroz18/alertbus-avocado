<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class RutaController extends Controller
{

    public function index()
    {
        $transportistas = DB::select("EXEC [SP_AlertBus_listTransportistas]");
        return view('Mantenimiento.rutas', ['transportistas' => $transportistas]);
    }

    public function getOrigenesByTransportista(Request $request)
    {
        $origenes = DB::select("SELECT DISTINCT origen FROM Ruta WHERE estado = 1 ORDER BY origen");
        return response()->json(['data' => $origenes]);
    }

    public function getDestinosByTransportista(Request $request)
    {
        $destinos = DB::select("SELECT DISTINCT destino FROM Ruta WHERE estado = 1 ORDER BY destino");
        return response()->json(['data' => $destinos]);
    }

    public function listar(Request $request)
    {
        $id = $request->get('idProveedor');
        $combo = 0;
        if ($request->get('combo') !== null) {
            $combo = $request->get('combo');
        }
        return response()->json(['data' => DB::select("exec SP_AlertBus_listRutas ?, ?", [$id, $combo])]);
    }

    public function store(Request $request)
    {
        if ($request->get('id') > 0) {
            $ruta = $request->get('id');
            $accion = 3;
        }
        else {
            $ruta = 0;
            $accion = 1;
        }

        $codigo = $request->get('codigo');
        $origen = $request->get('origen');
        $destino = $request->get('destino');
        $empresa = $request->get('transportista');
        $paraderos = $request->get('paraderos');
        //var_dump($paraderos);
        $insert = DB::select('exec [SP_AlertBus_CRUD_ruta] ?, ?, ?, ?, ?, ?, ?, ?', [$accion, $ruta, $empresa, $codigo, $origen, $destino, $paraderos, Auth::user()->usuario]);

        return response()->json(['message' => substr($insert[0]->exito, 2), 'success' => substr($insert[0]->exito, 0, 1)]);
    }

    public function delete(Request $request)
    {
        $ruta = $request->get('id');

        $delete = DB::select('exec [SP_AlertBus_CRUD_ruta] ?, ?, ?, ?, ?, ?, ?, ?', [4, $ruta, 0, '',  '', '', '', Auth::user()->usuario]);

        return response()->json(['message' => substr($delete[0]->exito, 2), 'success' => substr($delete[0]->exito, 0, 1)]);
    }

    public function show(Request $request)
    {
        $id = $request->get('idRuta');
        $ruta = DB::select('exec [SP_AlertBus_CRUD_ruta] ?, ?, ?, ?, ?, ?, ?, ?', [2, $id, 0, '',  '', '', '', Auth::user()->usuario]);
        return response()->json(['data' => $ruta[0]]);   
    }


}
