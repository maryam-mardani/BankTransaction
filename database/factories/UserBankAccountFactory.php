<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserBankAccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userIDs = DB::table('users')->pluck('id');
        return [
            'user_id' => fake()->randomElement($userIDs),
            'account_number' => fake()->unique()->numerify('##########'),
            'amount' => fake()->randomNumber(8,true)
        ];
    }
}
