<?php

namespace App\Models;

use App\Events\UserBlockEvent;
use App\Events\UserCreditWarningEvent;
use Eloquent as Model;

class UserCredit extends Model
{
    public $fillable = [
        'value',
        'LowCreditEmailSent'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function updateCredit($value)
    {
        $this->update([
            'value' => $value
        ]);
        $this->checkForRechangeEmail();
        $this->checkIfUserCreditIsNegative();

        return true;
    }

    public function checkIfUserCreditIsNegative()
    {
        if($this->value <= -1)
        {
            $this->user->update([
                'active' => false
            ]);

            event(new UserBlockEvent($this->user));

            return true;
        }
        return false;
    }

    public function checkForRechangeEmail()
    {
        if($this->value < 0)
            return false;
        if($this->value <= $this->getUserCreditRechargeConfig())
        {
            if(! $this->isLowCreditEmailSent() )
            {
                event(new UserCreditWarningEvent());
                $this->setLowCreditEmailSentTrue();
                return true;
            }
        }
        else
            $this->setLowCreditEmailSentFalse();

        return false;
    }

    private function getUserCreditRechargeConfig()
    {
        $config = Config::where('name','user-credit-recharge')->first();
        if(is_null($config))
            return null;

        return $config->value;
    }

    private function isLowCreditEmailSent()
    {
        return $this->LowCreditEmailSent;
    }

    private function setLowCreditEmailSentTrue()
    {
        $this->update([
            'LowCreditEmailSent' => true
        ]);
    }

    private function setLowCreditEmailSentFalse()
    {
        $this->update([
            'LowCreditEmailSent' => false
        ]);
    }
}
