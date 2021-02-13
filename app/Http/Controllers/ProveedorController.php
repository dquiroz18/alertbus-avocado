<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
class ProveedorController extends Controller
{
    public function index()
    {
        $empresas = DB::select("exec SP_AlertBus_listEmpresas");
        return view('Mantenimiento.proveedores', ['empresas' => $empresas]);
    }

    public function listar(Request $request)
    {
        return response()->json(['data' => DB::select("exec [SP_AlertBus_listTransportistas] ?", [ $request->get('idEmpresa')] )]);
    }

    public function sincronizacion_sap()
    {
        set_time_limit(6000);
        echo "Sincronizando Proveedores con SAP <br>";
        echo "Procesando .... Esto puede tomar un momento <br>";
        $ch = curl_init();

        $payload = json_encode(['idEmpresa' => 2]);
        curl_setopt($ch, CURLOPT_URL, 'http://190.108.86.52:8092/ecosacIbaoWs/EcosacIbaoWs.asmx?op=obtenerProveedor');
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
        var_dump($result);
        exit();
        $data = json_decode($result);
        foreach ($data as $row) {
            $query = DB::select("EXEC [AlertBus_Periferico_SP_Proveedores] ?, ?, ?, ?", 
                [ 
                    $row['id'],
                    $row['ruc'],
                    $row['razonSocial'],
                    $row['esTransportista']
             ]);
        }
        echo 'Operacion Realizada!';
        echo '<script>window.close()</script>';
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

        $idEmpresa = $request->get('idEmpresa');
        if (is_array($idEmpresa)) {
            $idEmpresa = implode('-', $idEmpresa);
        }
        $codigo = $request->get('codigo');
        $descripcion = $request->get('descripcion');
        $ruc = $request->get('ruc');

        $insert = DB::select('exec [SP_AlertBus_CRUD_proveedor] ?, ?, ?, ?, ?, ?', [$accion, $proveedor, $ruc, $descripcion, Auth::user()->usuario, $idEmpresa]);

        return response()->json(['message' => substr($insert[0]->exito, 2), 'success' => substr($insert[0]->exito, 0, 1)]);
    }

    public function delete(Request $request)
    {
        $proveedor = $request->get('id');

        $delete = DB::select('exec [SP_AlertBus_CRUD_proveedor] ?, ?, ?, ?, ?, ?', [4, $proveedor, 0, '', Auth::user()->usuario, '']);

        return response()->json(['message' => substr($delete[0]->exito, 2), 'success' => substr($delete[0]->exito, 0, 1)]);
    }

    public function show(Request $request)
    {
        $id = $request->get('idProveedor');
        $proveedor = DB::select('exec [SP_AlertBus_CRUD_proveedor] ?, ?, ?, ?, ?, ?', [2, $id, 0, '', Auth::user()->usuario, '']);
        return response()->json(['data' => $proveedor[0]]);   
    }

}
