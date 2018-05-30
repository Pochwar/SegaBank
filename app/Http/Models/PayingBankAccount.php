<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class PayingBankAccount extends Model
{
    protected $table = "paying_bank_accounts";

    protected $primaryKey = 'id';

    protected $fillable = [
        'account_code'
    ];

    const TAXE_PERCENT = 5;

    public function account(): MorphOne
    {
        return $this->morphOne('App\BankAccount', 'accountable');
    }

    public function credit($amount)
    {
        $this->solde += $amount;
        $this->solde -= $this->taxedAmount($amount);
        $this->save();
    }

    public function debit($amount)
    {
        $this->solde -= $amount;
        $this->solde -= $this->taxedAmount($amount);
        $this->save();
    }

    private function taxedAmount($amount) {
        return $amount - ($amount * self::TAXE_PERCENT / 100);
    }
}
