<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    public function register(Request $request){
        //Validasi request
        $validated = $request->validate([
            'email' => ['string', 'required', 'email', 'max:255'],
            'password' => ['string', 'required', 'max:255'],
            'name' => ['string', 'required', 'max:255'],
        ]);

        //Save data ke database
        $user = new User($validated);
        $user->password = Hash::make($validated['password']);
        $user->save();

        //Return response
        if ($user) {
            return response()->json([
                'message' => 'success',
                'data' => $user,
            ]);
        } else {
            return response()->json([
                'message' => 'Gagal membuat akun',
            ]
            );
        }
    }

    public function login(Request $request){
        //Validasi Request
        $validated = $request->validate([
            'email' => ['string', 'required', 'email', 'max:255'],
            'password' => ['string', 'required', 'max:255']
        ]);

        $user = User::where('email', $validated['email'])->first();
        if(!$user || !Hash::check($validated['password'], $user->password)){
            throw new HttpResponseException(response([
                "errors"=>[
                    "message" => [
                        "Username atau password salah"
                    ]
                ]
            ], 401));
        }

        return response()->json([
            'message' => 'success',
            'data' => $user,
        ]);
    }

    public function changePassword(Request $request){
        $validated = $request->validate([
            'email' => ['string', 'required', 'email', 'max:255'],
            'password' => ['string', 'required', 'max:255']
        ]);

        $user = User::where('email', $validated['email'])->first();

        if(!$user){
            throw new HttpResponseException(response([
                "errors"=>[
                    "message" => [
                        "Akun tidak ditemukan"
                    ]
                ]
            ], 404));
        }

        $user->password = Hash::make($validated['password']);
        $user->save();

        return response()->json([
            'message' => 'Password berhasil diubah'
        ]);
    }

    public function delete(Request $request){
        $validated = $request->validate([
            'email' => ['string', 'required', 'email', 'max:255']
        ]);

        $user = User::where('email', $validated['email'])->first();

        if(!$user){
            throw new HttpResponseException(response([
                "errors"=>[
                    "message" => [
                        "Akun tidak ditemukan"
                    ]
                ]
            ], 404));
        }

        $user->delete();

        return response()->json([
            'message' => 'Akun berhasil dihapus'
        ]);
    }
}
