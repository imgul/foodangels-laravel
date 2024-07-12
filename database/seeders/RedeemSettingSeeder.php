<?php

namespace Database\Seeders;

use App\Models\RedeemSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RedeemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RedeemSetting::create([
            'score_value' => 2,
            'reward_value' => 10
        ]);
    }
}
