<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserBankAccountSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       
        \App\Models\UserBankAccount::factory(20)->create();

    }
    
}
