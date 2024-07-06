<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\mantenimiento;

class mantenimientoController extends Controller
{
    public function index()
    {
        $mantenimientos = mantenimiento::all();
        return view('admin.mantenimiento.index', compact('mantenimientos'));
    }


    public function update(Request $request, string $id)
    {
        $mantenimientos = mantenimiento::find($id);
        $mantenimientos->update($request->all());
        return redirect()->route('admin.mantenimiento.index')->with('success','El mantenimiento ha sido actualizado correctamente');
    }


    public function destroy(string $id)
    {
        $mantenimientos = mantenimiento::all()->where('id','=',$id)->count();
        if($mantenimientos > 0){
            return redirect()->route('admin.mantenimiento.index')->with('error','Este mantenimiento contiene modelos asociados');
        }else{
            mantenimiento::find($id)->delete();
            return redirect()->route('admin.mantenimiento.index')->with('success','El mantenimiento ha sido eliminado');
        }
    }

}
