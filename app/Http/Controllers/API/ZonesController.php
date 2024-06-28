<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class ZonesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zones = Zone::pluck("name", "id");
        return response()->json($zones);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function allroutes2(Request $request)
    {
        $user = Auth::user();
        // Verificar si el usuario existe
        if (!$user) {
            return response()->json(['message' => 'Usuario no autenticado'], 401);
        }

        // Verificar si el usuario tiene una zona asociada
        if (!$user->zone) {
            return response()->json(['message' => 'Zona no encontrada para el usuario'], 404);
        }

        // Obtener las rutas asociadas a la zona del usuario incluyendo datos adicionales de vehicleroutes
        $routes = $user->zone->routes()->with(['vehicleRoutes' => function ($query) {
            $query->select('route_id', 'date_route', 'hour_route');
        }])->get(['routes.id', 'routes.name', 'routes.latitude_start', 'routes.longitude_start', 'routes.latitude_end', 'routes.longitude_end']);

        return response()->json($routes);
    }
}
