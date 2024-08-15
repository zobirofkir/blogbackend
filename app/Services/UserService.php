<?php

namespace App\Services;

use App\Http\Requests\UserRequest;
use App\Jobs\UserMailJob;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{
    private const AUTHORIZED_EMAIL = 'zobirofkir19@gmail.com';

    /**
     * Authorize the request based on email.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function authorizeRequest(): void
    {
        if (Auth::user()->email !== self::AUTHORIZED_EMAIL) {
            abort(403, 'Unauthorized');
        }
    }

    /**
     * Create a new user.
     *
     * @param UserRequest $request
     * @return User
     */
    public function createUser(UserRequest $request): User
    {
        $password = Hash::make($request->input('password'));

        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $password
        ]);
    }

    /**
     * Update user with validated data.
     *
     * @param User $user
     * @param array $validatedData
     */
    public function updateUser(User $user, array $validatedData): void
    {
        if (isset($validatedData['password'])) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        }

        $user->update($validatedData);
    }

    /**
     * Dispatch the email job.
     *
     * @param User $user
     * @param string $password
     */
    public function dispatchUserMailJob(User $user, string $password): void
    {
        UserMailJob::dispatch($user->email, $password);
    }
}
