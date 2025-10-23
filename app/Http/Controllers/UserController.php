<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::paginate(10);
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique(User::class)
            ],
            'role' => 'required',
            'password' => 'required|string|min:6',
        ]);

        $user = new User();
        $user->name=$request->name;
        $user->lastname=$request->lastname;
        $user->phone=$request->phone;
        $user->email=$request->email;
        $user->role=$request->role;
        $user->password=$request->password;
        $user->save();

        return redirect()->route('users')->with('success', 'Usuario creado correctamente');
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'lastname' => 'required',
            'phone' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->ignore($id)
            ],
            'role' => 'required',
            'password' => 'nullable|string|min:6',
        ]);

        $user = User::findOrFail($id);
        $user->name=$request->name;
        $user->lastname=$request->lastname;
        $user->phone=$request->phone;
        $user->email=$request->email;
        $user->role=$request->role;

        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }
        
        $user->save();

        return redirect()->route('users')->with('success', 'Usuario actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('users')->with('success', 'Usuario eliminado correctamente');
    }
}
