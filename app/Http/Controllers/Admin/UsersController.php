<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Usertype;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    // Muestra la lista de usuarios
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Muestra el formulario para crear un nuevo usuario
    public function create()
    {
        $usertypes = Usertype::all()->pluck('name', 'id');
        return view('admin.users.create', compact('usertypes'));
    }

    /* public function edit2(User $user)
    {
        $usertypes = Usertype::all()->pluck('name', 'id');
        return view('admin.users.edit', compact('user', 'usertypes'));
    } */

    // Guarda un nuevo usuario en la base de datos
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'usertype_id' => 'required|exists:usertypes,id',
            // Agrega otras validaciones según sea necesario
        ]);

        $user = new User($request->all());
        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $usertypes = Usertype::all()->pluck('name', 'id');
        return view('admin.users.update', compact('user', 'usertypes'));
    }


    // Actualiza un usuario en la base de datos
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'usertype_id' => 'required|exists:usertypes,id',
            // Asegúrate de excluir la validación de email único para el usuario actual
        ]);

        $user->update($request->all());
        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    // Elimina un usuario
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
