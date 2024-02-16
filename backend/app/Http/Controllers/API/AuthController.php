<?php

namespace App\Http\Controllers\API;

use App\Exceptions\EmailSendException;
use App\Exceptions\UnauthorizedException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Mail\EmailVerification;
use App\Models\User;
use DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * @throws EmailSendException
     */
    public function register(RegisterUserRequest $request): JsonResponse
    {
        $user = User::create([
            'name' => $request->input('name'),
            'password' => Hash::make($request->input('password')),
        ]);

        $token = hash('sha256', time());
        $email_id = DB::table('emails')->insertGetId([
            'value' => $request->input('value'),
            'user_id' => $user->id,
            'main' => true,
            'token' => $token,
        ]);

        Mail::to($request->input('value'))->send(new EmailVerification($email_id, $token));

        if ($email_id) {
            return response()->json([
                'message' => 'User created successfully. Email verification letter is sent.',
            ], 201);
        } else {
            throw new EmailSendException();
        }

    }

    /**
     * @throws UnauthorizedException
     */
    public function login(LoginUserRequest $request): JsonResponse
    {
        $credentials = $request->only('value', 'password');
        $token = Auth::attempt($credentials);

        if (! $token) {
            throw new UnauthorizedException();
        }

        $user = Auth::user();

        return response()->json([
            'user' => $user,
            'authorization' => [
                'token' => $token,
                'type' => 'bearer',
            ],
        ]);
    }

    public function logout(): JsonResponse
    {
        Auth::logout();

        return response()->json();
    }

    public function refresh(): JsonResponse
    {
        return response()->json([
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ],
        ]);
    }

    public function profile(): JsonResponse
    {
        return response()->json(auth()->user());
    }
}
