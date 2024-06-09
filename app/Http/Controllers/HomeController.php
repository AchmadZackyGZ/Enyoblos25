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
        $periode = $this->periode->first();
        $voter = $this->result->where('user_id', Auth::user()->id)->first();
        $candidate = $this->candidate->with('user')->where('status', 'Yes')->get();
        $isCandidate = $this->candidate->where('user_id', Auth::user()->id)->first();

        return view('user/home', [
            'title' => 'Home',
            'periode' => $periode,
            'voter' => $voter, 
            'isCandidate' => $isCandidate
        ]);

    }


    public function panitiaHome()
    {
        $candidate_id =$this->candidate->all()->pluck('user_id')->toArray();
        $votersTotal = User::whereNotIn('id', $candidate_id)->where('role', 'user')->count();
        $candidatesTotal = $this->candidate->count();
        $voters = $this->result->all()->count();
        $commimitteesTotal = $this->user->where('role', 'panitia')->count();
        $persentaseVote = 0;
        if ($votersTotal > 0) {
            $persentaseVote = ($voters / $votersTotal) * 100;
        }
        return view('panitia/home', [
            'title' => 'Dashboard',
            'votersTotal' => $votersTotal,
            'candidatesTotal' => $candidatesTotal,
            'voters' => $voters,
            'persentaseVote' => $persentaseVote,
            'commimitteesTotal' => $commimitteesTotal
        ]);
    }

    public function masterHome()
    {
        return view('master/home', [
            'title' => 'Dashboard'
        ]);
    }
}
