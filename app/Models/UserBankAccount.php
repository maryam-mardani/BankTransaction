<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBankAccount extends Model
{
    use HasFactory;
    protected $fillable = ['user_id','account_number','amount'];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function userBankAccountNumbers()
    {
        return $this->hasMany(UserBankAccountNumbers::class,'user_bank_account_id');
    }
}
