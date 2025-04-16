<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('views.pages.users.index', compact('users'));
    }

    public function create()
    {
        return view('views.pages.users.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required|in:admin,employee', 
            'password' => 'required',
        ]);
    
        $validate['password'] = Hash::make($validate['password']);
        User::create($validate);
    
        return redirect()->route('users.index')->with('success', 'User berhasil ditambahkan');
    }

    public function edit(User $user, $id)
    {
        $user = User::findOrFail($id);
        return view('views.pages.users.edit', compact('user'));
    }

    public function update(Request $request, User $user, $id)
    {
        $user = User::findOrFail($id);
        // Validasi data input
        $validate = $request->validate([
            'name' => 'required',
            'email' => 'required|email', // Tambahkan unique:users,email
            'role' => 'required|in:admin,employee', // Validasi role dengan in:admin,employee
            'password' => 'required', // Validasi minimal 8 karakter untuk password
        ]);
    
        // Simpan user baru
        $validate['password'] = Hash::make($validate['password']); // Encrypt password
        $user->update($validate);
    
        return redirect()->route('users.index')->with('success', 'User berhasil diupdate');
    }

    public function destroy(User $user, $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus');
    }
}
