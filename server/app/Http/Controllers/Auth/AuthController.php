<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\CreateUserRequest;
use App\Http\Requests\Auth\UserLogintRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function login(UserLogintRequest $request)
    {
        if (Auth::attempt([
            'email' => $request->validated()['email'],
            'password' => $request->validated()['password']
        ])) {
            $user = Auth::user();

            $token = $user->createToken(env('TOKEN_NAME'))->plainTextToken;

            return $this->respondCreated([
                'user' => $user,
                'token' => $token,
            ]);
        }

        return $this->respondError(null, 'Login failed');
    }

    public function register(CreateUserRequest $request)
    {
        $user = User::create( $request->validated() );

        return $this->respondOk($user, 'User created successfully');
    }


    public function logout()
    {
        auth('sanctum')->user()->currentAccessToken()->delete();

        return $this->respondOk(null);
    }
}
