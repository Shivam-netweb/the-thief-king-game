<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService extends BaseService{

    public function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }
    public function loginUser($request)
    {
        # getting exact fields from request

        $validated['password'] = $request->password;
        $fieldName = is_numeric($request->username) ? 'phone' : (filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username');
        $validated[$fieldName] = $request->username;

        # authenticating
        $user = User::where($fieldName, $request->username)->first();

        if(!$user) return $this->repo->message(message: __('auth.no_user'),statusCode : 403, statusText :'warning');

        if(Auth::attempt($validated)){
            $authUser = auth()->user();
            return $this->repo->message(message: __('auth.welcome',['name' => $authUser->name]),addOn: ['user' => $authUser]);
        }

        return $this->repo->message(message: __('auth.failed'), statusCode: 403, statusText: 'failed');
    }

    public function registerUser($validated)
    {
        DB::beginTransaction();
        $response = $this->store($this->prepareRegisterationRequest($validated));
        if($response->status() == 200){
            DB::commit();
            return $this->repo->message(message: __('auth.registered'));
        }

        return $response;
    }

    public function prepareRegisterationRequest($validated)
    {
        return $validated->except('_token','password_confirmation');
    }

    public function generateApiToken($userId)
    {
        try{
            $user = User::findOrFail($userId);
            $token = $user->createToken('chattify-user-'.$userId);
            return $this->repo->message(message:__('auth.token_generated',['user' => $user->name]), addOn: ['token' => $token->plainTextToken]);
        }catch(ModelNotFoundException $err){
            return $this->repo->message(__('token_failed'),500, 'failed',$err->getMessage());
        }
    }
}
