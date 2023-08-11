<?php

namespace App\Http\Controllers;

use App\Models\HasilPemilihan;
use App\Models\InfoPemilihan;
use App\Models\Kandidat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KandidatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kandidats = Kandidat::with('user')->get();
        // dd($kandidats->first()->user);
        return view('panitia/data_kandidat', [
            'title' => 'Data Kandidat',
            'kandidats' => $kandidats
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $userKandidat = Kandidat::where('id_user', Auth::user()->id)->first();
        $pengaturan = InfoPemilihan::first();
        return view('user/daftar_kandidat', [
            "title" => 'Daftar Kandidat',
            'userKandidat' => $userKandidat,
            'pengaturan' => $pengaturan
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'visi' => 'required',
            'misi' => 'required',
            'pdf_ktm' => 'required|mimes:pdf',
            'suket_organisasi' => 'required|mimes:pdf',
            'suket_lkmm_td' => 'required|mimes:pdf',
            'transkrip_nilai' => 'required|mimes:pdf',
            'foto' => 'required|mimes:jpg,png',
            'nomor_wa' => 'required|min:10|max:13'
        ]);

        $validatedData['id_user'] = User::where('nim', $request->nim)->first()->id;

        // Simpan data ke storage
        $pdf_ktm = $request->nim . '_' . 'pdf_ktm_' . $request->file('pdf_ktm')->getClientOriginalName();
        $suket_organisasi = $request->nim . '_' . 'suket_organisasi_' . $request->file('suket_organisasi')->getClientOriginalName();
        $suket_lkmm_td = $request->nim . '_' . 'suket_lkmm_td_' . $request->file('suket_lkmm_td')->getClientOriginalName();
        $transkrip_nilai = $request->nim . '_' . 'transkrip_nilai_' . $request->file('transkrip_nilai')->getClientOriginalName();
        $foto = $request->nim . '_' . 'foto_' . $request->file('foto')->getClientOriginalName();

        $validatedData['pdf_ktm'] = $request->file('pdf_ktm')->storeAs('pdf_ktm', $pdf_ktm, ['disk' => 'local']);
        $validatedData['suket_organisasi'] = $request->file('suket_organisasi')->storeAs('suket_organisasi', $suket_organisasi, ['disk' => 'local']);
        $validatedData['suket_lkmm_td'] = $request->file('suket_lkmm_td')->storeAs('suket_lkmm_td', $suket_lkmm_td, ['disk' => 'local']);
        $validatedData['transkrip_nilai'] = $request->file('transkrip_nilai')->storeAs('transkrip_nilai', $transkrip_nilai, ['disk' => 'local']);
        $validatedData['foto'] = $request->file('foto')->storeAs('foto', $foto, ['disk' => 'public']);

        $validatedData['status'] = 'belum_diverifikasi';

        Kandidat::create($validatedData);

        return redirect()->route('daftar_kandidat_form');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $dataKandidat = Kandidat::with('user')->find($id);
        if (!$dataKandidat) {
            return abort(404);
        }
        return view('panitia/cek_kelengkapan_kandidat', [
            'title' => "Kelengkapan Kandidat",
            'dataKandidat' => $dataKandidat
        ]);
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
        $kandidat = Kandidat::find($id);
        $kandidat->delete();

        Storage::delete($kandidat->pdf_ktm);
        Storage::delete($kandidat->suket_organisasi);
        Storage::delete($kandidat->suket_lkmm_td);
        Storage::delete($kandidat->transkrip_nilai);
        Storage::delete('public/' . $kandidat->foto);

        return redirect()->route('kandidat.index')->with('success', 'Data kandidat berhasil dihapus');
    }

    /**
     * Cek Kelengkapan Kandidat
     */
    public function cekKelengkapan(string $id, string $kelengkapan)
    {
        $dataKandidat = Kandidat::find($id)->toArray();
        if (!isset($dataKandidat[$kelengkapan])) {
            return abort(404);
        }
        $filePath = $dataKandidat[$kelengkapan];
        return response()->file(storage_path('app/' . $filePath));
    }

    /**
     * Download kelengkapan kandidat
     */
    public function downloadKelengkapan(string $id, string $kelengkapan)
    {
        $dataKandidat = Kandidat::find($id)->toArray();
        if (!isset($dataKandidat[$kelengkapan])) {
            return abort(404);
        }

        $filePath = $dataKandidat[$kelengkapan];
        return response()->download(storage_path('app/' . $filePath));
    }

    /**
     * Verifikasi data kandidat
     */
    public function verifikasiData(string $id)
    {
        $kandidat = Kandidat::find($id);
        $kandidat->update([
            'status' => 'sudah_diverifikasi'
        ]);

        return redirect()->back()->with('success', 'Kelengkapan sudah diverifikasi');
    }

    public function vote(string $id)
    {
        $idPemilih = Auth::user()->id;
        $idKandidat = $id;

        HasilPemilihan::create([
            'id_pemilih' => $idPemilih,
            'id_kandidat' => $idKandidat
        ]);

        return redirect()->route('home');
    }
}