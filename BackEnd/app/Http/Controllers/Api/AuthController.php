<?php

namespace App\Http\Controllers\Api;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Helpers\TokenApiHelper;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try {
            return TokenApiHelper::login($request);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function logout(Request $request)
    {
        try {
            return TokenApiHelper::logout($request->bearerToken());
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    public function verify(Request $request)
    {
        try {
            return response()->json([
                'status'  => true,
                'message' => 'Token valid'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status'  => false,
                'message' => $th->getMessage()
            ]);
        }
    }
}
