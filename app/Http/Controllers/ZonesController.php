<?php

namespace App\Http\Controllers;

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
        $coords = Zonecoords::where('zone_id',$id);
        return view('Admin.Zones.show',compact('zone','coords'));
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
        return redirect()->route('Admin.Zones.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
