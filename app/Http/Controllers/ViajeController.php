<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Response;
use Session;
use Storage;
use Excel;
use Illuminate\Http\Request;

class ViajeController extends Controller
{

    public function descargar()
    {
        $file= public_path(). "/plantilla_programacion.xlsm";

        $headers = array(
            'Content-Type: application/xlsm',
        );
        return Response::download($file, 'Plantilla Programacion.xlsm', $headers);
    }

    public function subir(Request $request)
    {
        $file = $request->file('file');
        if ($file == null) {
            return back()->with('message-fail', "No se ha seleccionado ningún archivo");
        }
        $filename = $file->getClientOriginalName();
        if (strpos($filename, 'Plantilla Programacion') === false) {
            return back()->with('message-fail', "Archivo inválido");
        }
        $string = "";
        $errors = '';
        Session::put('has_erros', false);
        Session::put('string', $string);
        Excel::selectSheetsByIndex(0)->load($file, function($reader) use ($string) {
            $results = $reader->get();
            //var_dump($results);
            $i = 1;
            foreach ($results as $row) {
                //var_dump($row);
                if (strlen($row->empresa) == 0) {
                    continue;
                }
                $i++;
                $fecha = '';
                $hora = '';
                if (!is_null($row->fecha)) 
                    if ($row->fecha->format('Y-m-d') !==null)
                        $fecha = $row->fecha->format('Y-m-d');
                if (!is_null($row->fecha)) 
                    if ($row->hora->format('Y-m-d') !==null)
                        $hora = $row->hora->format('H:i');
                $sql = DB::select("exec [SP_AlertBus_Programacion_Importar] ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", [$fecha, $hora, $row->empresa, $row->centrocosto, $row->transportista, $row->ruta, $row->tipovehiculo, $row->tarifa, $row->tarifafinal , $row->conductor, $row->vehiculo,  Auth::user()->usuario]);
                $errors = substr($sql[0]->exito, 0, 1);
                if ($errors == '0') {
                    Session::put('has_erros', true);
                    $string .= "Fila $i: " . substr($sql[0]->exito, 2) . PHP_EOL;
                }
                Storage::put('plantilla/errors.txt', $string);
            }
        });

        if (Session::get('has_erros')) {
            $file = storage_path() . '/app/plantilla/errors.txt';

            $headers = array(
                'Content-Type: application/txt',
            );
            return Response::download($file, 'Log.txt', $headers);
        }
        else {
            Session::put('string', 'Subido con Exito');
            return back()->with('message', Session::get('string'));
        }
        
    }

    public function importar(){
        return view('viajes.importar_programacion');
    }

    public function getTrabajador(Request $request)
    {
        $idsViajeDetalle = $request->get('idsViajeDetalle');
        $trabajador = DB::select("exec [SP_AlertBus_Viaje_Trabajador_Ver] ?", [$idsViajeDetalle]);

        $horarios = collect();
        $horasTareo = 0;
        foreach ($trabajador as $t) {
            $horarios->push([
                'idViajeDetalle' => $t->idViajeDetalle,
                'fecha_inicio' => date('Y-m-d' , strtotime($t->horaIngreso)),
                'hora_inicio' => date('H:i' , strtotime($t->horaIngreso)),
                'fecha_fin' => date('Y-m-d' , strtotime($t->horaSalida)),
                'hora_fin' => date('H:i' , strtotime($t->horaSalida))
            ]);
        }

        $tr = (object) [
            'nro_documento' => $trabajador[0]->numeroDocumento,
            'trabajador' => $trabajador[0]->nombreTrabajador
        ];

        $data = ['trabajador' => $tr, 'horarios' => $horarios];

        return response()->json(['data' => $data]);
    }
    public function deleteTrabajador(Request $request)
    {
        $idViajeDetalle = $request->get('idViajeDetalle');
        $sql = DB::select("exec [SP_AlertBus_Viaje_Trabajador_Eliminar] ?, ?", [$idViajeDetalle, Auth::user()->usuario]);
        $estado = $sql[0]->exito;
        return back()->with('message', substr($estado, 2));
    }

    public function editHorario(Request $request)
    {
        $idsViajeDetalle = $request->get('idsViajeDetalle');
        $idViajeDetalle = $request->get('idViajeDetalle');
        $inicio = $request->get('inicio');
        $fin = $request->get('fin');
        $usuario = Auth::user()->usuario;
        $sql = DB::select("EXEC [SP_AlertBus_Viaje_Trabajador_Editar] ?, ?, ?, ?, ?", [$idsViajeDetalle, $idViajeDetalle, $inicio, $fin, $usuario]);
        $estado = $sql[0]->exito;
        return response()->json(['message' => substr($estado, 2)]);    
    }

