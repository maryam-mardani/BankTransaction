<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionStatus extends Model
{
    use HasFactory;
    protected $fillable = ['title'];

    
    public function transactions()
    {
        return $this->hasMany(Transaction::class,'transaction_status_id');
    }
}
