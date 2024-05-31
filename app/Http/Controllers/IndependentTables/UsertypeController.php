<?php

namespace App\Http\Controllers\IndependentTables;

use App\Http\Controllers\Controller;
use App\Models\Usertype;
use Illuminate\Http\Request;

class UsertypeController extends Controller
{
    public function index()
    {
        $usertypes = Usertype::all();
        return view('Admin.UserType.index', compact('usertypes'));
    }

    public function create()
    {
        return view('Admin.UserType.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);

        Usertype::create($request->all());
        return redirect()->route('admin.usertypes.index')->with('success', 'User type created successfully.');
    }

    public function show(Usertype $usertype)
    {
        return view('admin.usertypes.show', compact('usertype'));
    }

    public function edit($id)
    {
        $usertype = Usertype::findOrFail($id);
        return view('Admin.UserType.update', compact('usertype'));
    }


    public function update(Request $request, Usertype $usertype)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:255'
        ]);

        $usertype->update($request->all());
        return redirect()->route('admin.usertypes.index')->with('success', 'User type updated successfully.');
    }


    public function destroy(Usertype $usertype)
    {
        $usertype->delete();
        return redirect()->route('admin.usertypes.index')->with('success', 'User type deleted successfully.');
    }
}
