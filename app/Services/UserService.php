<?php

namespace App\Services;

use App\Models\Config;
use App\Models\User;

class UserService implements UserServiceInterface
{
    public function registerUser($request)
    {
        $user = User::create([
            'username' => $request->input('user.username'),
            'email' => $request->input('user.email'),
            'password' => $request->input('user.password'),
        ]);

        return $this->storeRegistrationCredit($user);
    }

    private function storeRegistrationCredit($user)
    {
        $user->transactions()->create([
            'credit' => $this->getRegistrationCredit()
        ]);

        $user->credit()->create([
            'value' => $this->getRegistrationCredit()
        ]);
    }

    private function getRegistrationCredit()
    {
        return Config::where('name','registration-credit');
    }
}