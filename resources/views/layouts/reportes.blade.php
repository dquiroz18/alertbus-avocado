@extends('layouts.layout')

@section('style')
    <style>
        .divtable {
             overflow-x: hidden;
            overflow-y: hidden;
            white-space: nowrap;
        }
        .divtable tr td {
            white-space: nowrap;
        }
        .divtable tr th {
            white-space: nowrap;
        }
    </style>
@endsection

@section('main-content')
	<div class="col-sm-12">
	    <div class="row">
	       <div class="col-xs-12">
	           <div class="breadcrumbs">
	               <span>Reportes</span>
	               <span> >> </span>
	               @yield('name_reporte_breadcrumbs')
	           </div>
	       </div>
	    </div>
	    <div class="x_panel">
        	<div class="x_title">
	            @yield('reporte_title')
	            <ul class="nav navbar-right panel_toolbox">
	            	<li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
	            </ul>
	            <div class="clearfix"></div>
          	</div>
        	<div class="x_content">
                <div class="row">
                    <div class="form-group col-sm-3">
                        <label for="desde">Desde</label>
                        <input type="date" name="desde" id="desde" value="<?php $date = new \Datetime(); $date->modify('-1 day'); echo $date->format('Y-m-d') ?>" class="form-control">
                    </div>
                    <div class="form-group col-sm-3">
                        <label for="hasta">Hasta</label>
                        <input type="date" name="hasta" id="hasta" class="form-control" value="{{ date('Y-m-d') }}">
                    </div>
                </div>
        		<div class="row">
        			<div class="form-group col-sm-3">
        				<label for="Empresa">Empresa</label>
						<select name="empresa" id="empresa" class="form-control">
						</select>
        			</div>
        			<div class="form-group col-sm-3">
        				<label for="centrocosto">Centro Costo</label> <br>
						<select name="centrocosto" id="centrocosto" class="form-control" style="width: 100%">
							<option value="0">Seleccione</option>
						</select>
        			</div>
                    @yield('masFiltros')
        		</div>
        		<div class="row">
        			<div class="form-group col-sm-3">
        				<label for="transportista">Transportista</label> <br>
						<select name="transportista" id="transportista" class="form-control" style="width: 100%">
							<option value="0">Seleccione</option>
						</select>
        			</div>
        			<div class="form-group col-sm-3">
        				<label for="ruta">Ruta</label> <br>
						<select name="ruta" id="ruta" class="form-control" style="width: 100%">
							<option value="0">Seleccione</option>
						</select>
        			</div>
        			<div class="form-group col-sm-3" style="display: none;">
        				<label for="tipoViaje">Tipo Tarifa</label>
						<select name="tipoViaje" id="tipoViaje" class="form-control">
							<option value="0">Seleccione</option>
						</select>
        			</div>
                    @yield('masFiltros2')
                    <div class="form-group col-sm-1">
                        <label>Buscar</label> <br>
                        <button type="button" class="btn btn-primary" id="filtrar">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
        		</div>
            </div>
        </div>
        <div class="x_panel">
        	<div class="x_content">
                <div id="loading" class="col-sm-2 col-sm-offset-5" style="display: none;">
                    <img src="{{ asset('images/loading.gif') }}" alt="">
                </div>
                @yield('beforeTable')
                <div class="col-sm-12 divtable">
                    <table class="table table-hover table-striped table-bordered divtable" id="tabla">
                        @yield('content-table')
                    </table>    
                </div>
        	</div>
        </div>
	</div>

@endsection

@yield('script')