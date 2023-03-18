<?php

namespace App\Http\Controllers;

use App\Models\Tanggapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\TanggapanResource;
use Illuminate\Support\Facades\Validator;

class TanggapanController extends Controller
{
    public function index()
    {
        $tanggapan = Tanggapan::all();

        if($tanggapan->isEmpty()){
            return response() -> json([
                'code' => 200,
                'message' => 'Tidak ada tanggapan saat ini.',
            ], 200);
        } else {
            return response() -> json([
                'code' => 200,
                'message' => 'Berhasil mengakes!',
                'data' => $tanggapan
            ], 200);
        }
    }

    public function show($id)
    {
        // $tanggapan = tanggapan::with('oleh:id,nama')->findOrFail($id);

        // if($tanggapan->isEmpty()){
        //     return response() -> json([
        //         'code' => 200,
        //         'message' => 'Tidak ada tanggapan saat ini.',
        //     ], 200);
        // } else {
        //     return new tanggapanResource($tanggapan);
        // }

        $tanggapan = tanggapan::with('tanggapan:id,id_pengaduan')->findOrFail($id);

        return response() -> json([
            'code' => 200,
            'message' => 'Berhasil mengakes!',
            'data' => new TanggapanResource($tanggapan)
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_pengaduan' => 'required',
            'id_petugas' => 'required',
            'tgl_tanggapan' => 'required',
            'tanggapan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $tanggapan = Tanggapan::create([
            'id_pengaduan' => $request -> id_pengaduan,
            'id_petugas' => $request -> id_petugas,
            'tgl_tanggapan' => $request -> tgl_tanggapan,
            'tanggapan' => $request -> tanggapan,
        ]);

        if($tanggapan->exists()){
            return response() -> json([
                'code' => 200,
                'message' => 'tanggapan berhasil diajukan!',
                'data' => $tanggapan
            ], 200);
        } else {
            return response() -> json([
                'code' => 401,
                'message' => 'tanggapan gagal diajukan.'
            ], 401);
        }
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'id_pengaduan' => 'required',
            'id_petugas' => 'required',
            'tgl_tanggapan' => 'required',
            'tanggapan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $tanggapan = Tanggapan::where('id', $id)->update([
            'id_pengaduan' => $request -> id_pengaduan,
            'id_petugas' => $request -> id_petugas,
            'tgl_tanggapan' => $request -> tgl_tanggapan,
            'tanggapan' => $request -> tanggapan,
        ]);


        if(Tanggapan::where('id', $request->id)->firstOrFail()){
            $tanggapan = Tanggapan::where('id', $id)->first();
            
            return response() -> json([
                'code' => 200,
                'message' => 'Berhasil mengubah data!',
                'data' => $tanggapan
            ], 200);
        }else{
            return response() -> json([
                'code' => 500,
                'message' => 'Gagal merubah data.',
            ], 500);
        }
    }

 
    public function delete($id)
    {
        $tanggapan = tanggapan::where('id', $id)->delete();
        if($tanggapan){
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

    public function search($tanggapan)
    {
        return tanggapan::where("tanggapan", "like", "%".$tanggapan."%")->get();
    }

}
