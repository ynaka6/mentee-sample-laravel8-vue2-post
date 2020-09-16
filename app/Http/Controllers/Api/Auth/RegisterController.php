<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\Auth\RegisterRequest;

class RegisterController extends Controller
{
    public function handle(RegisterRequest $request)
    {
        $user = User::create($request->validated());
        Auth::login($user);
        return response()->json(compact('user'));
    }
}
