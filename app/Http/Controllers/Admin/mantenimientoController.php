<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\mantenimiento;
use App\Models\horario_mantenimiento;


class mantenimientoController extends Controller
{
    public function index()
    {
        $mantenimientos = mantenimiento::all();
        return view('admin.mantenimiento.index', compact('mantenimientos'));
    }


    public function create()
    {

        return view('admin.mantenimiento.create');
    }

    public function store(Request $request)
    {
        mantenimiento::create([
            'nombre' => $request->nombre,
            'fecha_inicio' => $request->fecha_inicio,
            'fecha_fin' => $request->fecha_fin,
        ]);
        return redirect()->route('admin.mantenimiento.index')->with('success', 'El mantenimiento ha sido registrado correctamente');
    }

    public function edit(string $id)
    {
        $mantenimientos = mantenimiento::find($id);
        return view('admin.mantenimiento.update')->with('mantenimientos', $mantenimientos);
    }

    public function update(Request $request, string $id)
    {
        $mantenimientos = mantenimiento::find($id);
        $mantenimientos->update($request->all());
        return redirect()->route('admin.mantenimiento.index')->with('success', 'El mantenimiento ha sido actualizado correctamente');
    }

    public function destroy(string $id)
    {
        $horario_mantenimientos = horario_mantenimiento::all()->where('id', '=', $id)->count();
        if ($horario_mantenimientos > 0) {
            return redirect()->route('admin.mantenimiento.index')->with('error', 'Este mantenimiento contiene horarios asociados');
        } else {
            mantenimiento::find($id)->delete();
            return redirect()->route('admin.mantenimiento.index')->with('success', 'El mantenimiento ha sido eliminado');
        }
    }
}
