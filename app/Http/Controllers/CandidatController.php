<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Result;
use App\Models\Periode;
use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CandidatRequest;
use Illuminate\Support\Facades\Storage;

class CandidatController extends Controller
{
    private $candidat;
    private $user;
    private $periode;
    private $result;
    public function __construct(Candidate $candidat, User $user, Periode $periode, Result $result){
      $this->candidat = $candidat;
      $this->user = $user;
      $this->periode = $periode;
      $this->result = $result;
    }


    public function index()
    {
        $data = $this->candidat->getWithUser();

        return view('panitia/data_kandidat', [
            'title' => 'Data Kandidat',
            'data' => $data
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->role != 'user') {
            $userKandidat = null;
            $hasilSearch = null;
            if (request('nim')) {
                $userId = $this->user->where('nim', request('nim'))->first()->id;
                $userKandidat = $this->candidat->where('user_id', $userId)->first();
                if (!$userKandidat) {
                    $hasilSearch =  $this->user->where('role', 'user')->where('nim', request('nim'))->first();
                }
            }

            return view('panitia/tambah_kandidat', [
                'title' => 'Tambah Kandidat',
                'hasilSearch' => $hasilSearch
            ]);
        }

        $periode = $this->periode->first();
        if ($periode->registration_page == 'ya') {
            $userKandidat = $this->candidat->where('user_id', Auth::user()->id)->first();
            return view('user/daftar_kandidat', [
                "title" => 'Daftar Kandidat',
                'userKandidat' => $userKandidat,
                'pengaturan' => $periode
            ]);
        }
        return redirect()->route('home');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CandidatRequest $request)
    {
        $validatedData = $request->all();

        $validatedData['user_id'] = $this->user->where('nim', $request->nim)->first()->id;

        // Simpan data ke storage
        $pdf_ktm = $request->nim . '_' . 'pdf_ktm_' . $request->file('student_card')->getClientOriginalName();
        $suket_organisasi = $request->nim . '_' . 'suket_organisasi_' . $request->file('organization_letter')->getClientOriginalName();
        $suket_lkmm_td = $request->nim . '_' . 'suket_lkmm_td_' . $request->file('lkmtd_letter')->getClientOriginalName();
        $transkrip_nilai = $request->nim . '_' . 'transkrip_nilai_' . $request->file('transcript')->getClientOriginalName();
        $foto = $request->nim . '_' . 'foto_' . $request->file('photo')->getClientOriginalName();

        $validatedData['student_card'] = $request->file('student_card')->storeAs('pdf_ktm', $pdf_ktm, ['disk' => 'local']);
        $validatedData['organization_letter'] = $request->file('organization_letter')->storeAs('suket_organisasi', $suket_organisasi, ['disk' => 'local']);
        $validatedData['lkmtd_letter'] = $request->file('lkmtd_letter')->storeAs('suket_lkmm_td', $suket_lkmm_td, ['disk' => 'local']);
        $validatedData['transcript'] = $request->file('transcript')->storeAs('transkrip_nilai', $transkrip_nilai, ['disk' => 'local']);
        $validatedData['photo'] = $request->file('photo')->storeAs('foto', $foto, ['disk' => 'public']);

        $validatedData['status'] = 'No';

        $this->candidat->create($validatedData);

        if (Auth::user()->role == 'user') {
            return redirect()->route('daftar_kandidat_form');
        }

        return redirect()->route('kandidat.index');
    }

     
    public function show(string $id)
    {
        $data = $this->candidat->findWithUser($id);
        if (!$data) {
            return abort(404);
        }
        return view('panitia/cek_kelengkapan_kandidat', [
            'title' => "Kelengkapan Kandidat",
            'data' => $data
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

        $data = $this->candidat->find($id);
        Storage::delete($data->student_card);
        Storage::delete($data->organization_letter);
        Storage::delete($data->lkmtd_letter);
        Storage::delete($data->transcript);
        Storage::delete('public/' . $data->photo);
        $data->delete();

        return redirect()->route('kandidat.index')->with('success', 'Data kandidat berhasil dihapus');
    }

    /**
     * Cek Kelengkapan Kandidat
     */
    public function cekKelengkapan(string $id, string $kelengkapan)
    {
        $dataKandidat = $this->candidat->find($id)->toArray(); 
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
        $dataKandidat = $this->candidat->find($id)->toArray();
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
        $kandidat = $this->candidat->find($id);
        $kandidat->update([
            'status' => 'yes'
        ]);

        return redirect()->back()->with('success', 'Kelengkapan sudah diverifikasi');
    }

    public function vote(string $id)
    {
        $user_id = Auth::user()->id; 
        $this->result->create([
            'user_id' => $user_id,
            'candidat_id' => $id
        ]);

        return redirect()->route('home');
    }
}
