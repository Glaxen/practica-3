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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Zonecoords::create($request->all());
        return redirect()->route('admin.zones.show',$request->zone_id)->with('success','coordenada agregada');
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
        $zone = Zone::find($id);
        return view('Admin.Zonecoords.create');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
