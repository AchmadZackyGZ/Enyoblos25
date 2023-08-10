<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::where('role', '!=', 'master')->get();

        return view('master/master_user', [
            'title' => 'Data User',
            'user' => $user
        ]);
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Berhasil menghapus user');
    }

    /**
     * Reset password user ke default password sesuai import
     */
    public function resetPassword($id)
    {
        $user = User::find($id);
        $user->update([
            'password' => $user->nim . '_pemira2023'
        ]);

        return redirect()->route('user.index')->with('success', 'Berhasil reset password');
    }

    /**
     * Ganti Password user
     */
    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'newPassword' => 'required|min:8'
        ]);
        $user = User::find(Auth::user()->id);
        $user->update([
            'password' => $validatedData['newPassword']
        ]);

        return redirect()->route('home')->with('success', 'Berhasil mengubah password');
    }
}
