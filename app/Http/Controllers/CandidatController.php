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
    private $candidate;
    private $user;
    private $periode;
    private $result;
    public function __construct(Candidate $candidate, User $user, Periode $periode, Result $result){
      $this->candidate = $candidate;
      $this->user = $user;
      $this->periode = $periode;
      $this->result = $result;
    }


    public function index()
    {
        $data = $this->candidate->getWithUser();

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
        $periode = $this->periode->first();

        if (Auth::user()->role != 'user') {
            $candidate = null;
            $search = null;
            if (request('nim')) {
                $userId = $this->user->where('nim', request('nim'))->first()->id;
                $candidate = $this->candidate->where('user_id', $userId)->first();
                if (!$candidate) {
                    $search =  $this->user->where('role', 'user')->where('nim', request('nim'))->first();
                }
            }

            return view('panitia/tambah_kandidat', [
                'title' => 'Tambah Kandidat',
                'periode' => $periode,
                'data' => $search
            ]);
        }

        $periode = $this->periode->first();

        if ($periode->registration_page == 'Active') {
            $candidate = $this->candidate->where('user_id', Auth::user()->id)->first();
            return view('user/daftar_kandidat', [
                "title" => 'Daftar Kandidat',
                'candidate' => $candidate,
                'periode' => $periode
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
        $student_card = $request->nim . '_' . 'pdf_ktm_' . $request->file('student_card')->getClientOriginalName();
        $organization_letter = $request->nim . '_' . 'suket_organisasi_' . $request->file('organization_letter')->getClientOriginalName();
        $lkmtd_letter = $request->nim . '_' . 'suket_lkmm_td_' . $request->file('lkmtd_letter')->getClientOriginalName();
        $transcript = $request->nim . '_' . 'transkrip_nilai_' . $request->file('transcript')->getClientOriginalName();
        $photo = $request->nim . '_' . 'foto_' . $request->file('photo')->getClientOriginalName();

        $validatedData['student_card'] = $request->file('student_card')->storeAs('pdf_ktm', $student_card, ['disk' => 'local']);
        $validatedData['organization_letter'] = $request->file('organization_letter')->storeAs('suket_organisasi', $organization_letter, ['disk' => 'local']);
        $validatedData['lkmtd_letter'] = $request->file('lkmtd_letter')->storeAs('suket_lkmm_td', $lkmtd_letter, ['disk' => 'local']);
        $validatedData['transcript'] = $request->file('transcript')->storeAs('transkrip_nilai', $transcript, ['disk' => 'local']);
        $validatedData['photo'] = $request->file('photo')->storeAs('foto', $photo, ['disk' => 'public']);

        $validatedData['status'] = 'No';

        $this->candidate->create($validatedData);

        if (Auth::user()->role == 'user') {
            return redirect()->route('daftar_kandidat_form');
        }

        return redirect()->route('kandidat.index');
    }

     
    public function show(string $id)
    {
        $data = $this->candidate->findWithUser($id);
        if (!$data) {
            return abort(404);
        }
        return view('panitia/cek_kelengkapan_kandidat', [
            'title' => "Kelengkapan Kandidat",
            'data' => $data
        ]);
    }


    public function destroy(string $id)
    {

        $data = $this->candidate->find($id);
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
    public function checkDocuments(string $id, string $object)
    {
        $data = $this->candidate->find($id)->toArray(); 
        if (!isset($data[$object])) {
            return abort(404);
        }
        $filePath = $data[$object];
        
        return response()->file(storage_path('app/' . $filePath));
    }

    /**
     * Download kelengkapan kandidat
     */
    public function downloadDocuments(string $id, string $object)
    {
        $data = $this->candidate->find($id)->toArray();
        if (!isset($data[$object])) {
            return abort(404);
        }

        $filePath = $data[$object];
        return response()->download(storage_path('app/' . $filePath));
    }

    /**
     * Verifikasi data kandidat
     */
    public function verifikasiData(string $id)
    {
        $data = $this->candidate->find($id);
        $data->update([
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
