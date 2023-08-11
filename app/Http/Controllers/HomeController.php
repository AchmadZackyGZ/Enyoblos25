<?php

namespace App\Http\Controllers;

use App\Models\HasilPemilihan;
use App\Models\Kandidat;
use App\Models\Pengaturan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        if (Auth::user()->role == 'panitia' || Auth::user()->role == 'master') {
            if (session()->has('success')) {
                return redirect()->route('panitia_home')->with('success', session('success'));
            }
            return redirect()->route('panitia_home');
        }

        if (session()->has('success')) {
            return redirect()->route('user_home')->with('success', session('success'));
        }
        return redirect()->route('user_home');
    }

    public function userHome()
    {
        $pengaturan = Pengaturan::first();
        $userVote = HasilPemilihan::where('id_pemilih', Auth::user()->id)->first();
        $kandidat = Kandidat::with('user')->where('status', 'sudah_diverifikasi')->get();
        $isUserKandidat = Kandidat::where('id_user', Auth::user()->id)->first();
        return view('user/home', [
            'title' => 'Home',
            'pengaturan' => $pengaturan,
            'userVote' => $userVote,
            'kandidat' => $kandidat,
            'isUserKandidat' => $isUserKandidat
        ]);
    }


    public function panitiaHome()
    {
        $idKandidat = Kandidat::all()->pluck('id_user')->toArray();
        $jumlahPemilih = User::whereNotIn('id', $idKandidat)->where('role', 'user')->count();
        $jumlahKandidat = Kandidat::count();
        $jumlahVote = HasilPemilihan::all()->count();
        $jumlahPanitia = User::where('role', 'panitia')->count();
        $persentaseVote = 0;
        if ($jumlahPemilih > 0) {
            $persentaseVote = ($jumlahVote / $jumlahPemilih) * 100;
        }
        return view('panitia/home', [
            'title' => 'Dashboard',
            'jumlahPemilih' => $jumlahPemilih,
            'jumlahKandidat' => $jumlahKandidat,
            'jumlahVote' => $jumlahVote,
            'persentaseVote' => $persentaseVote,
            'jumlahPanitia' => $jumlahPanitia
        ]);
    }

    public function masterHome()
    {
        return view('master/home', [
            'title' => 'Dashboard'
        ]);
    }
}
