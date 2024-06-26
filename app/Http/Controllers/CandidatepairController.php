<?php

namespace App\Http\Controllers;

use App\Http\Requests\CandidatepairRequest;
use App\Models\Candidate;
use App\Models\candidatepair;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\error;

class CandidatepairController extends Controller
{
    private $candidatepair;
    private $candidate;
    public function __construct(Candidate $candidate, Candidatepair $candidatepair){
        $this->candidate = $candidate; 
        $this->candidatepair = $candidatepair; 
    }
    
    public function index()
    {
        
        $data = $this->candidatepair->get();
        
        return view('paslon.index', [
            'title' => 'Data Paslon',
            'data' => $data,
            ]
        );
        
    }
    
    /**
    * Show the form for creating a new resource.
    */
    public function create()
    {
        $data = $this->candidate->where('status', 'yes')->get();
        
        return view('paslon.add', [
            'title' => 'Data Paslon',
            'data' => $data,
            ]
        );
    }
    
    /**
    * Store a newly created resource in storage.
    */
    function checkDataChairman(int $id){
        $object1 = $this->candidatepair->where('chairman', $id)->first();
        $data1 = !is_null($object1);

        $object2 = $this->candidatepair->where('vicechairman', $id)->first();
        $data2 = !is_null($object2);
        return $data1 || $data2;
    }
    
    function checkDataViceChairman(int $id){
        $object1 = $this->candidatepair->where('vicechairman', $id)->first();
        $data1 = !is_null($object1);
        return $data1;

        $object2 = $this->candidatepair->where('chairman', $id)->first();
        $data2 = !is_null($object2);

        return $data1 || $data2;
    }
    
    public function store(CandidatepairRequest $request)
    {
        $message = null;
        try {
            $chairman = $this->checkDataChairman($request->vicechairman);
            $vicechairman = $this->checkDataViceChairman($request->chairman);  
             
            if($chairman || $vicechairman){
                $message = 'Data paslon gagal ditambahkan';
            } else {
                $data = $request->all();
                $photo = $request->chairman. "-". $vicechairman . '_' . 'foto_' . $request->file('photo')->getClientOriginalName();
                $data['photo'] = $request->file('photo')->storeAs('pamflet', $photo, ['disk' => 'public']);
                $this->candidatepair->create($data);
                $message = 'Data paslon berhasil ditambahkan';
            }

        } catch (\Throwable $th) {
            $message = 'Data paslon gagal ditambahkan';
        }
        
        return redirect()->route('paslon.index')->with('success', $message);
        
    }
    
    /**
    * Display the specified resource.
    */
    public function show(candidatepair $candidatepair)
    {
        
    }
    
    /**
    * Show the form for editing the specified resource.
    */
    public function edit(candidatepair $candidatepair)
    {
        
    }
    
    /**
    * Update the specified resource in storage.
    */
    public function update(Request $request, candidatepair $candidatepair)
    {
        //
    }
    
    /**
    * Remove the specified resource from storage.
    */
    public function destroy($id)
    {
        $message = null;
        try {
            $data = $this->candidatepair->find($id);
            Storage::delete($data->photo);
            $data->delete();
            $message = 'Data paslon berhasil dihapus';
        } catch (\Throwable $th) {
            $message = 'Data paslon gagal dihapus';
        }
        
        return redirect()->route('paslon.index')->with('success', $message);
        
    }
}
