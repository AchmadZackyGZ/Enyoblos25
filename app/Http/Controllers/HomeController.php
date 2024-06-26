<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Result;
use App\Models\Periode;
use App\Models\Candidate;
use App\Models\candidatepair;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    private $candidatepair;
    private $candidate;
    private $periode;
    private $result;
    private $user;
    
    public function __construct(candidate $candidate,candidatepair $candidatepair, Periode $periode, Result $result, User $user)
    {
        $this->user = $user;
        $this->periode = $periode;
        $this->candidatepair = $candidatepair;
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
        $candidatepairs = $this->candidatepair->get();
        $isCandidate = $this->candidate->where('user_id', Auth::user()->id)->first();
        $voter = $this->result->where('user_id', Auth::user()->id)->first();

        return view('user/home', [
            'title' => 'Home',
            'periode' => $periode, 
            'voter' => $voter, 
            'candidatepairs' => $candidatepairs,
            'isCandidate' => $isCandidate
        ]);

    }


    public function committeeHome()
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
