<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\HasApiResponse;
use App\Http\Permissions\Abilities;
use App\Http\Requests\Api\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use HasApiResponse;

    //
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            return $this->error('Invalid credentials', 401);
        }

        $user = User::where('email', $request->email)->first();

        return $this->ok('OK', [
            'token' => $user->createToken(
                'Access token for user ' . $user->name,
                Abilities::for($user),
                now()->addDay()
            )->plainTextToken
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->ok('User logged out');
    }

}
