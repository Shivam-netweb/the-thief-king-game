<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserService extends BaseService{

    public function __construct()
    {

    }
    public function loginUser($request)
    {
        # getting exact fields from request

        $validated['password'] = $request->password;
        $fieldName = is_numeric($request->username) ? 'phone' : (filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username');
        $validated[$fieldName] = $request->username;

        # authenticating
        $user = User::where($fieldName, $request->username)->first();

        if(!$user) return $this->repo->message();

        if(Auth::attempt($validated)){

        }
    }
}