    public function addHorario(Request $request)
    {
        $idViaje = $request->get('idViaje');
        $numeroDni = $request->get('numeroDni');
        $horaIngreso = $request->get('horaIngreso');
        $horaSalida = $request->get('horaSalida');
        $usuario = Auth::user()->usuario;
        $sql = DB::select("EXEC [SP_AlertBus_Viaje_Trabajador_Insertar] ?, ?, ?, ?, ?", [$idViaje, $numeroDni, $horaIngreso, $horaSalida, $usuario]);
        $estado = $sql[0]->exito;
        return response()->json(['message' => substr($estado, 2)]);    
    }

    public function programar()
    {
        $empresas = DB::select("exec SP_AlertBus_listEmpresas");
        $areas = DB::select("exec SP_AlertBus_listAreas");
        $centrocostos = DB::select("exec SP_AlertBus_listCentroCostos");
        $transportistas = DB::select("exec SP_AlertBus_listTransportistas");
        $rutas = DB::select("exec SP_AlertBus_listRutas");
        $tiposVehiculos = DB::select("exec SP_AlertBus_listTiposVehiculos");
        $tiposViajes = DB::select("exec SP_AlertBus_listTiposViajes");
        $tarifas = DB::select("exec SP_AlertBus_listTarifas");

    	return view('viajes.programar', [
            'empresas' => $empresas,
            'areas' => $areas,
            'centrocostos' => $centrocostos,
            'transportistas' => $transportistas,
            'rutas' => $rutas,
            'tiposVehiculos' => $tiposVehiculos,
            'tiposViajes' => $tiposViajes,
            'tarifas' => $tarifas

        ]);
    }

    public function guardar_programacion(Request $request)
    {
        $nrinsertados = 0;
    	$empresa = $request->get('empresa');
    	$fechas = $request->get('fechas');
        $horas = $request->get('horas');
        //$areas = $request->get('areas');
    	$centrocostos = $request->get('centrocostos');
    	$transportistas = $request->get('transportistas');
    	$rutas = $request->get('rutas');
    	$tiposVehiculos = $request->get('tiposVehiculos');
    	$tarifas = $request->get('tarifas');
    	$precios = $request->get('precios');
    	for ($i=0; $i < count($horas); $i++) {
    		if (!is_null($fechas[$i]) && 
    			!is_null($horas[$i]) &&
                //!is_null($areas[$i]) &&
                !is_null($centrocostos[$i]) &&
    			!is_null($transportistas[$i]) &&
                !is_null($rutas[$i]) &&
    			!is_null($tiposVehiculos[$i])
    		) {

                if ($centrocostos[$i] == '0' ||
                    $transportistas[$i] == '0' ||
                    $rutas[$i] == '0' ||
                    $tiposVehiculos[$i] == '0'
                ) {
                    continue;
                }
                
    			$inserting = DB::select('exec SP_AlertBus_Programacion_Insertar ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?', [
    															$empresa,
    															$fechas[$i],
                                                                $horas[$i],
                                                                //$areas[$i],
                                                                0,
    															$centrocostos[$i],
    															$transportistas[$i],
    															$rutas[$i],
    															$tiposVehiculos[$i],
    															$tarifas[$i],
    															$precios[$i],
                                                                Auth::user()->usuario
    														   ]
    						);
                $nrinsertados++;
    		}
    	}
        return response()->json(['message' => "Se han insertado $nrinsertados registros", 'success' => 1]);
    }

    public function programados()
    {
        $empresas = DB::select("exec SP_AlertBus_listEmpresas");
        $areas = DB::select("exec SP_AlertBus_listAreas");
        $centrocostos = DB::select("exec SP_AlertBus_listCentroCostos");
        $transportistas = DB::select("exec SP_AlertBus_listTransportistas");
        $rutas = DB::select("exec SP_AlertBus_listRutas");
        $tiposViajes = DB::select("exec SP_AlertBus_listTiposViajes");
        $tiposVehiculos = DB::select("exec SP_AlertBus_listTiposVehiculos");
        $tarifas = DB::select("exec SP_AlertBus_listTarifas");
        $vehiculos = DB::select("exec SP_AlertBus_Get_Placa");
        $conductores = DB::select("exec SP_AlertBus_Get_Conductor");
        return view('viajes.programados', [
            'empresas' => $empresas,
            'areas' => $areas,
            'centrocostos' => $centrocostos,
            'transportistas' => $transportistas,
            'rutas' => $rutas,
            'tiposViajes' => $tiposViajes,
            'tiposVehiculos' => $tiposVehiculos,
            'tarifas' => $tarifas,
            'vehiculos' => $vehiculos,
            'conductores' => $conductores
        ]);
    }

