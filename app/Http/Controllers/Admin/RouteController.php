<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use App\Models\Routezone;
use App\Models\Route;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes = Route::all();
        return view('admin.routes.index', compact('routes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $zones = Zone::with('zonecoords')->get(); // Carga las zonas con coordenadas

        // Envía las zonas a la vista de creación de rutas
        return view('admin.routes.create', compact('zones'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude_start' => 'required|numeric',
            'longitude_start' => 'required|numeric',
            'latitude_end' => 'required|numeric',
            'longitude_end' => 'required|numeric',
            'status' => 'required|integer', //1 = Activo, 2 = Inactivo
            'zone_ids' => 'required|array',
            'zone_ids.*' => 'exists:zones,id'
        ]);

        // Intenta crear la ruta
        try {
            $route = Route::create($request->all());

            // Ahora crea las relaciones en la tabla RouteZones
            foreach ($request->zone_ids as $zoneId) {
                Routezone::create([
                    'route_id' => $route->id,
                    'zone_id' => $zoneId
                ]);
            }

            return redirect()->route('admin.routes.index')->with('success', 'Ruta creada correctamente.');
        } catch (\Exception $e) {
            return redirect()->route('admin.routes.index')->with('error', 'Error al crear la ruta: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Route $route)
    {
        return view('admin.routes.show', compact('route'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Route $route)
    {
        // Cargar todas las zonas y sus coordenadas
        $zones = Zone::with('zonecoords')->get();

        // Enviar la ruta y las zonas a la vista
        return view('admin.routes.edit', compact('route', 'zones'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Route $route)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'latitude_start' => 'required|numeric',
            'longitude_start' => 'required|numeric',
            'latitude_end' => 'required|numeric',
            'longitude_end' => 'required|numeric',
            'status' => 'required|integer',
            'zone_ids' => 'required|array', // Asegúrate de que se envía un array de IDs de zona
            'zone_ids.*' => 'exists:zones,id' // Cada ID de zona debe existir en la tabla de zonas
        ]);

        $route->update($request->all());

        // Eliminar las relaciones existentes
        Routezone::where('route_id', $route->id)->delete();

        // Insertar las nuevas relaciones
        foreach ($request->zone_ids as $zoneId) {
            Routezone::create([
                'route_id' => $route->id,
                'zone_id' => $zoneId
            ]);
        }

        return redirect()->route('admin.routes.index')->with('success', 'Route updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Route $route)
    {
        // Verifica si existen registros en vehicleroutes asociados a la ruta
        /* if ($route->vehicleroutes()->exists()) {
            // Cambia el estado de la ruta a inactivo en lugar de eliminarla
            $route->update(['status' => 2]);
            $message = 'Route status changed to inactive because it is linked to vehicle routes.';
        } else { */
        // Elimina las relaciones en routezones asociadas a esta ruta
        $route->routezones()->delete();

        // Si no hay registros vinculados en vehicleroutes, elimina la ruta
        $route->delete();
        $message = 'Route deleted successfully.';
        /* } */

        return redirect()->route('admin.routes.index')->with('success', $message);
    }
}
