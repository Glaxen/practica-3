<?php

namespace App\Http\Controllers\IndependentTables;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\Vehicletype;
use Illuminate\Http\Request;

class VehicletypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tipoV = Vehicletype::all();
        return view('Admin.VehicleType.index')->with('tipoV',$tipoV);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('Admin.VehicleType.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Vehicletype::create($request->all());
        return redirect()->route('admin.vehicletypes.index')->with('success','El tipo de vehículo ha sido registrado correctamente');
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
        $vehicleType = Vehicletype::find($id);
        return view('Admin.Vehicletype.update',compact('vehicleType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vehicleType = Vehicletype::find($id);
        $vehicleType->update($request->all());
        return redirect()->route('admin.vehicletypes.index')->with('success','El tipo de vehículo ha sido actualizado correctamente');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vehicle = Vehicle::where('type_id',$id)->get();
        if($vehicle->count()>0){
            return redirect()->route('admin.vehicletypes.index')->with('error','El tipo de vehículo tiene vehículos registrados');
        }else{
            $vehicletype = Vehicletype::find($id);
            $vehicletype->delete();
            return redirect()->route('admin.vehicletypes.index')->with('success','El tipo de vehiculo ha sido borrado correctamente');
        }
    }
}
