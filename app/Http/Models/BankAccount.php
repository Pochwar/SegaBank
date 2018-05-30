<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BankAccount extends Model
{
    protected $table = "bank_accounts";

    protected $primaryKey = 'code';

    protected $fillable = [
        'code',
        'solde',
        'agency_id',
        'accountable_id',
        'accountable_type'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function accountable()
    {
        return $this->morphTo();
    }


    public function agency()
    {
        return $this->belongsTo('App\Agency');
    }


    public function credit($amount)
    {
        $this->solde += $amount;
        $this->save();
    }

    public function debit($amount)
    {
        $this->solde -= $amount;
        $this->save();
    }
}