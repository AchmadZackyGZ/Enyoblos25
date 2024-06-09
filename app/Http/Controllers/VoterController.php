<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Result;
use App\Models\Periode;
use App\Models\Candidate; 
use Illuminate\Http\Request;
use App\Imports\ImportPemilih; 
use App\Http\Requests\UserRequest;
use Maatwebsite\Excel\Facades\Excel;

class VoterController extends Controller
{
    private $candidate; 
    private $user;
    
    public function __construct(Candidate $candidate, Periode $periode, Result $result, User $user)
    {
        $this->user = $user; 
       $this->candidate = $candidate; 
    }
    
    public function index()
    { 
        $idKandidat =$this->candidate->all()->pluck('user_id')->toArray();
        $dataPemilih =$this->user->whereNotIn('id', $idKandidat)->where('role', 'user')->get();
        return view('panitia/data_pemilih', [
            'title' => 'Data Pemilih',
            'dataPemilih' => $dataPemilih
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('panitia/tambah_pemilih', [
            'title' => 'Tambah Pemilih',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        $validatedData = $request->all();

        $validatedData['password'] = $validatedData['nim'] . '_pemira2023';

        $this->user->create($validatedData);

        return redirect()->route('pemilih.index')->with('success', 'Data Berhasil Ditambah');
    }

    
    /**
     * Digunakan untuk import data pemilih dari file excel.
     */
    public function importPemilih(Request $request)
    {
        $validatedData = $request->validate([
            'fileImport' => 'required|mimes:xlsx'
        ]);

        Excel::import(new ImportPemilih, $request->file('fileImport'));

        return redirect()->back()->with('success', 'Data Berhasil Diimport');
    }

    
    public function deleteSelected(Request $request)
    {
        if ($request->ids) {
            $this->user->whereIn('id', $request->ids)->delete();
            return redirect()->route('pemilih.index')->with('success', 'Data berhasil dihapus');
        }

        return redirect()->route('pemilih.index');
    }

}
