<?php

namespace App\Services;

use App\Models\Config;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService extends BaseService implements UserServiceInterface
{
    public function registerUser($request)
    {
        return DB::transaction(function () use ($request){
            $user = User::create([
                'username' => $request->input('user.username'),
                'email' => $request->input('user.email'),
                'password' => bcrypt($request->input('user.password')),
            ]);

            return $this->storeRegistrationCredit($user);

        });
    }

    private function storeRegistrationCredit($user)
    {
        $user->transactions()->create([
            'credit' => $this->getRegistrationCreditConfig()
        ]);

        $user->credit()->create([
            'value' => $this->getRegistrationCreditConfig()
        ]);

        return $user;
    }
}