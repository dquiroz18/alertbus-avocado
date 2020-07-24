<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Faker\Factory as Faker;

class DBController extends Controller
{
    public function run()
    {
    	$faker = Faker::create();
        
        $empresas = DB::table('Empresa')->pluck('idEmpresa')->toArray();
        $ccs = DB::table('CentroCosto')->pluck('idCentroCosto')->toArray();
        $prvs = DB::table('Proveedor')->pluck('idProveedor')->toArray();
        $rs = DB::table('Ruta')->pluck('idRuta')->toArray();
        $tps = DB::table('TipoVehiculo')->pluck('idTipoVehiculo')->toArray();
        $tts = DB::table('TipoTarifa')->pluck('idTipoTarifa')->toArray();
        $ts = DB::table('Tarifa')->pluck('idTarifa')->toArray();
        $cs = DB::table('Conductor')->pluck('idConductor')->toArray();
        $vs = DB::table('Vehiculo')->pluck('idVehiculo')->toArray();

        for ($i = 0; $i < 5; $i++) {
            DB::table('PlanificacionViaje')->insert([
                 'fecha' => '2019-10-25',
                'hora' => rand(0,23). ':'. rand(0,59),
                'idEmpresa' => $faker->randomElement($empresas),
                'idCentroCosto' => $faker->randomElement($ccs),
                'idProveedor' => $faker->randomElement($prvs),
                'idRuta' => $faker->randomElement($rs),
                'idTipoVehiculo' => $faker->randomElement($tps),
                'idTarifa' => $faker->randomElement($ts),
                'idTipoTarifa' => $faker->randomElement($tts),
                'idConductor' => $faker->randomElement($cs),
                'idVehiculo' => $faker->randomElement($vs),
                'estado' => 1,
            ]);
            $idpvs = DB::table('PlanificacionViaje')->pluck('idPlanificacionViaje')->toArray();
            DB::table('Viaje')->insert([
                'idPlanificacionViaje' => $faker->randomElement($idpvs),
                'horaInicio' => '2019-10-25 '.rand(0,23). ':'. rand(0,59),
                'horaFin' => '2019-10-25 '.rand(0,23). ':'. rand(0,59),
                'validado' => 1,
            ]);

            $idcs = DB::table('PlanificacionViaje')->pluck('idConductor')->toArray();
            for ($j = 0; $j < 10; $j++) {
                DB::table('Tracking')->insert([
                    'idConductor' => $faker->randomElement($idcs),
                    'fecha' => '2019-10-25 '.rand(0,23). ':'. rand(0,59),
                    'latitud' => '-'.rand(8, 10). '.'. rand(1000000, 1500000),
                    'longitud' => '-'.rand(50, 80). '.'. rand(1000000, 1500000),
                ]);                
            }
            $idvs = DB::table('Viaje')->pluck('idViaje')->toArray();
            for ($j = 0; $j < 10; $j++) {
                DB::table('ViajeDetalle')->insert([
                    'idViaje' => $faker->randomElement($idvs),
                    'numeroDocumento' => str_random(8),
                    'horaIngreso' => '2019-10-25 '.rand(0,23). ':'. rand(0,59),
                    'horaSalida' => '2019-10-25 '.rand(0,23). ':'. rand(0,59),
                    'validado' => 1
                ]);                
            }             

        }
        
    }

    
}