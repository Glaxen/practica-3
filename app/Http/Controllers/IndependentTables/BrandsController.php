<?php

namespace App\Http\Controllers\IndependentTables;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\BrandModel;
use App\Models\Brandsmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $brands = Brand::all();
        return view('Admin.Brands.index',compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('Admin.Brands.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->logo){
            $img = $request->file('logo')->store('public/brandslogo');
            $url = Storage::url($img);
        }else{
            $url='';
        }
        Brand::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'logo'=>$url
        ]);
        return redirect()->route('admin.brands.index')->with('success','La marca ha sido registrada correctamente');
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
        $brand = Brand::find($id);
        return view('Admin.Brands.update')->with('brand',$brand);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $brand = Brand::find($id);
        if ($request->logo) {
            $img = $request->file('logo')->store('public/brandslogo');
            $url = Storage::url($img);
            $brand->update([
                'name'=>$request->name,
                'description'=>$request->description,
                'logo'=>$url
            ]);
        }else{
            $brand->update([
                'name'=>$request->name,
                'description'=>$request->description,
            ]);
        }
        return redirect()->route('admin.brands.index')->with('success','La marca ha sido actualizada correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $modelos = Brandsmodel::all()->where('brand_id','=',$id)->count();
        if($modelos > 0){
            return redirect()->route('admin.brands.index')->with('error','La marca contiene modelos asociados');
        }else{
            Brand::find($id)->delete();
            return redirect()->route('admin.brands.index')->with('success','La marca ha sido eliminada');
        }
    }
}
