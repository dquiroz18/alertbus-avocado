<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    public function search_by_string($string, $id)
    {
    	$vehiculos = DB::select("exec SP_AlertBus_Get_Vehiculo_By_Placa ?, ?", [$string, $id]);

    	return response()->json(['vehiculos' => $vehiculos]);
    }
    
    public function index()
    {
        $transportistas = DB::select("EXEC [SP_AlertBus_listTransportistas]");
        return view('Mantenimiento.vehiculos', ['transportistas' => $transportistas]);
    }

    public function listar(Request $request)
    {
        $id = $request->get('idProveedor');
        return response()->json(['data' => DB::select("exec SP_AlertBus_listVehiculos ?", [$id])]);
    }

    public function listarTipoVehiculos(Request $request)
    {
        $id = $request->get('idProveedor');
        return response()->json(['data' => DB::select("exec [SP_AlertBus_listTiposVehiculos] ?, ?", [$id, 0])]);   
    }

    public function storeTipoVehiculo(Request $request)
    {
        $tipoVehiculo = $request->get('tipoVehiculo');
        $idProveedor = $request->get('idProveedor');
        $insert = DB::select('exec [SP_AlertBus_CRUD_TipoVehiculo] ?, ?, ?, ?, ?', [1, 0, $idProveedor, $tipoVehiculo, Auth::user()->usuario]);
        return response()->json(['message' => substr($insert[0]->exito, 2), 'success' => substr($insert[0]->exito, 0, 1)]);
    }

    public function deleteTipoVehiculo(Request $request)
    {
        $idProveedor = $request->get('idProveedor');
        $tipoVehiculo = $request->get('tipoVehiculo');
        $insert = DB::select('exec [SP_AlertBus_CRUD_TipoVehiculo] ?, ?, ?, ?, ?', [4, 0, $idProveedor, $tipoVehiculo, Auth::user()->usuario]);
        return response()->json(['message' => substr($insert[0]->exito, 2), 'success' => substr($insert[0]->exito, 0, 1)]);
    }

    public function store(Request $request)
    {
        if ($request->get('id') > 0) {
            $vehiculo = $request->get('id');
            $accion = 3;
        }
        else {
            $vehiculo = 0;
            $accion = 1;
        }

        $placa = $request->get('placa');
        $capacidad = $request->get('capacidad');
        if ($request->get('flag') == null) {
            $flag = 0;
        }
        else{
            $flag = $request->get('flag');    
        }
        
        $covid = $request->get('covid');
        $transportista = $request->get('transportista');
        $tipoVehiculo = $request->get('tipoVehiculo');

        $insert = DB::select('exec [SP_AlertBus_CRUD_vehiculo] ?, ?, ?, ?, ?, ?, ?, ?, ?', [$accion, $vehiculo, $transportista, $tipoVehiculo, $placa, $capacidad, $flag, $covid, Auth::user()->usuario]);

        return response()->json(['message' => substr($insert[0]->exito, 2), 'success' => substr($insert[0]->exito, 0, 1)]);
    }

    public function delete(Request $request)
    {
        $vehiculo = $request->get('id');

        $delete = DB::select('exec [SP_AlertBus_CRUD_vehiculo] ?, ?, ?, ?, ?, ?, ?, ?, ?', [4, $vehiculo, 0, 0, '',  '', 0, 0, Auth::user()->usuario]);

        return response()->json(['message' => substr($delete[0]->exito, 2), 'success' => substr($delete[0]->exito, 0, 1)]);
    }

    public function show(Request $request)
    {
        $id = $request->get('idVehiculo');
        $vehiculo = DB::select('exec [SP_AlertBus_CRUD_vehiculo] ?, ?, ?, ?, ?, ?, ?, ?, ?', [2, $id, 0, 0, '',  '', 0, 0, Auth::user()->usuario]);
        return response()->json(['data' => $vehiculo[0]]);   
    }


}
