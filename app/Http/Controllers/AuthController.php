<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request){
        try {

            $user = User::where(['email' => $request->email])->first();

            if($user){
                if (\Hash::check($request->password, $user->password)) {
                    $data = [
                        'user' => $user,
                        'token' => $user->createToken($user->id . '-'. $user->name)->accessToken
                    ];
    
                    return response()->json([
                        'status' => true,
                        'values' => $data,
                    ], 200);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'username or password incorrect',
                    ], 401);
                }
                
            }else{
                return response()->json([
                    'status' => false,
                    'message' => 'username or password incorrect',
                ], 401);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 400);
        }

    }
}