    public function copiar()
    {
        $empresas = DB::select("exec SP_AlertBus_listEmpresas");
        $centrocostos = DB::select("exec SP_AlertBus_listCentroCostos");
        $transportistas = DB::select("exec SP_AlertBus_listTransportistas");
        $rutas = DB::select("exec SP_AlertBus_listRutas");
        $tiposViajes = DB::select("exec SP_AlertBus_listTiposViajes");
        $vehiculos = DB::select("exec SP_AlertBus_Get_Placa");
        return view('viajes.copiar_programados', [
            'empresas' => $empresas,
            'centrocostos' => $centrocostos,
            'transportistas' => $transportistas,
            'rutas' => $rutas,
            'tiposViajes' => $tiposViajes,
            'vehiculos' => $vehiculos

        ]);
    }

    public function copiar_programados(Request $request)
    {
        $idEmpresa = $request->get('idEmpresa');
        $ids = $request->get('ids');
        $idPlanificacion = implode('-', $ids);
        $desde = $request->get('desde');
        $hasta = $request->get('hasta');
        $usuario = Auth::user()->usuario;
        $estado = $request->get('estado');

        $inserting = DB::select('exec SP_AlertBus_Programacion_Copiar ?, ?, ?, ?, ?, ?', [ $idEmpresa, $idPlanificacion, $desde, $hasta, $usuario, $estado ] );

        return response()->json(['message' => $inserting[0]->exito ]);

    }

    public function programados_filtros($idEmpresa, $idCentroCosto, $idTransportista, $idRuta, $idVehiculo, $desde, $hasta)
    {
        $result = DB::select("exec SP_AlertBus_RPT_Viaje_Programados ?, ?, ?, ?, ?, ?, ?", [$idEmpresa, $idCentroCosto, $idTransportista, $idRuta, $idVehiculo, $desde, $hasta]);

        return response()->json(['dataset' => $result]);
    }

    public function asignar_conductor_placa(Request $request)
    {
        $idConductor = $request->get('idConductor');
        $idVehiculo = $request->get('idVehiculo');
        $idPlanificacion = $request->get('idPlanificacion');
        $insert = DB::select("exec SP_AlertBus_Viajes_Asignar_Conductor_Placa ?, ?, ?, ?", [$idConductor, $idVehiculo, $idPlanificacion, Auth::user()->usuario]);
        return response()->json(['success' => substr($insert[0]->exito, 0, 1), 'message' => substr($insert[0]->exito, 2)]);
    }

    public function editar_programado(Request $request)
    {
        $idPlanificacion = $request->get('idPlanificacion');
        $empresa = $request->get('empresa');
        $fecha = $request->get('fecha');
        $hora = $request->get('hora');
        //$area = $request->get('area');
        $centrocosto = $request->get('centrocosto');
        $transportista = $request->get('transportista');
        $ruta = $request->get('ruta');
        $tipoVehiculo = $request->get('tipoVehiculo');
        $tarifa = $request->get('tarifa');
        $precio = $request->get('precio_final');
        if ($precio == 'null') {
            $precio = NULL;
        }

        $insert = DB::select("exec SP_AlertBus_Viaje_Programado_Editar ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?", [$idPlanificacion, $empresa, $fecha, $hora, 0, $centrocosto, $transportista, $ruta, $tipoVehiculo, $tarifa, $precio, Auth::user()->usuario]);
        return response()->json(['success' => substr($insert[0]->exito, 0, 1), 'message' => substr($insert[0]->exito, 2)]);
    }

    public function eliminar_programado(Request $request)
    {
        $idPlanificacion = $request->get('idPlanificacion');
        $insert = DB::select("exec SP_AlertBus_Viaje_Programado_Eliminar ?, ?", [$idPlanificacion, Auth::user()->usuario]);
        return response()->json(['success' => 1]);
    }

    public function buscar_programado($id)
    {
        $insert = DB::select("exec SP_AlertBus_Viaje_Programado_Ver ?", [$id]);
        return response()->json(['data' => $insert[0]]);
    }

    public function editar_realizado(Request $request)
    {
        //$editar_programado = $this->editar_programado($request);

        $idViaje = $request->get('idViaje');
        $idPlanificacion = $request->get('idPlanificacion');
        $conductor = $request->get('conductor');
        $vehiculo = $request->get('vehiculo');
        $horaInicio = $request->get('horaInicio');
        $horaFin = $request->get('horaFin');

        $horaInicioV = $request->get('horaInicioV');
        $horaFinV = $request->get('horaFinV');

        $horaInicioF = substr($horaInicioV, 0, 11) . $horaInicio;
        $horaFinF = substr($horaFinV, 0, 11) . $horaFin;
        $centrocosto = $request->get('centrocosto');
        $insert = DB::select("exec SP_AlertBus_Viaje_Realizado_Editar ?, ?, ?, ?, ?, ?, ?", [$idPlanificacion, $idViaje, $conductor, $vehiculo, $horaInicioF, $horaFinF, Auth::user()->usuario]);
        return response()->json(['success' => $insert[0]->exito]);
    }
}
