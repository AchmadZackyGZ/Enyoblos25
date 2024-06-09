<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Result;
use App\Models\Periode;
use App\Models\Candidate; 
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    private $candidate;
    private $periode;
    private $result;
    private $user;
    
    public function __construct(Candidate $candidate, Periode $periode, Result $result, User $user)
    {
        $this->user = $user;
        $this->periode = $periode;
        $this->candidate = $candidate;
        $this->result = $result;
    }


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
        $pengaturan = $this->periode->first();
        $userVote = $this->result->where('user_id', Auth::user()->id)->first();
        $kandidat = $this->candidate->with('user')->where('status', 'Yes')->get();
        $isUserKandidat = $this->candidate->where('user_id', Auth::user()->id)->first();

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
        $idKandidat =$this->candidate->all()->pluck('user_id')->toArray();
        $jumlahPemilih = User::whereNotIn('id', $idKandidat)->where('role', 'user')->count();
        $jumlahKandidat = $this->candidate->count();
        $jumlahVote = $this->result->all()->count();
        $jumlahPanitia = $this->user->where('role', 'panitia')->count();
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
