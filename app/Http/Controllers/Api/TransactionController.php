<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Rules\CardValidator;
use App\Models\Transaction;
use App\Models\TransactionFee;
use App\Models\UserBankAccount;
use App\Models\UserBankAccountCard;
use App\Events\TransactionProceedEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


/**
        * @OA\Post(
        * path="/api/transaction",
        * operationId="Transaction",
        * tags={"Transaction"},
        * summary="User Transaction",
        * description="User Transaction here",
        *     @OA\RequestBody(
        *         @OA\JsonContent(),
        *         @OA\MediaType(
        *            mediaType="multipart/form-data",
        *            @OA\Schema(
        *               type="object",
        *               required={"source_card_number","target_card_number","cvv2","expire_year","expire_month", "password", "amount"},
        *               @OA\Property(property="source_card_number", type="number"),
        *               @OA\Property(property="target_card_number", type="number"),
        *               @OA\Property(property="cvv2", type="password"),
        *               @OA\Property(property="expire_year", type="number"),
        *               @OA\Property(property="expire_month", type="number"),
        *               @OA\Property(property="password", type="password"),
        *               @OA\Property(property="amount", type="number"),
        *            ),
        *        ),
        *    ),
        *      @OA\Response(
        *          response=201,
        *          description="Transaction Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=200,
        *          description="Transaction Successfully",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(
        *          response=422,
        *          description="Unprocessable Entity",
        *          @OA\JsonContent()
        *       ),
        *      @OA\Response(response=400, description="Bad request"),
        *      @OA\Response(response=404, description="Resource Not Found"),
        * )
        */

class TransactionController extends Controller
{
    public function transfer(Request $request)
    {
        $status_code = 422;
        $response = ['response' => '3','description' => ''];
        $fields = $request->validate(
            [
                'source_card_number' => ['required',new CardValidator],
                'target_card_number' => ['required',new CardValidator],
                'cvv2' => ['required','digits:4'],
                'expire_year' => ['required','integer','digits:4','min:'.date('Y')],
                'expire_month' => ['required','digits:2','max:12'],
                'amount' => ['required','integer','min:'.env('TRANACTION_MIN_AMOUNT'),'max:'.env('TRANACTION_MAX_AMOUNT')],
                'password' => ['required','integer']
            ]
        );

       

        //Check Source Card Number
        $source = UserBankAccountCard::query()->where('card_number','=',$fields['source_card_number'])->first();
        $target = UserBankAccountCard::query()->where('card_number','=',$fields['target_card_number'])->first();
        if(!empty($source) && !empty($target))
        {
            //Check Security Info
            if($fields['cvv2'] != $source->cvv2 || $fields['expire_year'] != $source->expire_year ||
               $fields['expire_month'] != $source->expire_month || Hash::check($fields['password'], $source->password))
            {
                $response['response'] = 2;
                $response['description'] = 'The security information is not valid !';
            }
            //Check Expiration Date
            elseif($fields['expire_year'].'-'.$fields['expire_month'] < date('Y-m'))
            {
                $response['response'] = 2;
                $response['description'] = 'Your card has been expired !';
            }
            //Check Amount 
            elseif($fields['amount']+env('TRANACTION_FEE') > $source->userBankAccount->amount)
            {
                $response['response'] = 2;
                $response['description'] = 'Your account balance is insufficient !';
            }
            else
            {
                //All fields are valid
                $response['response'] = 1;
                $response['description'] = 'The transaction proceed successful !';
            }
        }
        else
        {
            $response['response'] = 2;
            $response['description'] = (empty($source)) ? 'The Source Card Number is not valid !' : 'The Target Card Number is not valid !';
        }


        //transaction
        DB::beginTransaction();
        $transaction = $this->addTransactionLog($fields['amount'],$fields['source_card_number'],$fields['target_card_number'],$response);
        if($response['response'] == 1)
        {
            $this->transferToTarget($fields['amount'],$source->userBankAccount->id,$target->userBankAccount->id);
            $this->transactionFee($transaction->id);
            TransactionProceedEvent::dispatch($transaction);
            $status_code = 200;
        }
        //Should Add Log For Account Number -- skip it for now
        DB::commit();


        //Return Result
        return response()->json($response,$status_code);
        
    }



    public function addTransactionLog($amount,$source_card,$target_card,$reponse)
    {
        return Transaction::create([
            'source_card_number' => $source_card,
            'target_card_number' => $target_card,
            'amount' => $amount,
            'fee' => env('TRANACTION_FEE'),
            'transaction_status_id' => $reponse['response'],
            'message' => $reponse['description']
        ]);
    }


    public function transferToTarget($amount,$source_account_id,$target_account_id)
    {
        $source = UserBankAccount::find($source_account_id);
        $source->amount -= $amount+env('TRANACTION_FEE');
        $source->save();

        $target = UserBankAccount::find($target_account_id);
        $target->amount += $amount;
        $target->save();
    }

    public function transactionFee($transaction_id)
    {
        TransactionFee::create([
            'transaction_id' => $transaction_id,
            'fee' => env('TRANACTION_FEE')
        ]);
    }

}
