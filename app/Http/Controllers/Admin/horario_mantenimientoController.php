<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\mantenimiento;
use App\Models\horario_mantenimiento;
use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Validation\ValidationException;

class horario_mantenimientoController extends Controller
{
    public function index()
    {

        $horario_mantenimientos = DB::select("
        SELECT hm.dia as dia, v.name as vehiculo, vo.user_id, hm.tipo as tipo, hm.hora_inicio as hora_inicio, hm.hora_fin as hora_fin, m.id as id_mantenimiento, hm.id as id
        from horario_mantenimientos hm
        INNER JOIN mantenimientos m on hm.id_mantenimiento = m.id
        INNER JOIN vehicles v on hm.id_vehiculo = v.id
        LEFT JOIN vehicleoccupants vo on v.id = vo.vehicle_id
        ORDER BY hm.id DESC
        LIMIT 1");
        return view('admin.horario_mantenimiento.index', compact('horario_mantenimientos'));
    }

    public function create()
    {
        $vehiculos = Vehicle::where('status', 1)->pluck('name', 'id');
        $mantenimientos = mantenimiento::orderBy('id', 'desc')->take(1)->pluck('nombre', 'id');
        return view('admin.horario_mantenimiento.create', compact('vehiculos', 'mantenimientos'));
    }



    public function store(Request $request)
    {
        // Convertir las horas a formato completo de fecha y hora
        $horaInicio = Carbon::parse($request->hora_inicio)->format('Y-m-d H:i:s');
        $horaFin = Carbon::parse($request->hora_fin)->format('Y-m-d H:i:s');
        $tipoMantenimiento = $request->tipo;
        $dia = $request->dia;

        // Validar solapamiento de horarios para el mismo día y tipo de mantenimiento
        $horariosSolapados = horario_mantenimiento::where('dia', $dia)
            ->where('id_vehiculo', $request->id_vehiculo)
            ->where('tipo', $tipoMantenimiento)
            ->where(function ($query) use ($horaInicio, $horaFin) {
                $query->where(function ($q) use ($horaInicio, $horaFin) {
                    $q->where('hora_inicio', '<', $horaFin)
                        ->where('hora_fin', '>', $horaInicio);
                })->orWhere(function ($q) use ($horaInicio, $horaFin) {
                    $q->where('hora_inicio', '>=', $horaInicio)
                        ->where('hora_inicio', '<', $horaFin);
                })->orWhere(function ($q) use ($horaInicio, $horaFin) {
                    $q->where('hora_fin', '>', $horaInicio)
                        ->where('hora_fin', '<=', $horaFin);
                });
            })->exists();

        if ($horariosSolapados) {
            return redirect()->route('admin.horario_mantenimiento.index')->with('error', 'El horario seleccionado se cruza con otro horario existente para el mismo día y tipo de mantenimiento.');
        }

        // Crear el nuevo horario de mantenimiento si no hay solapamiento
        horario_mantenimiento::create([
            'dia' => $dia,
            'id_vehiculo' => $request->id_vehiculo,
            'tipo' => $tipoMantenimiento,
            'hora_inicio' => $horaInicio,
            'hora_fin' => $horaFin,
            'id_mantenimiento' => $request->id_mantenimiento,
        ]);

        // Redirigir a la vista index con un mensaje de éxito
        return redirect()->route('admin.horario_mantenimiento.index')->with('success', 'El horario del mantenimiento ha sido registrado correctamente');
    }

    public function edit(string $id)
    {
        $mantenimientos = mantenimiento::orderBy('id', 'desc')->take(1)->pluck('nombre', 'id');
        $vehiculos = Vehicle::where('status', 1)->pluck('name', 'id');
        $horario_mantenimientos = horario_mantenimiento::find($id);
        return view('admin.horario_mantenimiento.update', compact('vehiculos', 'mantenimientos'))->with('horario_mantenimientos', $horario_mantenimientos);
    }

    public function update(Request $request, string $id)
    {
        $horario_mantenimientos = horario_mantenimiento::find($id);
        $horario_mantenimientos->update($request->all());
        return redirect()->route('admin.horario_mantenimiento.index')->with('success', 'El horario ha sido actualizado correctamente');
    }

    public function destroy(string $id)
    {
        $ultimoId = DB::table('horario_mantenimientos')->orderBy('id', 'desc')->value('id');
        DB::table('horario_mantenimientos')->where('id', $ultimoId)->delete();
        return redirect()->route('admin.horario_mantenimiento.index')->with('success', 'El horario se ha sido eliminado');
    }
}
