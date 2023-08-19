<?php

namespace App\Http\Controllers;

use App\Mail\InfoPemiraMail;
use App\Models\HasilPemilihan;
use App\Models\Pengaturan;
use App\Models\Kandidat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PanitiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $idKandidat = Kandidat::all()->pluck('id_user')->toArray();
        // $dataPanitia = User::whereNotIn('id', $idKandidat)->where('role', 'panitia')->get();
        $dataPanitia = User::where('role', 'panitia')->get();

        $hasilSearch = null;
        if (request('nim')) {
            $hasilSearch = User::where('nim', request('nim'))->where('role', '!=', 'panitia')->first();
        }

        return view('master/data_panitia', [
            'title' => 'Data Panitia',
            'dataPanitia' => $dataPanitia,
            'hasilSearch' => $hasilSearch
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $panitia = User::where('nim', $request->nim);

        $panitia->update([
            'role' => 'panitia'
        ]);

        return redirect()->route('panitia.index')->with('success', 'Data panitia telah ditambah');
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
        //
    }

    /**
     * Hapus data panitia terpilih
     */
    public function deleteSelected(Request $request)
    {
        if ($request->ids) {
            User::whereIn('id', $request->ids)->update([
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
        $pengaturan = Pengaturan::first();
        return view('panitia/pengaturan', [
            'title' => 'Pengaturan KPU',
            'data' => $pengaturan
        ]);
    }

    /**
     * Update info kpu
     */
    public function pengaturanPost(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|min:3',
            'tahun' => 'required|numeric',
            'status_pemilihan' => 'required',
            'status_pendaftaran' => 'required',
            'halaman_pendaftaran' => 'required'
        ]);

        $pengaturan = Pengaturan::first();
        $pengaturan->update($validatedData);

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
        $pengaturan = Pengaturan::first();
        return view('panitia/status_pemilihan', [
            'title' => 'Status Pemilihan',
            'pengaturan' => $pengaturan
        ]);
    }

    /**
     * API ambil data pemilihan
     */
    public function getDataPemilihan()
    {
        $dataCalon = Kandidat::with('user')->get();
        $dataJson = [];
        foreach ($dataCalon as $c) {
            array_push($dataJson, [$c->user->name => HasilPemilihan::where('id_kandidat', $c->id)->count()]);
        }

        return response()->json($dataJson);
    }

    /**
     * Kirim email info pemira ke user
     */
    public function kirimEmail($id)
    {
        $user = User::find($id);

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
        $users = User::where('role', '!=', 'master')->get();

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
