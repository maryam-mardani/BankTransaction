<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserBankAccountCardSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
        \App\Models\UserBankAccountCard::factory(20)->create();

    }
    
}
