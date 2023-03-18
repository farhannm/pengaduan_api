<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PengaduanResource;
use Illuminate\Support\Facades\Validator;

class PengaduanController extends Controller
{

    public function index()
    {
        $pengaduan = Pengaduan::all();

        if($pengaduan->isEmpty()){
            return response() -> json([
                'code' => 200,
                'message' => 'Tidak ada pengaduan saat ini.',
            ], 200);
        } else {
            return response() -> json([
                'code' => 200,
                'message' => 'Berhasil mengakes!',
                'data' => $pengaduan
            ], 200);
        }
    }

    public function show($id)
    {
        // $pengaduan = Pengaduan::with('oleh:id,nama')->findOrFail($id);

        // if($pengaduan->isEmpty()){
        //     return response() -> json([
        //         'code' => 200,
        //         'message' => 'Tidak ada pengaduan saat ini.',
        //     ], 200);
        // } else {
        //     return new PengaduanResource($pengaduan);
        // }

        $pengaduan = Pengaduan::with('pengaduan:id,nama')->findOrFail($id);

        return response() -> json([
            'code' => 200,
            'message' => 'Berhasil mengakes!',
            'data' => new PengaduanResource($pengaduan)
        ], 200);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_pengaduan' => 'required',
            'tgl_pengaduan' => 'required',
            'isi_pengaduan' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3000'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pengaduan = Pengaduan::create([
            'nama_pengaduan' => $request -> nama_pengaduan,
            'tgl_pengaduan' => $request -> tgl_pengaduan,
            'isi_pengaduan' => $request -> isi_pengaduan,
            'image' => $request -> image
        ]);

        if($pengaduan->exists()){
            return response() -> json([
                'code' => 200,
                'message' => 'Pengaduan berhasil diajukan!',
                'data' => $pengaduan
            ], 200);
        } else {
            return response() -> json([
                'code' => 401,
                'message' => 'Pengaduan gagal diajukan.'
            ], 401);
        }
    }

    public function upload(Request $request, $id)
    {

        $this->validate($request, [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3000'
        ]);

        $image = $request->file('image')->getClientOriginalName();
        $request->file('image')->move('upload', $image);

        $data = [
            'image' => url('upload/' . $image)
        ];

        $pengaduan = Pengaduan::where('id', $id)->update($data);
        

        if(Pengaduan::where('id', $request->id)->firstOrFail()){
            $pengaduan = Pengaduan::where('id', $id)->first();
            
            return response() -> json([
                'code' => 200,
                'message' => 'Berhasil menambahkan foto!',
                'data' => $pengaduan
            ], 200);
        }else{
            return response() -> json([
                'code' => 500,
                'message' => 'Gagal menambahkan foto.',
            ], 500);
        }
    
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_pengaduan' => 'required',
            'tgl_pengaduan' => 'required',
            'isi_pengaduan' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $pengaduan = Pengaduan::where('id', $id)->update([
            'nama_pengaduan' => $request -> nama_pengaduan,
            'tgl_pengaduan' => $request -> tgl_pengaduan,
            'isi_pengaduan' => $request -> isi_pengaduan,
        ]);


        if(Pengaduan::where('id', $request->id)->firstOrFail()){
            $pengaduan = Pengaduan::where('id', $id)->first();
            
            return response() -> json([
                'code' => 200,
                'message' => 'Berhasil mengubah data!',
                'data' => $pengaduan
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
        $pengaduan = Pengaduan::where('id', $id)->delete();
        if($pengaduan){
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

    public function search($pengaduan)
    {
        return Pengaduan::where("nama_pengaduan", "like", "%".$pengaduan."%")->get();
    }

}
