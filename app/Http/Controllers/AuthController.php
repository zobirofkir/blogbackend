<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Http\Requests\PasswordRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\AuthResouce;
use App\Http\Resources\AuthResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    /**
     * Create Login User
     *
     * @param AuthRequest $request
     * @return AuthResource
     */
    public function login(AuthRequest $request) : AuthResouce
    {
        $request->validated();
        /**
         * @var User
         */
        $user = User::where("email", $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return abort(401, "Email ou mot de passe incorrects");
        }
        
        return AuthResouce::make($user);
    }

    /**
     * Create Me Method
     * 
     * @return UserResource
    */
    public function current() : UserResource
    {
        $user = $this->currentUser();
        return UserResource::make($user);
    }

    /**
     * Update Current User Password
     */
    public function updateCurrentUserPassword(PasswordRequest $request)
    {
        $this->currentUser()->update($request->validated());
        return UserResource::make($this->currentUser()->refresh());
    }

    /**
     * Create Logout User 
     * 
     * @return bool
    */
    public function logout() : bool
    {
        $user = $this->currentUser();
        $user->token()?->revoke();
        return true;
    }    


    /**
     * Get current user as App\Models\User
     *
     * @return User
     */
    private function currentUser () :User
    {
        return User::find(Auth::user()->id);
    }
} 