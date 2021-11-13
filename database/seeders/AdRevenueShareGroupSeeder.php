<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AdRevenueShareGroup;

class AdRevenueShareGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groups = [
            ['group' => 1, 'name' => 'platform owner', 'share_percent' => 50, 'influencer_percent' => 0],
            ['group' => 2, 'name' => 'partnership', 'share_percent' => 20, 'influencer_percent' => 0],
            ['group' => 3, 'name' => 'audience', 'share_percent' => 25, 'influencer_percent' => 5],
        ];

        foreach ($groups as $group) {
            AdRevenueShareGroup::firstOrCreate([
                'group' => $group['group'],
                'name' => $group['name'],
                'share_percent' => $group['share_percent'],
                'influencer_percent' => $group['influencer_percent']
            ]);
        }
    }
}
