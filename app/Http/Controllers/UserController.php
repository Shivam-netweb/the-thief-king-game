<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\UserService;
use App\Http\Requests\UserRegisterationRequest;
use App\Http\Requests\UserAuthenticationRequest;

class UserController extends Controller
{
    protected $service;
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * Authenticates the user
     */
    public function loginUser(UserAuthenticationRequest $request) : \Illuminate\Http\Response
    {
        return $this->service->loginUser($request);
    }

    /**
     * Register a new user
     */
    public function registerUser(UserRegisterationRequest $request) : \Illuminate\Http\Response
    {
        return $this->service->registerUser($request);
    }

    public function generateToken($id)
    {
        return $this->service->generateApiToken($id);
    }

    public function startNewGame(Request $request)
    {

    }
}
