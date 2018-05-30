<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\MorphOne;

class SavingBankAccount extends BankAccount
{
    protected $table = "saving_bank_accounts";

    protected $primaryKey = 'id';

    protected $fillable = [
        'tx_interet',
        'account_code'
    ];

    public function account(): MorphOne
    {
        return $this->morphOne('App\BankAccount', 'accountable');
    }

    public function calcInteret() {
        $this->solde = $this->solde + ($this->solde * $this->tx_interet / 100);
        $this->save();
    }
}
