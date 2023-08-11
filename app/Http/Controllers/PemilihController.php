<?php

namespace App\Http\Controllers;

use App\Imports\ImportPemilih;
use App\Imports\PemilihImport;
use App\Models\Kandidat;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class PemilihController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $dataPemilih = User::where('role', 'user')->get();
        $idKandidat = Kandidat::all()->pluck('id_user')->toArray();
        $dataPemilih = User::whereNotIn('id', $idKandidat)->where('role', 'user')->get();
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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nim' => 'required|min:10|max:10|unique:users',
            'name' => 'required|min:3|max:255',
            'email' => 'required|unique:users',
            'angkatan' => 'required|min:4'
        ]);

        $validatedData['password'] = $validatedData['nim'] . '_pemira2023';

        User::create($validatedData);

        return redirect()->route('pemilih.index')->with('success', 'Data Berhasil Ditambah');
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
        dd($id);
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

    /**
     * Menghapus data pemilih yang dipilih
     */
    public function deleteSelected(Request $request)
    {
        if ($request->ids) {
            User::whereIn('id', $request->ids)->delete();
            return redirect()->route('pemilih.index')->with('success', 'Data berhasil dihapus');
        }

        return redirect()->route('pemilih.index');
    }
}
