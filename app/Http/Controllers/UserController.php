<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Jobs\UserMailJob;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() : AnonymousResourceCollection
    {
        $user = Auth::user();

        if ($user->email !== 'zobirofkir19@gmail.com') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request) : UserResource
    {
        $user = Auth::user();

        if ($user->email !== 'zobirofkir19@gmail.com') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $password = Hash::make($request->input('password')); // Hash the password
        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $password
        ]);    
        UserMailJob::dispatch($user->email, $request->input('password'));
        return UserResource::make($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user) : UserResource
    {
        $currentUser = Auth::user();

        if ($currentUser->email !== 'zobirofkir19@gmail.com') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user) : UserResource
    {
        $currentUser = Auth::user();

        if ($currentUser->email !== 'zobirofkir19@gmail.com') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $updatedData = $request->validated();

        if (isset($updatedData['password'])) {
            $updatedData['password'] = Hash::make($updatedData['password']); // Hash the new password
        }

        $user->update($updatedData);
        
        // Dispatch job to send the updated email and password
        UserMailJob::dispatch($user->email, $request->input('password'));

        return UserResource::make($user->refresh());
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user) : bool
    {
        $currentUser = Auth::user();

        if ($currentUser->email !== 'zobirofkir19@gmail.com') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $user->delete();
    }
}
