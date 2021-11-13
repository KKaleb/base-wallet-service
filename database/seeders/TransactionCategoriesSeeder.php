<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransactionCategory;

class TransactionCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ["top_up", "ad_revenue", "payout"];
        foreach ($categories as $category) {
            TransactionCategory::firstOrCreate(['name' => $category]);
        }
    }
}
