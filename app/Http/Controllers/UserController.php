<?php

namespace App\Http\Controllers;

use App\Models\User; 
use App\Models\Periode; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
     
    private $periode; 
    private $user;
    
    public function __construct(Periode $periode, User $user)
    {
        $this->user = $user;
        $this->periode = $periode; 
    }
    
    public function index()
    {
        $user = User::where('role', '!=', 'master')->get();
        $pengaturan = $this->periode->first();

        return view('master/master_user', [
            'title' => 'Data User',
            'user' => $user,
            'pengaturan' => $pengaturan
        ]);
    }

    
   
    public function destroy(string $id)
    {
        $user = $this->user->find($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'Berhasil menghapus user');
    }

    /**
     * Reset password user ke default password sesuai import
     */
    public function resetPassword($id)
    {
        $user = $this->user->find($id);
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
        
        $user = $this->user->find(Auth::user()->id);
        $user->update([
            'password' => $validatedData['newPassword']
        ]);

        return redirect()->route('home')->with('success', 'Berhasil mengubah password');
    }
}
