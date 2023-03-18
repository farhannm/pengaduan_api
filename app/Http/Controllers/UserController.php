<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pengaduan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('api');
    }

    public function index()
    {   
        //api
        $user = User::all();

        if($user->isEmpty()){
            return response() -> json([
                'code' => 200,
                'message' => 'Tidak ada user terdaftar ini.',
            ], 200);
        } else {
            return response() -> json([
                'code' => 200,
                'message' => 'Berhasil mengakes!',
                'data' => $user
            ], 200);
        }

    }


    public function show(Request $request, $id)
    {
        $user = User::where('id',$id)->get();

        if (Auth::user()) {   // Check is user logged in
            return response() -> json([
                'code' => 200,
                'message' => 'Berhasil mengakes!',
                'data' => $user
            ], 200);
        } else {
            return response() -> json([
                'code' => 401,
                'message' => 'Akses ditolak, anda harus login terlebih dahulu.',
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

        $user = User::where('id', $id)->update($data);
        

        if(User::where('id', $request->id)->firstOrFail()){
            $user = User::where('id', $id)->first();
            
            return response() -> json([
                'code' => 200,
                'message' => 'Berhasil menambahkan foto!',
                'data' => $user
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
            'nik' => 'required|string|max:16',
            'nama' => 'required|string|max:200',
            'username' => 'required||string|unique:users',
            'password' => 'required|string|min:5',
            'telp' => 'required|string|max:13'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::where('id', $id)->update([
            'nik' => $request -> nik,
            'nama' => $request -> nama,
            'username' => $request -> username,
            'password' => Hash::make($request -> password),
            'telp' => $request ->telp
        ]);

        if(User::where('id', $request->id)->firstOrFail()){
            $user = User::where('id', $id)->first();
            
            return response() -> json([
                'code' => 200,
                'message' => 'Berhasil mengubah data!',
                'data' => $user
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
        $user = User::where('id', $id)->delete();
        if($user){
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

    public function search($nama)
    {
        $user = User::where("nama", "like", "%".$nama."%")->get();

        if($user->isEmpty()){
            return response() -> json([
                'code' => 200,
                'message' => 'Tidak ada pengguna dengan nama tersebut, coba lebih spesifik.',
            ], 200);
        } else {
            return response() -> json([
                'code' => 200,
                'message' => 'Berhasil mengakes!',
                'data' => $user
            ], 200);
        }
    }

}
