<?php

namespace App\Http\Controllers\IndependentTables;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Vehiclecolor;
use Illuminate\Http\Request;

class VehiclecolorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $colors = Vehiclecolor::all();
        return view('Admin.VehicleColors.index')->with('colors',$colors);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.VehicleColors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Vehiclecolor::create($request->all());
        return redirect()->route('admin.colors.index')->with('success','El color ha sido registrado correctamente');
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
        $color = Vehiclecolor::find($id);
        return view('Admin.VehicleColors.update',compact('color'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $color = Vehiclecolor::find($id);
        $color->update($request->all());
        return redirect()->route('admin.colors.index')->with('success','El color ha sido actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $color = Vehiclecolor::find($id);
        $vehicle=Vehicle::where('color_id',$id)->get();
        if ($vehicle->count()>0){
            return redirect()->route('admin.colors.index')->with('error','El color tiene autos registrados');
        }else{
            $color->delete();
            return redirect()->route('admin.colors.index')->with('success','El color ha sido borrado correctamente');
        }

    }
}
