<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class ProveedorController extends Controller
{
    public function index()
    {
        return view('Mantenimiento.proveedores');
    }

    public function listar()
    {
        return response()->json(['data' => DB::select("exec [SP_AlertBus_listTransportistas]")]);
    }

    public function sincronizacion_sap()
    {
        set_time_limit(6000);
        echo "Sincronizando Proveedores con SAP <br>";
        echo "Procesando .... Esto puede tomar un momento <br>";
        $ch = curl_init();

        $payload = json_encode(['idEmpresa' => 2]);
        curl_setopt($ch, CURLOPT_URL, 'http://190.108.86.52:8092/ecosacIbaoWs/EcosacIbaoWs.asmx/obtenerProveedor');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

        $headers = array();
        $headers[] = 'Accept: application/json';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Length: 0'));

        $result = curl_exec($ch);
        $error = [];
        if (curl_errno($ch)) {
        $error = ['Error' => curl_error($ch)];
        echo "Error con SAP.... ". curl_error($ch) . " <br>";

        }
        curl_close ($ch);
        echo($result);
    }

    public function store(Request $request)
    {
        if ($request->get('id') > 0) {
            $proveedor = $request->get('id');
            $accion = 3;
        }
        else {
            $proveedor = 0;
            $accion = 1;
        }

        $codigo = $request->get('codigo');
        $descripcion = $request->get('descripcion');
        $ruc = $request->get('ruc');

        $insert = DB::select('exec [SP_AlertBus_CRUD_proveedor] ?, ?, ?, ?, ?', [$accion, $proveedor, $ruc, $descripcion, Auth::user()->usuario]);

        return response()->json(['message' => substr($insert[0]->exito, 2), 'success' => substr($insert[0]->exito, 0, 1)]);
    }

    public function delete(Request $request)
    {
        $proveedor = $request->get('id');

        $delete = DB::select('exec [SP_AlertBus_CRUD_proveedor] ?, ?, ?, ?, ?', [4, $proveedor, 0, '',  Auth::user()->usuario]);

        return response()->json(['message' => substr($delete[0]->exito, 2), 'success' => substr($delete[0]->exito, 0, 1)]);
    }

    public function show(Request $request)
    {
        $id = $request->get('idProveedor');
        $proveedor = DB::select('exec [SP_AlertBus_CRUD_proveedor] ?, ?, ?, ?, ?', [2, $id, 0, '', Auth::user()->usuario]);
        return response()->json(['data' => $proveedor[0]]);   
    }

}
