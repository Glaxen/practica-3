<?php

namespace App\Http\Controllers;

use App\Models\Route;
use App\Models\Routezone;
use App\Models\User;
use App\Models\Zone;
use App\Models\Zonecoords;
use Illuminate\Http\Request;

class ZonesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $zones = Zone::all();
        return view('Admin.Zones.index',compact('zones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.Zones.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Zone::create($request->all());
        return redirect()->route('admin.zones.index')->with('success','zona agregada');;
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $zone = Zone::find($id);
        $coords = Zonecoords::where('zone_id',$zone->id)->get();
        $coordcap = Zonecoords::select('latitude as lat', 'longitude as lng')->where('zone_id', $id)->get();
        return view('Admin.Zones.show',compact('zone','coords','coordcap'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $zone = Zone::find($id);
        return view('Admin.Zones.edit',compact('zone'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $zone = Zone::find($id);
        $zone->update($request->all());
        return redirect()->route('admin.zones.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //La zona no se puede borrar sihay usuarios o rutas asignadas a esa zona
        $zone = Zone::find($id);
        $userzones = User::where('zone_id',$zone->id)->get();
        $rutaszonas = Routezone::where('zone_id',$zone->id)->get();
        if($userzones->isNotEmpty() || $rutaszonas->isNotEmpty()){
            return redirect()->route('admin.zones.index')->with('error','No se puede eliminar la zona debido a que hay usuarios y rutas asosciadas');
        }else{
            $zonecoords = Zonecoords::where('zone_id',$zone->id)->get();
            foreach($zonecoords as $c){
                $c->delete();
            }
            $zone->delete();
            return redirect()->route('admin.zones.index')->with('success','Zona eliminada con exito');
        }
    }
}
