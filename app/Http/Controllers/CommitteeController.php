<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Periode;
use App\Models\Candidate;  
use App\Mail\InfoPemiraMail;
use Illuminate\Http\Request; 
use App\Models\Result;
use Illuminate\Support\Facades\Mail; 

class CommitteeController extends Controller
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
         
        $dataPanitia =  $this->user->where('role', 'panitia')->get();

        $hasilSearch = null;
        if (request('nim')) {
            $hasilSearch =  $this->user->where([['role', '!=', 'panitia'], ['nim', request('nim')]])->first();
        }

        return view('master/data_panitia', [
            'title' => 'Data Panitia',
            'dataPanitia' => $dataPanitia,
            'hasilSearch' => $hasilSearch
        ]);
    }

     

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $committee = $this->user->where('nim', $request->nim)->first();

        $committee->update([
            'role' => 'panitia'
        ]);

        return redirect()->route('panitia.index')->with('success', 'Data panitia telah ditambah');
    }

      
    public function deleteSelected(Request $request)
    {

        if ($request->ids) {
            $this->user->whereIn('id', $request->ids)->update([
                'role' => 'user'
            ]);
        }

        return redirect()->route('panitia.index')->with('success', 'Data panitia telah dihapus');
    }

    /**
     * Form info kpu
     */
    public function pengaturan()
    {
        $data = $this->periode->first();
        return view('panitia/pengaturan', [
            'title' => 'Pengaturan KPU',
            'data' => $data
        ]);
    }

    /**
     * Update info kpu
     */
    public function pengaturanPost(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|min:3',
            'year' => 'required|numeric',
            'election_status' => 'required',
            'registration_status' => 'required',
            'registration_page' => 'required'
        ]);

        $data = $this->periode->first();
        $data->update($validatedData);

        return redirect()->route('pengaturan')->with('success', 'Berhasil diupdate');
    }

    /**
     * Download template untuk import pemilih dari excel
     */
    public function downloadTemplatePemilih()
    {
        return response()->download(storage_path('app/template/Template Import Pemilih.xlsx'));
    }

    /**
     * Cek status pemilihan
     */
    public function statusPemilihan()
    {
        $periode = $this->periode->first();
        return view('panitia/status_pemilihan', [
            'title' => 'Status Pemilihan',
            'pengaturan' => $periode
        ]);
    }

    /**
     * API ambil data pemilihan
     */
    public function getDataPemilihan()
    {
        $dataCalon = $this->candidate->getWithUser();
        $dataJson = [];
        foreach ($dataCalon as $c) {
            array_push($dataJson, [$c->user->name => $this->result->where('candidat_id', $c->id)->count()]);
        }

        return response()->json($dataJson);
    }

    /**
     * Kirim email info pemira ke user
     */
    public function kirimEmail($id)
    {
        $user = $this->user->find($id);

        $mailData = [
            'title' => 'PEMIRA Kahima 2023',
            'body' => 'Informasi mengenai kahima baru tahun 2023',
            'nama' => $user->name,
            'default_password' => $user->nim . '_pemira2023',
            'login_email' => $user->email
        ];

        Mail::to($user->email)->send(new InfoPemiraMail($mailData));

        return redirect()->back()->with('success', 'Berhasil mengirim email ke ' . $user->email);
    }

    /**
     * Kirim email ke semua user
     */
    public function kirimEmailAll()
    {
        $users = $this->user->where('role', '!=', 'master')->get();

        foreach ($users as $user) {
            $mailData = [
                'title' => 'PEMIRA Kahima 2023',
                'body' => 'Informasi mengenai kahima baru tahun 2023',
                'nama' => $user->name,
                'default_password' => $user->nim . '_pemira2023',
                'login_email' => $user->email
            ];

            Mail::to($user->email)->send(new InfoPemiraMail($mailData));
        }

        return redirect()->back()->with('success', 'Berhasil mengirim email ke semua user');
    }
}
