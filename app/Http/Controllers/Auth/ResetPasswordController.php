<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Resources\Auth\LoginResource;
use App\Models\PasswordReset;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    private $passwordReset;

    public function __construct()
    {
        $this->passwordReset = new PasswordReset(); // Assuming PasswordReset model exists
    }

    public function forgetPassword(Request $request, $verified_code = 0)
    {
        
        $user = User::where('email', $request->email)->first();

        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $request->email],
            ['token' => $verified_code]
        );

        return response()->json(['message' => 'Password reset token generated successfully.', 'status' => true], 200);
    }

    public function resetPassword(Request $request)
    {
        $reset = PasswordReset::where('email', $request->email)->first();

        if (!$reset) {
            return response()->json(['message' => 'Password reset token not found.', 'status' => false], 404);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid user.', 'status' => false], 404);
        }

        $user->password = $request->password;
        $user->verified_code = null;
        $user->email_verified_at = Carbon::now();
        $user->save();
        $reset->delete();

        return response()->json(['message' => 'Password reset successfully.', 'status' => true], 200);
    }
}
