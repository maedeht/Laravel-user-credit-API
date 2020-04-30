<?php

namespace App\Services;

use App\Models\Config;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class UserService implements UserServiceInterface
{
    public function registerUser($request)
    {
        return DB::transaction(function () use ($request){
            $user = User::create([
                'username' => $request->input('user.username'),
                'email' => $request->input('user.email'),
                'password' => $request->input('user.password'),
            ]);

            return $this->storeRegistrationCredit($user);

        });
    }

    private function storeRegistrationCredit($user)
    {
        $registration_config = $this->getRegistrationCreditConfig();

        if(is_null($registration_config))
            return [];

        $user->transactions()->create([
            'credit' => $registration_config
        ]);

        $user->credit()->create([
            'value' => $registration_config
        ]);

        return $user;
    }

    private function getRegistrationCreditConfig()
    {
        $config = Config::where('name','registration-credit')->first();
        if(is_null($config))
            return null;

        return $config->value;

    }
}