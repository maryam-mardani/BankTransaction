<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBankAccountCard extends Model
{
    use HasFactory;
    protected $fillable = ['user_bank_account_id','card_number','cvv2','expire_date','password'];

    public function userBankAccount()
    {
        return $this->belongsTo(UserBankAccount::class,'user_bank_account_id');
    }
}
