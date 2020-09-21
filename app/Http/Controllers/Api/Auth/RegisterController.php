<?php

namespace App\Http\Controllers\Api\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\Auth\RegisterRequest;

class RegisterController extends Controller
{
    protected $user;
    
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(RegisterRequest $request)
    {
        if (Auth::check()) {
            return response('', 400);
        }
        $user = $this->user->create($request->validated());
        Auth::login($user);
        return response()->json($user);
    }
}
