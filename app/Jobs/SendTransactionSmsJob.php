<?php

namespace App\Jobs;

use App\Events\TransactionProceed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Traits\SendSms;

class SendTransactionSmsJob
{
    use SendSms;
    
    
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(TransactionProceed $event): void
    {
        $source_account = $event->transaction->sourceCard()->userBankAccount();
        $source_user = $source_account->user();
        $target_account = $event->transaction->targetCard()->userBankAccount();
        $target_user = $source_account->user();

        $source_message =  __('messages.source_transfer', ['amount' => $transaction->amount+$transaction->fee,
                                                           'account_number' => $source_account->account_number, 
                                                           'account_balance' => $source_account->amount,
                                                           'transaction_date' => $transaction->created_at->format('d.m.Y')
                                                        ]);
        $this->{env('SMS_API')}($source_user->mobile,$source_message);

        $target_message =  __('messages.source_transfer', ['amount' => $transaction->amount,
                                                           'account_number' => $target_account->account_number, 
                                                           'account_balance' => $target_account->amount,
                                                           'transaction_date' => $transaction->created_at->format('d.m.Y')                                                        
                                                        ]);
        $this->{env('SMS_API')}($target_user->mobile,$target_message);
    }
}
