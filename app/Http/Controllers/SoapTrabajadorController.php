<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class SoapTrabajadorController extends Controller
{
    public function getTrabajadoresSistemaExterno()
    {
		$wsdl = 'http://190.108.86.51:8069/WSNISIRA/WebServiceNisira?wsdl'	; //URL de nuestro servicio soap

		//Basados en la estructura del servicio armamos un array
		$params = array(
		    "Dbconexion" => "ECOSAC",
		    "Idemp" => ""
		    );

		$options = array(
			"uri"=> $wsdl,
			"style"=> SOAP_RPC,
			"use"=> SOAP_ENCODED,
			'soap_version' => SOAP_1_1, 
		    'exceptions' => false, 
		    'trace' => true, 
    		'cache_wsdl' => WSDL_CACHE_NONE,
        	'ignoreSslErrors' => true
			);

		//Enviamos el Request
		$soap = new \SoapClient($wsdl, $options);
		$result = $soap->getTrabajadoresSistemaExterno($params); //Aquí cambiamos dependiendo de la acción del servicio que necesitemos ejecutar
		$file = fopen("trabajadores_ecosac.json", "w");
		fwrite($file, $result->return)	;
		fclose($file);
		$data = json_decode($result->return, TRUE);
		DB::update("UPDATE Trabajador SET estado = 0");
		foreach ($data as $row) {
			$query = DB::select("EXEC [AlertBus_Nisira_SP_Trabajadores] ?, ?, ?, ?, ?, ?, ?, ?", 
				[ 
					$row['idempresa'],
					$row['idtrabajador'],
					$row['appaterno'],
					$row['apmaterno'],
					$row['nombres'],
					$row['nrodocumento'],
					$row['listanegra'],
					$row['numerotarjeta']
			 ]);
		}
		echo 'Operacion Realizada!';
		echo '<script>window.close()</script>';
    }

    public function enviarMarcacionesTrabajadores()
    {
    	$marcaciones = DB::select("EXEC [AlertBus_Nisira_SP_Sincronizacion_Marcaciones]");
    	$xmlr = new \SimpleXMLElement("<List></List>");
    	foreach ($marcaciones as $row) {
    		$marcacion = $xmlr->addChild('Marcacion');
    		$marcacion->addChild('idempresaexterno', $row->codigoEmpresa);
			$marcacion->addChild('idtrabajador', $row->codigoTrabajador);
			$marcacion->addChild('apenom', $row->nombreTrabajador);
			$marcacion->addChild('fecha', $row->fechaHora);
			$marcacion->addChild('marcacion', $row->hora);
			$marcacion->addChild('idresponsableexterno', $row->codigoResponsable);
			$marcacion->addChild('validacionrrh', $row->flagTareo);
    	}
		$wsdl = 'http://190.108.86.51:8069/WSNISIRA/WebServiceNisira?wsdl'	; //URL de nuestro servicio soap
		$file = fopen("test.xml", "w+");
		fwrite($file, $xmlr->asXML());
		fclose($file);
		//Basados en la estructura del servicio armamos un array
		$params = array(
		    "Dbconexion" => "ECOSAC",
		    "Idemp" => "001",
		    "XmlMarcaciones" => $xmlr->asXML()
		    );

		$options = array(
			"uri"=> $wsdl,
			"style"=> SOAP_RPC,
			"use"=> SOAP_ENCODED,
			'soap_version' => SOAP_1_1, 
		    'exceptions' => false, 
		    'trace' => true, 
    		'cache_wsdl' => WSDL_CACHE_NONE,
        	'ignoreSslErrors' => true
			);

		//Enviamos el Request
		$soap = new \SoapClient($wsdl, $options);
		$result = $soap->registroMarcacionesExternas($params); //Aquí cambiamos dependiendo de la acción del servicio que necesitemos ejecutar
		echo $result->return. "<br>";
		echo 'Operacion Realizada!';
		echo '<script>window.close()</script>';
    }

    public function getCentroCostos()
    {
		$wsdl = 'http://190.108.86.51:8069/WSNISIRA/WebServiceNisira?wsdl'	; //URL de nuestro servicio soap

		//Basados en la estructura del servicio armamos un array
		$params = array(
		    "dbconexion" => "ECOSAC",
		    "Idemp" => ""
		    );

		$options = array(
			"uri"=> $wsdl,
			"style"=> SOAP_RPC,
			"use"=> SOAP_ENCODED,
			'soap_version' => SOAP_1_1, 
		    'exceptions' => false, 
		    'trace' => true, 
    		'cache_wsdl' => WSDL_CACHE_NONE,
        	'ignoreSslErrors' => true
			);

		//Enviamos el Request
		$soap = new \SoapClient($wsdl, $options);
		$result = $soap->getConsExternoAll($params); //Aquí cambiamos dependiendo de la acción del servicio que necesitemos ejecutar
		$data = json_decode($result->return, TRUE);
		//var_dump($data);
		DB::update("UPDATE CentroCosto SET estado = 0");
		foreach ($data as $row) {
			$query = DB::select("EXEC [AlertBus_Nisira_SP_CentroCostos] ?, ?, ?, ?, ?", 
				[ 
					$row['idempresa'],
					$row['idconsumidor'],
					$row['tipo'],
					$row['jerarquia'],
					$row['descripcion']
			 ]);
		}
		echo 'Operacion Realizada!';
		echo '<script>window.close()</script>';
    }

    public function getProveedores()
    {
    	echo "Proveedores de idEmpresa 2 <br>";
		$soapUrl = "http://190.108.86.52:8092/ecosacIbaoWs/EcosacIbaoWs.asmx?op=obtenerProveedor"; // asmx URL of WSDL

        // xml post structure
		$idEmpresa = 2;
        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                              <soap:Body>
                                <obtenerProveedor  xmlns="http://localhost/">
                                  <idEmpresa>'.$idEmpresa.'</idEmpresa> 
                                </obtenerProveedor  >
                              </soap:Body>
                            </soap:Envelope>';   // data from the form, e.g. some ID number

		$headers = array(
	        "Content-type: text/xml;charset=\"utf-8\"",
	        "Accept: text/xml",
	        "Cache-Control: no-cache",
	        "Pragma: no-cache",
	        "SOAPAction: \"http://localhost/obtenerProveedor\"", 
	        "Content-length: ".strlen($xml_post_string),
	    ); //SOAPAction: your op URL

		$url = $soapUrl;

		// PHP cURL  for https connection with auth
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		// converting
		$response = curl_exec($ch); 
		curl_close($ch);

		//var_dump($response);
		// converting
		$response1 = str_replace("<soap:Body>","",$response);
		//var_dump($response1);
		$response2 = str_replace("</soap:Body>","",$response1);
		//var_dump($response2);
		// convertingc to XML
		$parser = simplexml_load_string($response2);
		//var_dump($parser->obtenerProveedorResponse->obtenerProveedorResult);
		$final = json_decode($parser->obtenerProveedorResponse->obtenerProveedorResult, true);
		//var_dump($final);
		if (isset($final["data"])) {
			$data = $final["data"];
			DB::update("UPDATE Proveedor SET estado = 0");
			foreach ($data as $row) {
				$query = DB::select("EXEC [AlertBus_Periferico_SP_Proveedores] ?, ?, ?, ?", 
				[ 
					$row['id'],
					$row['ruc'],
					$row['razonSocial'],
					$row['esTransportista']
				]);
			}	
		}
		echo 'Operacion Realizada! <br>';
		echo "Proveedores de idEmpresa 3 <br>";

		$soapUrl = "http://190.108.86.52:8092/ecosacIbaoWs/EcosacIbaoWs.asmx?op=obtenerProveedor"; // asmx URL of WSDL

        // xml post structure
		$idEmpresa = 2;
        $xml_post_string = '<?xml version="1.0" encoding="utf-8"?>
                            <soap:Envelope xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xsd="http://www.w3.org/2001/XMLSchema" xmlns:soap="http://schemas.xmlsoap.org/soap/envelope/">
                              <soap:Body>
                                <obtenerProveedor  xmlns="http://localhost/">
                                  <idEmpresa>'.$idEmpresa.'</idEmpresa> 
                                </obtenerProveedor  >
                              </soap:Body>
                            </soap:Envelope>';   // data from the form, e.g. some ID number

		$headers = array(
	        "Content-type: text/xml;charset=\"utf-8\"",
	        "Accept: text/xml",
	        "Cache-Control: no-cache",
	        "Pragma: no-cache",
	        "SOAPAction: \"http://localhost/obtenerProveedor\"", 
	        "Content-length: ".strlen($xml_post_string),
	    ); //SOAPAction: your op URL

		$url = $soapUrl;

		// PHP cURL  for https connection with auth
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_ANY);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $xml_post_string); // the SOAP request
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		// converting
		$response = curl_exec($ch); 
		curl_close($ch);

		//var_dump($response);
		// converting
		$response1 = str_replace("<soap:Body>","",$response);
		//var_dump($response1);
		$response2 = str_replace("</soap:Body>","",$response1);
		//var_dump($response2);
		// convertingc to XML
		$parser = simplexml_load_string($response2);
		//var_dump($parser->obtenerProveedorResponse->obtenerProveedorResult);
		$final = json_decode($parser->obtenerProveedorResponse->obtenerProveedorResult, true);
		//var_dump($final);
		if (isset($final["data"])) {
			$data = $final["data"];
			DB::update("UPDATE Proveedor SET estado = 0");
			foreach ($data as $row) {
				$query = DB::select("EXEC [AlertBus_Periferico_SP_Proveedores] ?, ?, ?, ?", 
				[ 
					$row['id'],
					$row['ruc'],
					$row['razonSocial'],
					$row['esTransportista']
				]);
			}	
		}
		echo 'Operacion Realizada! <br>';
		echo '<script>window.close()</script>';
    }

}
