<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Models\Zonecoords;
use Illuminate\Http\Request;

class ZonecoordsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $markers = json_decode($request->input('markers'), true);
        foreach ($markers as $coordenada) {
            if (!isset($coordenada['id'])) {
                Zonecoords::create([
                    'latitude' => floatval($coordenada['latitude']),
                    'longitude' => floatval($coordenada['longitude']),
                    'zone_id' => $request->zone_id,
                ]);
            }
        }

        return redirect()->route('admin.zones.show', $request->zone_id)->with('success', 'coordenadas agregadas');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Por cuestiones de la vida y error humano el EDIT funciona como SHOW y el SHOW funcionara como EDIT
        $zone = Zone::find($id);
        $lastcoord = Zonecoords::select('latitude as lat', 'longitude as lng')
            ->where('zone_id', $id)->latest()->first();
        $vertices = Zonecoords::select('latitude as lat', 'longitude as lng', 'id')->where('zone_id', $id)->get();

        return view('Admin.Zonecoords.modifyPerimeter', compact('zone', 'lastcoord', 'vertices'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //Por cuestiones de la vida y error humano el EDIT funciona como SHOW y el SHOW funcionara como EDIT
        $zone = Zone::find($id);
        $lastcoord = Zonecoords::select('latitude as lat', 'longitude as lng')
            ->where('zone_id', $id)->latest()->first();
        $vertices = Zonecoords::select('latitude as lat', 'longitude as lng', 'id')->where('zone_id', $id)->get();

        return view('Admin.Zonecoords.create', compact('zone', 'lastcoord', 'vertices'));
        //zonechords la latitud y longitud son double
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $allcoords = json_decode($request->input('markers'), true);
        $zoneCoords = Zonecoords::where('zone_id', $id)->get();
        $zoneCoordIds = $zoneCoords->pluck('id')->toArray();
        $markerIds = array_column($allcoords, 'id');
        $missingIds = array_filter($markerIds, function ($id) use ($zoneCoordIds) {
            return !in_array($id, $zoneCoordIds);
        });
        if (!empty($missingIds)) {
            foreach ($missingIds as $missingId) {
                Zonecoords::find($missingId)->delete();
            }
        }

        foreach ($allcoords as $c) {
            $updateCoord = Zonecoords::find($c['id']);
            $updateCoord->update([
                'latitude' => $c['latitude'],
                'longitude' => $c['longitude']
            ]);
        }
        return redirect()->route('admin.zones.show', $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
