<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    
    public function index()
    {
        
        $users = User::all();
        return view('users.index', compact('users'));
    }

 
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);
             User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            
        ]);
        return redirect()->route('users.index')->with('success', 'Utilisateur créé avec succès !');
    }    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
       return view('users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
      return view('users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
            $request->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
        ]);
          $data = [
            'name' => $request->name,
            'email' => $request->email,
           
        ];
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
       $user->delete();
        return redirect()->route('users.index')->with('success', 'Utilisateur supprimé avec succès !'); 
    }
}
