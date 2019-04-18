<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function getDetails()
    {
        $user=Auth::user();
        return $user;
    }

    public function test()
    {
        return ['this is a word'];
    }
}
