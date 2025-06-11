<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Technicien;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user= new User();
        $techniciens = Technicien::all();
        return view('admin.users.form', [
            'user'=> $user,
            'techniciens' => $techniciens,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       //dd($request);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',

        ]);

        $name = $request->input('name');
        $email= $request->input('email');
        $password = $request->input('password');
        $role = $request->input('role');
        $token = $request->input('_token');
        $technicien = $request->input('technicien');


        $user = new User();
        $user->remember_token = $token;
        $user->name = $name;
        $user->email = $email;
        $user->password = $password;
        $user->role = $role;
        $user->technicien_id = ($role == 'technicien') ? $technicien : null;
       // dd($user);
        $user->save();

        return redirect()->route('admin.user.index')
            ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        return view('admin.users.form');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        $techn = Technicien::find($user->technicien_id);
        $techniciens = Technicien::all();
        return view('admin.users.form', [
            'user'=> $user,
            'techniciens' => $techniciens,
            'techn' => $techn,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',

        ]);

        $name = $request->input('name');
        $email= $request->input('email');
        $password = $request->input('password');
        $role = $request->input('role');


        // dd($request);
        $user = User::find($id);
        $user->name = $name;
        $user->email = $email;
        $user->role = $role;
        if (!empty($password)) {
            $user->password = bcrypt($password);
        }
        $user->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();
        $message = __('L\'utilisateur :nom  a été supprimé avec succès.', [
            'nom' => $user->name,

        ]);

        return to_route('admin.user.index')->with('success', $message);
    }
}
