<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function viaje_personal()
    {
    	$empresas = DB::select("exec SP_AlertBus_listEmpresas");
        $centrocostos = DB::select("exec SP_AlertBus_listCentroCostos");
        $transportistas = DB::select("exec SP_AlertBus_listTransportistas");
        $rutas = DB::select("exec SP_AlertBus_listRutas");
        $tiposViajes = DB::select("exec SP_AlertBus_listTiposViajes");
        $vehiculos = DB::select("exec SP_AlertBus_Get_Placa");
    	return view('reportes.detalle_trabajadores', [
            'empresas' => $empresas,
            'centrocostos' => $centrocostos,
            'transportistas' => $transportistas,
            'rutas' => $rutas,
            'tiposViajes' => $tiposViajes,
            'vehiculos' => $vehiculos,
            'header' => ['Empresa','Fecha','Centro Costo','Transportista','Ruta','Tipo Vehículo','Placa','Hora Inicio','Hora Fin','Nro. Documento', 'Trabajador', 'Restricción']
        ]);
    }

    public function tracking($id) 
    {
        $result = DB::select("exec SP_AlertBus_RPT_Viaje_Tracking ?", [$id]);
        return view('reportes.tracking_iframe', [
            'result' => $result
        ]);
    }

    public function viajes()
    {
    	$empresas = DB::select("exec SP_AlertBus_listEmpresas");
        $centrocostos = DB::select("exec SP_AlertBus_listCentroCostos");
        $transportistas = DB::select("exec SP_AlertBus_listTransportistas");
        $rutas = DB::select("exec SP_AlertBus_listRutas");
        $tiposViajes = DB::select("exec SP_AlertBus_listTiposViajes");
        $vehiculos = DB::select("exec SP_AlertBus_Get_Placa");
    	return view('reportes.viajes', [
            'empresas' => $empresas,
            'centrocostos' => $centrocostos,
            'transportistas' => $transportistas,
            'rutas' => $rutas,
            'tiposViajes' => $tiposViajes,
            'vehiculos' => $vehiculos,
            'header' => ['Ver Detalle','Ver Tracking','Manifiesto','Empresa','Fecha','Centro Costo','Transportista','Ruta','Tipo Vehículo','Tarifa','Conductor','Placa','Hora Inicio','Hora Fin','Duración','Cant. Pasajeros', '% Ocupación']
        ]);
    }

    public function viaje_detalle($id)
    {
        $cabecera = DB::select('exec SP_AlertBus_RPT_Viaje_Detalle_Cabecera ?', [$id]);
    	$result = DB::select("exec SP_AlertBus_RPT_Viaje_Detalle ?", [$id]);

        $empresas = DB::select("exec SP_AlertBus_listEmpresas");
        $areas = DB::select("exec SP_AlertBus_listAreas");
        $centrocostos = DB::select("exec SP_AlertBus_listCentroCostos");
        $transportistas = DB::select("exec SP_AlertBus_listTransportistas");
        $rutas = DB::select("exec SP_AlertBus_listRutas");
        $tiposViajes = DB::select("exec SP_AlertBus_listTiposViajes");
        $tiposVehiculos = DB::select("exec SP_AlertBus_listTiposVehiculos");
        $vehiculos = DB::select("exec SP_AlertBus_Get_Placa");
        $conductores = DB::select("exec SP_AlertBus_Get_Conductor");

    	return view('reportes.viaje_detalle', [
            'result' => $result,
            'cabecera' => $cabecera,
            'empresas' => $empresas,
            'areas' => $areas,
            'centrocostos' => $centrocostos,
            'transportistas' => $transportistas,
            'rutas' => $rutas,
            'tiposViajes' => $tiposViajes,
            'tiposVehiculos' => $tiposVehiculos,
            'vehiculos' => $vehiculos,
            'conductores' => $conductores
        ]);
    }

    public function viaje_tracking($id)
    {
        $detalle = DB::select("exec SP_AlertBus_RPT_Viaje_Tracking_Cabecera ?", [$id]);
        return view('reportes.tracking', [
            'id' => $id,
            'detalle' => $detalle[0]
        ]);
    }

    public function liquidacion()
    {
    	$empresas = DB::select("exec SP_AlertBus_listEmpresas");
        $centrocostos = DB::select("exec SP_AlertBus_listCentroCostos");
        $transportistas = DB::select("exec SP_AlertBus_listTransportistas");
        $rutas = DB::select("exec SP_AlertBus_listRutas");
        $tiposViajes = DB::select("exec SP_AlertBus_listTiposViajes");
        $tiposVehiculos = DB::select("exec SP_AlertBus_listTiposVehiculos");
        $vehiculos = DB::select("exec SP_AlertBus_Get_Placa");
    	return view('reportes.liquidacion', [
            'empresas' => $empresas,
            'centrocostos' => $centrocostos,
            'transportistas' => $transportistas,
            'rutas' => $rutas,
            'tiposViajes' => $tiposViajes,
            'vehiculos' => $vehiculos,
            'header' => ['Empresa','Fecha','Centro Costo','Transportista','Ruta','Tipo Vehículo','Placa','Tarifa','Cant. Pasajeros','% Ocupación']
        ]);
    }

    public function filtrar($idEmpresa = 0, $idCentroCosto = 0, $idTransportista = 0, $idRuta = 0, $idTipoTarifa = 0, $desde = 0, $hasta = 0, $sp_name = 0)
    {
        $result = DB::select("exec $sp_name ?, ?, ?, ?, ?, ?, ?", [$idEmpresa, $idCentroCosto, $idTransportista, $idRuta, $idTipoTarifa, $desde, $hasta]);

        return response()->json(['dataset' => $result]);
    }
}