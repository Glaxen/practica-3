<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Brandsmodel;
use App\Models\Vehicle;
use App\Models\Vehiclecolor;
use App\Models\Vehicletype;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function filterModelbyBrand($id) {
        $modelos=Brandsmodel::all()->where('brand_id','=',$id);
        return $modelos;
    }

    public function index()
    {
        $vehicles = DB::select("
        Select v.id,v.name as name,b.name as brand,bm.name as model, vt.name as type,v.plate
        from vehicles v Inner join brands b on v.brand_id=b.id
        Inner join brandsmodels bm on v.model_id=bm.id
        Inner join vehicletypes vt on v.type_id=vt.id");
        return view('Admin.Vehicles.index',compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brand = Brand::pluck('name','id');
        $idbrand = $brand->keys()->first();
        $model = Brandsmodel::where('brand_id',$idbrand)->pluck('name','id');
        $vcolor = Vehiclecolor::pluck('name','id');
        $vtype = Vehicletype::pluck('name','id');
        return view('Admin.Vehicles.create', compact('brand','model','vcolor','vtype'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'plate'=>'unique:Vehicles',
            'code'=>'unique:Vehicles',
        ]);
        $status = 0;
        if (isset($request->status)) {
            $status=1;
        }
        $vehicle=Vehicle::create($request->except('status','image') + ['status' =>$status]);
        return redirect()->route('admin.vehicles.index')->with('success','El vehiculo se registro correctamente');
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
        $vehicle=Vehicle::find($id);
        $brandId = $vehicle->brand_id;
        $brandfilter = Brand::where('id', $brandId)->pluck('name', 'id');
        $model = Brandsmodel::where('brand_id',$brandfilter->keys()->first())->pluck('name','id');
        $brand = Brand::pluck('name','id');
        $vcolor = Vehiclecolor::pluck('name','id');
        $vtype = Vehicletype::pluck('name','id');
        return view('Admin.Vehicles.update',compact('vehicle','brand','model','vcolor','vtype'));
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
}