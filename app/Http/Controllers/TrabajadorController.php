<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;

class TrabajadorController extends Controller
{
    public function search($ndoc)
    {
        $sql =  DB::select("SELECT * FROM Trabajador where numeroDocumento = ? AND estado = 1 ", [$ndoc]);
        if (count($sql) != 0) {
            return response()->json(['trabajador' => $sql[0]]); 
        }
        else {
            return response()->json(['trabajador' => 0]);
        }
    }
    
    public function sincronizar_sap()
    {
        set_time_limit(6000);
        echo "Sincronizando Trabajadores con SAP <br>";
        echo "Procesando .... Esto puede tomar un momento <br>";
        $ch = curl_init();

        //login

        $params = [
            "UsuarioWA" => "20602336141",
            "ContraseñaWA" => "1B4OP3RUS.4.C"
        ];

        $payload = json_encode($params);

        curl_setopt($ch, CURLOPT_URL, "http://54.235.215.155:8890/api/Login/EXT_Autentificar");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $error = [];
        if (curl_errno($ch)) {
            $error = ['Error' => curl_error($ch)];
            echo "Error con SAP al loguear.... ". curl_error($ch) . " <br>";
        }
        curl_close ($ch);


        $token = json_decode($result);
        //var_dump($token);
        //exit();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://54.235.215.155:8890/api/Personal/EXT_ObtenerPersonalActivo?prmstrSociedad=&prmstrCategoria=');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: Token $token";
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $error = [];
        if (curl_errno($ch)) {
            $error = ['Error' => curl_error($ch)];
            echo "Error con SAP al obtener trabajadores.... ". curl_error($ch) . " <br>";
        }
        curl_close ($ch);


        $file = fopen("trabajadores.json", "w");
        fwrite($file, $result.PHP_EOL);
        fclose($file);
        $data = json_decode($result, true);
        if (count($data) > 0) {
            DB::update("UPDATE Trabajador SET estado = 0");
            /*
            @codigoEmpresa CHAR(4),
            @tarjetaRFID VARCHAR(50),
            @codigoTrabajador VARCHAR(50),
            @nroDocumento VARCHAR(50),
            @apellidoPaterno VARCHAR(50),
            @apellidoMaterno VARCHAR(50),
            @nombres VARCHAR(50),
            @categoria VARCHAR(50),
            @area VARCHAR(50),
            @cargo VARCHAR(50)  
            */
            foreach ($data as $item) {
                //var_dump($item);
                $codigoEmpresa = $item['Sociedad'];
                $tarjetaRFID = $item['TarjetaProximidad']; 
                $codigoTrabajador = $item['NumeroPersonal'];
                $nroDocumento = $item['DNI'];
                $apellidoPaterno = $item['ApellidoPaterno'];
                $apellidoMaterno = $item['ApellidoMaterno'];
                $nombres = $item['Nombre'];
                $categoria = $item['Categoria'];
                $area = $item['DesUnidadOrganizativa'];
                $cargo = $item['DesPosicion'];

                $sql = DB::select("EXEC [AlertBus_SAP_SP_Trabajadores] ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", [$codigoEmpresa, $tarjetaRFID, $codigoTrabajador, $nroDocumento, $apellidoPaterno, $apellidoMaterno, $nombres, $categoria, $area, $cargo]);
            }
        }
        echo "Procesando.... Hecho! <br>";
        echo "Sincronizacion Terminada. Cierre esta pestaña.... <br>";
        $this->sincronizar_sap_black_list();
    }

    public function sincronizar_sap_black_list()
    {
        set_time_limit(6000);
        echo "Sincronizando Trabajadores con SAP <br>";
        echo "Procesando .... Esto puede tomar un momento <br>";
        $ch = curl_init();

        //login

        $params = [
            "UsuarioWA" => "20602336141",
            "ContraseñaWA" => "1B4OP3RUS.4.C"
        ];

        $payload = json_encode($params);

        curl_setopt($ch, CURLOPT_URL, "http://54.235.215.155:8890/api/Login/EXT_Autentificar");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $error = [];
        if (curl_errno($ch)) {
            $error = ['Error' => curl_error($ch)];
            echo "Error con SAP al loguear.... ". curl_error($ch) . " <br>";
        }
        curl_close ($ch);


        $token = json_decode($result);
        //var_dump($token);
        //exit();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://54.235.215.155:8890/api/Personal/EXT_ObtenerPersonalObservado?prmstrDNI=');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        
        $headers = array();
        $headers[] = 'Accept: application/json';
        $headers[] = "Authorization: Token $token";
        $headers[] = "Content-Type: application/json";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($ch);
        $error = [];
        if (curl_errno($ch)) {
            $error = ['Error' => curl_error($ch)];
            echo "Error con SAP al obtener trabajadores.... ". curl_error($ch) . " <br>";
        }
        curl_close ($ch);


        $file = fopen("trabajadores_blacklist.json", "w");
        fwrite($file, $result.PHP_EOL);
        fclose($file);
        $data = json_decode($result, true);
        if (count($data) > 0) {
            //DB::update("UPDATE Trabajador SET estado = 0");
            /*
            @codigoEmpresa CHAR(4),
            @tarjetaRFID VARCHAR(50),
            */
            foreach ($data as $item) {
                //var_dump($item);
                $dni = $item['DNI'];
                $nombres = $item['Nombre']; 

                $sql = DB::select("EXEC [AlertBus_SAP_SP_Trabajadores_BlackList] ?, ?", [$dni, $nombres]);
            }
        }
        echo "Procesando.... Hecho! <br>";
        echo "Sincronizacion Terminada. Cierre esta pestaña.... <br>";
        if(Auth::guest()){
            echo '<script type="text/javascript">window.close();</script>';
        }
    }

    public function index()
    {
        $empresas = DB::select("EXEC [SP_AlertBus_listEmpresas]");
        return view('Mantenimiento.trabajadores', ['empresas' => $empresas]);
    }

    public function listar(Request $request)
    {
        $trabajadores = DB::select("EXEC [SP_AlertBus_listTrabajadores] ?", [$request->get('idEmpresa')]);
        return response()->json(['data' => $trabajadores]);
    }
}

