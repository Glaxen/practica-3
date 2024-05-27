<?php

namespace App\Http\Controllers\IndependentTables;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Brandsmodel;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class BrandsmodelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       $modelbrand =Brandsmodel::select('brandsmodels.id','brandsmodels.name','brandsmodels.description','brandsmodels.code','br.name as brand')
       ->join('brands as br','brandsmodels.brand_id','=','br.id')->get();
        return view('Admin.BrandModel.index', compact('modelbrand'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $brands = Brand::pluck('name','id');
        return view('Admin.BrandModel.create',compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Brandsmodel::create($request->all());
        return redirect()->route('admin.brandsmodel.index')->with('success','El modelo ha sido registrado correctamente');
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
        $brands = Brand::pluck('name','id');
        $brandmodel = Brandsmodel::find($id);
        return view('Admin.BrandModel.update', compact('brandmodel','brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brandmodel = Brandsmodel::find($id);
        $brandmodel->update($request->all());
        return redirect()->route('admin.brandsmodel.index')->with('success','El modelo ha sido actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $vehicles = Vehicle::where('model_id','=',intval($id))->get();
        if($vehicles->count()>0){
            return redirect()->route('admin.brandsmodel.index')->with('error','El modelo de Vehiculo tiene vehiculos asociados');
        }else{
            $modelo = Brandsmodel::find($id);
            $modelo->delete();
            return redirect()->route('admin.brandsmodel.index')->with('success','El modelo ha sido eliminado exitosamente');
        }
    }
}
