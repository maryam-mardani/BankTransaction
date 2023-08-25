<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserBankAccountCardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userBankAccountIDs = DB::table('user_bank_accounts')->pluck('id');
        return [
            'user_bank_account_id' => fake()->randomElement($userBankAccountIDs),
            'card_number' => fake()->unique()->numerify('###############'),
            'cvv2' => fake()->numerify('####'),
            'expire_year' => fake()->date('Y'),
            'expire_month' => fake()->date('m'),
            'password' => Hash::make('12345678')
        ];
    }
}
