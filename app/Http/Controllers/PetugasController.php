<?php

namespace App\Http\Controllers;

use App\Models\Petugas;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index(Request $request)
    {
        $petugas = Petugas::all();

        if($petugas->isEmpty()){
            return response() -> json([
                'code' => 200,
                'message' => 'Tidak ada petugas saat ini.',
            ], 200);
        } else {
            return response() -> json([
                'code' => 200,
                'message' => 'Berhasil mengakes!',
                'data' => $petugas
            ], 200);
        }
    }


    public function show($id)
    {
        $petugas = Petugas::where('id',$id)->get();

        return response() -> json([
            'code' => 200,
            'message' => 'Berhasil mengakes!',
            'data' => $petugas
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'nik' => 'required|string|max:16',
            'nama_petugas' => 'required|string',
            'username' => 'required||string|unique:petugas',
            'password' => 'required|string|min:5',
            'telp' => 'required|string|max:13'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $petugas = Petugas::create([
            'nik' => $request -> nik,
            'nama_petugas' => $request -> nama_petugas,
            'username' => $request -> username,
            'password' => Hash::make($request -> password),
            'telp' => $request -> telp
        ]);

        if($petugas->exists()){
            return response() -> json([
                'code' => 200,
                'message' => 'Petugas berhasil didaftarkan!',
                'data' => $petugas
            ], 200);
        } else {
            return response() -> json([
                'code' => 401,
                'message' => 'Petugas gagal didaftarkan.'
            ], 401);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_petugas' => 'required|string',
            'username' => 'required||string|unique:petugas',
            'password' => 'required|string|min:5',
            'telp' => 'required|string|max:13'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $petugas = Petugas::where('id', $id)->update([
            'nama_petugas' => $request -> nama_petugas,
            'username' => $request -> username,
            'password' => Hash::make($request -> password),
            'telp' => $request ->telp
        ]);

        if(Petugas::where('id', $request->id)->firstOrFail()){
            $petugas = Petugas::where('id', $id)->first();
            
            return response() -> json([
                'code' => 200,
                'message' => 'Berhasil mengubah data!',
                'data' => $petugas
            ], 200);
        }else{
            return response() -> json([
                'code' => 500,
                'message' => 'Gagal merubah data.',
            ], 500);
        }
    }

    public function delete(Request $request, $id)
    {
        $petugas = Petugas::where('id', $id)->delete();
        if($petugas){
            return response()->json([
                'code' => 200,
                'message' => 'Berhasil menghapus data!',
            ]);
        }else{
            return response() -> json([
                'code' => 500,
                'message' => 'Gagal menghapus data.'
            ], 500);
        }
    }

    public function search($petugas)
    {
        return petugas::where("nama_petugas", "like", "%".$petugas."%")->get();
    }

}
