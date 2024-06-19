<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Models\Routestatu;
use App\Models\Vehicle;
use App\Models\Vehicleroute;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehiclerouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehiculos = Vehicle::where('status',1)->pluck('name','id');
        $rutas = Route::where('status',1)->pluck('name','id');

        $vehicleroutes = DB::select("
        SELECT vr.id as id, v.name as vehiculo, r.name as route, vr.date_route as fecha, rs.name as status, vr.description as description, vr.hour_route as hora FROM `vehicleroutes` as vr
        INNER JOIN `routes` as r on vr.route_id = r.id
        INNER JOIN `vehicles` as v on vr.vehicle_id = v.id
        INNER JOIN `routestatus` as rs on vr.routestatus_id = rs.id
        WHERE v.id = ? and r.id = ?",[$vehiculos->keys()->first(),$rutas->keys()->first()]);

        return view('Admin.VehicleRoutes.index',compact('vehicleroutes','vehiculos','rutas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //se puede asignar una ruta a un vehiculo sin antes haberle asignado ocupantes?
        $vehiculos = Vehicle::where('status',1)->pluck('name','id');
        $rutas = Route::where('status',1)->pluck('name','id');

        return view('Admin.VehicleRoutes.create',compact('vehiculos','rutas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $fechaInicio = Carbon::parse($request->fecha_inicio);
        $fechaFin = Carbon::parse($request->fecha_fin);

        // Generar el periodo de fechas
        $period = CarbonPeriod::create($fechaInicio, $fechaFin);
        foreach ($period as $date) {
            Vehicleroute::create([
                'date_route' => $date->format('Y-m-d'),
                'vehicle_id' => $request->vehicle_id,
                'routestatus_id' => 1,
                'hour_route' => $request->hour_route,
                'route_id' => $request->route_id,
            ]);
        }

        return redirect()->route('admin.vehicleroute.index')->with('success','Rutas programadas con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vehicleroute = VehicleRoute::find($id);
        $vehiculos = Vehicle::where('status',1)->pluck('name','id');
        $rutas = Route::where('status',1)->pluck('name','id');
        $statusroute = Routestatu::pluck('name','id');
        return view('Admin.VehicleRoutes.edit',compact('vehicleroute','vehiculos','rutas','statusroute'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vehicleroute =Vehicleroute::find($id);
        $vehicleroute->update([
            'date_route' => $request->date_route,
            'vehicle_id' => $request->vehicle_id,
            'routestatus_id' => $request->routestatus_id,
            'hour_route' => $request->hour_route,
            'route_id' => $request->route_id,
        ]);

        return redirect()->route('admin.vehicleroute.index')->with('success','Rutaa editada con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showMultiUpdateModal(){
        $vehiculos = Vehicle::where('status',1)->pluck('name','id');
        $rutas = Route::where('status',1)->pluck('name','id');
        $statusroute = Routestatu::pluck('name','id');
        return view('Admin.VehicleRoutes.multiedit',compact('vehiculos','rutas','statusroute'));
    }

    public function multiUpdate(Request $request){

        $idsArray = explode(',', $request->selectedId);
        $idsArray = array_map('intval', $idsArray);

        foreach ($idsArray as $id) {
            $vehicleroute =Vehicleroute::find($id);
            $vehicleroute->update([
                'vehicle_id' => $request->vehicle_id,
                'routestatus_id' => $request->routestatus_id,
                'route_id' => $request->route_id,
            ]);

        }
        return redirect()->route('admin.vehicleroute.index')->with('success','Rutas editadas con exito');
    }

    public function filtertable(Request $request){
        // Validar los inputs recibidos si es necesario
        $request->validate([
            'vehicle_id' => 'nullable|integer',
            'route_id' => 'nullable|integer',
            'fechainicio' => 'nullable|date',
            'fechafin' => 'nullable|date',
        ]);

        // Iniciar la consulta con una condición siempre verdadera para facilitar concatenación
        $query = "
        SELECT vr.id as id, v.name as vehiculo, r.name as route, vr.date_route as fecha, rs.name as status, vr.description as description, vr.hour_route as hora
        FROM vehicleroutes as vr
        INNER JOIN routes as r on vr.route_id = r.id
        INNER JOIN vehicles as v on vr.vehicle_id = v.id
        INNER JOIN routestatus as rs on vr.routestatus_id = rs.id
        WHERE 1=1";

        // Array para almacenar los parámetros de la consulta
        $params = [];

        // Verificar cada variable y agregar el filtro a la consulta si no es nula
        if (!is_null($request->vehicle_id)) {
            $query .= " AND v.id = ?";
            $params[] = $request->vehicle_id;
        }

        if (!is_null($request->route_id)) {
            $query .= " AND r.id = ?";
            $params[] = $request->route_id;
        }

        if (!is_null($request->fechainicio)) {
            $query .= " AND vr.date_route >= ?";
            $params[] = $request->fechainicio;
        }

        if (!is_null($request->fechafin)) {
            $query .= " AND vr.date_route <= ?";
            $params[] = $request->fechafin;
        }

        // Ejecutar la consulta con los parámetros
        $vehicleroutes = DB::select($query, $params);

        // Retornar los datos en formato JSON
        return response()->json(['data' => $vehicleroutes]);
    }
}
