<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Models\LoginFcmToken;
use App\Models\OrderSort;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'message' => 'email is not correct',
            ],500);
        }

        $check = Hash::check($request->password, $user->password);
        if (!$check) {
            return response()->json([
                'message' => 'password is not correct',
            ],500);
        };
        // if ($request->fcm_token) {
        //     $loginFcmToken = LoginFcmToken::firstOrCreate([
        //         'fcm_token' => $request->fcm_token,
        //         'modelabel_type' => 'App\Models\User',
        //         'modelabel_id' => $user->id,
        //     ]);
        // }

        $user['token'] = auth('api')->login($user);

      
   
        
        
        

        return (new LoginResource($user))->additional([
            'message' => ' Login successfully',
        ]);
    }
    public function logout(Request $request)
    {
        auth('api')->logout();
        return response()->json([
            'message' => 'Logout successfully',
        ]);
    }


    // public function addFcmtoken(Request $request)
    // {
    //     $loginFcmToken = LoginFcmToken::firstOrCreate([
    //         'fcm_token' => $request->fcm_token,
    //         'modelabel_type' => 'App\Models\User',
    //         'modelabel_id' => $request->user_id,
    //     ]);
    //     return response()->json([
    //         'data' => $loginFcmToken,
    //         'message' => 'Add Fcm Token  Successfully',
    //     ]);
    // }
}
