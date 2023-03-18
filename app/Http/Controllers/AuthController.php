<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function registerUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => 'required|string|max:16',
            'nama' => 'required|string|max:200',
            'username' => 'required||string|unique:users',
            'password' => 'required|string|min:5',
            'telp' => 'required|numeric'
        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'nik' => $request -> nik,
            'nama' => $request -> nama,
            'username' => $request -> username,
            'password' => Hash::make($request -> password),
            'telp' => $request ->telp
        ]);

        return response() -> json([
            'code' => 200,
            'message' => 'User telah berhasil didaftarkan',
            'data' => $user
        ], 200);
    }
    

    public function login(Request $request)
    {
        $validasi = Validator::make($request->all(),[
            'username' => 'required',
            'password' => 'required|min:5',
        ]);

        if($validasi->fails()){
            return $this->error($validasi->errors()->first());
        }

        
        $token = Str::random(40);

        $data = [
            'api_token' => $token
        ];

        $user = User::where('username', $request->username)->update($data);
        $user = User::all();

        return response()->json([
            'code' => 200,
            'message' => 'Login Berhasil',
            'api_token' => $token,
            'data'=> $user
        ] ,200);
    }

    // public function logout(Request $request)
    // {
    //     return response()->json([
    //         'code' => 200,
    //         'message' => 'Logout berhasil.'
    //     ], 200);
    // }

    // public function me()
    // {
    //     return response()->json(Auth::user());
    // }
}
