<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;

class PDFController extends Controller
{
    public function liqui_pdf($idEmpresa, $idCentroCosto, $idTransportista, $idRuta, $idTipoViaje, $desde, $hasta, $sp_name)
    {
    	$result = DB::select("exec $sp_name ?, ?, ?, ?, ?, ?, ?", [$idEmpresa, $idCentroCosto, $idTransportista, $idRuta, $idTipoViaje, $desde, $hasta]);
    	$data = collect();
    	$empresa = strtoupper($result[0]->nombreEmpresa);
        $logo = $result[0]->logo;
    	foreach ($result as $row) {
    		$data->push($row);
    	}
    	$proveedores = $data->groupBy('nombreProveedor');
    	PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif', 'orientation' => 'landscape']);
        return PDF::loadView('reportes.liquidacion_pdf', [
        	'empresa' => $empresa,
        	'proveedores' => $proveedores,
        	'desde' => $desde,
        	'hasta' => $hasta,
            'logo' => $logo
        ])->download('Reporte Liquidacion.pdf');
    }

    public function manifiestoPDF($idViaje){
        
        $result = DB::select("exec SP_AlertBus_RPT_Viaje_Manifiesto ?", [$idViaje]);
        $logo = $result[0]->logo;
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif', 'orientation' => 'landscape']);
        return PDF::loadView('reportes.manifiesto_pdf', ['data' => $result, 'logo' => $logo])->download('Reporte Manifiesto.pdf');
    }

    public function manifiesto_pdf($idEmpresa, $idCentroCosto, $idTransportista, $idRuta, $idTipoViaje, $desde, $hasta, $sp_name)
    {
        $result = DB::select("exec $sp_name ?, ?, ?, ?, ?, ?, ?", [$idEmpresa, $idCentroCosto, $idTransportista, $idRuta, $idTipoViaje, $desde, $hasta]);
        $data = collect();
        $empresa = strtoupper($result[0]->nombreEmpresa);
        $logo = $result[0]->logo;
        foreach ($result as $row) {
            $data->push($row);
        }
        $data = $data->groupBy('idViaje');
        PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif', 'orientation' => 'landscape']);
        return PDF::loadView('reportes.manifiesto_pdf', [
            'empresa' => $empresa,
            'data' => $data,
            'desde' => $desde,
            'hasta' => $hasta,
            'logo' => $logo
        ])->download('Reporte Manifiesto.pdf');
    }
}