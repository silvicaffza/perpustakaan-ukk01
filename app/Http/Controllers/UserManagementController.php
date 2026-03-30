<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
  public function index()
{
    $users = User::where('role', 'user')
        ->withCount([
            'loans as total_loans',
            'loans as late_loans' => function ($q) {
                $q->whereNotNull('returned_at')
                  ->whereColumn('returned_at', '>', 'due_date');
            }
        ])
        ->latest()
        ->get();

    return view('account-user.index', compact('users'));
}

    public function show($id)
    {
        $user = User::findOrFail($id);
        return view('account-user.show', compact('user'));
    }

    public function create()
    {
        return view('account-user.create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user'
        ]);

        return redirect()->route('account-user.index')
            ->with('success','User berhasil dibuat');
    }

    public function edit($id)
    {
        $user = User::where('role','user')->findOrFail($id);
        return view('account-user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::where('role','user')->findOrFail($id);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return redirect()->route('account-user.index')
            ->with('success','User berhasil diupdate');
    }

    public function destroy($id)
    {
        $user = User::where('role','user')->findOrFail($id);
        $user->delete();

        return redirect()->route('account-user.index')
            ->with('success','User berhasil dihapus');
    }
}