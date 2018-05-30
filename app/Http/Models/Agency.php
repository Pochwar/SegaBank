<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Agency extends Model
{
    protected $table = "agencies";

    protected $fillable = [
        'code',
        'address'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function bankAccounts(): HasMany
    {
        return $this->hasMany('App\BankAccount', 'agency_id');
    }
}