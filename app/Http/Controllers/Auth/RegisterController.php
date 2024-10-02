<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Auth\RegisterResource;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{

    private $verified_code;
    public function __construct()
    {
        // $this->middleware('auth:api');

        $this->verified_code = rand(10000, 99999);
    }

    public function index(RegisterRequest $request)
    {
        $user = User::create(
            array_merge($request->only(
                'name',
                // 'last_name',
                'username',
                'phone',
                'password',
                'email',
                'image'
            ), [
                'verified_code' => $this->verified_code,
                // 'password' => $request->password,
            ])
        );

        $user['token'] = auth('api')->login($user);

        return new RegisterResource($user);
    }
}
