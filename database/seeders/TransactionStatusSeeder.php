<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionStatusSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $records = [];
       $records[] = ['id' => 1,'title' => 'Successfull'];
       $records[] = ['id' => 2,'title' => 'Failed'];
       $records[] = ['id' => 3,'title' => 'Unknown'];

       DB::table('transaction_statuses')->insert($records);
    }
    
}
