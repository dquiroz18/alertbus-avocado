<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class TarifaController extends Controller
{
    public function index()
    {
        $transportistas = DB::select("EXEC [SP_AlertBus_listTransportistas]");
        return view('Mantenimiento.tarifas', ['transportistas' => $transportistas]);
    }

    public function listar(Request $request)
    {
        $id = $request->get('idProveedor');
        return response()->json(['data' => DB::select("exec SP_AlertBus_listTarifas ?", [$id])]);
    }
    
    public function store(Request $request)
    {
        if ($request->get('id') > 0) {
            $tarifa = $request->get('id');
            $accion = 3;
        }
        else {
            $tarifa = 0;
            $accion = 1;
        }

        $ruta = $request->get('ruta');
        $tipoVehiculo = $request->get('tipoVehiculo');
        $tipoTarifa = $request->get('tipoTarifa');
        $precio = $request->get('precio');
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');
        $transportista = $request->get('transportista');

        $insert = DB::select('exec [SP_AlertBus_CRUD_tarifa] ?, ?, ?, ?, ?, ?, ?, ?, ?', [$accion, $tarifa, $transportista, $ruta, $tipoVehiculo, $precio, $desde, $hasta, Auth::user()->usuario]);

        return response()->json(['message' => substr($insert[0]->exito, 2), 'success' => substr($insert[0]->exito, 0, 1)]);
    }

    public function listarTipoTarifas(Request $request)
    {
        $id = $request->get('idProveedor');
        return response()->json(['data' => DB::select("exec [SP_AlertBus_listTipoTarifas] ?", [$id])]);   
    }

    public function storeTipoTarifa(Request $request)
    {
        $tipoTarifa = $request->get('tipoTarifa');
        $idProveedor = $request->get('idProveedor');
        $insert = DB::select('exec [SP_AlertBus_CRUD_TipoTarifa] ?, ?, ?, ?, ?', [1, 0, $idProveedor, $tipoTarifa, Auth::user()->usuario]);
        return response()->json(['message' => substr($insert[0]->exito, 2), 'success' => substr($insert[0]->exito, 0, 1)]);
    }

    public function delete(Request $request)
    {
        $tarifa = $request->get('id');

        $delete = DB::select('exec [SP_AlertBus_CRUD_tarifa] ?, ?, ?, ?, ?, ?, ?, ?, ?', [4, $tarifa, 0, 0, 0, 0, '',  '', Auth::user()->usuario]);

        return response()->json(['message' => substr($delete[0]->exito, 2), 'success' => substr($delete[0]->exito, 0, 1)]);
    }

    public function show(Request $request)
    {
        $id = $request->get('idTarifa');
        $tarifa = DB::select('exec [SP_AlertBus_CRUD_tarifa] ?, ?, ?, ?, ?, ?, ?, ?, ?', [2, $id, 0, 0, 0, 0, '',  '', Auth::user()->usuario]);
        return response()->json(['data' => $tarifa[0]]);   
    }


}
