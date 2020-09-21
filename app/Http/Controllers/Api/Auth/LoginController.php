<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    protected $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(LoginRequest $request)
    {
        if (Auth::check()) {
            return response('', 400);
        }
        $user = $this->user->where('email', $request->email)->first();
        if (!$user || !password_verify($request->password, $user->password)) {
            return response([
                'message' => 'These credentials do not match our records.',
                'errors' => [
                    'email' => ['These credentials do not match our records.']
                ]
            ], 422);
        }
    
        Auth::login($user);

        return response()->json($user);
    }
}
