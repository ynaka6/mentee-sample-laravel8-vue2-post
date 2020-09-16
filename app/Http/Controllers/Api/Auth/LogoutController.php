<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function handle()
    {
        Auth::logout(Auth::user());
        return response('', 200);
    }
}
