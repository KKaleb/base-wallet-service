<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TransactionChannel;

class TransactionChannelsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $channels = ["arena", "consumus", "proxima", "topbrain"];
        foreach ($channels as $channel) {
            TransactionChannel::firstOrCreate(['name' => $channel]);
        }
    }
}
