<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\MorphOne;

class SimpleBankAccount extends BankAccount
{
    protected $table = "simple_bank_accounts";

    protected $primaryKey = 'id';

    protected $fillable = [
        'decouvert',
        'account_code'
    ];

    public function account(): MorphOne
    {
        return $this->morphOne('App\BankAccount', 'accountable');
    }

    public function debit($amount)
    {
        if($this->solde - $amount > $this->decouvert) {
            $this->solde -= $amount;
            $this->save();
        }
    }
}
