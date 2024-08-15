<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class UserController extends Controller
{
    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        $this->userService->authorizeRequest();

        return UserResource::collection(User::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request): UserResource
    {
        $this->userService->authorizeRequest();
        $user = $this->userService->createUser($request);
        $this->userService->dispatchUserMailJob($user, $request->input('password'));

        return UserResource::make($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        $this->userService->authorizeRequest();

        return UserResource::make($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, User $user): UserResource
    {
        $this->userService->authorizeRequest();

        $this->userService->updateUser($user, $request->validated());
        $this->userService->dispatchUserMailJob($user, $request->input('password'));

        return UserResource::make($user->refresh());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): bool
    {
        $this->userService->authorizeRequest();

        return $user->delete();
    }
}
