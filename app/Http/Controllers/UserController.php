<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UserAuthenticationRequest;

class UserController extends Controller
{
    public function loginUser(UserAuthenticationRequest $request)
    {


    }
}
