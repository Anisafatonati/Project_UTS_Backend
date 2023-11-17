<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Menangkap inputan
        $input = [
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
        ];

        // Membuat pengguna baru
        $user = User::create($input);

        // Membuat entri pegawai terkait
        $employeeInput = [
            "name" => $request->name,
            "gender" => $request->gender,
            "phone" => $request->phone,
            "address" => $request->address,
            "status" => $request->status,
            "hired_on" => $request->hired_on,
        ];

        $user->employee()->create($employeeInput);

        $data = [
            'message' => 'User and Employee are created successfully',
        ];

        // Mengirim response JSON
        return response()->json($data, 200);
    }

    public function login(Request $request)
    {
        $input = [
            "email" => $request->email,
            "password" => $request->password,
        ];

        // Mengambil data user (DB)
        if (Auth::attempt($input)) {
            $token = Auth::user()->createToken("auth_token");

            $data = [
                "message" => "Login successfully",
                "token" => $token->plainTextToken,
            ];

            return response()->json($data, 200);
        } else {
            $data = [
                "message" => "Username or Password is wrong",
            ];

            return response()->json($data, 401);
        }
    }
}
