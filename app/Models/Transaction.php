<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $fillable = ['source_card_number','target_card_number','amount','fee','transaction_status_id','message'];

    
    public function transactionStatus()
    {
        return $this->belongsTo(TransactionStatus::class,'transaction_status_id');
    }

}
