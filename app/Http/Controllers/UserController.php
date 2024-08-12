<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index() : AnonymousResourceCollection
    {
        return UserResource::collection(
            User::all()
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request) : UserResource
    {
        $this->authorize("create", User::class);
        return UserResource::make(
            User::create($request->validated())
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user) : UserResource
    {
        $this->authorize("view", User::class);
        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user) : UserResource
    {
        $this->authorize("update", User::class);
        $user->update($request->validated());
        return UserResource::make(
            $user->refresh()
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user) : bool
    {
        $this->authorize("delete", User::class);
        return $user->delete();
    }
}
