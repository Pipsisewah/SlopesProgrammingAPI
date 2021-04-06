<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Responses\StandardResponse;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(RegisterRequest $request):JsonResponse{
        Log::notice("Received request to create user, " , ['info' => $request->toArray()]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        return StandardResponse::getStandardResponse(200,
        "Registration Successful"
        );
    }

    public function login(LoginRequest $request): JsonResponse{
        Log::notice("User attempting to login", ['info' => $request->toArray()]);
        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['The provided credentials are incorrect.'],
            ]);
        }

        $user->tokens()->delete();
        return StandardResponse::getStandardResponse(200,
            "Login Successful",
            [
            'access_token' => $user->createToken($request->email)->plainTextToken,
            'token_type' => 'Bearer',
        ]);
    }

    public function test(Request $request){
        return response()->json(['message' => 'hello'],200);
    }
}
