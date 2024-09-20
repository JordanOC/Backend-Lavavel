<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Exibe o formulário de registro
    public function create()
    {
        return view('users.create');
    }

    // Processa o registro de um novo usuário
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'phone' => $request->phone,
        ]);

        return redirect()->route('/')->with('success', 'User registered successfully.');
    }

    // Exibe o formulário de edição de dados pessoais
    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    // Processa a atualização dos dados pessoais
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
        ]);

        $user->update($request->all());

        return redirect()->route('/')->with('success', 'User updated successfully.');
    }
}
