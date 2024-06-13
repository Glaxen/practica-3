<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Usertype;
use App\Models\Vehicle;
use App\Models\Vehicleoccupant;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleoccupantsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function filterbyUsertype($id){
        $users=User::all()->where('usertype_id','=',$id);
        return $users;
    }

    public function index()
    {
        $voc = Vehicle::all();

        return view('Admin.Vehiclesoccupant.index',compact('voc'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $usertypes = Usertype::where('id','>', 2)->pluck('name','id');
        $usersFt = $usertypes->keys()->first();
        $users = User::where('usertype_id','=', $usersFt)->pluck('name', 'id');
        // Vehicleoccupant::whereIn('id', $)

        $vehicles = Vehicle::pluck('name','id');
        $vehiclesCapacity = Vehicle::pluck('capacity','id');
        return view('Admin.Vehiclesoccupant.create', compact('usertypes','users','vehicles','vehiclesCapacity'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'occupants' => 'required|array',
            'occupants.*' => 'string',
        ]);
        // Cada ocupante se recibe con la cadena de vehiculo_tipousaurio_usuario
        $occupants = $request->occupants;

        foreach ($occupants as $occupant) {
            // Divide la cadena en partes usando el guion bajo como delimitador
            $values = explode('_', $occupant);

            if (count($values) === 3) {
                $vehicleId = (int) $values[0];
                $userTypeId = (int) $values[1];
                $userId = (int) $values[2];

                Vehicleoccupant::create([
                    'vehicle_id' => $vehicleId,
                    'usertype_id' => $userTypeId,
                    'user_id' => $userId,
                    'status' => 1,
                    'assigment_date' => Carbon::today(),
                ]);
            } else {

                throw new \Exception("Formato de ocupante incorrecto: $occupant");
            }
        }

        return redirect()->route('admin.vehicleoccupants.index')->with('success','Los ocupantes se registraron correctamente');;
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
        $vehicles = Vehicle::find($id);
        $vo = DB::select("
        Select vo.id, vo.user_id, vo.usertype_id, vo.vehicle_id, u.name as user, ut.name as tipo
        from vehicleoccupants vo Inner join users u on vo.user_id=u.id
        Inner join usertypes ut on vo.usertype_id=ut.id
        where vo.vehicle_id = ? and vo.status = 1",[$id]);
        // $vo = Vehicleoccupant::where('vehicle_id',$id)->get();

        $usertypes = Usertype::where('id','>', 2)->pluck('name','id');
        $usersFt = $usertypes->keys()->first();
        $users = User::where('usertype_id','=', $usersFt)->pluck('name', 'id');
        $vehiclesCapacity = Vehicle::where('id',$id)->pluck('capacity','id');

        return view('Admin.Vehiclesoccupant.edit',compact('usertypes','users','vehicles','vehiclesCapacity','vo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vo=Vehicleoccupant::where('vehicle_id',$id)->get();
        $ocupantes = $request->occupants;
        $idsConjunto = array_map('intval', $request->ids);
        if ($ocupantes){
            $idsNoEnConjunto = Vehicleoccupant::whereNotIn('id', $idsConjunto)->pluck('id');
            Vehicleoccupant::whereIn('id', $idsNoEnConjunto)->update(['status' => 0]);
        }else{
            foreach ($vo as $occupant) {
                $occupant->status = 0;
                $occupant->save();
            }
        }
        return redirect()->route('admin.vehicleoccupants.index')->with('success','Los ocupantes se registraron correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
