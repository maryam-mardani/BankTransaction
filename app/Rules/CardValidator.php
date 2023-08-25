<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CardValidator implements Rule
{
    public function __construct()
    {

    }

    function passes($attribute,$value)
    {
        $card_number = $this->convertPersianToEnglish($value);
        if(!is_numeric($card_number)) return false;
        $card_number = str_split($card_number);

        $lenght = sizeof($card_number);
        if($lenght != 16) return false;
        if(!in_array($card_number[0],[2,4,5,6])) return false;
        
        $card_array = [];
        for($i=0; $i < $lenght-1; $i++)
        {
            $cross = ($i%2 == 1) ? 1 : 2;

            $card_array[$i] = $card_number[$i]*$cross;
            if($card_array[$i] > 9) $card_array[$i] = $card_array[$i]-9;
        }
        $card_array[] = $card_number[sizeof($card_number)-1];

        return array_sum($card_array)%10 == 0 ? true : false;    
    }
    
    public function convertPersianToEnglish($card_number) 
    {
        $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
        $english = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
         
        $card_number = str_replace($persian, $english, $card_number);
        return $card_number;
    }

    
    public function message()
    {
        return 'The :attribute is not valid';
    }
}
