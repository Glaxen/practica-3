<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Routezone;
use App\Models\Route;
use App\Models\Zone;
use Illuminate\Http\Request;

class RoutezoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routezones = Routezone::with(['route', 'zone'])->get();
        return view('admin.routezones.index', compact('routezones')); // Asegúrate de ajustar la ruta de la vista
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $routes = Route::all()->pluck('name', 'id');
        $zones = Zone::all()->pluck('name', 'id');
        return view('admin.routezones.create', compact('routes', 'zones')); // Asegúrate de ajustar la ruta de la vista
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'route_id' => 'required|exists:routes,id',
            'zone_id' => 'required|exists:zones,id'
        ]);

        Routezone::create($request->all());
        return redirect()->route('admin.routezones.index')->with('success', 'Routezone created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Routezone $routezone)
    {
        return view('admin.routezones.show', compact('routezone')); // Asegúrate de ajustar la ruta de la vista
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Routezone $routezone)
    {
        $routes = Route::all()->pluck('name', 'id');
        $zones = Zone::all()->pluck('name', 'id');
        return view('admin.routezones.edit', compact('routezone', 'routes', 'zones')); // Asegúrate de ajustar la ruta de la vista
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Routezone $routezone)
    {
        $request->validate([
            'route_id' => 'required|exists:routes,id',
            'zone_id' => 'required|exists:zones,id'
        ]);

        $routezone->update($request->all());
        return redirect()->route('admin.routezones.index')->with('success', 'Routezone updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Routezone $routezone)
    {
        $routezone->delete();
        return redirect()->route('admin.routezones.index')->with('success', 'Routezone deleted successfully.');
    }
}
